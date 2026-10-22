<?php
/*
Template Name: Locations
*/
get_header();
$dc_quote = esc_url(home_url('/quote/'));
$dc_map_areas = [
    ['london', 'London and the South East', ['London', 'North London', 'Bromley', 'Surrey', 'Kent'], '79.34%', '81.03%', 'london'],
    ['hertfordshire', 'Hertfordshire', ['Hertfordshire'], '73.50%', '77.00%', 'hertfordshire'],
    ['southampton', 'Southampton', ['Southampton'], '66.95%', '87.67%', 'southampton'],
    ['bristol', 'Bristol', ['Bristol'], '55.46%', '81.62%', 'bristol'],
    ['gloucester', 'Gloucester', ['Gloucester'], '58.85%', '77.06%', 'gloucester'],
    ['midlands', 'Birmingham and Coventry', ['Birmingham', 'Coventry'], '64.08%', '70.56%', 'birmingham'],
    ['nottingham', 'Nottingham', ['Nottingham'], '69.34%', '64.95%', 'nottingham'],
    ['manchester', 'Manchester', ['Manchester'], '58.81%', '59.10%', 'manchester'],
    ['liverpool', 'Liverpool', ['Liverpool'], '51.54%', '59.91%', 'liverpool'],
    ['leeds', 'Leeds', ['Leeds'], '65.54%', '55.55%', 'leeds'],
];
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <section class="dc-pagehead">
            <div class="dc-container">
                <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / Locations</div>
                <div class="dc-pagehead-split" style="margin-top:16px;">
                    <div>
                        <h1>Boiler installation and repair near you</h1>
                        <p class="dc-lead">Serving London and all areas within 80 miles. Gas Safe registered engineers, fixed prices and same-day attendance where available.</p>
                        <div class="dc-hero__price">From &pound;1,680* <small>boiler installation, fully fitted</small></div>
                        <div class="dc-ticks">
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe registered engineers</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Boiler repair from &pound;85, servicing from &pound;69</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Same-day slots where available</div>
                        </div>
                        <div class="dc-pills" style="margin-top:20px;">
                            <span class="dc-mut" style="font-size:14px;font-weight:700;align-self:center;">Popular:</span>
                            <a class="dc-pill" href="<?php echo esc_url(home_url('/boiler-installation-london/')); ?>">London</a>
                            <a class="dc-pill" href="<?php echo esc_url(home_url('/boiler-installation-surrey/')); ?>">Surrey</a>
                            <a class="dc-pill" href="<?php echo esc_url(home_url('/boiler-installation-kent/')); ?>">Kent</a>
                            <a class="dc-pill" href="<?php echo esc_url(home_url('/boiler-installation-bromley/')); ?>">Bromley</a>
                            <a class="dc-pill" href="<?php echo esc_url(home_url('/quote/')); ?>">Hertfordshire</a>
                        </div>
                    </div>
                    <div style="max-width:640px;"><?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Get your fixed price quote']); ?></div>
                </div>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:8px;">Areas we cover</h2>
                <p class="dc-sub muted" style="margin-bottom:32px;">Select an area on the map or from the list to see what we offer there.</p>
                <div class="dc-map__grid">
                    <div class="dc-card dc-map__card">
                        <div class="dc-map" role="group" aria-label="Service area map">
                            <img src="<?php echo esc_url(mbgroupltd_image('uk-map.svg')); ?>" alt="Map of service areas across the UK" loading="lazy" decoding="async" style="display:block;width:100%;height:auto;">
                            <?php foreach ($dc_map_areas as $dc_i => $dc_a) : ?>
                            <button type="button" class="dc-map__pin" data-dc-areas__card="<?php echo esc_attr($dc_a[0]); ?>" style="left:<?php echo esc_attr($dc_a[3]); ?>;top:<?php echo esc_attr($dc_a[4]); ?>;" aria-label="Show <?php echo esc_attr($dc_a[1]); ?>"><span class="dc-map__tip" aria-hidden="true"><?php echo esc_html($dc_a[1]); ?></span></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="dc-map__aside">
                    <div class="dc-card dc-map__panel">
                        <?php foreach ($dc_map_areas as $dc_i => $dc_a) :
                        ?>
                        <div class="dc-map__detail" data-dc-detail="<?php echo esc_attr($dc_a[0]); ?>"<?php echo $dc_i === 0 ? ' style="display:block;"' : ''; ?>>
                            <div class="dc-map__area">SELECTED AREA</div>
                            <h3 class="dc-map__area-title"><?php echo esc_html($dc_a[1]); ?></h3>
                            <div class="dc-pills" style="margin-bottom:16px;">
                                <?php foreach ($dc_a[2] as $dc_city) : ?><span class="dc-pill"><?php echo esc_html($dc_city); ?></span><?php endforeach; ?>
                            </div>
                            <div class="dc-ticks" style="margin-top:0;margin-bottom:0;">
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Boiler installation from &pound;1,680*</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Boiler repair from &pound;85</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Boiler servicing from &pound;69</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Same-day slots where available</div>
                            </div>
                            <div class="dc-map__actions">
                                <a class="dc-btn" href="<?php echo $dc_quote; ?>">Get a quote in <?php echo esc_html($dc_a[2][0]); ?></a>
                                <?php $dc_view_url = esc_url(mbgroupltd_nearby_url('/boiler-installation-' . $dc_a[5] . '/')); ?>
                                <?php if ($dc_view_url !== $dc_quote) : ?>
                                <a class="dc-btn dc-btn--outline" href="<?php echo $dc_view_url; ?>">View <?php echo esc_html($dc_a[2][0]); ?> page</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="dc-map__regions">
                        <?php
                        $dc_groups = [
                            ['London and the South East', [['London', '/boiler-installation-london/'], ['North London', '/boiler-installation-north-london/'], ['Potters Bar', '/boiler-installation-potters-bar/'], ['Bromley', '/boiler-installation-bromley/'], ['Surrey', '/boiler-installation-surrey/'], ['Kent', '/boiler-installation-kent/'], ['Southampton', '/boiler-installation-southampton/'], ['Hertfordshire', '/quote/']]],
                            ['Midlands', [['Birmingham', '/boiler-installation-birmingham/'], ['Coventry', '/boiler-installation-coventry/'], ['Nottingham', '/boiler-installation-nottingham/']]],
                            ['North', [['Manchester', '/boiler-installation-manchester/'], ['Leeds', '/boiler-installation-leeds/'], ['Liverpool', '/boiler-installation-liverpool/']]],
                            ['South West', [['Bristol', '/boiler-installation-bristol/'], ['Gloucester', '/boiler-installation-gloucester/']]],
                        ];
                        foreach ($dc_groups as $dc_g) :
                        ?>
                        <div class="dc-region">
                            <div class="dc-region__heading"><?php echo esc_html($dc_g[0]); ?></div>
                            <div class="dc-region__pills">
                                <?php foreach ($dc_g[1] as $dc_c) : ?>
                                <a class="dc-pill" href="<?php echo esc_url(mbgroupltd_nearby_url($dc_c[1])); ?>"><?php echo esc_html($dc_c[0]); ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    </div>
                </div>
                <p class="dc-map__note">Serving London and all areas within 80 miles, plus the locations above. Cannot see your town? Call <a class="dc-link-red" href="tel:02081502025">020 8150 2025</a>. We may still be able to help.</p>
            </div>
        </section>

        <section style="background:#eef3fa;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">Services in every area</h2>
                <p class="dc-sub muted" style="margin-bottom:32px;">Every location gets the same fixed prices and Gas Safe registered engineers.</p>
                <div class="dc-cards-3">
                    <?php
                    $dc_svcs = [
                        ['service-installation.png', 'Boiler installation', 'From &pound;1,680*, fitted in a day', '/boiler-installation/'],
                        ['service-repair.png', 'Boiler repair', 'From &pound;85, same-day diagnosis', '/boiler-repair-london/'],
                        ['service-servicing.png', 'Boiler servicing', 'From &pound;69, with Gas Safe certificate', '/boiler-service-london/'],
                        ['service-repair.png', 'Emergency repair', 'We aim to attend within the hour', '/quote/'],
                        ['service-thermostat.png', 'Smart thermostat fitting', 'Free survey', '/quote/'],
                        ['service-powerflush.png', 'Power flushing', 'Quoted as a fixed price', '/quote/'],
                    ];
                    foreach ($dc_svcs as $dc_s) :
                    ?>
                    <div class="dc-card dc-service">
                        <img src="<?php echo esc_url(mbgroupltd_image($dc_s[0])); ?>" alt="<?php echo esc_attr($dc_s[1]); ?>" loading="lazy" decoding="async">
                        <div class="dc-service__body">
                            <h3><?php echo esc_html($dc_s[1]); ?></h3>
                            <div class="dc-service__desc"><?php echo wp_kses_post($dc_s[2]); ?></div>
                            <a class="dc-link-red" href="<?php echo esc_url(mbgroupltd_nearby_url($dc_s[3])); ?>">Get a quote</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:12px;">What homeowners say across the UK</h2>
                <?php echo mbgroupltd_google_review_links_html(); ?>
                <div class="dc-cards-3">
                    <div class="dc-card dc-review">
                        <div class="dc-stars" role="img" aria-label="Rated 5 out of 5 stars"></div>
                        <p style="margin-top:12px;">Rang on a Sunday evening in January. An engineer was at my door within an hour and fitted a new combi boiler the next morning. Professional and fairly priced.</p>
                        <b>Sarah R.</b> <span class="dc-mut">Brixton, London</span>
                    </div>
                    <div class="dc-card dc-review">
                        <div class="dc-stars" role="img" aria-label="Rated 5 out of 5 stars"></div>
                        <p style="margin-top:12px;">Got three quotes and MeraBoiler were the most competitive. The engineer was professional, tidy and explained everything clearly.</p>
                        <b>Mohammed K.</b> <span class="dc-mut">Edgbaston, Birmingham</span>
                    </div>
                    <div class="dc-card dc-review">
                        <div class="dc-stars" role="img" aria-label="Rated 5 out of 5 stars"></div>
                        <p style="margin-top:12px;">Called on a Tuesday morning with no hot water. Fixed quote by lunchtime and a new boiler fitted the next day. No surprises.</p>
                        <b>James P.</b> <span class="dc-mut">Clifton, Bristol</span>
                    </div>
                </div>
            </div>
        </section>

        <section style="background:#eef3fa;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">Location questions</h2>
                <div class="dc-faq__grid">
                    <?php
                    $dc_faqs = [
                        ['Do you cover my area?', 'Enter your postcode above and we confirm straight away.'],
                        ['How quickly can you attend?', 'Same-day and next-day slots are available across our coverage areas, subject to engineer availability.'],
                        ['Do prices change by area?', 'Guide prices start from &pound;1,680 fully fitted. Your fixed quote is confirmed after a free survey, wherever you are.'],
                        ['Do you work outside these areas?', 'Call us on 020 8150 2025. We may still be able to help.'],
                    ];
                    foreach ($dc_faqs as $dc_f) :
                    ?>
                    <details class="dc-card dc-faq__item">
                        <summary><span><?php echo esc_html($dc_f[0]); ?></span><span class="dc-faq__plus" aria-hidden="true">+</span></summary>
                        <div class="dc-faq__answer"><?php echo wp_kses_post($dc_f[1]); ?></div>
                    </details>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/dc/brands'); ?>
        <?php get_template_part('template-parts/dc/cta'); ?>
    </main>
</div>

<script>
(function () {
    // Interactive area map: pins switch the detail panel.
    var pins = document.querySelectorAll('.dc-map__pin');
    var details = document.querySelectorAll('.dc-map__detail');
    if (!pins.length) return;
    function show(key) {
        details.forEach(function (el) {
            el.style.display = el.getAttribute('data-dc-detail') === key ? 'block' : 'none';
        });
        pins.forEach(function (p) {
            var on = p.getAttribute('data-dc-areas__card') === key;
            p.style.background = on ? '#0B2A5B' : '';
            p.style.width = on ? '32px' : '';
            p.style.height = on ? '32px' : '';
            p.style.boxShadow = on ? '0 0 0 9px rgba(31,95,191,.28)' : '';
            p.style.zIndex = on ? '3' : '';
        });
    }
    pins.forEach(function (p) {
        p.addEventListener('click', function () {
            show(p.getAttribute('data-dc-areas__card'));
        });
    });
})();
</script>

<?php get_footer(); ?>
