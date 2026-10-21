<?php
/**
 * Meraboiler performance helpers: delay third parties, WP bloat trim.
 * NOTE: Do not inject layout-critical CSS here - it caused a zoom/FOUC flash
 * when Tailwind/Bootstrap/main.css arrived later and overrode it.
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Preconnect to critical third-party origins.
 */
add_action('wp_head', static function () {
    $origins = [
        'https://fonts.gstatic.com',
        'https://cdn.jsdelivr.net',
        'https://cdnjs.cloudflare.com',
    ];
    foreach ($origins as $origin) {
        $cross = (strpos($origin, 'gstatic') !== false || strpos($origin, 'cdn') !== false) ? ' crossorigin' : '';
        echo '<link rel="preconnect" href="' . esc_url($origin) . '"' . $cross . '>' . "\n";
        echo '<link rel="dns-prefetch" href="' . esc_url($origin) . '">' . "\n";
    }
}, 1);

/**
 * Tiny, non-layout stabilisers only (no grids/columns/font scaling).
 */
add_action('wp_head', static function () {
    echo '<style id="mb-critical-css">'
        . 'html{-webkit-text-size-adjust:100%;text-size-adjust:100%;}'
        . 'img{max-width:100%;height:auto;}'
        . '.admin-bar .header-section{top:32px}'
        . '@media(max-width:782px){.admin-bar .header-section{top:46px}}'
        . '</style>';
}, 2);

/**
 * Do not defer layout CSS. Late CSS was the "reload zoom" bug sitewide.
 * Only defer clearly non-layout leftovers.
 */
add_filter('style_loader_tag', static function ($html, $handle) {
    $defer_handles = [
        'wp-block-library',
        'classic-theme-styles',
        'global-styles',
    ];
    if (!in_array($handle, $defer_handles, true)) {
        return $html;
    }
    if (strpos($html, 'onload=') !== false) {
        return $html;
    }
    $html = preg_replace("/\smedia=['\"][^'\"]*['\"]/", '', $html);
    if (substr(rtrim($html), -2) === '/>') {
        $html = preg_replace('/\s*\/>/', ' media="print" onload="this.media=\'all\'" />', $html, 1);
    } else {
        $html = str_replace('>', ' media="print" onload="this.media=\'all\'">', $html);
    }
    $noscript = preg_replace('/\smedia="print" onload="this\.media=\'all\'"/', '', $html);
    return $html . '<noscript>' . $noscript . '</noscript>';
}, 10, 2);

/**
 * Prefer defer on non-critical foot scripts only (never jQuery/Bootstrap).
 */
add_filter('script_loader_tag', static function ($tag, $handle) {
    $defer = [
        'custom-scripts',
    ];
    if (!in_array($handle, $defer, true)) {
        return $tag;
    }
    if (strpos($tag, ' defer') !== false || strpos($tag, ' async') !== false) {
        return $tag;
    }
    return str_replace(' src', ' defer src', $tag);
}, 10, 2);

/**
 * Strip common WordPress front-end bloat.
 */
add_action('init', static function () {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
}, 1);

add_action('wp_enqueue_scripts', static function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('classic-theme-styles');
    wp_deregister_script('wp-embed');
}, 100);

/**
 * NOTE: analytics pixels (GA/GTM/Meta/TikTok) load once, immediately, from
 * header.php. A previous version also re-injected the same IDs lazily here,
 * causing double PageViews - removed 2026-10-14. Do not re-add lazy pixel
 * loading without removing the header tags first.
 */
