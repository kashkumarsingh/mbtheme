<?php
/**
 * Settings Sanitizer - Handles all settings sanitization
 */

if (!defined('ABSPATH')) {
    exit;
}

class CQF_Settings_Sanitizer {

    public function sanitize($settings) {
        // CRITICAL: Check checkboxes BEFORE merging with defaults
        $raw_settings = (array) $settings;
        $smtp_enabled = isset($raw_settings['smtp_enabled']) ? 1 : 0;
        $smtp_auth = isset($raw_settings['smtp_auth']) ? 1 : 0;
        $webhook_enabled = isset($raw_settings['webhook_enabled']) ? 1 : 0;
        
        $defaults = CQF_Settings_Manager::get_default_settings();
        $settings = wp_parse_args($raw_settings, $defaults);

        // Sanitize email settings
        $settings['email_from'] = sanitize_email($settings['email_from'] ?? '');
        $from_name = sanitize_text_field($settings['email_from_name'] ?? '');
        $from_name = trim(preg_replace('/^\[[^\]]+\]\s*/', '', $from_name));
        $settings['email_from_name'] = $from_name !== '' ? $from_name : 'Sales Team';
        
        // Set checkbox values from raw POST (before merge)
        $settings['smtp_enabled'] = $smtp_enabled;
        $settings['smtp_auth'] = $smtp_auth;
        $settings['webhook_enabled'] = $webhook_enabled;
        
        $settings['smtp_host'] = sanitize_text_field($settings['smtp_host'] ?? '');
        $settings['smtp_port'] = absint($settings['smtp_port'] ?? 587);
        $settings['smtp_encryption'] = sanitize_text_field($settings['smtp_encryption'] ?? 'tls');
        $settings['smtp_username'] = sanitize_text_field($settings['smtp_username'] ?? '');
        $settings['smtp_password'] = $settings['smtp_password'] ?? '';
        $settings['phone_number'] = class_exists('CQF_Shared_Utilities')
            ? CQF_Shared_Utilities::phone_display($settings['phone_number'] ?? '')
            : trim(preg_replace('/[^\d+\s().-]/', '', (string) ($settings['phone_number'] ?? '')));
        $settings['whatsapp_number'] = class_exists('CQF_Shared_Utilities')
            ? CQF_Shared_Utilities::whatsapp_digits($settings['whatsapp_number'] ?? '')
            : preg_replace('/\D+/', '', (string) ($settings['whatsapp_number'] ?? ''));

        // Sanitize notification recipients
        $emails = array_filter(
            array_map(
                'sanitize_email',
                array_map('trim', explode(',', $settings['notification_recipients'] ?? ''))
            )
        );
        $settings['notification_recipients'] = implode(', ', $emails);

        // Sanitize webhook URL
        $webhook_url = esc_url_raw($settings['webhook_url'] ?? '');
        if (!empty($webhook_url) && !filter_var($webhook_url, FILTER_VALIDATE_URL)) {
            $webhook_url = '';
            add_settings_error(
                CQF_Settings_Manager::OPTION_KEY,
                'invalid_webhook_url',
                __('Invalid webhook URL format. Please enter a valid URL.', 'custom-quote-form-shared')
            );
        }
        if (!empty($webhook_url) && !preg_match('/^https?:\/\//i', $webhook_url)) {
            $webhook_url = '';
            add_settings_error(
                CQF_Settings_Manager::OPTION_KEY,
                'invalid_webhook_protocol',
                __('Webhook URL must start with http:// or https://', 'custom-quote-form-shared')
            );
        }
        $settings['webhook_url'] = $webhook_url;

        $webhook_wizard_url = esc_url_raw($settings['webhook_wizard_url'] ?? '');
        if (!empty($webhook_wizard_url) && !filter_var($webhook_wizard_url, FILTER_VALIDATE_URL)) {
            $webhook_wizard_url = '';
        }
        if (!empty($webhook_wizard_url) && !preg_match('/^https?:\/\//i', $webhook_wizard_url)) {
            $webhook_wizard_url = '';
        }
        $settings['webhook_wizard_url'] = $webhook_wizard_url;
        $settings['webhook_api_key'] = sanitize_text_field($settings['webhook_api_key'] ?? '');

        return $settings;
    }
}

