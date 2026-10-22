<?php
/**
 * Enhanced conversions helper for Google Ads thank-you page.
 *
 * Used only after quote wizard completion. Does not affect Zapier webhooks.
 */

if (!defined('ABSPATH')) {
    exit;
}

class CQF_Enhanced_Conversions {

    const TRANSIENT_PREFIX = 'cqf_ec_';
    const TTL_SECONDS = 900; // 15 minutes

    /**
     * Store enhanced conversion fields after quote wizard submit (thank-you only).
     *
     * @param string $token     New one-time thank-you token.
     * @param array  $form_data Sanitized wizard form fields.
     * @return string Token used.
     */
    public static function store_from_wizard($token, $form_data) {
        if (empty($token)) {
            return '';
        }

        $name_parts = self::split_name($form_data['full_name'] ?? '');

        $phone = !empty($form_data['mobile_international'])
            ? $form_data['mobile_international']
            : ($form_data['mobile'] ?? '');

        $street = !empty($form_data['street'])
            ? $form_data['street']
            : '';

        self::store($token, [
            'form_type' => 'quote-form-wizard',
            'email' => $form_data['email'] ?? '',
            'phone_number' => $phone,
            'first_name' => $name_parts['first_name'],
            'last_name' => $name_parts['last_name'],
            'full_name' => $form_data['full_name'] ?? '',
            'street' => $street,
            'postal_code' => $form_data['postcode'] ?? '',
            'country' => 'GB',
            'service_type' => $form_data['service_type'] ?? '',
        ]);

        return $token;
    }

    /**
     * Persist payload under a short-lived transient.
     *
     * @param string $token
     * @param array  $payload
     */
    public static function store($token, array $payload) {
        $token = sanitize_text_field($token);
        if ($token === '') {
            return;
        }

        $clean = [
            'form_type' => sanitize_key($payload['form_type'] ?? ''),
            'email' => sanitize_email($payload['email'] ?? ''),
            'phone_number' => sanitize_text_field($payload['phone_number'] ?? ''),
            'first_name' => sanitize_text_field($payload['first_name'] ?? ''),
            'last_name' => sanitize_text_field($payload['last_name'] ?? ''),
            'full_name' => sanitize_text_field($payload['full_name'] ?? ''),
            'street' => sanitize_text_field($payload['street'] ?? ''),
            'postal_code' => sanitize_text_field($payload['postal_code'] ?? ''),
            'country' => sanitize_text_field($payload['country'] ?? 'GB'),
            'service_type' => sanitize_text_field($payload['service_type'] ?? ''),
            'stored_at' => time(),
        ];

        set_transient(self::TRANSIENT_PREFIX . $token, $clean, self::TTL_SECONDS);
    }

    /**
     * Retrieve payload for thank-you page (one-time; deleted after fetch).
     *
     * @param string $token
     * @return array|null
     */
    public static function consume($token) {
        $token = sanitize_text_field($token);
        if ($token === '') {
            return null;
        }

        $key = self::TRANSIENT_PREFIX . $token;
        $data = get_transient($key);
        if ($data === false || !is_array($data)) {
            return null;
        }

        delete_transient($key);
        return $data;
    }

    /**
     * Peek without deleting. Prefer consume().
     *
     * @param string $token
     * @return array|null
     */
    public static function get($token) {
        $token = sanitize_text_field($token);
        if ($token === '') {
            return null;
        }

        $data = get_transient(self::TRANSIENT_PREFIX . $token);
        return is_array($data) ? $data : null;
    }

    /**
     * Build thank-you redirect URL for a token.
     *
     * @param string $token
     * @param array  $extra_args
     * @return string
     */
    public static function thank_you_url($token, array $extra_args = []) {
        $args = array_merge([
            'token' => $token,
        ], $extra_args);

        return add_query_arg(array_filter($args), home_url('/thank-you/'));
    }

    /**
     * Split a full name into first / last for Google EC address fields.
     *
     * @param string $full_name
     * @return array{first_name:string,last_name:string}
     */
    public static function split_name($full_name) {
        $full_name = trim((string) $full_name);
        if ($full_name === '') {
            return ['first_name' => '', 'last_name' => ''];
        }

        $parts = preg_split('/\s+/', $full_name, 2);
        return [
            'first_name' => $parts[0] ?? '',
            'last_name' => $parts[1] ?? '',
        ];
    }
}
