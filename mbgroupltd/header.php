<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php get_template_part('template-parts/site-tracking'); ?>
    <?php
    $has_external_seo_plugin = function_exists('mbgroupltd_has_external_seo_plugin') && mbgroupltd_has_external_seo_plugin();
    $meta_description = function_exists('mbgroupltd_get_meta_description') ? mbgroupltd_get_meta_description() : wp_trim_words((string) get_bloginfo('description'), 28, '...');
    $canonical_url = function_exists('mbgroupltd_get_canonical_url') ? mbgroupltd_get_canonical_url() : home_url('/');
    $og_image = function_exists('mbgroupltd_get_og_image_url') ? mbgroupltd_get_og_image_url() : '';
    $robots = function_exists('mbgroupltd_get_robots_directive') ? mbgroupltd_get_robots_directive() : 'index,follow';
    $og_type = is_singular() ? 'article' : 'website';
    ?>
    <?php if (!$has_external_seo_plugin) : ?>
    <link rel="canonical" href="<?php echo esc_url($canonical_url); ?>">
    <meta name="robots" content="<?php echo esc_attr($robots); ?>">
    <meta name="description" content="<?php echo esc_attr($meta_description); ?>">
    <meta property="og:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
    <meta property="og:description" content="<?php echo esc_attr($meta_description); ?>">
    <meta property="og:image" content="<?php echo esc_url($og_image); ?>">
    <meta property="og:url" content="<?php echo esc_url($canonical_url); ?>">
    <meta property="og:type" content="<?php echo esc_attr($og_type); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($meta_description); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($og_image); ?>">
    <?php endif; ?>
    <?php if (!$has_external_seo_plugin) :
      $organization_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'logo' => $og_image,
        'telephone' => '+442081502025',
      ];

      $webpage_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => wp_get_document_title(),
        'url' => $canonical_url,
        'description' => $meta_description,
        'isPartOf' => [
          '@type' => 'WebSite',
          'name' => get_bloginfo('name'),
          'url' => home_url('/'),
        ],
      ];
    ?>
    <script type="application/ld+json"><?php echo wp_json_encode($organization_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
    <script type="application/ld+json"><?php echo wp_json_encode($webpage_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php get_template_part('template-parts/site-tracking', null, ['placement' => 'body']); ?>
<!-- Header -->
<header class="header-section dc-header sticky top-0 z-50 bg-white transition-transform duration-300">
    <div id="dc-topbar" class="dc-topbar" role="region" aria-label="Winter offer">
        <a class="dc-topbar__msg" href="<?php echo esc_url(home_url('/quote/')); ?>"><span class="dc-topbar__tag">WINTER OFFER</span><span>Bosch Greenstar 25kW, fully fitted from &pound;1,890</span><b>Request this offer</b></a>
        <a class="dc-topbar__msg" href="<?php echo esc_url(home_url('/quote/')); ?>" aria-hidden="true" tabindex="-1"><span class="dc-topbar__tag">WINTER OFFER</span><span>Gas Safe engineers and a fixed price agreed on the day</span><b>Get a quote</b></a>
        <a class="dc-topbar__msg" href="<?php echo esc_url(home_url('/quote/')); ?>" aria-hidden="true" tabindex="-1"><span class="dc-topbar__tag">WINTER OFFER</span><span>Same-day installation across London. Terms apply.</span><b>Request this offer</b></a>
        <button type="button" id="dc-topbar-close" class="dc-topbar__close" aria-label="Close announcement banner">Close</button>
    </div>
    <nav class="dc-header__bar">
        <div class="dc-header__row">
            <!-- Logo -->
            <a class="site-logo dc-header__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?> Home">
                <?php
                $logo_id = get_theme_mod('custom_logo');
                $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : false;
                // Fall back to the bundled logo when no custom logo is set
                // OR its file is missing (e.g. deleted from the media library).
                if ($logo_url) {
                    $logo_path = get_attached_file($logo_id);
                    if (!$logo_path || !file_exists($logo_path)) {
                        $logo_url = false;
                    }
                }
                if ($logo_url) {
                    echo '<img width="280" height="64" src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" decoding="async">';
                } else {
                    echo '<img width="280" height="64" src="' . esc_url(mbgroupltd_image('logo-meraboiler.png')) . '" alt="' . esc_attr(get_bloginfo('name')) . '" decoding="async">';
                }
                ?>
            </a>
            <!-- Mobile Toggler (opens off-canvas menu) -->
            <button class="dc-toggler" type="button" data-dc-drawer-open aria-controls="dcMobileMenu" aria-expanded="false" aria-label="Open menu">
                <span class="dc-toggler__box" aria-hidden="true">
                    <span class="dc-toggler__bar"></span>
                    <span class="dc-toggler__bar"></span>
                    <span class="dc-toggler__bar"></span>
                </span>
            </button>
            <!-- Navigation Menu (desktop) -->
            <div class="dc-header__nav" id="dcDesktopNav">
                <ul class="dc-header__list">
                    <?php
                    $menu_items = wp_get_nav_menu_items('main-menu');
                    $dc_blog_url = get_permalink(get_option('page_for_posts'));
                    if (!$dc_blog_url) {
                        $dc_blog_url = home_url('/blog/');
                    }
                    if ($menu_items) {
                        foreach ($menu_items as $item) {
                            if ($item->menu_item_parent == 0) {
                                $child_items = array_filter($menu_items, function ($submenu) use ($item) {
                                    return $submenu->menu_item_parent == $item->ID;
                                });
                                $is_active = in_array('current-menu-item', $item->classes) ? 'active' : '';
                                if (empty($child_items)) {
                                    echo '<li class="nav-item">';
                                    echo '<a class="nav-link ' . esc_attr($is_active) . '" href="' . esc_url($item->url) . '"' . ($is_active ? ' aria-current="page"' : '') . '>' . esc_html($item->title) . '</a>';
                                    echo '</li>';
                                } else {
                                    $many = count($child_items) > 6 ? ' has-many' : '';
                                    echo '<li class="nav-item relative group' . esc_attr($many) . '">';
                                    echo '<button type="button" class="nav-link focus:outline-none ' . esc_attr($is_active) . '" aria-haspopup="true" aria-expanded="false">';
                                    echo '<span>' . esc_html($item->title) . '</span>';
                                    echo '<svg class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">';
                                    echo '<path fill-rule="evenodd" d="M6.293 7.293a1 1 0 011.414 0L10 9.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />';
                                    echo '</svg>';
                                    echo '</button>';
                                    echo '<ul class="dropdown-menu absolute hidden z-20 left-0 mt-2 w-48 bg-white border border-gray-200 shadow-lg rounded-md group-hover:block focus-within:block">';
                                    foreach ($child_items as $child_item) {
                                        $child_active = in_array('current-menu-item', $child_item->classes) ? 'active' : '';
                                        echo '<li><a class="dropdown-item block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 ' . esc_attr($child_active) . '" href="' . esc_url($child_item->url) . '">' . esc_html($child_item->title) . '</a></li>';
                                    }
                                    echo '</ul>';
                                    echo '</li>';
                                }
                            }
                        }
                    } else {
                        foreach (['Installation' => '/boiler-installation-london/', 'Repair' => '/boiler-repair-london/', 'Services' => '/service-plan/', 'Areas' => '/service-areas/', 'About' => '/about-us/', 'Contact' => '/contact-us/'] as $label => $path) {
                            echo '<li class="nav-item"><a class="nav-link" href="' . esc_url(home_url($path)) . '">' . esc_html($label) . '</a></li>';
                        }
                        echo '<li class="nav-item"><a class="nav-link" href="' . esc_url($dc_blog_url) . '">Blog</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="dc-header__cta">
                <a class="dc-header__phone" href="tel:02081502025"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.13.96.35 1.9.68 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.91.33 1.85.55 2.81.68A2 2 0 0122 16.92z"></path></svg>020 8150 2025</a>
                <a class="dc-btn" href="<?php echo esc_url(home_url('/quote/')); ?>">Get a free quote</a>
            </div>
        </div>
    </nav>
    <!-- Mobile off-canvas menu -->
    <div class="dc-drawer__overlay" data-dc-drawer__close hidden></div>
    <aside class="dc-drawer" id="dcMobileMenu" aria-label="Mobile menu" aria-hidden="true" hidden>
        <div class="dc-drawer__head">
            <a class="dc-drawer__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?> Home" data-dc-drawer__close>
                <?php
                if (!empty($logo_url)) {
                    echo '<img width="180" height="42" src="' . esc_url($logo_url) . '" alt="" loading="lazy" decoding="async">';
                } else {
                    echo '<img width="180" height="42" src="' . esc_url(mbgroupltd_image('logo-meraboiler.png')) . '" alt="" loading="lazy" decoding="async">';
                }
                ?>
            </a>
            <button type="button" class="dc-drawer__close" data-dc-drawer__close aria-label="Close menu">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0B2A5B" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M5 5l14 14M19 5L5 19"></path></svg>
            </button>
        </div>
        <nav class="dc-drawer__nav" aria-label="Mobile">
            <ul>
                <?php
                $dc_drawer_items = $menu_items;
                if ($dc_drawer_items) {
                    foreach ($dc_drawer_items as $dc_item) {
                        if ($dc_item->menu_item_parent != 0) {
                            continue;
                        }
                        $dc_children = array_filter($dc_drawer_items, function ($dc_sub) use ($dc_item) {
                            return $dc_sub->menu_item_parent == $dc_item->ID;
                        });
                        if (empty($dc_children)) {
                            echo '<li class="dc-drawer__item">';
                            $dc_current = in_array('current-menu-item', $dc_item->classes, true) ? ' is-current' : '';
                            echo '<a class="dc-drawer__link' . esc_attr($dc_current) . '" data-dc-drawer__close href="' . esc_url($dc_item->url) . '"' . ($dc_current ? ' aria-current="page"' : '') . '>' . esc_html($dc_item->title) . '</a>';
                            echo '</li>';
                        } else {
                            echo '<li class="dc-drawer__item dc-drawer-parent">';
                            echo '<div class="dc-drawer__row">';
                            echo '<a class="dc-drawer__link" data-dc-drawer__close href="' . esc_url($dc_item->url) . '">' . esc_html($dc_item->title) . '</a>';
                            echo '<button type="button" class="dc-drawer__toggle" aria-expanded="false" aria-label="Expand ' . esc_attr($dc_item->title) . ' submenu"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#42536F" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M9 5l7 7-7 7"></path></svg></button>';
                            echo '</div>';
                            echo '<ul class="dc-drawer__sub" hidden>';
                            foreach ($dc_children as $dc_child) {
                                echo '<li><a data-dc-drawer__close href="' . esc_url($dc_child->url) . '">' . esc_html($dc_child->title) . '</a></li>';
                            }
                            echo '</ul>';
                            echo '</li>';
                        }
                    }
                } else {
                    foreach (['Boiler installation' => '/boiler-installation-london/', 'Boiler repair' => '/boiler-repair-london/', 'Boiler servicing' => '/boiler-service-london/', 'All services' => '/services/', 'Areas we cover' => '/service-areas/', 'About us' => '/about-us/', 'Contact' => '/contact-us/'] as $dc_label => $dc_path) {
                        echo '<li class="dc-drawer__item">';
                        echo '<a class="dc-drawer__link" data-dc-drawer__close href="' . esc_url(home_url($dc_path)) . '">' . esc_html($dc_label) . '</a>';
                        echo '</li>';
                    }
                    echo '<li class="dc-drawer__item">';
                    echo '<a class="dc-drawer__link" data-dc-drawer__close href="' . esc_url($dc_blog_url) . '">Blog</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </nav>
        <div class="dc-drawer__cta">
            <a class="dc-btn" data-dc-drawer__close href="<?php echo esc_url(home_url('/quote/')); ?>">Get a free quote</a>
            <a class="dc-btn dc-btn--wa" data-dc-drawer__close href="https://api.whatsapp.com/send/?phone=447894020000&text=Hi+Meraboiler+I+need+Quote+%2F+Assistance&type=phone_number&app_absent=0" target="_blank" rel="noopener"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="M12 3a9 9 0 00-7.8 13.5L3 21l4.7-1.2A9 9 0 1012 3z"></path><path d="M9 8.5c0 3.5 3 6.5 6.5 6.5l1-2-2-1-1 .8a4 4 0 01-2-2l.8-1-1-2-1.3.7z" fill="#fff" stroke="none"></path></svg> WhatsApp us</a>
            <a class="dc-btn dc-btn--outline" data-dc-drawer__close href="tel:02081502025">Call 020 8150 2025</a>
        </div>
    </aside>
</header>
<script>
    (function () {
        var banner = document.getElementById('dc-topbar');
        var closeButton = document.getElementById('dc-topbar-close');
        if (!banner || !closeButton) {
            return;
        }

        closeButton.addEventListener('click', function () {
            banner.style.display = 'none';
        });
    })();
</script>