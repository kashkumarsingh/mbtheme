<?php
/*
Plugin Name: Custom Quote Form Wizard
Description: A custom quote form wizard integrated with Tailwind and Bootstrap.
Version: 1.0
Author: MeraboilerIT
Text Domain: custom-quote-form-wizard
*/

//Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

//define plugin path

define('CQFW_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Load shared utilities if available
if (class_exists('CQF_Shared_Utilities')) {
    // Shared utilities already loaded
} elseif (file_exists(WP_PLUGIN_DIR . '/custom-quote-form-shared/includes/class-shared-utilities.php')) {
    require_once WP_PLUGIN_DIR . '/custom-quote-form-shared/includes/class-shared-utilities.php';
    CQF_Shared_Utilities::get_instance();
}

//Include necessary files
require_once CQFW_PLUGIN_PATH . 'includes/class-database.php';
require_once CQFW_PLUGIN_PATH . 'includes/enqueue-scripts.php';
require_once CQFW_PLUGIN_PATH . 'includes/form-handler.php';

if (is_admin()) {
    require_once CQFW_PLUGIN_PATH . 'includes/admin-settings.php';
}

// Create database table on plugin activation
register_activation_hook(__FILE__, ['CQFW_Database', 'create_table']);
//add shortcode

function cqfw_quote_form_shortcode(){
    ob_start();
    include(CQFW_PLUGIN_PATH .'templates/quote-form-wizard.php');
    return ob_get_clean();
}

add_shortcode('cqfw_quote_form', 'cqfw_quote_form_shortcode');