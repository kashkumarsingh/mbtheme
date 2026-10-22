<?php

class QuoteFormHandler {
    const NONCE_ACTION = 'quote_submit_form_nonce';
    const SETTINGS_OPTION = 'cqf_settings';
    const EMAIL_FROM = 'sales@meraboiler.com';
    const DEFAULT_EMAIL_TO = []; // Empty - only use configured recipients

    public function __construct() {
        add_action('wp_ajax_quote_submit_form', [$this, 'handle_form_submission']);
        add_action('wp_ajax_nopriv_quote_submit_form', [$this, 'handle_form_submission']);
    }

    /**
     * Handles the form submission and triggers notifications.
     */
    public function handle_form_submission() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            wp_send_json_error(['message' => 'Invalid request method.'], 405);
        }

        if (!$this->is_valid_nonce()) {
            wp_send_json_error(['message' => 'Security check failed.'], 403);
        }

        if (empty($_POST['formData'])) {
            wp_send_json_error(['message' => 'Form payload missing.'], 400);
        }

        $formData = $this->parse_form_data();

        if (!$this->is_valid_form_data($formData)) {
            wp_send_json_error(['message' => 'Required fields are missing.'], 422);
        }

        // Save to database first
        $submission_id = CQF_Database::save_submission($formData);
        if ($submission_id === false) {
            error_log('CQF: Failed to save submission to database');
            // Continue anyway - don't fail the submission if DB save fails
        }

        // Generate event_id for TikTok (used for both browser and server-side for deduplication).
        $event_id = 'cqf_' . ( $submission_id ? (int) $submission_id : time() );

        // Generate token for transfer to wizard
        $transfer_token = wp_generate_password(32, false);
        $transient_key = 'cqf_transfer_' . $transfer_token;
        set_transient($transient_key, $formData, 600); // 10 minutes expiry

        // Send success response IMMEDIATELY (before slow email sending)
        error_log('CQF: Sending success response');
        $response_data = [
            'success' => true,
            'data' => [
                'message' => 'Form submitted successfully.',
                'transfer_token' => $transfer_token,
                'event_id' => $event_id,
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
                'email'        => $formData['cust_email'] ?? '',
                'phone'        => $formData['cust_mobile'] ?? '',
                'external_id'  => (string) $submission_id,
                'value'        => 0,
                'currency'     => 'GBP',
                'content_id'   => 'custom_quote_form',
                'content_type' => 'lead',
                'content_name' => $formData['service_type'] ?? 'Homepage Quote Form',
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
            : ['enabled' => false, 'url' => ''];
        
        if (!empty($webhook_settings['enabled']) && !empty($webhook_settings['url'])) {
            error_log('CQF: Webhook enabled, sending to webhook URL');
            try {
                $payload = CQF_Webhook_Service::build_regular_payload($formData, $submission_id);
                $api_key = $webhook_settings['api_key'] ?? '';
                CQF_Webhook_Service::send($payload, $webhook_settings['url'], $api_key);
                error_log('CQF: Webhook sent successfully');
            } catch (\Throwable $e) {
                error_log('CQF: Webhook failed: ' . $e->getMessage());
            }
        }

        // Always send email so you have a copy (and so you get data even if webhook had issues)
        error_log('CQF: Sending email notifications');
        $this->send_emails_fallback($formData);
        
        error_log('CQF: Processing completed, now closing connection');
        
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
        
        error_log('CQF: Connection closed, exiting');
        
        // Exit cleanly
        exit;
    }
    
    /**
     * Process emails asynchronously after response is sent
     * This prevents visitors from waiting
     */
    private function process_emails_async($formData) {
        error_log('CQF: Starting async email processing (shutdown hook)');
        
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
        
        // Check if webhook is enabled - if so, send to webhook instead of email
        $webhook_settings = class_exists('CQF_Shared_Admin_Settings') 
            ? CQF_Shared_Admin_Settings::get_webhook_settings() 
            : ['enabled' => false, 'url' => ''];
        
        if (!empty($webhook_settings['enabled']) && !empty($webhook_settings['url'])) {
            error_log('CQF: Webhook enabled, sending to webhook URL');
            try {
                $this->send_to_webhook($formData, $submission_id, $webhook_settings['url']);
                error_log('CQF: Webhook sent successfully');
            } catch (\Throwable $e) {
                error_log('CQF: Webhook failed: ' . $e->getMessage());
                error_log('CQF: Falling back to email notifications');
                // Fallback to email if webhook fails
                $this->send_emails_fallback($formData);
            }
        } else {
            // Webhook not enabled, use email system
            error_log('CQF: Webhook not enabled, using email notifications');
            $this->send_emails_fallback($formData);
        }
        
        error_log('CQF: Processing completed');
    }
    
    /**
     * Send admin email safely (with error handling)
     */
    private function send_admin_email_safe($formData) {
        try {
            error_log('CQF: send_admin_email_safe called');
            $this->send_admin_email($formData);
            error_log('CQF: send_admin_email completed without exception');
        } catch (\Throwable $e) {
            error_log('CQF: CRITICAL ERROR - Quote form admin email error: ' . $e->getMessage());
            error_log('CQF: Error type: ' . get_class($e));
            error_log('CQF: Error file: ' . $e->getFile() . ':' . $e->getLine());
            throw $e; // Re-throw to see if it's caught elsewhere
        }
    }
    
    /**
     * Send thank you email safely (with error handling)
     */
    private function send_thank_you_email_safe($formData) {
        try {
            $this->send_thank_you_email($formData);
        } catch (\Throwable $e) {
            error_log('Quote form thank you email error: ' . $e->getMessage());
        }
    }

    /**
     * Verifies the nonce for security.
     */
    private function is_valid_nonce() {
        return isset($_POST['quote_nonce']) && wp_verify_nonce($_POST['quote_nonce'], self::NONCE_ACTION);
    }

    /**
     * Parses and sanitizes the form data.
     */
    private function parse_form_data() {
        parse_str($_POST['formData'], $formData);

        $mobile = sanitize_text_field($formData['cust_mobile'] ?? '');
        $mobileMeta = class_exists('CQF_Shared_Utilities') 
            ? CQF_Shared_Utilities::format_mobile_number($mobile)
            : $this->format_mobile_number($mobile);
        
        $address = sanitize_text_field($formData['cust_address'] ?? '');
        if (empty($address)) {
            $address = sanitize_text_field($formData['manual_cust_address'] ?? '');
        }

        return [
            'service_type' => sanitize_text_field($formData['service_type'] ?? ''),
            'cust_fullname' => sanitize_text_field($formData['cust_fullname'] ?? ''),
            'cust_email' => sanitize_email($formData['cust_email'] ?? ''),
            'cust_mobile' => $mobile,
            'cust_mobile_international' => $mobileMeta['international'],
            'cust_mobile_whatsapp_url' => $mobileMeta['whatsapp'],
            'cust_pin' => sanitize_text_field($formData['cust_pin'] ?? ''),
            'cust_address' => $address,
            'utm_source' => isset($formData['utm_source']) ? sanitize_text_field($formData['utm_source']) : '',
            'site_name' => get_bloginfo('name'),
            'site_url' => get_site_url(),
        ];
    }

    /**
     * Checks if the required fields are present in the form data.
     */
    private function is_valid_form_data($formData) {
        return !empty($formData['service_type'])
            && !empty($formData['cust_fullname'])
            && !empty($formData['cust_email'])
            && !empty($formData['cust_mobile'])
            && !empty($formData['cust_address']);
    }

    /**
     * Retrieves merged plugin settings.
     */
    private function get_settings() {
        return wp_parse_args(
            get_option(self::SETTINGS_OPTION, []),
            [
                'email_recipients' => '', // Empty default - only use what's configured
            ]
        );
    }

    private function send_admin_email($formData) {
        $recipients = $this->get_email_recipients();

        if (empty($recipients)) {
            throw new \RuntimeException('No email recipients configured.');
        }

        // Build subject with postcode and site name
        $postcode = !empty($formData['cust_pin']) ? $formData['cust_pin'] : '';
        $site_name = !empty($formData['site_name']) ? $formData['site_name'] : get_bloginfo('name');
        
        if (!empty($postcode)) {
            $subject = sprintf('Enquiry [%s] - [%s] Homepage Contact Form', $postcode, $site_name);
        } else {
            $subject = sprintf('Enquiry - [%s] Homepage Contact Form', $site_name);
        }
        $body = $this->build_admin_email_body($formData);

        $email_settings = $this->get_email_settings();
        
        if (!empty($email_settings['smtp_enabled'])) {
            // Try SMTP first, fallback to wp_mail if connection or authentication fails
            try {
                // Use exponential backoff retry for rate limit errors
                $this->retry_email_with_backoff(function() use ($recipients, $subject, $body, $formData) {
                    return $this->send_email_via_phpmailer($recipients, $subject, $body, $formData['cust_email'], $formData['cust_fullname']);
                });
            } catch (\RuntimeException $e) {
                $error_message = $e->getMessage();
                $is_localhost = !empty($email_settings['smtp_host']) && strtolower($email_settings['smtp_host']) === 'localhost';
                
                // Fallback to WordPress default mail if:
                // 1. Connection/authentication fails, OR
                // 2. Rate limit retries exhausted
                if ($this->is_connection_error($error_message, $is_localhost) || $this->is_rate_limit_error($e)) {
                    error_log('CQF: SMTP failed (' . $error_message . '), falling back to WordPress default mail');
                    $headers = $this->build_headers($formData['cust_email'], $formData['cust_fullname']);
                    if (!wp_mail($recipients, $subject, $body, $headers)) {
                        error_log('CQF: WordPress default mail also failed');
                        throw new \RuntimeException('Failed to send email via both SMTP and WordPress default mail.');
                    } else {
                        error_log('CQF: Email sent successfully via WordPress default mail (SMTP fallback)');
                    }
                } else {
                    // Re-throw other SMTP errors
                    throw $e;
                }
            }
        } else {
            // Use WordPress default mail
            $headers = $this->build_headers($formData['cust_email'], $formData['cust_fullname']);
            if (!wp_mail($recipients, $subject, $body, $headers)) {
                throw new \RuntimeException('Failed to send fallback admin email.');
            }
        }
    }

    private function send_thank_you_email($formData) {
        $siteURL = esc_url(get_site_url());
        $body = $this->build_thank_you_email_body($formData['cust_fullname'], $siteURL);
        $subject = 'Thank You for Your Quote Request';

        $email_settings = $this->get_email_settings();
        
        if (!empty($email_settings['smtp_enabled'])) {
            // Try SMTP first, fallback to wp_mail if connection or authentication fails
            try {
                // Use exponential backoff retry for rate limit errors
                $this->retry_email_with_backoff(function() use ($formData, $subject, $body) {
                    return $this->send_email_via_phpmailer([$formData['cust_email']], $subject, $body);
                });
            } catch (\RuntimeException $e) {
                $error_message = $e->getMessage();
                $is_localhost = !empty($email_settings['smtp_host']) && strtolower($email_settings['smtp_host']) === 'localhost';
                
                // Fallback to WordPress default mail if:
                // 1. Connection/authentication fails, OR
                // 2. Rate limit retries exhausted
                if ($this->is_connection_error($error_message, $is_localhost) || $this->is_rate_limit_error($e)) {
                    error_log('CQF: SMTP failed for thank you email (' . $error_message . '), falling back to WordPress default mail');
                    $headers = $this->build_headers(self::EMAIL_FROM, CQF_Shared_Utilities::sales_team_name());
                    if (!wp_mail($formData['cust_email'], $subject, $body, $headers)) {
                        error_log('CQF: WordPress default mail also failed for thank you email');
                        throw new \RuntimeException('Failed to send thank you email via both SMTP and WordPress default mail.');
                    } else {
                        error_log('CQF: Thank you email sent successfully via WordPress default mail (SMTP fallback)');
                    }
                } else {
                    // Re-throw other SMTP errors
                    throw $e;
                }
            }
        } else {
            // Use WordPress default mail
            $headers = $this->build_headers(self::EMAIL_FROM, CQF_Shared_Utilities::sales_team_name());
            wp_mail($formData['cust_email'], $subject, $body, $headers);
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
                error_log('CQF: Admin email sent successfully via SMTP to: ' . implode(', ', $recipients));
            } else {
                error_log('CQF: CRITICAL - mail->send() returned false. ErrorInfo: ' . $mail->ErrorInfo);
                throw new \RuntimeException('PHPMailer send() returned false: ' . $mail->ErrorInfo);
            }
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            error_log('CQF: CRITICAL PHPMailer Exception: ' . $e->getMessage());
            error_log('CQF: PHPMailer ErrorInfo: ' . $mail->ErrorInfo);
            error_log('CQF: SMTP Host: ' . $email_settings['smtp_host']);
            error_log('CQF: SMTP Port: ' . $email_settings['smtp_port']);
            error_log('CQF: SMTP Username: ' . $email_settings['smtp_username']);
            
            // Extract SMTP error code if available
            $smtp_code = $this->extract_smtp_error_code($mail->ErrorInfo);
            throw new \RuntimeException('Failed to send email via SMTP: ' . $mail->ErrorInfo, $smtp_code);
        } catch (\Exception $e) {
            error_log('CQF: CRITICAL General Exception in send_email_via_phpmailer: ' . $e->getMessage());
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
        $transient_key = 'cqf_last_email_send';
        $last_send = get_transient($transient_key);
        
        if ($last_send !== false) {
            $elapsed = time() - $last_send;
            if ($elapsed < $min_interval_seconds) {
                $wait_time = $min_interval_seconds - $elapsed;
                error_log("CQF: Throttling email sending, waiting {$wait_time} seconds to prevent rate limiting");
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
                error_log("CQF: Rate limit detected, attempt {$attempt}/{$max_attempts}, waiting {$delay} seconds before retry");
                sleep($delay);
                $delay *= 2; // Exponential backoff
            }
        }
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

    /**
     * Send emails as fallback (when webhook is disabled or fails)
     */
    private function send_emails_fallback($formData) {
        error_log('CQF: Sending emails (fallback method)');
        try {
            error_log('CQF: Attempting to send admin email');
            $this->send_admin_email_safe($formData);
            error_log('CQF: Admin email sent successfully');
        } catch (\Throwable $e) {
            error_log('CQF: CRITICAL - Admin email failed: ' . $e->getMessage());
            error_log('CQF: Stack trace: ' . $e->getTraceAsString());
        }
        
        try {
            // Throttle email sending to prevent rate limiting
            $this->throttle_email_sending();
            
            error_log('CQF: Attempting to send thank you email');
            $this->send_thank_you_email_safe($formData);
            error_log('CQF: Thank you email sent successfully');
        } catch (\Throwable $e) {
            error_log('CQF: CRITICAL - Thank you email failed: ' . $e->getMessage());
            error_log('CQF: Stack trace: ' . $e->getTraceAsString());
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

    private function build_admin_email_body($formData) {
        $serviceType = $formData['service_type'];
        $fullName = $formData['cust_fullname'];
        $email = $formData['cust_email'];
        $mobile = $formData['cust_mobile'];
        $address = $formData['cust_address'];

        $mobileMeta = $this->format_mobile_number($mobile);
        $telLink = $mobileMeta['international'] ?: $mobile;
        $displayMobile = $telLink ?: $mobile;
        $mobileCell = !empty($telLink)
            ? '<a href="tel:' . esc_attr($telLink) . '">' . esc_html($displayMobile) . '</a>'
            : esc_html($mobile);
        $brand = class_exists('CQF_Shared_Utilities') ? CQF_Shared_Utilities::brand_from_host() : '';
        $heading = trim($brand . ' HomePage Initial Contact');

        return "
            <table width='80%' align='center' cellpadding='0' cellspacing='0' style='font-family:Verdana, Geneva, sans-serif; font-size:13px; border:dotted 1px #186ea9; border-bottom:solid 3px #0037ff;'>
                <tr>
                    <td style='background:#0037ff; padding:10px 0; font-weight:bold; color:#fff; font-size:16px;' colspan='2' align='center' valign='middle'>" . esc_html($heading) . "</td>
                </tr>
                <tr>
                    <td width='50%' style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Enquiry For</td>
                    <td width='50%' style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#555;'>$serviceType</td>
                </tr>
                <tr>
                    <td width='50%' style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Full Name</td>
                    <td width='50%' style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#555;'>$fullName</td>
                </tr>
                <tr>
                    <td width='50%' style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Email Address</td>
                    <td width='50%' style='background:#f2f2f2; padding:10px; border-right:solid 1px #ddd; color:#555;'>$email</td>
                </tr>
                <tr>
                    <td width='50%' style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Mobile / WhatsApp</td>
                    <td width='50%' style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#555;'>$mobileCell</td>
                </tr>
                <tr>
                    <td width='50%' style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; font-weight:bold; color:#555;'>Address</td>
                    <td width='50%' style='background:#ffffff; padding:10px; border-right:solid 1px #ddd; color:#555;'>$address</td>
                </tr>
            </table>";
    }

    private function build_thank_you_email_body($fullName, $siteURL) {
        $email_settings = $this->get_email_settings();
        $brand = class_exists('CQF_Shared_Utilities') ? CQF_Shared_Utilities::brand_from_host() : '';
        $whatsapp_url = class_exists('CQF_Shared_Utilities')
            ? CQF_Shared_Utilities::whatsapp_chat_url($email_settings['whatsapp_number'] ?? '', trim('Hi ' . $brand . ' I need Quote / Assistance'))
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
                <p>Thank you for reaching out to us. We have received your quote request and will get back to you soon.</p>
                <p>In the meantime, you can:</p>
                <ul>
                    $whatsapp_item
                    $phone_item
                    <li><a href='$siteURL' style='color:#0037ff;'>Visit our website</a></li>
                </ul>
                <p>Best Regards,<br>" . esc_html(trim($brand . ' Team')) . "</p>
            </div>";
    }

    private function get_email_recipients() {
        // First try to get from shared settings
        if (class_exists('CQF_Shared_Admin_Settings')) {
            $shared_settings = CQF_Shared_Admin_Settings::get_email_settings();
            error_log('CQF: Shared settings notification_recipients: ' . (isset($shared_settings['notification_recipients']) ? $shared_settings['notification_recipients'] : 'NOT SET'));
            
            if (!empty($shared_settings['notification_recipients'])) {
                $emails = array_filter(
                    array_map(
                        'sanitize_email',
                        array_map('trim', explode(',', $shared_settings['notification_recipients']))
                    )
                );
                if (!empty($emails)) {
                    error_log('CQF: Using shared settings emails: ' . implode(', ', $emails));
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
}

new QuoteFormHandler();
