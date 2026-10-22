<?php

class QuoteFormWizardHandler {
    const NONCE_ACTION = 'quote_submit_form_wizard_nonce';
    const NONCE_FIELD = 'quote_wizard_nonce';
    const SETTINGS_OPTION = 'cqfw_settings';
    const EMAIL_FROM = 'sales@meraboiler.com';
    const DEFAULT_EMAIL_TO = []; // Empty - only use configured recipients

    public function __construct() {
        add_action('wp_ajax_quote_submit_form_wizard', [$this, 'handle_form_submission']);
        add_action('wp_ajax_nopriv_quote_submit_form_wizard', [$this, 'handle_form_submission']);
    }

    public function handle_form_submission() {
        error_log('CQFW: Form submission started');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            wp_send_json_error(['message' => 'Invalid request method.'], 405);
        }

        if (!$this->is_valid_nonce()) {
            error_log('CQFW: Nonce validation failed');
            wp_send_json_error(['message' => 'Security check failed.'], 403);
        }

        error_log('CQFW: Collecting form data');
        $formData = $this->collect_form_data();

        if (!$this->has_required_fields($formData)) {
            error_log('CQFW: Required fields missing');
            wp_send_json_error(['message' => 'Required fields are missing.'], 422);
        }

        // Save to database first (fast operation - should be < 1 second)
        error_log('CQFW: Saving to database');
        $submission_id = CQFW_Database::save_submission($formData);
        if ($submission_id === false) {
            error_log('CQFW: Failed to save submission to database');
            // Continue anyway - don't fail the submission if DB save fails
        } else {
            error_log('CQFW: Saved to database with ID: ' . $submission_id);
        }

        // Generate event_id for TikTok (used for both browser and server-side for deduplication).
        $event_id = 'cqfw_' . ( $submission_id ? (int) $submission_id : time() );

        // Google Ads thank-you token (EC only — webhook payload/flow unchanged below)
        $thank_you_token = wp_generate_password(32, false);
        if (class_exists('CQF_Enhanced_Conversions')) {
            CQF_Enhanced_Conversions::store_from_wizard($thank_you_token, $formData);
        }

        // Send success response IMMEDIATELY (before slow email sending)
        error_log('CQFW: Sending success response');
        $response_data = [
            'success' => true,
            'data' => [
                'message' => 'Form submitted successfully.',
                'event_id' => $event_id,
                'thank_you_token' => $thank_you_token,
            ]
        ];
        
        // Send JSON response manually (don't use wp_send_json_success as it calls wp_die)
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=' . get_option('blog_charset'));
        }
        echo wp_json_encode($response_data);

        // Send TikTok server-side Lead event (Events API) in background.
        if ( class_exists( 'CQF_TikTok_Events' ) ) {
            $request_ip        = isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '';
            $request_user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
            $current_url       = isset( $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'] )
                ? ( ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] )
                : get_site_url();

            $ttclid = isset( $_COOKIE['ttclid'] ) ? $_COOKIE['ttclid'] : '';
            $ttp    = isset( $_COOKIE['_ttp'] ) ? $_COOKIE['_ttp'] : '';

            CQF_TikTok_Events::send_lead( [
                'event_id'     => $event_id,
                'event_time'   => time(),
                'email'        => $formData['email'] ?? '',
                'phone'        => $formData['mobile'] ?? '',
                'external_id'  => (string) $submission_id,
                'value'        => 0,
                'currency'     => 'GBP',
                'content_id'   => 'custom_quote_form_wizard',
                'content_type' => 'lead',
                'content_name' => $formData['service_type'] ?? 'Boiler Quote Wizard',
                'url'          => $current_url,
                'ip'           => $request_ip,
                'user_agent'   => $request_user_agent,
                'ttclid'       => $ttclid,
                'ttp'          => $ttp,
            ] );
        }
        
        // Send to webhook if enabled (Zapier, Make, etc.)
        $webhook_settings = class_exists('CQF_Shared_Admin_Settings') 
            ? CQF_Shared_Admin_Settings::get_webhook_settings() 
            : ['enabled' => false, 'url' => '', 'wizard_url' => ''];
        $wizard_webhook_url = !empty($webhook_settings['wizard_url']) ? $webhook_settings['wizard_url'] : ($webhook_settings['url'] ?? '');
        
        if (!empty($webhook_settings['enabled']) && !empty($wizard_webhook_url)) {
            error_log('CQFW: Webhook enabled, sending to webhook URL');
            try {
                $payload = CQF_Webhook_Service::build_wizard_payload($formData, $submission_id);
                $api_key = $webhook_settings['api_key'] ?? '';
                CQF_Webhook_Service::send($payload, $wizard_webhook_url, $api_key);
                error_log('CQFW: Webhook sent successfully');
            } catch (\Throwable $e) {
                error_log('CQFW: Webhook failed: ' . $e->getMessage());
            }
        }

        // Always send email so you have a copy (and so you get data even if webhook had issues)
        error_log('CQFW: Sending email notifications');
        $this->send_emails_fallback($formData);
        
        error_log('CQFW: All emails sent, now closing connection');
        
        // Close connection to client AFTER emails are sent
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif (function_exists('litespeed_finish_request')) {
            litespeed_finish_request();
        } else {
            // Fallback: ignore user abort and continue processing
            ignore_user_abort(true);
            if (ob_get_level() > 0) {
                ob_end_flush();
            }
            flush();
        }
        
        error_log('CQFW: Connection closed, exiting');
        
        // Exit cleanly
        exit;
    }
    
    /**
     * Process emails asynchronously after response is sent
     * This prevents visitors from waiting
     */
    private function process_emails_async($formData) {
        error_log('CQFW: Starting async email processing (shutdown hook)');
        
        // Close connection to client immediately
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif (function_exists('litespeed_finish_request')) {
            litespeed_finish_request();
        } else {
            // Fallback: ignore user abort and continue processing
            ignore_user_abort(true);
            if (ob_get_level() > 0) {
                ob_end_flush();
            }
            flush();
        }
        
        // Now send emails (visitor already got response)
        error_log('CQFW: Sending admin email');
        $this->send_admin_email_safe($formData);
        
        // Throttle email sending to prevent rate limiting
        // Use microtime for non-blocking delay calculation
        $this->throttle_email_sending();
        
        error_log('CQFW: Sending thank you email');
        $this->send_thank_you_email_safe($formData);
        error_log('CQFW: Async email processing completed');
    }
    
    /**
     * Send admin email safely (with error handling)
     */
    private function send_admin_email_safe($formData) {
        try {
            error_log('CQFW: send_admin_email_safe called');
            $this->send_admin_email($formData);
            error_log('CQFW: send_admin_email completed without exception');
        } catch (\Throwable $e) {
            error_log('CQFW: CRITICAL ERROR - Quote wizard admin email error: ' . $e->getMessage());
            error_log('CQFW: Error type: ' . get_class($e));
            error_log('CQFW: Error file: ' . $e->getFile() . ':' . $e->getLine());
            throw $e; // Re-throw to see if it's caught elsewhere
        }
    }

    private function is_valid_nonce() {
        return isset($_POST[self::NONCE_FIELD]) && wp_verify_nonce($_POST[self::NONCE_FIELD], self::NONCE_ACTION);
    }

    private function collect_form_data() {
        $street = sanitize_text_field($_POST['cust_street'] ?? '');
        $postcode = sanitize_text_field($_POST['cust_pin'] ?? '');

        $mobile = sanitize_text_field($_POST['mobile_'] ?? '');
        $mobileMeta = class_exists('CQF_Shared_Utilities') 
            ? CQF_Shared_Utilities::format_mobile_number($mobile)
            : $this->format_mobile_number($mobile);

        return [
            'service_type' => sanitize_text_field($_POST['service_type'] ?? ($_GET['service_type'] ?? '')),
            'owner_type' => sanitize_text_field($_POST['owner_type'] ?? ''),
            'full_name' => sanitize_text_field($_POST['f_name'] ?? ''),
            'email' => sanitize_email($_POST['email_'] ?? ''),
            'mobile' => $mobile,
            'mobile_international' => $mobileMeta['international'],
            'mobile_whatsapp_url' => $mobileMeta['whatsapp'],
            'street' => $street,
            'postcode' => $postcode,
            'hear_about_us' => sanitize_text_field($_POST['hearaboutus_'] ?? ''),
            'boiler_age' => sanitize_text_field($_POST['boiler_age'] ?? ''),
            'boiler_working' => sanitize_text_field($_POST['boiler_working'] ?? ''),
            'fuel_type' => sanitize_text_field($_POST['q1'] ?? ''),
            'existing_boiler' => sanitize_text_field($_POST['q2'] ?? ''),
            'desired_boiler' => sanitize_text_field($_POST['q3'] ?? ''),
            'property_type' => sanitize_text_field($_POST['q4'] ?? ''),
            'bedrooms' => sanitize_text_field($_POST['q5'] ?? ''),
            'bath_tubs' => sanitize_text_field($_POST['q6'] ?? ''),
            'showers' => sanitize_text_field($_POST['q7'] ?? ''),
            'occupants' => sanitize_text_field($_POST['q8'] ?? ''),
            'current_boiler_location' => sanitize_text_field($_POST['q9'] ?? ''),
            'new_boiler_location' => sanitize_text_field($_POST['q10'] ?? ''),
            'flue_exit' => sanitize_text_field($_POST['q11'] ?? ''),
            'flue_height' => sanitize_text_field($_POST['q12'] ?? ''),
            'flue_distance' => sanitize_text_field($_POST['q13'] ?? ''),
            'flue_structure' => sanitize_text_field($_POST['q14'] ?? ''),
            'flue_window_distance' => sanitize_text_field($_POST['q15'] ?? ''),
            'meter_distance' => sanitize_text_field($_POST['q16'] ?? ''),
            'radiators' => sanitize_text_field($_POST['q17'] ?? ''),
            'site_name' => get_bloginfo('name'),
            'site_url' => get_site_url(),
            'submitted_at_utc' => current_time('mysql', true),
        ];
    }

    private function has_required_fields($data) {
        return !empty($data['full_name'])
            && !empty($data['email'])
            && !empty($data['mobile'])
            && !empty($data['street'])
            && !empty($data['postcode']);
    }


    private function send_admin_email($formData) {
        $recipients = $this->get_email_recipients();
        
        error_log('CQFW: Email recipients: ' . print_r($recipients, true));

        if (empty($recipients)) {
            error_log('CQFW: No email recipients configured - cannot send admin email');
            throw new \RuntimeException('No email recipients configured.');
        }

        // Build subject with postcode and site name
        $postcode = !empty($formData['postcode']) ? $formData['postcode'] : '';
        $site_name = !empty($formData['site_name']) ? $formData['site_name'] : get_bloginfo('name');
        
        // Always show both brackets in the format: Enquiry [postcode] [site] - Quote Form
        $subject = sprintf('Enquiry [%s] [%s] - Quote Form', $postcode, $site_name);
        $body = $this->build_admin_email_body($formData);

        $email_settings = $this->get_email_settings();
        
        if (!empty($email_settings['smtp_enabled'])) {
            // Try SMTP first, fallback to wp_mail if connection or authentication fails
            try {
                // Use exponential backoff retry for rate limit errors
                $this->retry_email_with_backoff(function() use ($recipients, $subject, $body, $formData) {
                    return $this->send_email_via_phpmailer($recipients, $subject, $body, $formData['email'], $formData['full_name']);
                });
            } catch (\RuntimeException $e) {
                $error_message = $e->getMessage();
                $is_localhost = !empty($email_settings['smtp_host']) && strtolower($email_settings['smtp_host']) === 'localhost';
                
                // Fallback to WordPress default mail if:
                // 1. Connection/authentication fails, OR
                // 2. Rate limit retries exhausted
                if ($this->is_connection_error($error_message, $is_localhost) || $this->is_rate_limit_error($e)) {
                    error_log('CQFW: SMTP failed (' . $error_message . '), falling back to WordPress default mail');
                    $headers = $this->build_headers($formData['email'], $formData['full_name']);
                    if (!wp_mail($recipients, $subject, $body, $headers)) {
                        error_log('CQFW: WordPress default mail also failed');
                        throw new \RuntimeException('Failed to send email via both SMTP and WordPress default mail.');
                    } else {
                        error_log('CQFW: Email sent successfully via WordPress default mail (SMTP fallback)');
                    }
                } else {
                    // Re-throw other SMTP errors
                    throw $e;
                }
            }
        } else {
            // Use WordPress default mail
            $headers = $this->build_headers($formData['email'], $formData['full_name']);
            if (!wp_mail($recipients, $subject, $body, $headers)) {
                throw new \RuntimeException('Failed to send fallback admin email.');
            }
        }
    }

    private function send_thank_you_email($formData) {
        $siteURL = esc_url($formData['site_url']);
        $body = $this->build_thank_you_email_body($formData['full_name'], $siteURL);
        $subject = 'Thank You for Your Quote Request';

        $email_settings = $this->get_email_settings();
        
        if (!empty($email_settings['smtp_enabled'])) {
            // Try SMTP first, fallback to wp_mail if connection or authentication fails
            try {
                // Use exponential backoff retry for rate limit errors
                $this->retry_email_with_backoff(function() use ($formData, $subject, $body) {
                    return $this->send_email_via_phpmailer([$formData['email']], $subject, $body);
                });
            } catch (\RuntimeException $e) {
                $error_message = $e->getMessage();
                $is_localhost = !empty($email_settings['smtp_host']) && strtolower($email_settings['smtp_host']) === 'localhost';
                
                // Fallback to WordPress default mail if:
                // 1. Connection/authentication fails, OR
                // 2. Rate limit retries exhausted
                if ($this->is_connection_error($error_message, $is_localhost) || $this->is_rate_limit_error($e)) {
                    error_log('CQFW: SMTP failed for thank you email (' . $error_message . '), falling back to WordPress default mail');
                    $headers = $this->build_headers(self::EMAIL_FROM, CQF_Shared_Utilities::sales_team_name());
                    if (!wp_mail($formData['email'], $subject, $body, $headers)) {
                        error_log('CQFW: WordPress default mail also failed for thank you email');
                        throw new \RuntimeException('Failed to send thank you email via both SMTP and WordPress default mail.');
                    } else {
                        error_log('CQFW: Thank you email sent successfully via WordPress default mail (SMTP fallback)');
                    }
                } else {
                    // Re-throw other SMTP errors
                    throw $e;
                }
            }
        } else {
            // Use WordPress default mail
            $headers = $this->build_headers(self::EMAIL_FROM, CQF_Shared_Utilities::sales_team_name());
            if (!wp_mail($formData['email'], $subject, $body, $headers)) {
                throw new \RuntimeException('Failed to send thank you email.');
            }
        }
    }

    /**
     * Send email via PHPMailer with SMTP configuration
     */
    private function send_email_via_phpmailer($recipients, $subject, $body, $reply_to_email = '', $reply_to_name = '') {
        // Load PHPMailer if not already loaded
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
            require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
            require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
        }

        $email_settings = $this->get_email_settings();
        
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = $email_settings['smtp_host'];
            $mail->Port = $email_settings['smtp_port'];
            $mail->Timeout = 10; // 10 second timeout to prevent hanging
            $mail->SMTPKeepAlive = false; // Don't keep connection alive
            
            // SMTP Authentication (optional - for GoDaddy, set to false)
            $mail->SMTPAuth = !empty($email_settings['smtp_auth']);
            if ($mail->SMTPAuth) {
                $mail->Username = $email_settings['smtp_username'];
                $mail->Password = $email_settings['smtp_password'];
            } else {
                // Explicitly clear username/password when auth is disabled
                $mail->Username = '';
                $mail->Password = '';
            }
            
            // Encryption (optional - for GoDaddy, set to 'none')
            if ($email_settings['smtp_encryption'] === 'ssl') {
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($email_settings['smtp_encryption'] === 'tls') {
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            } elseif ($email_settings['smtp_encryption'] === 'none') {
                // No encryption (for GoDaddy)
                $mail->SMTPSecure = '';
            }
            
            // From
            $from_email = !empty($email_settings['email_from']) ? $email_settings['email_from'] : self::EMAIL_FROM;
            $from_name = CQF_Shared_Utilities::sales_team_name();
            $mail->setFrom($from_email, $from_name);
            
            // Recipients
            foreach ($recipients as $recipient) {
                $mail->addAddress($recipient);
            }
            
            // Reply-To
            if (!empty($reply_to_email) && is_email($reply_to_email)) {
                $mail->addReplyTo($reply_to_email, $reply_to_name);
            }
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->CharSet = 'UTF-8';
            
            $result = $mail->send();
            if ($result) {
                error_log('CQFW: Admin email sent successfully via SMTP to: ' . implode(', ', $recipients));
            } else {
                error_log('CQFW: CRITICAL - mail->send() returned false. ErrorInfo: ' . $mail->ErrorInfo);
                throw new \RuntimeException('PHPMailer send() returned false: ' . $mail->ErrorInfo);
            }
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            error_log('CQFW: CRITICAL PHPMailer Exception: ' . $e->getMessage());
            error_log('CQFW: PHPMailer ErrorInfo: ' . $mail->ErrorInfo);
            error_log('CQFW: SMTP Host: ' . $email_settings['smtp_host']);
            error_log('CQFW: SMTP Port: ' . $email_settings['smtp_port']);
            error_log('CQFW: SMTP Username: ' . $email_settings['smtp_username']);
            
            // Extract SMTP error code if available
            $smtp_code = $this->extract_smtp_error_code($mail->ErrorInfo);
            throw new \RuntimeException('Failed to send email via SMTP: ' . $mail->ErrorInfo, $smtp_code);
        } catch (\Exception $e) {
            error_log('CQFW: CRITICAL General Exception in send_email_via_phpmailer: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Extract SMTP error code from error message
     * SMTP codes: 421 (service unavailable), 450 (mailbox unavailable), 550 (mailbox unavailable/rate limit)
     */
    private function extract_smtp_error_code($error_info) {
        // Try to extract SMTP code from error message (format: "SMTP code: 550")
        if (preg_match('/SMTP code:\s*(\d{3})/i', $error_info, $matches)) {
            return (int) $matches[1];
        }
        return 0;
    }

    /**
     * Check if error indicates rate limiting based on SMTP code and message
     */
    private function is_rate_limit_error($exception) {
        $error_message = $exception->getMessage();
        $error_code = $exception->getCode();
        
        // SMTP error codes that indicate rate limiting or temporary failures
        $rate_limit_codes = [421, 450, 550]; // 550 is commonly used for rate limits
        
        // Check SMTP error code
        if (in_array($error_code, $rate_limit_codes, true)) {
            return true;
        }
        
        // Check error message for rate limit indicators
        $rate_limit_indicators = [
            'Too many emails',
            'rate limit',
            'data not accepted',
            'mailbox temporarily unavailable',
            'service temporarily unavailable'
        ];
        
        foreach ($rate_limit_indicators as $indicator) {
            if (stripos($error_message, $indicator) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if error indicates connection/authentication failure
     */
    private function is_connection_error($error_message, $is_localhost) {
        $connection_errors = [
            'Could not connect',
            'Network is unreachable',
            'Failed to connect to server'
        ];
        
        foreach ($connection_errors as $error) {
            if (stripos($error_message, $error) !== false) {
                return true;
            }
        }
        
        // Authentication errors on localhost (GoDaddy doesn't support auth)
        if ($is_localhost && stripos($error_message, 'Could not authenticate') !== false) {
            return true;
        }
        
        return false;
    }

    /**
     * Throttle email sending to prevent rate limiting
     * Uses WordPress transients to track last email send time
     */
    private function throttle_email_sending($min_interval_seconds = 2) {
        $transient_key = 'cqfw_last_email_send';
        $last_send = get_transient($transient_key);
        
        if ($last_send !== false) {
            $elapsed = time() - $last_send;
            if ($elapsed < $min_interval_seconds) {
                $wait_time = $min_interval_seconds - $elapsed;
                error_log("CQFW: Throttling email sending, waiting {$wait_time} seconds to prevent rate limiting");
                sleep($wait_time);
            }
        }
        
        // Update last send time
        set_transient($transient_key, time(), 60); // Expire after 60 seconds
    }

    /**
     * Retry email sending with exponential backoff
     * 
     * @param callable $callback Function to retry
     * @param int $max_attempts Maximum number of retry attempts
     * @param int $initial_delay Initial delay in seconds before first retry
     * @return mixed Return value from callback
     * @throws \RuntimeException If all retries fail
     */
    private function retry_email_with_backoff($callback, $max_attempts = 3, $initial_delay = 1) {
        $attempt = 0;
        $delay = $initial_delay;
        
        while ($attempt < $max_attempts) {
            try {
                return $callback();
            } catch (\RuntimeException $e) {
                $attempt++;
                
                if ($attempt >= $max_attempts) {
                    throw $e; // Re-throw if max attempts reached
                }
                
                // Only retry on rate limit errors
                if (!$this->is_rate_limit_error($e)) {
                    throw $e; // Don't retry non-rate-limit errors
                }
                
                // Exponential backoff: delay doubles with each attempt
                error_log("CQFW: Rate limit detected, attempt {$attempt}/{$max_attempts}, waiting {$delay} seconds before retry");
                sleep($delay);
                $delay *= 2; // Exponential backoff
            }
        }
    }

    /**
     * Send emails as fallback (when webhook is disabled or fails)
     */
    private function send_emails_fallback($formData) {
        error_log('CQFW: Sending emails (fallback method)');
        try {
            error_log('CQFW: Attempting to send admin email');
            $this->send_admin_email_safe($formData);
            error_log('CQFW: Admin email sent successfully');
        } catch (\Throwable $e) {
            error_log('CQFW: CRITICAL - Admin email failed: ' . $e->getMessage());
            error_log('CQFW: Stack trace: ' . $e->getTraceAsString());
        }
        
        try {
            error_log('CQFW: Attempting to send thank you email');
            $this->send_thank_you_email_safe($formData);
            error_log('CQFW: Thank you email sent successfully');
        } catch (\Throwable $e) {
            error_log('CQFW: CRITICAL - Thank you email failed: ' . $e->getMessage());
            error_log('CQFW: Stack trace: ' . $e->getTraceAsString());
        }
    }

    private function build_headers($replyToEmail, $replyToName = '') {
        if (empty($replyToEmail) || !is_email($replyToEmail)) {
            $replyToEmail = self::EMAIL_FROM;
            $replyToName = CQF_Shared_Utilities::sales_team_name();
        }

        $replyTo = $replyToEmail;

        if (!empty($replyToName)) {
            $replyTo = sprintf('%s <%s>', $replyToName, $replyToEmail);
        }

        return [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . CQF_Shared_Utilities::sales_team_name() . ' <' . self::EMAIL_FROM . '>',
            'Reply-To: ' . $replyTo,
        ];
    }

    private function build_admin_email_body($data) {
        $telLink = $data['mobile_international'] ?: $data['mobile'];
        $displayMobile = $telLink ?: $data['mobile'];
        $mobileCell = !empty($telLink)
            ? '<a href="tel:' . esc_attr($telLink) . '">' . esc_html($displayMobile) . '</a>'
            : esc_html($data['mobile']);


        return "
        <table width='80%' align='center' cellpadding='0' cellspacing='0' style='font-family:Verdana, Geneva, sans-serif; font-size:13px; border:dotted 1px #186ea9; border-bottom:solid 3px #0037ff;'>
          <tr>
                    <td style='background:#0037ff; padding:10px 0; font-weight:bold; color:#fff; font-size:16px;' colspan='4' align='center' valign='middle'>" . esc_html(trim((class_exists('CQF_Shared_Utilities') ? CQF_Shared_Utilities::brand_from_host() : '') . ' Boiler Offer Enquiry (Wizard)')) . "</td>
          </tr>
           <tr>
                    <td width='25%' style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Owner Type</td>
                    <td width='25%' style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['owner_type']}</td>
                    <td width='25%' style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Email</td>
                    <td width='25%' style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['email']}</td>
          </tr>
            <tr>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Name</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['full_name']}</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Mobile / WhatsApp</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$mobileCell}</td>
            </tr>
            <tr>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Address</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;' colspan='3'>{$data['street']}</td>
            </tr>
                <tr>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Boiler Functioning</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['boiler_working']}</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Current Boiler Age</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['boiler_age']}</td>
          </tr>
                <tr>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Existing Boiler</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['existing_boiler']}</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Desired Boiler</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['desired_boiler']}</td>
          </tr>
          <tr>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Property Type</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['property_type']}</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Fuel Type</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['fuel_type']}</td>
          </tr>
          <tr>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Bedrooms</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['bedrooms']}</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Bath Tubs</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['bath_tubs']}</td>
          </tr>
          <tr>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Showers</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['showers']}</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Occupants</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['occupants']}</td>
          </tr>
          <tr>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Current Boiler Location</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['current_boiler_location']}</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>New Boiler Location</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['new_boiler_location']}</td>
          </tr>
          <tr>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Flue Exit</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['flue_exit']}</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Flue Height</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['flue_height']}</td>
          </tr>
          <tr>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Distance to Other Property</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['flue_distance']}</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Structure Near Flue</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['flue_structure']}</td>
          </tr>
          <tr>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Flue distance from window/door</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['flue_window_distance']}</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Gas meter distance</td>
                    <td style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['meter_distance']}</td>
          </tr>
          <tr>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Radiators</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['radiators']}</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>How did you hear about us?</td>
                    <td style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#333;'>{$data['hear_about_us']}</td>
        </tr>
        </table>";
    }

    private function build_thank_you_email_body($fullName, $siteURL) {
        $email_settings = $this->get_email_settings();
        $brand = class_exists('CQF_Shared_Utilities') ? CQF_Shared_Utilities::brand_from_host() : '';
        $whatsapp_url = class_exists('CQF_Shared_Utilities')
            ? CQF_Shared_Utilities::whatsapp_chat_url($email_settings['whatsapp_number'] ?? '', trim('Hi ' . $brand))
            : '';
        $whatsapp_item = $whatsapp_url !== ''
            ? "<li><a href='" . esc_url($whatsapp_url) . "' style='color:#0037ff;'>Chat with us on WhatsApp</a></li>"
            : '';
        $phone_display = class_exists('CQF_Shared_Utilities')
            ? CQF_Shared_Utilities::phone_display($email_settings['phone_number'] ?? '')
            : '';
        $phone_url = class_exists('CQF_Shared_Utilities')
            ? CQF_Shared_Utilities::phone_tel_url($phone_display)
            : '';
        $phone_item = $phone_url !== ''
            ? "<li><a href='" . esc_attr($phone_url) . "' style='color:#0037ff;'>Call us at " . esc_html($phone_display) . "</a></li>"
            : '';

        return "
            <div style='font-family:Verdana, Geneva, sans-serif;'>
                <p>Dear $fullName,</p>
                <p>Thank you for reaching out to us. We have received your quote and will get back to you soon.</p>
                <p>In the meantime, you can:</p>
                <ul>
                    $whatsapp_item
                    $phone_item
                    <li><a href='$siteURL' style='color:#0037ff;'>Visit our website</a></li>
                </ul>
                <p>Best Regards,<br>" . esc_html(trim($brand . ' Team')) . "</p>
            </div>";
    }

    private function send_thank_you_email_safe($formData) {
        try {
            $this->send_thank_you_email($formData);
        } catch (\Throwable $e) {
            error_log('Quote wizard thank you email error: ' . $e->getMessage());
        }
    }

    /**
     * Fallback phone formatter if shared utilities not available
     */
    private function format_mobile_number($mobile) {
        if (class_exists('CQF_Shared_Utilities')) {
            return CQF_Shared_Utilities::format_mobile_number($mobile);
        }
        
        // Fallback implementation
        $digits = preg_replace('/\D+/', '', $mobile);

        if (empty($digits)) {
            return [
                'international' => '',
                'whatsapp' => '',
            ];
        }

        if (strpos($digits, '00') === 0) {
            $digits = substr($digits, 2);
        }

        if (strpos($digits, '44') === 0) {
            $international = '+' . $digits;
        } elseif (isset($digits[0]) && $digits[0] === '0') {
            $international = '+44' . substr($digits, 1);
        } else {
            $international = '+' . $digits;
        }

        $whatsappDigits = preg_replace('/\D+/', '', $international);

        return [
            'international' => $international,
            'whatsapp' => !empty($whatsappDigits) ? 'https://wa.me/' . $whatsappDigits : '',
        ];
    }

    private function get_email_recipients() {
        // First try to get from shared settings
        if (class_exists('CQF_Shared_Admin_Settings')) {
            $shared_settings = CQF_Shared_Admin_Settings::get_email_settings();
            error_log('CQFW: Shared settings notification_recipients: ' . (isset($shared_settings['notification_recipients']) ? $shared_settings['notification_recipients'] : 'NOT SET'));
            
            if (!empty($shared_settings['notification_recipients'])) {
                $emails = array_filter(
                    array_map(
                        'sanitize_email',
                        array_map('trim', explode(',', $shared_settings['notification_recipients']))
                    )
                );
                if (!empty($emails)) {
                    error_log('CQFW: Using shared settings emails: ' . implode(', ', $emails));
                    return $emails;
                }
            }
        }

        // Fallback to plugin-specific settings
        $settings = $this->get_settings();
        $emails = array_filter(
            array_map(
                'sanitize_email',
                array_map('trim', explode(',', $settings['email_recipients'] ?? ''))
            )
        );

        if (!empty($emails)) {
            return $emails;
        }

        // If no recipients configured, return empty array (will throw error in send_admin_email)
        return [];
    }

    private function get_settings() {
        return wp_parse_args(
            get_option(self::SETTINGS_OPTION, []),
            [
                'email_recipients' => '', // Empty default - only use what's configured
            ]
        );
    }

    /**
     * Get email settings from shared plugin
     */
    private function get_email_settings() {
        if (class_exists('CQF_Shared_Admin_Settings')) {
            return CQF_Shared_Admin_Settings::get_email_settings();
        }
        
        // Fallback: get settings directly from options
        $settings = get_option('cqf_shared_settings', []);
        return wp_parse_args($settings, [
            'email_from' => self::EMAIL_FROM,
            'email_from_name' => CQF_Shared_Utilities::sales_team_name(),
            'smtp_enabled' => 0,
            'smtp_host' => '',
            'smtp_port' => 587,
            'smtp_encryption' => 'tls',
            'smtp_username' => '',
            'smtp_password' => '',
            'phone_number' => '020 8150 2025',
            'whatsapp_number' => '447305988000',
        ]);
    }
}

new QuoteFormWizardHandler();
