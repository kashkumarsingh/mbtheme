<?php
if (!function_exists('mbgroupltd_render_boiler_installation_location_page')) {
    function mbgroupltd_render_boiler_installation_location_page($location_slug, $location_label = '')
    {
        $location_slug = sanitize_title($location_slug);
        $location_label = $location_label ?: ucwords(str_replace('-', ' ', $location_slug));
        $dc_quote = esc_url(home_url('/quote/'));
        $dc_others = ['london' => 'London', 'bristol' => 'Bristol', 'birmingham' => 'Birmingham', 'manchester' => 'Manchester', 'leeds' => 'Leeds', 'coventry' => 'Coventry', 'nottingham' => 'Nottingham', 'surrey' => 'Surrey'];
        unset($dc_others[$location_slug]);
        $dc_others = array_slice($dc_others, 0, 4, true);
        ?>
        <main id="main" class="site-main dc" role="main">
            <section class="dc-pagehead">
                <div class="dc-container">
                    <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / <a href="<?php echo esc_url(home_url('/service-areas/')); ?>">Locations</a> / <?php echo esc_html($location_label); ?> / Boiler installation</div>
                    <div class="dc-pagehead-split">
                        <div>
                            <div class="dc-eyebrow" style="margin-bottom:12px;">BOILER INSTALLATION</div>
                            <h1>Boiler installation in <?php echo esc_html($location_label); ?></h1>
                            <p class="dc-lead">A-rated boilers fitted in a day by Gas Safe engineers across <?php echo esc_html($location_label); ?>. Fixed price, parts and labour included. Searching for boiler installation near me? Get a fixed quote in 60 seconds.</p>
                            <div class="dc-hero__price">From &pound;1,680*</div>
                            <div class="dc-ticks">
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Same-day and next-day slots in <?php echo esc_html($location_label); ?></div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed price agreed before we start</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Up to a 12-year manufacturer guarantee, depending on the model</div>
                            </div>
                        </div>
                        <div><?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Get your ' . $location_label . ' installation price']); ?></div>
                    </div>
                </div>
            </section>

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <div class="dc-split">
                        <div><img class="dc-pic" src="<?php echo esc_url(mbgroupltd_image('service-installation.png')); ?>" alt="Boiler installation in <?php echo esc_attr($location_label); ?>" loading="lazy" decoding="async"></div>
                        <div>
                            <h2 class="dc-h2" style="margin-bottom:12px;">What is included</h2>
                            <div class="dc-ticks" style="margin-top:0;">
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe registered installation</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Parts and labour</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Magnetic filter fitted</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Wireless thermostat included</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safety and Building Regulations certificates</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Boiler tested and registered</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed price, final quote after survey</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php get_template_part('template-parts/dc/brands'); ?>
            <?php get_template_part('template-parts/dc/boilers', null, ['title' => 'Boilers we fit in ' . $location_label, 'sub' => 'Every price includes Gas Safe installation, a magnetic filter, a wireless thermostat and both safety certificates. Final quote confirmed after survey.']); ?>

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">How it works</h2>
                    <div class="dc-steps">
                        <div class="dc-step"><div class="dc-step__number">1</div><h3>Get your quote</h3><p>Tell us your postcode and boiler requirements. We&rsquo;ll give you a clear fixed price.</p></div>
                        <div class="dc-step"><div class="dc-step__number">2</div><h3>Book the job</h3><p>Choose a date that suits you. Same-day and next-day slots are available.</p></div>
                        <div class="dc-step"><div class="dc-step__number">3</div><h3>We install</h3><p>Gas Safe engineers fit, test and register your boiler.</p></div>
                    </div>
                </div>
            </section>

            <section style="background:#eef3fa;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">Installation questions in <?php echo esc_html($location_label); ?></h2>
                    <div class="dc-faq__grid">
                        <?php
                        $dc_faqs = [
                            ['How much does a new boiler cost in ' . $location_label . '?', 'Guide prices start from &pound;1,680 fully fitted, confirmed after a free survey of your home.'],
                            ['How long does installation take?', 'Most like-for-like combi swaps are completed in a day.'],
                            ['Do you cover my area?', 'We cover ' . $location_label . ' and surrounding areas. Enter your postcode in the quote form to check instantly.'],
                            ['What guarantee do I get?', 'Up to 12 years, depending on the boiler model (5 years on Ariston) and registration, subject to yearly servicing.'],
                            ['Is a powerflush included?', 'Where your system needs it, we quote a powerflush at a fixed price before we start: a chemical, thermal and magnetic flush with inhibitor to protect the new boiler.'],
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
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(home_url('/boiler-installation-' . $dc_slug . '/')); ?>"><?php echo esc_html($dc_name); ?></a>
                        <?php endforeach; ?>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/boiler-repair-' . $location_slug . '/')); ?>">Boiler repair <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/boiler-service-' . $location_slug . '/')); ?>">Boiler servicing <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/emergency-boiler-repair-' . $location_slug . '/')); ?>">Emergency repair <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(home_url('/quote/')); ?>">Power flushing <?php echo esc_html($location_label); ?></a>
                    </div>
                </div>
            </section>

            <?php get_template_part('template-parts/dc/cta'); ?>

            <?php if (function_exists('mbgroupltd_render_location_context_block')) {
                mbgroupltd_render_location_context_block('installation', $location_slug, $location_label);
            } ?>

            <?php if (function_exists('mbgroupltd_render_service_hub_links')) {
                mbgroupltd_render_service_hub_links('installation', $location_slug, $location_label);
            } ?>
        </main>
        <?php
    }
}
