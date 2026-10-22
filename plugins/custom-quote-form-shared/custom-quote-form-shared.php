<?php
/**
 * Plugin Name: Custom Quote Form Shared Utilities
 * Description: Shared utilities for Custom Quote Form plugins (address API, phone formatting, etc.)
 * Version: 1.0
 * Author: MeraboilerIT
 * Text Domain: custom-quote-form-shared
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define shared utilities path
if (!defined('CQF_SHARED_PATH')) {
    define('CQF_SHARED_PATH', plugin_dir_path(__FILE__));
}

// Load shared utilities class
require_once CQF_SHARED_PATH . 'includes/class-shared-utilities.php';

// Load retry utility
require_once CQF_SHARED_PATH . 'includes/class-retry-utility.php';

// Load webhook service
require_once CQF_SHARED_PATH . 'includes/class-webhook-service.php';

// Load TikTok Events API helper
require_once CQF_SHARED_PATH . 'includes/class-tiktok-events.php';

// Load Google enhanced conversions helper (thank-you page only; not used by webhooks)
require_once CQF_SHARED_PATH . 'includes/class-enhanced-conversions.php';

// Load admin settings (refactored with separation of concerns)
require_once CQF_SHARED_PATH . 'includes/settings/class-settings-manager.php';

// Backward compatibility - maintain old class name
if (!class_exists('CQF_Shared_Admin_Settings')) {
    class CQF_Shared_Admin_Settings {
        public static function get_email_settings() {
            return CQF_Settings_Manager::get_email_settings();
        }
        
        public static function get_webhook_settings() {
            return CQF_Settings_Manager::get_webhook_settings();
        }
    }
}

// Initialize shared utilities
CQF_Shared_Utilities::get_instance();

// Initialize settings manager
new CQF_Settings_Manager();

/**
 * Get shared assets URL (for loader.svg, etc.)
 */
if (!function_exists('cqf_shared_asset_url')) {
    function cqf_shared_asset_url($path = '') {
        return plugin_dir_url(__FILE__) . 'assets/' . ltrim($path, '/');
    }
}

