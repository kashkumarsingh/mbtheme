<?php
/**
 * Extra structured data for Rich Results: LocalBusiness + FAQPage.
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Local HVAC business entity (complements Yoast Organization).
 */
function mbgroupltd_local_business_schema()
{
    $facts = function_exists('mbgroupltd_entity_facts') ? mbgroupltd_entity_facts() : [];
    $logo = function_exists('mbgroupltd_get_og_image_url') ? mbgroupltd_get_og_image_url() : '';
    return [
        '@context' => 'https://schema.org',
        '@type' => 'HVACBusiness',
        '@id' => home_url('/#localbusiness'),
        'name' => $facts['name'] ?? 'MeraBoiler',
        'url' => home_url('/'),
        'image' => $logo ?: home_url('/wp-content/uploads/'),
        'telephone' => $facts['phone_tel'] ?? '+442081502025',
        'email' => $facts['email'] ?? 'info@meraboiler.com',
        'priceRange' => '££',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $facts['street'] ?? 'Suite 1, Greenleaf House',
            'addressLocality' => $facts['city'] ?? 'Potters Bar',
            'addressRegion' => $facts['region'] ?? 'Hertfordshire',
            'postalCode' => $facts['postcode'] ?? 'EN6 1AE',
            'addressCountry' => 'GB',
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => 51.6931,
            'longitude' => -0.1786,
        ],
        'areaServed' => [
            ['@type' => 'AdministrativeArea', 'name' => 'London'],
            ['@type' => 'Country', 'name' => 'United Kingdom'],
        ],
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '08:00',
                'closes' => '20:00',
            ],
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => 'Saturday',
                'opens' => '08:00',
                'closes' => '18:00',
            ],
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => 'Sunday',
                'opens' => '09:00',
                'closes' => '17:00',
            ],
        ],
        'aggregateRating' => [
            '@type' => 'AggregateRating',
            'ratingValue' => $facts['google_rating'] ?? '4.0',
            'reviewCount' => $facts['google_review_count'] ?? '271',
            'bestRating' => '5',
        ],
        'sameAs' => array_values(array_filter([
            $facts['facebook'] ?? 'https://www.facebook.com/officialMeraBoiler/',
            $facts['instagram'] ?? 'https://www.instagram.com/meraboiler/',
            $facts['tiktok'] ?? 'https://www.tiktok.com/@meraboiler',
            $facts['youtube'] ?? 'https://www.youtube.com/@meraboiler',
            $facts['linkedin'] ?? 'https://uk.linkedin.com/company/meraboiler',
            $facts['trustpilot'] ?? 'https://www.trustpilot.com/review/meraboiler.com',
            $facts['google_reviews'] ?? 'https://www.google.com/maps/search/?api=1&query=MeraBoiler+Potters+Bar',
        ])),
    ];
}

/**
 * FAQPage matching the hardcoded homepage questions.
 */
function mbgroupltd_faq_page_schema()
{
    $items = [
        ['How much does a new boiler cost?', 'A like-for-like combi swap starts from around £1,680 fully fitted. Your fixed quote depends on the boiler model, controls and any pipework changes, agreed in writing before we start.'],
        ['Do you cover my area?', 'We install and repair across London and the surrounding areas, plus Bristol, Birmingham, Manchester, Leeds and more. Enter your postcode in the quote form to check instantly.'],
        ['How long does a boiler installation take?', 'Most straightforward combi swaps are done in a day. Conversions or system moves can take two to three days. We\'ll confirm the plan at the survey.'],
        ['What guarantee do I get with a new boiler?', 'Up to 12 years, depending on the boiler model (5 years on Ariston, up to 10 years on Vaillant and up to 12 years on Worcester Bosch), including parts and labour once registered and subject to yearly servicing. We handle all the paperwork for you.'],
        ['Are your engineers Gas Safe registered?', 'Yes. Every MeraBoiler engineer is Gas Safe registered. Feel free to ask to see ID on arrival.'],
        ['How often should I service my boiler?', 'Once a year. An annual service keeps the appliance safe, protects the guarantee and is often required by the manufacturer.'],
    ];
    $entities = [];
    foreach ($items as $item) {
        $answer = wp_strip_all_tags($item[1]);
        if (function_exists('mbgroupltd_sanitize_entity_text')) {
            $answer = mbgroupltd_sanitize_entity_text($answer);
        }
        if ($answer === '') {
            continue;
        }
        $entities[] = [
            '@type' => 'Question',
            'name' => $item[0],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $answer,
            ],
        ];
    }
    if (!$entities) {
        return null;
    }
    return [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        '@id' => home_url('/#faq'),
        'mainEntity' => $entities,
    ];
}

add_action('wp_footer', static function () {
    if (is_admin()) {
        return;
    }
    $blocks = [mbgroupltd_local_business_schema()];

    // When Yoast/Rank Math is absent, also emit basic Organization + WebPage.
    if (!function_exists('mbgroupltd_has_external_seo_plugin') || !mbgroupltd_has_external_seo_plugin()) {
        $blocks[] = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => home_url('/#organization'),
            'name' => get_bloginfo('name'),
            'url' => home_url('/'),
            'telephone' => '+442081502025',
            'logo' => function_exists('mbgroupltd_get_og_image_url') ? mbgroupltd_get_og_image_url() : '',
        ];
        $blocks[] = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => home_url('/#webpage'),
            'name' => wp_get_document_title(),
            'url' => function_exists('mbgroupltd_get_canonical_url') ? mbgroupltd_get_canonical_url() : home_url('/'),
            'isPartOf' => ['@id' => home_url('/#website')],
        ];
    }

    if (is_front_page()) {
        $faq = mbgroupltd_faq_page_schema();
        if ($faq) {
            $blocks[] = $faq;
        }
    }
    foreach ($blocks as $block) {
        echo '<script type="application/ld+json">' . wp_json_encode($block, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}, 5);
