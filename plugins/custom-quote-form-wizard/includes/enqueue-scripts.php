<?php
function cqfw_enqueue_scripts() {
    $css = plugin_dir_path(__FILE__) . '../assets/css/custom-quote-form-wizard.css';
    $js = plugin_dir_path(__FILE__) . '../assets/js/wizard-plain.js';
    wp_enqueue_style('cqfe-custom-css', plugin_dir_url(__FILE__) . '../assets/css/custom-quote-form-wizard.css', [], file_exists($css) ? filemtime($css) : '1.2.3');

    wp_enqueue_script('cqfw-custom-js', plugin_dir_url(__FILE__) . '../assets/js/wizard-plain.js', [], file_exists($js) ? filemtime($js) : '1.2.3', true);

    // Localize script to pass AJAX URL and thank-you redirect
    wp_localize_script('cqfw-custom-js', 'cqfw_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'home_url' => home_url('/'),
        'thank_you_url' => home_url('/thank-you/'),
    ));
}
add_action('wp_enqueue_scripts', 'cqfw_enqueue_scripts');