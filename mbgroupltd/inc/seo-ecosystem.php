<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('mbgroupltd_seo_locations')) {
    function mbgroupltd_seo_locations()
    {
        return [
            'london' => 'London',
            'birmingham' => 'Birmingham',
            'bristol' => 'Bristol',
            'manchester' => 'Manchester',
            'leeds' => 'Leeds',
            'coventry' => 'Coventry',
            'leicester' => 'Leicester',
            'nottingham' => 'Nottingham',
            'surrey' => 'Surrey',
            'bromley' => 'Bromley',
            'gloucester' => 'Gloucester',
            'southampton' => 'Southampton',
            'kent' => 'Kent',
            'liverpool' => 'Liverpool',
            'north-london' => 'North London',
            'potters-bar' => 'Potters Bar',
            'cardiff' => 'Cardiff',
            'sheffield' => 'Sheffield',
        ];
    }
}

if (!function_exists('mbgroupltd_service_hub_path')) {
    function mbgroupltd_service_hub_path($service_type)
    {
        $hubs = [
            'installation' => '/boiler-installation/',
            'repair' => '/boiler-repair-near-me/',
            'service' => '/boiler-service/',
            'emergency' => '/emergency-boiler-repair/',
        ];

        return $hubs[$service_type] ?? '/service-areas/';
    }
}

if (!function_exists('mbgroupltd_location_content_signals')) {
    function mbgroupltd_location_content_signals($location_slug)
    {
        $location_slug = sanitize_title((string) $location_slug);
        $defaults = [
            'housing' => 'mixed property types including flats, terraces, and detached homes',
            'seasonal' => 'winter demand peaks and pre-winter servicing demand',
            'coverage_note' => 'city centre and surrounding residential postcodes',
        ];

        $signals = [
            'london' => ['housing' => 'Victorian terraces, converted flats, and modern apartments', 'seasonal' => 'high winter callout volumes and older heating systems in dense postcodes', 'coverage_note' => 'North, East, South and West London zones'],
            'birmingham' => ['housing' => 'semi-detached suburbs and mixed urban housing', 'seasonal' => 'winter pressure and pump faults in older homes', 'coverage_note' => 'B postcodes and nearby commuter belts'],
            'bristol' => ['housing' => 'period homes, townhouses, and newer estates', 'seasonal' => 'autumn servicing demand before cold months', 'coverage_note' => 'central Bristol and BS districts'],
            'manchester' => ['housing' => 'city apartments and family housing estates', 'seasonal' => 'high demand during sudden cold snaps', 'coverage_note' => 'M postcodes and surrounding residential zones'],
            'leeds' => ['housing' => 'terraced housing and suburban family homes', 'seasonal' => 'boiler pressure and circulation issues in winter', 'coverage_note' => 'LS districts across north and south Leeds'],
            'coventry' => ['housing' => 'post-war housing stock and newer developments', 'seasonal' => 'increased breakdown callouts in colder months', 'coverage_note' => 'CV postcodes and nearby areas'],
            'leicester' => ['housing' => 'Victorian terraces and mixed suburban housing', 'seasonal' => 'annual-service demand rises strongly in autumn', 'coverage_note' => 'LE central and outer postcodes'],
            'nottingham' => ['housing' => 'mixed city housing and suburban developments', 'seasonal' => 'frequent winter no-heat emergencies', 'coverage_note' => 'NG districts including city and outskirts'],
            'surrey' => ['housing' => 'detached family homes and commuter properties', 'seasonal' => 'efficiency upgrades before winter heating periods', 'coverage_note' => 'key GU, KT, RH, SM and TW areas'],
            'bromley' => ['housing' => 'family homes, bungalows, and suburban terraces', 'seasonal' => 'older systems requiring annual reliability checks', 'coverage_note' => 'BR postcodes and neighbouring districts'],
            'gloucester' => ['housing' => 'historic housing stock and modern estates', 'seasonal' => 'cold-season repair demand with ageing boilers', 'coverage_note' => 'GL city and nearby service routes'],
            'southampton' => ['housing' => 'coastal apartments and suburban homes', 'seasonal' => 'winter response demand and annual safety checks', 'coverage_note' => 'SO postcodes across city and outskirts'],
            'kent' => ['housing' => 'mixed commuter towns and semi-rural homes', 'seasonal' => 'preventive servicing demand before winter', 'coverage_note' => 'CT, ME, TN and DA service coverage'],
            'liverpool' => ['housing' => 'urban terraces and suburban family properties', 'seasonal' => 'high urgent-repair demand in cold periods', 'coverage_note' => 'L postcodes across the city region'],
            'north-london' => ['housing' => 'period terraces, flats, and high-density residential streets', 'seasonal' => 'high boiler load during winter in older homes', 'coverage_note' => 'N postcodes and surrounding boroughs'],
            'potters-bar' => ['housing' => '1930s semis, detached family homes and newer estates around EN6', 'seasonal' => 'winter breakdowns on older combi boilers in family houses', 'coverage_note' => 'Potters Bar, Little Heath, South Mimms and nearby EN postcodes'],
            'cardiff' => ['housing' => 'city terraces, apartments, and suburban homes', 'seasonal' => 'increased emergency breakdowns in winter', 'coverage_note' => 'CF districts across Cardiff'],
            'sheffield' => ['housing' => 'hillside housing, terraces, and suburban family homes', 'seasonal' => 'winter demand for annual service and fault response', 'coverage_note' => 'S postcodes across Sheffield'],
        ];

        return array_merge($defaults, $signals[$location_slug] ?? []);
    }
}

if (!function_exists('mbgroupltd_render_location_context_block')) {
    function mbgroupltd_render_location_context_block($service_type, $location_slug, $location_label)
    {
        $service_type = sanitize_key((string) $service_type);
        $location_slug = sanitize_title((string) $location_slug);
        $location_label = sanitize_text_field((string) $location_label);
        if (empty($location_slug) || $location_slug === 'uk') {
            return;
        }

        $signals = mbgroupltd_location_content_signals($location_slug);
        $service_label = [
            'installation' => 'boiler installation',
            'repair' => 'boiler repair',
            'service' => 'boiler servicing',
            'emergency' => 'emergency boiler repair',
        ][$service_type] ?? 'boiler support';

        echo '<section style="background:#fff;">';
        echo '<div class="dc-container" style="padding-top:72px;padding-bottom:72px;">';
        echo '<h2 class="dc-h2" style="margin-bottom:32px;">Local ' . esc_html(ucwords($service_label)) . ' Context in ' . esc_html($location_label) . '</h2>';
        echo '<div class="dc-cards-3">';
        echo '<div class="dc-card dc-problem"><h3>Property types we commonly serve</h3><p>Our engineers regularly work on ' . esc_html($signals['housing']) . ' in ' . esc_html($location_label) . '.</p></div>';
        echo '<div class="dc-card dc-problem"><h3>Seasonal demand pattern</h3><p>We plan engineer coverage around ' . esc_html($signals['seasonal']) . ' to reduce wait times.</p></div>';
        echo '<div class="dc-card dc-problem"><h3>Coverage note</h3><p>We support ' . esc_html($signals['coverage_note']) . ' with fixed-price quoting and clear scheduling.</p></div>';
        echo '</div>';
        echo '</div>';
        echo '</section>';
    }
}

if (!function_exists('mbgroupltd_parse_service_page_context')) {
    function mbgroupltd_parse_service_page_context($slug)
    {
        $slug = sanitize_title((string) $slug);
        $locations = mbgroupltd_seo_locations();
        $contexts = [
            'boiler-installation' => 'installation',
            'boiler-repair-near-me' => 'repair',
            'boiler-service' => 'service',
            'emergency-boiler-repair' => 'emergency',
        ];

        if (isset($contexts[$slug])) {
            return [
                'service_type' => $contexts[$slug],
                'location_slug' => 'uk',
                'location_label' => 'UK',
            ];
        }

        $patterns = [
            'installation' => '/^boiler-installation-(.+)$/',
            'repair' => '/^boiler-repair-(.+)$/',
            'service' => '/^boiler-service-(.+)$/',
            'emergency' => '/^emergency-boiler-repair-(.+)$/',
        ];

        foreach ($patterns as $service_type => $pattern) {
            if (preg_match($pattern, $slug, $matches)) {
                $location_slug = sanitize_title($matches[1]);
                $location_label = $locations[$location_slug] ?? ucwords(str_replace('-', ' ', $location_slug));
                return [
                    'service_type' => $service_type,
                    'location_slug' => $location_slug,
                    'location_label' => $location_label,
                ];
            }
        }

        if (preg_match('/^(vaillant|worcester-bosch|glowwarm|glowworm|ariston)-boiler-(installation|repair|service)(?:-(.+))?$/', $slug, $matches)) {
            $service_type_map = [
                'installation' => 'installation',
                'repair' => 'repair',
                'service' => 'service',
            ];
            $service_type = $service_type_map[$matches[2]] ?? 'service';
            $location_slug = !empty($matches[3]) ? sanitize_title($matches[3]) : 'uk';
            $location_label = $location_slug === 'uk'
                ? 'UK'
                : ($locations[$location_slug] ?? ucwords(str_replace('-', ' ', $location_slug)));
            return [
                'service_type' => $service_type,
                'location_slug' => $location_slug,
                'location_label' => $location_label,
            ];
        }

        return null;
    }
}

if (!function_exists('mbgroupltd_render_service_hub_links')) {
    function mbgroupltd_render_service_hub_links($service_type, $location_slug = '', $location_label = '')
    {
        $service_type = sanitize_key((string) $service_type);
        $location_slug = sanitize_title((string) $location_slug);
        $location_label = sanitize_text_field((string) $location_label);
        $has_location = !empty($location_slug) && !in_array($location_slug, ['uk', 'boiler-service', 'emergency-boiler-repair'], true);
        $label = $location_label ?: ($has_location ? ucwords(str_replace('-', ' ', $location_slug)) : 'UK');

        $services = [
            'installation' => ['name' => 'Boiler Installation', 'path_prefix' => '/boiler-installation-'],
            'repair' => ['name' => 'Boiler Repair', 'path_prefix' => '/boiler-repair-'],
            'service' => ['name' => 'Boiler Service', 'path_prefix' => '/boiler-service-'],
            'emergency' => ['name' => 'Emergency Boiler Repair', 'path_prefix' => '/emergency-boiler-repair-'],
        ];

        echo '<section style="background:#eef3fa;">';
        echo '<div class="dc-container" style="padding-top:72px;padding-bottom:72px;">';
        echo '<h2 class="dc-h2" style="margin-bottom:8px;">Related Heating Services' . ($has_location ? ' in ' . esc_html($label) : '') . '</h2>';
        echo '<p class="dc-sub muted" style="margin-bottom:32px;">Compare nearby options and choose the right service for your home.</p>';
        echo '<div class="dc-areas__grid">';

        foreach ($services as $key => $service) {
            if ($has_location) {
                $candidate_path = $service['path_prefix'] . $location_slug . '/';
                $candidate_url = home_url($candidate_path);
                $candidate_post = get_page_by_path(trim($candidate_path, '/'));
                $url = $candidate_post ? $candidate_url : home_url(mbgroupltd_service_hub_path($key));
            } else {
                $url = home_url(mbgroupltd_service_hub_path($key));
            }
            $is_current = $key === $service_type;
            $text = $service['name'] . ($has_location ? ' ' . $label : '');
            echo '<a class="dc-card dc-areas__card" href="' . esc_url($url) . '"' . ($is_current ? ' aria-current="page"' : '') . '>' . esc_html(trim($text)) . '</a>';
        }

        echo '</div>';
        echo '<div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:28px;">';
        echo '<a class="dc-btn dc-btn--outline" href="' . esc_url(home_url('/service-areas/')) . '">View all service areas</a>';
        echo '<a class="dc-btn" href="' . esc_url(home_url('/quote/')) . '">Get a fixed-price quote</a>';
        echo '</div>';
        echo '</div>';
        echo '</section>';
    }
}

if (!function_exists('mbgroupltd_print_service_schema')) {
    function mbgroupltd_print_service_schema()
    {
        if (!is_page()) {
            return;
        }

        $post_id = get_queried_object_id();
        if (!$post_id) {
            return;
        }

        $slug = get_post_field('post_name', $post_id);
        $context = mbgroupltd_parse_service_page_context($slug);
        if (!$context) {
            return;
        }

        $service_labels = [
            'installation' => 'Boiler Installation',
            'repair' => 'Boiler Repair',
            'service' => 'Boiler Service',
            'emergency' => 'Emergency Boiler Repair',
        ];

        $service_label = $service_labels[$context['service_type']] ?? 'Boiler Service';
        $location_label = $context['location_label'];
        $is_uk = $context['location_slug'] === 'uk';
        $service_name = $is_uk ? $service_label . ' UK' : $service_label . ' in ' . $location_label;
        $page_url = get_permalink($post_id);
        $hub_url = home_url(mbgroupltd_service_hub_path($context['service_type']));

        $service_schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service_name,
            'serviceType' => $service_label,
            'provider' => [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'url' => home_url('/'),
                'telephone' => '+442081502025',
            ],
            'areaServed' => $is_uk ? 'United Kingdom' : $location_label,
            'url' => $page_url,
        ];

        $breadcrumb = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => home_url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $service_label,
                    'item' => $hub_url,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $is_uk ? 'UK Coverage' : $location_label,
                    'item' => $page_url,
                ],
            ],
        ];

        echo '<script type="application/ld+json">' . wp_json_encode($service_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
        echo '<script type="application/ld+json">' . wp_json_encode($breadcrumb, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
add_action('wp_head', 'mbgroupltd_print_service_schema', 35);

/* NOTE: the old mb-seo-links/mb-seo-local-context inline styles were removed
   2026-10-15: both blocks now render with the shared dc section classes. */

if (!function_exists('mbgroupltd_filter_attachment_indexing')) {
    function mbgroupltd_filter_attachment_indexing($robots)
    {
        if (is_attachment()) {
            $robots['noindex'] = true;
            $robots['nofollow'] = false;
        }

        return $robots;
    }
}
add_filter('wp_robots', 'mbgroupltd_filter_attachment_indexing');

if (!function_exists('mbgroupltd_redirect_attachment_pages')) {
    function mbgroupltd_redirect_attachment_pages()
    {
        if (!is_attachment()) {
            return;
        }

        $attachment_id = get_queried_object_id();
        $target = wp_get_attachment_url($attachment_id);
        if (!empty($target)) {
            wp_safe_redirect($target, 301);
            exit;
        }
    }
}
add_action('template_redirect', 'mbgroupltd_redirect_attachment_pages');

if (!function_exists('mbgroupltd_legacy_seo_redirects')) {
    function mbgroupltd_legacy_seo_redirects()
    {
        if (is_admin()) {
            return;
        }

        $request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
        if ($request_uri === '') {
            return;
        }

        $path = trailingslashit(strtolower((string) wp_parse_url($request_uri, PHP_URL_PATH)));
        $redirects = [
            '/boiler-installation-leeds-get-repair-and-maintenance-services/' => '/boiler-installation-leeds/',
            '/boiler-installation-london-10-years-parts-labour-guarantee/' => '/boiler-installation-london/',
            '/boiler-repai-gloucester/' => '/boiler-repair-gloucester/',
            '/emergency-boiler-repair-north-leicester/' => '/emergency-boiler-repair-leicester/',
            '/emergency-boiler-repair-north-coventry/' => '/emergency-boiler-repair-coventry/',
            '/emergency-boiler-repair-north-liverpool/' => '/emergency-boiler-repair-liverpool/',
            '/boiler-install-repair-in-north-london/' => '/boiler-repair-north-london/',
            '/blog/mera-boiler-finance-london-pay-monthly-0-interest/' => '/blog/boiler-finance-london-pay-monthly-0-interest/',
            '/mera-boiler-finance-london-pay-monthly-0-interest/' => '/blog/boiler-finance-london-pay-monthly-0-interest/',
            '/promotion/' => '/',
            '/boilers/' => '/boiler-installation/',
            '/scottish-power-boiler-service/' => '/boiler-service-london/',
            '/next-day-boiler-installation/' => '/boiler-installation/',
            '/central-heating-service-london/' => '/boiler-service-london/',
        ];

        if (!isset($redirects[$path])) {
            return;
        }

        wp_safe_redirect(home_url($redirects[$path]), 301);
        exit;
    }
}
add_action('template_redirect', 'mbgroupltd_legacy_seo_redirects', 1);

if (!function_exists('mbgroupltd_force_canonical_host')) {
    /**
     * Fold www and http onto https://meraboiler.com so Search Console
     * does not split homepage clicks across two hosts.
     * Only runs on the live host. Local and staging hosts are left alone.
     */
    function mbgroupltd_force_canonical_host()
    {
        if (is_admin() || wp_doing_ajax() || wp_doing_cron() || (defined('REST_REQUEST') && REST_REQUEST)) {
            return;
        }

        $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
        $host = preg_replace('/:\d+$/', '', $host);
        if (!in_array($host, ['meraboiler.com', 'www.meraboiler.com'], true)) {
            return;
        }

        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (isset($_SERVER['SERVER_PORT']) && (string) $_SERVER['SERVER_PORT'] === '443')
            || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string) $_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https');

        if ($host === 'meraboiler.com' && $https) {
            return;
        }

        $uri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
        if ($uri === '' || $uri[0] !== '/') {
            $uri = '/' . ltrim($uri, '/');
        }

        wp_redirect('https://meraboiler.com' . $uri, 301);
        exit;
    }
}
add_action('template_redirect', 'mbgroupltd_force_canonical_host', 0);

if (!function_exists('mbgroupltd_gsc_title_overrides')) {
    /**
     * Titles for URLs already shown in Google that earned impressions and no clicks.
     * Keyed by path so this works whether Yoast stored a different title in the database.
     */
    function mbgroupltd_gsc_title_overrides()
    {
        return [
            '/contact-us/' => 'Call 020 8150 2025 | Boiler Engineer North London',
            '/boiler-installation-north-london/' => 'Boiler Installation North London | Fixed Price',
            '/boiler-repair-north-london/' => 'Boiler Repair North London | Same-Day Gas Safe',
            '/boiler-service-north-london/' => 'Boiler Servicing North London | Gas Safe, Fixed Price',
            '/emergency-boiler-repair-north-london/' => 'Emergency Boiler Repair North London | Same Day',
            '/boiler-installation-potters-bar/' => 'Boiler Installation Potters Bar | Call 020 8150 2025',
            '/boiler-repair-potters-bar/' => 'Boiler Repair Potters Bar | Call 020 8150 2025',
            '/boiler-service-potters-bar/' => 'Boiler Servicing Potters Bar | Call 020 8150 2025',
            '/emergency-boiler-repair-potters-bar/' => 'Emergency Boiler Repair Potters Bar | 020 8150 2025',
            '/boiler-installation-london/' => 'Boiler Installation London | Gas Safe, Fixed Price',
            '/' => 'Meraboiler | Boiler Installation and Reviews',
            '/blog/boiler-finance-london-pay-monthly-0-interest/' => '0% Boiler Finance Explained | What to Check',
        ];
    }
}

if (!function_exists('mbgroupltd_gsc_description_overrides')) {
    function mbgroupltd_gsc_description_overrides()
    {
        return [
            '/contact-us/' => 'Gas Safe boiler repair and installation in North London and Potters Bar. Call 020 8150 2025 for a fixed-price quote.',
            '/boiler-installation-north-london/' => 'Fixed-price boiler installation in North London. Gas Safe engineers and next-day fitting. Call 020 8150 2025.',
            '/boiler-repair-north-london/' => 'Boiler repair across North London and Potters Bar. Same-day Gas Safe callouts and a fixed price before any work starts.',
            '/boiler-service-north-london/' => 'Annual boiler servicing in North London. Gas Safe engineers, fixed price, landlord and homeowner visits.',
            '/emergency-boiler-repair-north-london/' => 'Emergency boiler repair in North London. Same-day Gas Safe engineer, fixed quote, no call-out surprise.',
            '/boiler-installation-potters-bar/' => 'Boiler installation in Potters Bar. Fixed price, Gas Safe engineers and homeowner reviews. Call 020 8150 2025.',
            '/boiler-repair-potters-bar/' => 'Boiler repair in Potters Bar. Same-day Gas Safe callout, fixed price, and reviews from local homeowners. Call 020 8150 2025.',
            '/boiler-service-potters-bar/' => 'Boiler servicing in Potters Bar. Gas Safe, fixed price, and reviews from local homeowners. Call 020 8150 2025.',
            '/emergency-boiler-repair-potters-bar/' => 'Emergency boiler repair in Potters Bar. Same-day Gas Safe engineer and a fixed quote. Call 020 8150 2025.',
            '/boiler-installation-london/' => 'Fixed-price boiler installation in London. Gas Safe fitting and a written quote before we start.',
            '/' => 'Meraboiler reviews and fixed-price boiler installation from £1,680. Gas Safe engineers. Call 020 8150 2025.',
            '/blog/boiler-finance-london-pay-monthly-0-interest/' => 'A guide to 0% boiler finance: what the offer means, what to check in the terms, and how a fixed-price quote compares. Call 020 8150 2025.',
        ];
    }
}

if (!function_exists('mbgroupltd_current_seo_path')) {
    function mbgroupltd_current_seo_path()
    {
        if (is_front_page()) {
            return '/';
        }

        $uri = (string) ($_SERVER['REQUEST_URI'] ?? '');
        $path = (string) wp_parse_url($uri, PHP_URL_PATH);
        $path = strtolower($path);
        if ($path === '') {
            return '/';
        }

        return trailingslashit($path);
    }
}

if (!function_exists('mbgroupltd_apply_gsc_title')) {
    function mbgroupltd_apply_gsc_title($title)
    {
        $overrides = mbgroupltd_gsc_title_overrides();
        $path = mbgroupltd_current_seo_path();
        if (isset($overrides[$path])) {
            return $overrides[$path];
        }

        return $title;
    }
}
add_filter('wpseo_title', 'mbgroupltd_apply_gsc_title', 100);
add_filter('pre_get_document_title', 'mbgroupltd_apply_gsc_title', 100);

if (!function_exists('mbgroupltd_apply_gsc_description')) {
    function mbgroupltd_apply_gsc_description($description)
    {
        $overrides = mbgroupltd_gsc_description_overrides();
        $path = mbgroupltd_current_seo_path();
        if (isset($overrides[$path])) {
            return $overrides[$path];
        }

        return $description;
    }
}
add_filter('wpseo_metadesc', 'mbgroupltd_apply_gsc_description', 100);

