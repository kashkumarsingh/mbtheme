<?php
function cqf_enqueue_scripts() {
    // Enqueue Custom CSS
    $cqf_css = plugin_dir_path(__FILE__) . '../assets/css/custom-quote-form.css';
    wp_enqueue_style('cqf-custom-css', plugin_dir_url(__FILE__) . '../assets/css/custom-quote-form.css', [], file_exists($cqf_css) ? filemtime($cqf_css) : '1.0.5');

    // Enqueue Parsley JS
    wp_enqueue_script('parsley-js', 'https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js', array('jquery'), '2.9.2', true);

    // Enqueue Custom JS (ensure jQuery loads first)
    wp_enqueue_script(
        'cqf-custom-js',
        plugin_dir_url(__FILE__) . '../assets/js/custom-quote-form.js',
        array('jquery'), // jQuery dependency ensures it loads first
        '1.0.4', // Bump version to force cache refresh
        true
    );

    // Localize script to pass AJAX URL and redirect URL
    wp_localize_script('cqf-custom-js', 'cqf_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'redirect_url' => home_url('/quote') // Homepage form continues into the wizard
    ));
}
add_action('wp_enqueue_scripts', 'cqf_enqueue_scripts');
