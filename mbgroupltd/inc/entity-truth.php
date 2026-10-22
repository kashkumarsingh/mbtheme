<?php
/**
 * One set of public facts for SEO, AEO and LLMs.
 * Sanitises on-page copy, schema, Yoast graph, and /llms.txt.
 */
if (!defined('ABSPATH')) {
    exit;
}

function mbgroupltd_entity_facts()
{
    return [
        'name' => 'MeraBoiler',
        'phone_display' => '020 8150 2025',
        'phone_tel' => '+442081502025',
        'email' => 'info@meraboiler.com',
        'admin_email' => 'admin@meraboiler.com',
        'whatsapp' => '447894020000',
        'gas_emergency' => '0800 111 999',
        'street' => 'Suite 1, Greenleaf House',
        'city' => 'Potters Bar',
        'region' => 'Hertfordshire',
        'postcode' => 'EN6 1AE',
        'price_combi' => 1680,
        'price_from' => '£1,680 fully fitted',
        'price_offer' => '£1,890',
        'finance' => 'Boiler finance is not currently advertised. Quotes are fixed-price for like-for-like work; a survey confirms extras.',
        'reviews' => 'Customers review MeraBoiler on Google and Trustpilot. Always check the live listing for the current rating and review count.',
        'hours_office' => 'Office hours 8am–8pm Monday to Friday, 8am–6pm Saturday, 9am–5pm Sunday. Emergency engineer callouts are arranged separately.',
        'linkedin' => 'https://uk.linkedin.com/company/meraboiler',
        'facebook' => 'https://www.facebook.com/officialMeraBoiler/',
        'instagram' => 'https://www.instagram.com/meraboiler/',
        'tiktok' => 'https://www.tiktok.com/@meraboiler',
        'youtube' => 'https://www.youtube.com/@meraboiler',
        'trustpilot' => 'https://www.trustpilot.com/review/meraboiler.com',
        'google_reviews' => 'https://www.google.com/maps/search/?api=1&query=MeraBoiler+Potters+Bar',
        'google_rating' => '4.0',
        'google_review_count' => '271',
    ];
}

function mbgroupltd_google_review_sentence()
{
    $facts = mbgroupltd_entity_facts();
    return 'Google rating ' . $facts['google_rating'] . ' from ' . $facts['google_review_count'] . ' reviews';
}

function mbgroupltd_google_review_links_html()
{
    $facts = mbgroupltd_entity_facts();
    return '<p class="dc-mut dc-review-links">' . esc_html(mbgroupltd_google_review_sentence()) . '. '
        . '<a href="' . esc_url($facts['google_reviews']) . '">Google reviews</a> · '
        . '<a href="' . esc_url($facts['trustpilot']) . '">Trustpilot reviews</a></p>';
}

function mbgroupltd_sanitize_entity_text($text)
{
    if (!is_string($text) || $text === '') {
        return $text;
    }

    $replacements = [
        'meraboiler@gmail.com' => 'info@meraboiler.com',
        'If you smell gas call 785 7870 000 immediately!' => 'If you smell gas, leave the property and call the National Gas Emergency Service on 0800 111 999 immediately.',
        'If you smell gas call 785 7870 000 (7857870000) immediately!' => 'If you smell gas, leave the property and call the National Gas Emergency Service on 0800 111 999 immediately.',
        'call 785 7870 000 immediately' => 'call the National Gas Emergency Service on 0800 111 999 immediately',
        'call 785 7870 000' => 'call 0800 111 999',
        '785 7870 000 (7857870000)' => '0800 111 999',
        '7857870000' => '0800111999',
        '785 7870 000' => '0800 111 999',
        'from £1750' => 'from £1,890',
        'from £1,750' => 'from £1,890',
        'replacement from £1750' => 'replacement from £1,890',
        'replacement from £1,750' => 'replacement from £1,890',
        'With a 5-star rating on Trustpilot, accrued from over 7000 customer reviews, and a service rated ‘Excellent’, Meraboiler’s stellar reputation is clear for all to see. Constantly raising the bar in terms of their service and performance, Meraboiler has been awarded the prestigious Which? Trusted Trader accreditation. This is only the beginning however, as Meraboiler promises to not only maintain but build upon these levels of excellence as the company continues to go from strength to strength.' =>
            'MeraBoiler uses Gas Safe registered engineers and publishes customer feedback on Google and Trustpilot. Check those live listings for the current rating and review count rather than any figure copied from this page.',
        'over 7000 customer reviews' => 'reviews on Google and Trustpilot (see the live listings for the current count)',
        'over 7000' => 'hundreds of',
        '7000 customer reviews' => 'Google and Trustpilot reviews',
        'Which? Trusted Trader accreditation' => 'Gas Safe registered engineers',
        'the prestigious Which? Trusted Trader' => 'Gas Safe registration',
        'We perform both gas boiler installations and LPG boilers.' => 'We install and repair mains natural-gas boilers. We do not fit LPG, oil or heat-pump systems.',
        'and LPG boilers' => '',
        'flexible finance plans' => 'fixed-price quotes',
        'Compare fixed-price options, flexible finance plans, and book trusted gas safe engineers with mera boiler.' =>
            'Compare fixed-price options and book Gas Safe registered engineers with MeraBoiler.',
    ];

    $out = str_ireplace(array_keys($replacements), array_values($replacements), $text);

    // Keep the phrase on the finance guide. Elsewhere it is not an offer we make.
    $path = strtolower((string) wp_parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH));
    $finance_guide = str_contains(trailingslashit($path), '/blog/boiler-finance-london-pay-monthly-0-interest/');
    if (!$finance_guide) {
        $out = preg_replace('#<span[^>]*>\s*0%\s*finance[^<]*</span>#i', '', $out);
        $out = preg_replace('/\b0%\s*finance\b/i', 'fixed-price quotes', $out);
    }

    return $out;
}

function mbgroupltd_sanitize_entity_deep($value)
{
    if (is_string($value)) {
        return mbgroupltd_sanitize_entity_text($value);
    }
    if (is_array($value)) {
        foreach ($value as $key => $item) {
            if ($key === 'foundingDate') {
                unset($value[$key]);
                continue;
            }
            if ($key === 'email' && is_string($item) && stripos($item, 'gmail.com') !== false) {
                $value[$key] = mbgroupltd_entity_facts()['email'];
                continue;
            }
            $value[$key] = mbgroupltd_sanitize_entity_deep($item);
        }
    }
    return $value;
}

add_filter('the_content', 'mbgroupltd_sanitize_entity_text', 99);
add_filter('the_excerpt', 'mbgroupltd_sanitize_entity_text', 99);
add_filter('wpseo_metadesc', 'mbgroupltd_sanitize_entity_text', 99);
add_filter('wpseo_title', 'mbgroupltd_sanitize_entity_text', 99);
add_filter('wpseo_opengraph_desc', 'mbgroupltd_sanitize_entity_text', 99);

add_filter('wpseo_schema_graph', static function ($graph) {
    return mbgroupltd_sanitize_entity_deep($graph);
}, 99);

add_filter('wpseo_schema_organization', static function ($data) {
    $facts = mbgroupltd_entity_facts();
    unset($data['foundingDate'], $data['numberOfEmployees']);
    $data['email'] = $facts['email'];
    $data['telephone'] = $facts['phone_tel'];
    $data['legalName'] = $facts['name'];
    $data['description'] = 'UK Gas Safe boiler installation, repair and servicing from Potters Bar. Fixed-price quotes from ' . $facts['price_from'] . '. Google rating ' . $facts['google_rating'] . ' from ' . $facts['google_review_count'] . ' reviews.';
    $data['address'] = [
        '@type' => 'PostalAddress',
        'streetAddress' => $facts['street'],
        'addressLocality' => $facts['city'],
        'addressRegion' => $facts['region'],
        'postalCode' => $facts['postcode'],
        'addressCountry' => 'GB',
    ];
    $data['sameAs'] = [
        $facts['facebook'],
        $facts['instagram'],
        $facts['tiktok'],
        $facts['youtube'],
        $facts['linkedin'],
        $facts['trustpilot'],
        $facts['google_reviews'],
    ];
    return mbgroupltd_sanitize_entity_deep($data);
}, 99);

add_filter('wpseo_schema_website', static function ($data) {
    $facts = mbgroupltd_entity_facts();
    $data['description'] = 'Gas Safe boiler installation, service and repair in London and the UK. Like-for-like combi fitting from ' . $facts['price_from'] . '.';
    return mbgroupltd_sanitize_entity_deep($data);
}, 99);

add_filter('wp_robots', static function ($robots) {
    if (!is_array($robots)) {
        return $robots;
    }
    $noindex = false;
    if (is_attachment() || is_author()) {
        $noindex = true;
    }
    if (is_singular('attachment')) {
        $noindex = true;
    }
    if (is_page('thank-you') || is_page_template('page-thank-you.php')) {
        $noindex = true;
    }
    if ($noindex) {
        $robots['noindex'] = true;
        $robots['follow'] = true;
    }
    return $robots;
}, 20);

add_filter('wpseo_sitemap_exclude_post_type', static function ($excluded, $post_type) {
    if ($post_type === 'attachment') {
        return true;
    }
    return $excluded;
}, 10, 2);

add_action('template_redirect', static function () {
    if (is_admin()) {
        return;
    }
    $path = trim((string) (wp_parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: ''), '/');
    $home = trim((string) (wp_parse_url(home_url('/'), PHP_URL_PATH) ?: ''), '/');
    if ($home !== '' && strpos($path, $home . '/') === 0) {
        $path = trim(substr($path, strlen($home) + 1), '/');
    }
    if ($path !== 'llms.txt') {
        return;
    }
    $file = get_template_directory() . '/llms.txt';
    if (!is_readable($file)) {
        return;
    }
    status_header(200);
    header('Content-Type: text/plain; charset=utf-8');
    header('X-Robots-Tag: noindex');
    nocache_headers();
    readfile($file);
    exit;
}, 0);

add_filter('robots_txt', static function ($output, $public) {
    if (!$public) {
        return $output;
    }
    if (stripos($output, 'llms.txt') === false) {
        $output .= "\n# Curated LLM brief (theme overrides Yoast auto file)\n";
        $output .= 'Sitemap: ' . home_url('/sitemap_index.xml') . "\n";
    }
    $output = preg_replace('/User-agent: GPTBot\s+Disallow: \/\*\?m=me-/i', "User-agent: GPTBot\nAllow: /", $output);
    $output = preg_replace('/User-agent: Google-Extended\s+Disallow: \/\*\?m=me-/i', "User-agent: Google-Extended\nAllow: /", $output);
    $extra = "\nUser-agent: GPTBot\nAllow: /\n\nUser-agent: ChatGPT-User\nAllow: /\n\nUser-agent: ClaudeBot\nAllow: /\n\nUser-agent: PerplexityBot\nAllow: /\n";
    if (stripos($output, 'ChatGPT-User') === false) {
        $output .= $extra;
    }
    return $output;
}, 20, 2);
