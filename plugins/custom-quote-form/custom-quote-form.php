<?php

/*

Plugin Name: Custom Quote Form

Description: A custom quote form integrated with Tailwind and Bootstrap.

Version: 1.0

Author: MeraboilerIT

Text Domain: custom-quote-form

*/



// Exit if accessed directly

if (!defined('ABSPATH')) {

    exit;

}



// Define plugin path

define('CQF_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Load shared utilities if available
if (class_exists('CQF_Shared_Utilities')) {
    // Shared utilities already loaded
} elseif (file_exists(WP_PLUGIN_DIR . '/custom-quote-form-shared/includes/class-shared-utilities.php')) {
    require_once WP_PLUGIN_DIR . '/custom-quote-form-shared/includes/class-shared-utilities.php';
    CQF_Shared_Utilities::get_instance();
}

// Include necessary files
require_once CQF_PLUGIN_PATH . 'includes/class-database.php';
require_once CQF_PLUGIN_PATH . 'includes/enqueue-scripts.php';
require_once CQF_PLUGIN_PATH . 'includes/form-handler.php';

if (is_admin()) {
    require_once CQF_PLUGIN_PATH . 'includes/admin-settings.php';
}

// Add Shortcode

function cqf_quote_form_shortcode() {

    ob_start();

    include(CQF_PLUGIN_PATH . 'templates/quote-form.php');

    return ob_get_clean();

}

add_shortcode('cqf_quote_form', 'cqf_quote_form_shortcode');

// Create database table on plugin activation
register_activation_hook(__FILE__, ['CQF_Database', 'create_table']);

// Update table structure on plugin load (for existing installations)
add_action('plugins_loaded', function() {
    CQF_Database::update_table();
}, 10);

