<?php

$mbgroupltd_seo_ecosystem_file = get_template_directory() . '/inc/seo-ecosystem.php';
if (file_exists($mbgroupltd_seo_ecosystem_file)) {
    require_once $mbgroupltd_seo_ecosystem_file;
}

$mbgroupltd_performance_file = get_template_directory() . '/inc/performance.php';
if (file_exists($mbgroupltd_performance_file)) {
    require_once $mbgroupltd_performance_file;
}

$mbgroupltd_schema_extras_file = get_template_directory() . '/inc/schema-extras.php';
if (file_exists($mbgroupltd_schema_extras_file)) {
    require_once $mbgroupltd_schema_extras_file;
}

$mbgroupltd_job_services_file = get_template_directory() . '/inc/job-services.php';
if (file_exists($mbgroupltd_job_services_file)) {
    require_once $mbgroupltd_job_services_file;
}

$mbgroupltd_entity_truth_file = get_template_directory() . '/inc/entity-truth.php';
if (file_exists($mbgroupltd_entity_truth_file)) {
    require_once $mbgroupltd_entity_truth_file;
}

// Enqueue Styles

function mbgroupltd_enqueue_styles()
{
    // Order: fonts, icons, theme CSS, responsive overrides, design system.
    // Bootstrap was removed: no theme markup depends on it (verified), and
    // the quote plugins enqueue their own copy where they need it.
    // Tailwind utilities come from main.css plus the plugin CDN.

    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Patua+One&family=Nunito+Sans:wght@400;600;700;800&family=Open+Sans:wght@400;600&display=swap', [], null);

    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css', [], null);

    wp_enqueue_style(
        'main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        ['font-awesome'],
        filemtime(get_template_directory() . '/assets/css/main.css')
    );

    $responsive_css_path = get_template_directory() . '/assets/css/responsive.css';
    if (file_exists($responsive_css_path)) {
        wp_enqueue_style(
            'mbgroupltd-responsive',
            get_template_directory_uri() . '/assets/css/responsive.css',
            ['main-style'],
            filemtime($responsive_css_path)
        );
    }

    // Design tokens first, then base. Every dc stylesheet consumes the tokens.
    $dc_tokens_path = get_template_directory() . '/assets/css/dc-tokens.css';
    if (file_exists($dc_tokens_path)) {
        wp_enqueue_style(
            'mbgroupltd-dc-tokens',
            get_template_directory_uri() . '/assets/css/dc-tokens.css',
            ['main-style'],
            filemtime($dc_tokens_path)
        );
    }

    // New-design base styles (header, top bar, footer, buttons) - sitewide.
    $dc_base_path = get_template_directory() . '/assets/css/dc-base.css';
    if (file_exists($dc_base_path)) {
        wp_enqueue_style(
            'mbgroupltd-dc-base',
            get_template_directory_uri() . '/assets/css/dc-base.css',
            ['mbgroupltd-dc-tokens'],
            filemtime($dc_base_path)
        );
    }

    $dc_pages_path = get_template_directory() . '/assets/css/dc-pages.css';
    if (file_exists($dc_pages_path)) {
        wp_enqueue_style(
            'mbgroupltd-dc-pages',
            get_template_directory_uri() . '/assets/css/dc-pages.css',
            ['mbgroupltd-dc-home'],
            filemtime($dc_pages_path)
        );
    }
    // Round 2 (locations map, checker, safety, thank-you).
    $dc_pages2_path = get_template_directory() . '/assets/css/dc-pages-2.css';
    if (file_exists($dc_pages2_path)) {
        wp_enqueue_style(
            'mbgroupltd-dc-pages-2',
            get_template_directory_uri() . '/assets/css/dc-pages-2.css',
            ['mbgroupltd-dc-pages'],
            filemtime($dc_pages2_path)
        );
    }
    $dc_home_path = get_template_directory() . '/assets/css/dc-home.css';
    if (file_exists($dc_home_path)) {
        wp_enqueue_style(
            'mbgroupltd-dc-home',
            get_template_directory_uri() . '/assets/css/dc-home.css',
            ['mbgroupltd-dc-base'],
            filemtime($dc_home_path)
        );
    }

    // NOTE: contact.css does not exist - contact styles live in main.css
    // (.contact-hero block). Do not re-add a contact.css enqueue without
    // moving those rules out of main.css first (would double-load).
}

add_action('wp_enqueue_scripts', 'mbgroupltd_enqueue_styles');



// Enqueue Scripts

function mbgroupltd_enqueue_scripts()
{
    wp_deregister_script('jquery');

    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', [], null, true);

    // Bootstrap JS bundle removed with the CSS: nothing in the theme uses
    // collapse/dropdown/modal JS (custom drawer + dropdown code instead).
    // jQuery stays: the quote plugins depend on it.
    $custom_deps = ['jquery'];

    // Promo offers slider (vanilla JS, front page only).
    if (is_front_page()) {
        $dc_slider_path = get_template_directory() . '/assets/js/dc-slider.js';
        if (file_exists($dc_slider_path)) {
            wp_enqueue_script('mbgroupltd-dc-slider', get_template_directory_uri() . '/assets/js/dc-slider.js', [], filemtime($dc_slider_path), true);
        }
        $dc_rails_path = get_template_directory() . '/assets/js/dc-rails.js';
        if (file_exists($dc_rails_path)) {
            wp_enqueue_script('mbgroupltd-dc-rails', get_template_directory_uri() . '/assets/js/dc-rails.js', [], filemtime($dc_rails_path), true);
        }
    }

    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/assets/js/scripts.js', $custom_deps, filemtime(get_template_directory() . '/assets/js/scripts.js'), true);
}

add_action('wp_enqueue_scripts', 'mbgroupltd_enqueue_scripts');




// Theme Setup

function mbgroupltd_theme_setup()
{

    add_theme_support('custom-logo', [

        'height' => 100,

        'width' => 280,

        'flex-height' => true,

        'flex-width' => true,

    ]);



    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

}

add_action('after_setup_theme', 'mbgroupltd_theme_setup');

/**
 * Ensure /thank-you/ page exists for Google Ads enhanced conversions.
 * Template: page-thank-you.php (page-{slug}.php). Safe if page already exists.
 */
function mbgroupltd_ensure_thank_you_page()
{
    if (get_option('mbgroupltd_thank_you_page_id')) {
        $existing_id = (int) get_option('mbgroupltd_thank_you_page_id');
        if ($existing_id > 0 && get_post_status($existing_id) === 'publish') {
            return;
        }
    }

    $existing = get_page_by_path('thank-you');
    if ($existing instanceof WP_Post) {
        update_option('mbgroupltd_thank_you_page_id', (int) $existing->ID);
        return;
    }

    $page_id = wp_insert_post([
        'post_title'   => 'Thank You',
        'post_name'    => 'thank-you',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
        'post_author'  => 1,
    ], true);

    if (!is_wp_error($page_id) && $page_id) {
        update_option('mbgroupltd_thank_you_page_id', (int) $page_id);
        update_post_meta((int) $page_id, '_wp_page_template', 'page-thank-you.php');
    }
}
add_action('init', 'mbgroupltd_ensure_thank_you_page', 20);

/**
 * Publish Potters Bar service pages on the next front-end or admin load.
 * page-{slug}.php supplies the layout once the page exists. No SQL import.
 */
function mbgroupltd_ensure_potters_bar_pages()
{
    if (get_option('mbgroupltd_potters_bar_pages_ready')) {
        return;
    }

    $pages = [
        'boiler-installation-potters-bar' => ['Boiler Installation Potters Bar', 'page-boiler-installation-potters-bar.php'],
        'boiler-repair-potters-bar' => ['Boiler Repair Potters Bar', 'page-boiler-repair-potters-bar.php'],
        'boiler-service-potters-bar' => ['Boiler Servicing Potters Bar', 'page-boiler-service-potters-bar.php'],
        'emergency-boiler-repair-potters-bar' => ['Emergency Boiler Repair Potters Bar', 'page-emergency-boiler-repair-potters-bar.php'],
    ];

    foreach ($pages as $slug => $spec) {
        [$title, $template] = $spec;
        $existing = get_page_by_path($slug);
        if ($existing instanceof WP_Post) {
            if ($existing->post_status !== 'publish') {
                wp_update_post([
                    'ID' => (int) $existing->ID,
                    'post_status' => 'publish',
                ]);
            }
            update_post_meta((int) $existing->ID, '_wp_page_template', $template);
            continue;
        }

        $page_id = wp_insert_post([
            'post_title' => $title,
            'post_name' => $slug,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '',
            'post_author' => 1,
        ], true);

        if (!is_wp_error($page_id) && $page_id) {
            update_post_meta((int) $page_id, '_wp_page_template', $template);
        }
    }

    update_option('mbgroupltd_potters_bar_pages_ready', 1, false);
}
add_action('init', 'mbgroupltd_ensure_potters_bar_pages', 21);

/**
 * Prefer noindex on thank-you so tokenized conversion snapshots are not indexed.
 */
function mbgroupltd_thank_you_robots($robots)
{
    if (is_page('thank-you') || is_page_template('page-thank-you.php')) {
        if (is_array($robots)) {
            $robots['noindex'] = true;
            $robots['nofollow'] = true;
            return $robots;
        }
    }
    return $robots;
}
add_filter('wp_robots', 'mbgroupltd_thank_you_robots');

/**
 * Keep theme SEO tags simple and reliable when no SEO plugin is active.
 */
function mbgroupltd_has_external_seo_plugin()
{
    return defined('WPSEO_VERSION')
        || defined('RANK_MATH_VERSION')
        || defined('AIOSEO_VERSION')
        || class_exists('The_SEO_Framework\\Load');
}

function mbgroupltd_get_current_url()
{
    if (is_singular()) {
        return get_permalink();
    }

    if (is_home()) {
        $home_id = (int) get_option('page_for_posts');
        if ($home_id > 0) {
            return get_permalink($home_id);
        }
    }

    if (is_post_type_archive()) {
        return get_post_type_archive_link(get_query_var('post_type'));
    }

    if (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        if ($term && !is_wp_error($term)) {
            return get_term_link($term);
        }
    }

    if (is_author()) {
        return get_author_posts_url((int) get_query_var('author'));
    }

    if (is_search()) {
        return get_search_link();
    }

    return home_url(add_query_arg([], $GLOBALS['wp']->request ?? ''));
}

function mbgroupltd_get_canonical_url()
{
    $url = mbgroupltd_get_current_url();
    if (is_wp_error($url) || empty($url)) {
        return home_url('/');
    }

    $paged = max((int) get_query_var('paged'), (int) get_query_var('page'));
    if ($paged > 1 && !is_singular()) {
        $url = add_query_arg('paged', $paged, $url);
    }

    return $url;
}

function mbgroupltd_get_meta_description()
{
    if (is_front_page()) {
        $front_id = (int) get_option('page_on_front');
        if ($front_id > 0) {
            $excerpt = get_the_excerpt($front_id);
            if (!empty($excerpt)) {
                return wp_trim_words(wp_strip_all_tags($excerpt), 28, '...');
            }

            $content = get_post_field('post_content', $front_id);
            if (!empty($content)) {
                return wp_trim_words(wp_strip_all_tags(do_shortcode($content)), 28, '...');
            }
        }
    }

    if (is_singular()) {
        $excerpt = get_the_excerpt();
        if (!empty($excerpt)) {
            return wp_trim_words(wp_strip_all_tags($excerpt), 28, '...');
        }

        $content = get_post_field('post_content', get_the_ID());
        if (!empty($content)) {
            return wp_trim_words(wp_strip_all_tags(do_shortcode($content)), 28, '...');
        }
    }

    if (is_category() || is_tag() || is_tax()) {
        $description = term_description();
        if (!empty($description)) {
            return wp_trim_words(wp_strip_all_tags($description), 28, '...');
        }
    }

    if (is_search()) {
        return sprintf('Search results for "%s" on %s.', get_search_query(), get_bloginfo('name'));
    }

    return wp_trim_words((string) get_bloginfo('description'), 28, '...');
}

function mbgroupltd_get_og_image_url()
{
    if (is_singular() && has_post_thumbnail()) {
        $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
        if (!empty($image)) {
            return $image;
        }
    }

    $logo_id = get_theme_mod('custom_logo');
    if (!empty($logo_id)) {
        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
        if (!empty($logo_url)) {
            return $logo_url;
        }
    }

    return mbgroupltd_image('logo-meraboiler.png');
}

/**
 * Theme images stored in the media library (uploads/2026/10).
 * Keys are the previous asset filenames.
 */
function mbgroupltd_theme_images()
{
    return [
        'logo-meraboiler.png' => 'meraboiler-boiler-installation-logo.png',
        'boiler-bosch-greenstar.png' => 'worcester-bosch-greenstar-combi-boiler.png',
        'boiler-vaillant-ecotec.png' => 'vaillant-ecotec-plus-combi-boiler.png',
        'boiler-glowworm-energy.png' => 'glow-worm-energy-combi-boiler.png',
        'boiler-ariston-one.png' => 'ariston-one-combi-boiler.png',
        'brand-worcester.png' => 'worcester-bosch-brand-logo.png',
        'brand-vaillant.png' => 'vaillant-brand-logo.png',
        'brand-glowworm.png' => 'glow-worm-brand-logo.png',
        'brand-ariston.png' => 'ariston-brand-logo.png',
        'cylinder-unvented.png' => 'unvented-hot-water-cylinder.png',
        'service-installation.png' => 'gas-safe-boiler-installation.png',
        'service-repair.png' => 'boiler-repair-engineer.png',
        'service-servicing.png' => 'annual-boiler-service.png',
        'service-thermostat.png' => 'smart-thermostat-fitting.png',
        'service-powerflush.png' => 'heating-system-power-flush.png',
        'service-underfloor.jpg' => 'underfloor-heating-with-a-boiler.jpg',
        'service-central-heating.jpg' => 'central-heating-installation.jpg',
        'uk-map.svg' => 'uk-boiler-service-areas-map.svg',
    ];
}

function mbgroupltd_image($key)
{
    $images = mbgroupltd_theme_images();
    $file = $images[$key] ?? basename((string) $key);
    return content_url('uploads/2026/10/' . $file);
}

function mbgroupltd_get_robots_directive()
{
    if (is_search() || is_404() || is_tag()) {
        return 'noindex,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1';
    }

    return 'index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1';
}

/**
 * Redirect legacy /contactus URLs to the canonical /contact-us page (301).
 * Consolidates analytics (e.g. Site Kit) on one path.
 */
function mbgroupltd_redirect_contactus_to_contact_us()
{
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return;
    }

    $uri_path = wp_parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if (!is_string($uri_path) || $uri_path === '') {
        return;
    }

    $path = trim($uri_path, '/');
    $home_path = trim((string) (wp_parse_url(home_url('/'), PHP_URL_PATH) ?: ''), '/');
    if ($home_path !== '') {
        if ($path === $home_path) {
            $path = '';
        } elseif (strpos($path, $home_path . '/') === 0) {
            $path = trim(substr($path, strlen($home_path) + 1), '/');
        }
    }

    if (strtolower($path) !== 'contactus') {
        return;
    }

    $target = home_url('/contact-us/');
    if (!empty($_GET)) {
        $target = add_query_arg(wp_unslash($_GET), $target);
    }

    wp_safe_redirect($target, 301);
    exit;
}

add_action('template_redirect', 'mbgroupltd_redirect_contactus_to_contact_us', 0);

/**
 * Fix bad /chat URLs like https://meraboiler.com/meraboiler.com/chat
 * (relative link "meraboiler.com/chat" without https://).
 * Also serve /chat when no WP page exists yet.
 */
function mbgroupltd_request_path_relative()
{
    $uri_path = wp_parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if (!is_string($uri_path) || $uri_path === '') {
        return '';
    }

    $path = trim($uri_path, '/');
    $home_path = trim((string) (wp_parse_url(home_url('/'), PHP_URL_PATH) ?: ''), '/');
    if ($home_path !== '') {
        if ($path === $home_path) {
            return '';
        }
        if (strpos($path, $home_path . '/') === 0) {
            $path = trim(substr($path, strlen($home_path) + 1), '/');
        }
    }
    return $path;
}

function mbgroupltd_normalize_public_url($url)
{
    $url = trim((string) $url);
    if ($url === '') {
        return '';
    }
    // meraboiler.com/chat  ->  https://meraboiler.com/chat
    if (preg_match('#^(?:www\.)?meraboiler\.com(/.*)?$#i', $url, $m)) {
        return 'https://meraboiler.com' . (isset($m[1]) && $m[1] !== '' ? $m[1] : '/');
    }
    // Any bare host/path without scheme
    if (!preg_match('#^(?:[a-z][a-z0-9+.-]*:)?//#i', $url) && preg_match('#^[a-z0-9.-]+\.[a-z]{2,}(/|$)#i', $url)) {
        return 'https://' . $url;
    }
    return $url;
}

function mbgroupltd_fix_chat_paths()
{
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return;
    }

    $path = strtolower(mbgroupltd_request_path_relative());

    if ($path === 'chat' || $path === 'meraboiler.com/chat' || $path === 'www.meraboiler.com/chat') {
        $target = home_url('/contact-us/');
        if (!empty($_GET)) {
            $target = add_query_arg(wp_unslash($_GET), $target);
        }
        wp_safe_redirect($target, 301);
        exit;
    }
}
add_action('template_redirect', 'mbgroupltd_fix_chat_paths', 0);



// Register Menus

function mbgroupltd_register_menus()
{

    register_nav_menus([

        'main-menu' => __('Main Menu', 'mbgroupltd'),

        'footer_menu' => __('Footer Menu', 'mbgroupltd'),

        'footer_column_1_menu' => __('Footer Column 1 Menu', 'mbgroupltd'),

        'footer_column_2_menu' => __('Footer Column 2 Menu', 'mbgroupltd'),

        'footer_column_3_menu' => __('Footer Column 3 Menu', 'mbgroupltd'),

        'footer_column_4_menu' => __('Footer Column 4 Menu', 'mbgroupltd'),

    ]);

}

add_action('init', 'mbgroupltd_register_menus');



// Add this in your plugin or theme's functions.php or relevant PHP file
add_action('wp_ajax_fetch_address_suggestions', 'fetch_address_suggestions');
add_action('wp_ajax_nopriv_fetch_address_suggestions', 'fetch_address_suggestions');

function fetch_address_suggestions() {
    try {
        // Sanitize and retrieve postcode
        $postcode = sanitize_text_field($_GET['postcode']);

        // Example: API call or processing
        $apiUrl = "https://api.ideal-postcodes.co.uk/v1/postcodes/" . urlencode($postcode) . "?api_key=ak_lxsz8dglM4w48USGY5De1qNVdyQ9Q";

        // Example: Perform cURL request or API call
        $response = wp_remote_get($apiUrl);

        if (is_wp_error($response)) {
            throw new Exception('Error fetching data: ' . $response->get_error_message());
        }

        // Example: Process response and return data
        $data = wp_remote_retrieve_body($response);
        wp_send_json_success($data);
    } catch (Exception $e) {
        error_log('Error fetching address suggestions: ' . $e->getMessage());
        wp_send_json_error('Error fetching address suggestions: ' . $e->getMessage());
    }

    // Ensure to exit to avoid further execution
    wp_die();
}

// Enqueue Scripts for Specific Pages or Sections

/**
 * Safe internal link: returns the page permalink when the path exists as a
 * WP page, otherwise the fallback (default: quote page). Prevents 404s from
 * location cross-links where a city/service combo has no page yet.
 */
function mbgroupltd_nearby_url($path, $fallback = '/quote/')
{
    $slug = trim((string) $path, '/');
    if ($slug === '') {
        return home_url($fallback);
    }
    $page = get_page_by_path($slug);
    if ($page) {
        return get_permalink($page);
    }
    return home_url($fallback);
}

/**
 * Blog index (home.php) renders its own query at 7 posts per page.
 * Mirror that in the main query so /boiler-guide/page/N/ exists for every
 * page the pager links to instead of 404ing on the main query count.
 */
function mbgroupltd_blog_posts_per_page($query)
{
    if (is_admin() || !$query->is_main_query() || !$query->is_home()) {
        return;
    }
    $query->set('posts_per_page', 7);
}
add_action('pre_get_posts', 'mbgroupltd_blog_posts_per_page');

/**
 * Disable Table of Contents Plus auto-insert on Boiler Guide posts.
 */
add_filter('toc_insert', function ($content) {
    if (is_singular('post')) {
        return '';
    }
    return $content;
}, 20);

add_filter('the_content', function ($content) {
    if (!is_singular('post')) {
        return $content;
    }
    // Strip common TOC wrappers if a plugin already injected them.
    $content = preg_replace('/<div[^>]*id=["\']toc_container["\'][^>]*>.*?<\/div>/is', '', $content);
    $content = preg_replace('/<nav[^>]*class=["\'][^"\']*toc[^"\']*["\'][^>]*>.*?<\/nav>/is', '', $content);
    return $content;
}, 25);


