<?php
if (!function_exists('mbgroupltd_render_emergency_boiler_repair_location_page')) {
    function mbgroupltd_render_emergency_boiler_repair_location_page($location_slug, $location_label = '')
    {
        $location_slug = sanitize_title($location_slug);
        $location_label = $location_label ?: ucwords(str_replace('-', ' ', $location_slug));
        $dc_others = ['london' => 'London', 'bristol' => 'Bristol', 'birmingham' => 'Birmingham', 'manchester' => 'Manchester', 'leeds' => 'Leeds', 'coventry' => 'Coventry', 'nottingham' => 'Nottingham', 'surrey' => 'Surrey'];
        unset($dc_others[$location_slug]);
        $dc_others = array_slice($dc_others, 0, 4, true);
        ?>
        <main id="main" class="site-main dc" role="main">
            <section class="dc-pagehead">
                <div class="dc-container">
                    <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / <a href="<?php echo esc_url(home_url('/service-areas/')); ?>">Locations</a> / <?php echo esc_html($location_label); ?> / Emergency repair</div>
                    <div class="dc-pagehead-split">
                        <div>
                            <div class="dc-eyebrow" style="margin-bottom:12px;">EMERGENCY REPAIR</div>
                            <h1>Emergency boiler repair in <?php echo esc_html($location_label); ?></h1>
                            <p class="dc-lead">No heating or hot water? Gas Safe registered engineers aim to attend within the hour, day and night, across <?php echo esc_html($location_label); ?>. Searching for emergency boiler repair near me? Call now.</p>
                            <div class="dc-hero__price" style="font-size:34px;">Attendance aimed within the hour</div>
                            <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:20px;">
                                <a class="dc-btn" href="tel:02081502025">Call 020 8150 2025</a>
                            </div>
                            <div class="dc-ticks">
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Attendance aimed within the hour</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Available day and night</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe registered engineers</div>
                            </div>
                        </div>
                        <div><?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Request an emergency visit']); ?></div>
                    </div>
                </div>
            </section>

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <div class="dc-split">
                        <div><img class="dc-pic" src="<?php echo esc_url(mbgroupltd_image('service-repair.png')); ?>" alt="Emergency boiler repair in <?php echo esc_attr($location_label); ?>" loading="lazy" decoding="async"></div>
                        <div>
                            <h2 class="dc-h2" style="margin-bottom:12px;">What is included</h2>
                            <div class="dc-ticks" style="margin-top:0;">
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe registered engineer</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Attendance aimed within the hour</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Day and night availability</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Clear price before work starts</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Repair or replacement options</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section style="background:#eef3fa;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">Emergency safety and help</h2>
                    <div class="dc-safety">
                        <div class="dc-card dc-safety-card dc-safety-card--alert">
                            <h3>Smell gas?</h3>
                            <p>Call the National Gas Emergency Service. Turn off the gas at the meter, open windows and do not use switches or flames.</p>
                            <div class="dc-gas-num">0800 111 999</div>
                            <p style="font-size:13px;">Free, any time, day or night.</p>
                        </div>
                        <div class="dc-card dc-safety-card">
                            <h3>No heating or hot water?</h3>
                            <p>Call us now. We aim to attend within the hour, day and night, wherever capacity allows.</p>
                            <a class="dc-btn" href="tel:02081502025">Call 020 8150 2025</a>
                        </div>
                    </div>
                </div>
            </section>

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">How it works</h2>
                    <div class="dc-steps">
                        <div class="dc-step"><div class="dc-step__number">1</div><h3>Call or request</h3><p>Call now or send the form. Tell us your postcode and what has happened.</p></div>
                        <div class="dc-step"><div class="dc-step__number">2</div><h3>We attend</h3><p>An engineer heads to you. We aim to attend within the hour.</p></div>
                        <div class="dc-step"><div class="dc-step__number">3</div><h3>We fix it</h3><p>Diagnosed and repaired on the spot where possible, then fully tested.</p></div>
                    </div>
                </div>
            </section>

            <section style="background:#eef3fa;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">Emergency repair questions in <?php echo esc_html($location_label); ?></h2>
                    <div class="dc-faq__grid">
                        <?php
                        $dc_faqs = [
                            ['How fast can you attend in ' . $location_label . '?', 'We aim to attend within the hour, subject to engineer capacity at the time.'],
                            ['Are you available at night?', 'Yes. Emergency attendance is available day and night, every day.'],
                            ['What if my boiler cannot be repaired?', 'We will tell you straight away and can quote a fixed price for a replacement, often installed the same day or next day.'],
                            ['Do you cover my area?', 'We cover ' . $location_label . ' and surrounding areas. Enter your postcode in the form to check instantly.'],
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

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:12px;">What <?php echo esc_html($location_label); ?> homeowners say</h2>
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
                    <h2 class="dc-h2" style="margin-bottom:32px;">Nearby areas and services</h2>
                    <div class="dc-areas__grid">
                        <?php foreach ($dc_others as $dc_slug => $dc_name) : ?>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/emergency-boiler-repair-' . $dc_slug . '/')); ?>"><?php echo esc_html($dc_name); ?></a>
                        <?php endforeach; ?>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/boiler-installation-' . $location_slug . '/')); ?>">Boiler installation <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/boiler-repair-' . $location_slug . '/')); ?>">Boiler repair <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/boiler-service-' . $location_slug . '/')); ?>">Boiler servicing <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(home_url('/boiler-repair-near-me/')); ?>">Boiler repair near me</a>
                    </div>
                </div>
            </section>

            <?php get_template_part('template-parts/dc/cta'); ?>

            <?php if (function_exists('mbgroupltd_render_location_context_block')) {
                mbgroupltd_render_location_context_block('emergency', $location_slug, $location_label);
            } ?>

            <?php if (function_exists('mbgroupltd_render_service_hub_links')) {
                mbgroupltd_render_service_hub_links('emergency', $location_slug, $location_label);
            } ?>
        </main>
        <?php
    }
}
