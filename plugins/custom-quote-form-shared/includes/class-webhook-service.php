<?php
/**
 * Webhook Service for Custom Quote Form plugins
 * 
 * Handles webhook delivery with retry logic and error handling
 */

if (!defined('ABSPATH')) {
    exit;
}

class CQF_Webhook_Service {
    
    /**
     * Send form submission to webhook URL
     * 
     * @param array $payload Webhook payload data
     * @param string $webhook_url Webhook URL
     * @param string $api_key Optional API key for authentication
     * @return array Response data
     * @throws \RuntimeException If webhook fails after all retries
     */
    public static function send($payload, $webhook_url, $api_key = '') {
        if (empty($webhook_url)) {
            throw new \RuntimeException('Webhook URL is empty');
        }
        
        // Validate URL
        if (!filter_var($webhook_url, FILTER_VALIDATE_URL)) {
            throw new \RuntimeException('Invalid webhook URL format');
        }
        
        // Use retry utility for exponential backoff
        return CQF_Retry_Utility::retry_with_backoff(
            function() use ($webhook_url, $payload, $api_key) {
                return self::dispatch($webhook_url, $payload, $api_key);
            },
            'webhook'
        );
    }
    
    /**
     * Dispatch webhook HTTP request
     * 
     * @param string $webhook_url Webhook URL
     * @param array $payload JSON payload
     * @param string $api_key Optional API key for authentication
     * @return array Response data
     * @throws \RuntimeException If request fails
     */
    private static function dispatch($webhook_url, $payload, $api_key = '') {
        $headers = [
            'Content-Type' => 'application/json',
        ];
        
        // Add API key header if provided (for Make.com and similar services)
        if (!empty($api_key)) {
            $headers['x-make-apikey'] = $api_key;
        }
        
        $response = wp_remote_post($webhook_url, [
            'timeout' => 10,
            'headers' => $headers,
            'body' => wp_json_encode($payload),
            'data_format' => 'body',
        ]);

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            error_log('CQF Webhook: Request failed: ' . $error_message);
            throw new \RuntimeException('Webhook request failed: ' . $error_message);
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);

        // Consider 2xx status codes as success
        if ($status_code >= 200 && $status_code < 300) {
            error_log('CQF Webhook: Sent successfully (HTTP ' . $status_code . ')');
            return ['success' => true, 'status_code' => $status_code, 'body' => $body];
        } else {
            error_log('CQF Webhook: Error status: HTTP ' . $status_code);
            error_log('CQF Webhook: Response body: ' . $body);
            throw new \RuntimeException('Webhook returned error status: HTTP ' . $status_code, $status_code);
        }
    }
    
    /**
     * Build webhook payload for quote form wizard.
     * Flat structure so Zapier gets the same top-level keys as the homepage form.
     *
     * @param array $formData Form submission data
     * @param int|false $submission_id Database submission ID
     * @return array Webhook payload
     */
    public static function build_wizard_payload($formData, $submission_id = null) {
        $site_name = $formData['site_name'] ?? get_bloginfo('name');
        $site_url  = $formData['site_url'] ?? get_site_url();
        $address   = ! empty( $formData['street'] ) ? trim( $formData['street'] . ' ' . ( $formData['postcode'] ?? '' ) ) : ( $formData['postcode'] ?? '' );

        return [
            'site'                   => $site_name,
            'site_url'               => $site_url,
            'submitted_at_utc'       => $formData['submitted_at_utc'] ?? current_time('mysql', true),
            'service_type'           => $formData['service_type'] ?? '',
            'full_name'              => $formData['full_name'] ?? '',
            'email'                  => $formData['email'] ?? '',
            'mobile'                 => $formData['mobile'] ?? '',
            'mobile_international'   => $formData['mobile_international'] ?? '',
            'mobile_whatsapp_url'    => $formData['mobile_whatsapp_url'] ?? '',
            'postal_code'            => $formData['postcode'] ?? '',
            'address'                => $address,
            'utm_source'             => '', // wizard doesn't collect utm_source by default
            'querystring'            => isset( $_SERVER['QUERY_STRING'] ) ? $_SERVER['QUERY_STRING'] : '',
            'form_type'              => 'quote-form-wizard',
            'submission_id'          => $submission_id ?: null,
            'owner_type'             => $formData['owner_type'] ?? '',
            'hear_about_us'          => $formData['hear_about_us'] ?? '',
            'boiler_age'             => $formData['boiler_age'] ?? '',
            'boiler_working'         => $formData['boiler_working'] ?? '',
            'fuel_type'              => $formData['fuel_type'] ?? '',
            'existing_boiler'        => $formData['existing_boiler'] ?? '',
            'desired_boiler'         => $formData['desired_boiler'] ?? '',
            'property_type'          => $formData['property_type'] ?? '',
            'bedrooms'               => $formData['bedrooms'] ?? '',
            'bath_tubs'              => $formData['bath_tubs'] ?? '',
            'showers'                => $formData['showers'] ?? '',
            'occupants'              => $formData['occupants'] ?? '',
            // Installation / location fields
            'current_boiler_location' => $formData['current_boiler_location'] ?? '',
            'new_boiler_location'     => $formData['new_boiler_location'] ?? '',
            'flue_exit'               => $formData['flue_exit'] ?? '',
            'flue_height'             => $formData['flue_height'] ?? '',
            'flue_distance'           => $formData['flue_distance'] ?? '',
            'flue_structure'          => $formData['flue_structure'] ?? '',
            'flue_window_distance'    => $formData['flue_window_distance'] ?? '',
            'meter_distance'          => $formData['meter_distance'] ?? '',
            'radiators'               => $formData['radiators'] ?? '',
        ];
    }
    
    /**
     * Build webhook payload for regular quote form (homepage contact).
     * Flat structure so Zapier and other webhooks get top-level keys like before.
     *
     * @param array $formData Form submission data
     * @param int|false $submission_id Database submission ID
     * @return array Webhook payload
     */
    public static function build_regular_payload($formData, $submission_id = null) {
        $site_name = $formData['site_name'] ?? get_bloginfo('name');
        $site_url  = $formData['site_url'] ?? get_site_url();

        return [
            'site'                   => $site_name,
            'site_url'               => $site_url,
            'submitted_at_utc'       => current_time('mysql', true),
            'service_type'           => $formData['service_type'] ?? '',
            'full_name'              => $formData['cust_fullname'] ?? '',
            'email'                  => $formData['cust_email'] ?? '',
            'mobile'                 => $formData['cust_mobile'] ?? '',
            'mobile_international'   => $formData['cust_mobile_international'] ?? '',
            'mobile_whatsapp_url'    => $formData['cust_mobile_whatsapp_url'] ?? '',
            'postal_code'            => $formData['cust_pin'] ?? '',
            'address'                => $formData['cust_address'] ?? '',
            'utm_source'             => $formData['utm_source'] ?? '',
            'querystring'            => isset( $_SERVER['QUERY_STRING'] ) ? $_SERVER['QUERY_STRING'] : '',
            'form_type'              => 'quote-form',
            'submission_id'          => $submission_id ?: null,
        ];
    }
}

