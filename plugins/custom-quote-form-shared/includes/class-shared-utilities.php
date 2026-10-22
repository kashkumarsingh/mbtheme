<?php
/**
 * Shared utilities class for Custom Quote Form plugins
 * 
 * Provides common functionality:
 * - Phone number formatting
 * - Common validation helpers
 */

if (!defined('ABSPATH')) {
    exit;
}

class CQF_Shared_Utilities {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        // No AJAX handlers needed - address API removed
    }
    
    /**
     * Formats mobile number to international format (+44 for UK)
     * 
     * Handles:
     * - 07590937772 → +447590937772
     * - +447590937772 → +447590937772
     * - +44 7590 937772 → +447590937772
     * - 0044 759 093 7772 → +447590937772
     * 
     * @param string $mobile Raw mobile number input
     * @return array Array with 'international' and 'whatsapp' keys
     */
    public static function format_mobile_number($mobile) {
        if (empty($mobile)) {
            return [
                'international' => '',
                'whatsapp' => '',
            ];
        }
        
        // Remove all non-digit characters
        $digits = preg_replace('/\D+/', '', $mobile);
        
        if (empty($digits)) {
            return [
                'international' => '',
                'whatsapp' => '',
            ];
        }
        
        // Handle 00 prefix (international format without +)
        if (strpos($digits, '00') === 0) {
            $digits = substr($digits, 2);
        }
        
        // Format based on starting digits
        if (strpos($digits, '44') === 0) {
            // Already has country code
            $international = '+' . $digits;
        } elseif ($digits[0] === '0') {
            // UK number starting with 0, replace with +44
            $international = '+44' . substr($digits, 1);
        } else {
            // Other format, just add +
            $international = '+' . $digits;
        }
        
        // Create WhatsApp URL (remove + and spaces)
        $whatsappDigits = preg_replace('/\D+/', '', $international);
        $whatsapp = !empty($whatsappDigits) ? 'https://wa.me/' . $whatsappDigits : '';
        
        return [
            'international' => $international,
            'whatsapp' => $whatsapp,
        ];
    }
    
    /**
     * Sanitizes and validates email address
     * 
     * @param string $email Email address
     * @return string|false Sanitized email or false if invalid
     */
    public static function sanitize_email($email) {
        return sanitize_email($email);
    }
    
    /**
     * Sanitizes text field
     * 
     * @param string $text Text to sanitize
     * @return string Sanitized text
     */
    public static function sanitize_text($text) {
        return sanitize_text_field($text);
    }

    /**
     * Digits-only WhatsApp number, or an empty string when none is set.
     *
     * @param string $number
     * @return string
     */
    public static function whatsapp_digits($number) {
        return preg_replace('/\D+/', '', (string) $number);
    }

    /**
     * Phone number safe to show and dial. Keeps a leading + and common separators.
     *
     * @param string $number
     * @return string
     */
    public static function phone_display($number) {
        $number = trim((string) $number);
        $number = preg_replace('/[^\d+\s().-]/', '', $number);
        return trim($number);
    }

    /**
     * tel: href for a display phone number, or an empty string when it has no digits.
     *
     * @param string $number
     * @return string
     */
    public static function phone_tel_url($number) {
        $display = self::phone_display($number);
        $digits = preg_replace('/\D+/', '', $display);
        if ($digits === '') {
            return '';
        }
        $prefix = (strpos($display, '+') === 0) ? '+' : '';
        return 'tel:' . $prefix . $digits;
    }

    /**
     * Customer-facing WhatsApp chat link for a business number.
     *
     * @param string $number
     * @param string $message
     * @return string
     */
    public static function whatsapp_chat_url($number, $message) {
        $digits = self::whatsapp_digits($number);
        if ($digits === '') {
            return '';
        }

        return 'https://api.whatsapp.com/send/?phone=' . rawurlencode($digits)
            . '&text=' . rawurlencode($message)
            . '&type=phone_number&app_absent=0';
    }

    /**
     * Editable part of the sender name. Brand stays outside this value.
     *
     * @return string
     */
    public static function from_name_suffix() {
        $suffix = 'Sales Team';
        if (class_exists('CQF_Settings_Manager')) {
            $settings = CQF_Settings_Manager::get_settings();
            $stored = trim((string) ($settings['email_from_name'] ?? ''));
            $stored = preg_replace('/^\[[^\]]+\]\s*/', '', $stored);
            if ($stored !== '' && strcasecmp($stored, 'Meraboiler Sales Team') !== 0) {
                $suffix = $stored;
            }
        }
        return $suffix;
    }

    /**
     * Sender display name for the site that received the submission.
     * meraboiler.com → [Meraboiler] Sales Team
     * emeraboiler.com → [eMeraboiler] Sales Team
     * megaboiler.com → [Megaboiler] Sales Team
     *
     * @param string|null $host
     * @return string
     */
    public static function sales_team_name($host = null) {
        return '[' . self::brand_from_host($host) . '] ' . self::from_name_suffix();
    }

    /**
     * @param string|null $host
     * @return string
     */
    public static function brand_from_host($host = null) {
        if ($host === null || $host === '') {
            $host = wp_parse_url(home_url(), PHP_URL_HOST);
        }
        if (($host === null || $host === '') && !empty($_SERVER['HTTP_HOST'])) {
            $host = wp_unslash($_SERVER['HTTP_HOST']);
        }

        $host = strtolower((string) $host);
        $host = preg_replace('/:\d+$/', '', $host);
        $host = preg_replace('/^www\./', '', $host);

        $label = $host;
        $parts = array_values(array_filter(explode('.', $host)));
        if (!empty($parts)) {
            $label = $parts[0];
        }

        if ($label === 'emeraboiler') {
            return 'eMeraboiler';
        }
        if ($label === 'meraboiler') {
            return 'Meraboiler';
        }
        if ($label === 'megaboiler') {
            return 'Megaboiler';
        }

        return $label !== '' ? ucfirst($label) : 'Meraboiler';
    }
}

