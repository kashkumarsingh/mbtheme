<?php
if (!function_exists('mbgroupltd_render_boiler_repair_location_page')) {
    function mbgroupltd_render_boiler_repair_location_page($location_slug, $location_label = '')
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
                    <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / <a href="<?php echo esc_url(home_url('/service-areas/')); ?>">Locations</a> / <?php echo esc_html($location_label); ?> / Boiler repair</div>
                    <div class="dc-pagehead-split">
                        <div>
                            <div class="dc-eyebrow" style="margin-bottom:12px;">BOILER REPAIR</div>
                            <h1>Boiler repair in <?php echo esc_html($location_label); ?></h1>
                            <p class="dc-lead">Same-day diagnosis and repair with clear fixed pricing from Gas Safe registered engineers across <?php echo esc_html($location_label); ?>. Searching for boiler repair near me? Get a fixed price before work starts.</p>
                            <div class="dc-hero__price">From &pound;85*</div>
                            <div class="dc-ticks">
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Same-day diagnosis where available</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Clear fixed pricing, call out and parts</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe registered engineers</div>
                            </div>
                        </div>
                        <div><?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Get your ' . $location_label . ' repair quote']); ?></div>
                    </div>
                </div>
            </section>

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <div class="dc-split">
                        <div><img class="dc-pic" src="<?php echo esc_url(mbgroupltd_image('service-repair.png')); ?>" alt="Boiler repair in <?php echo esc_attr($location_label); ?>" loading="lazy" decoding="async"></div>
                        <div>
                            <h2 class="dc-h2" style="margin-bottom:12px;">What is included</h2>
                            <div class="dc-ticks" style="margin-top:0;">
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe registered diagnosis</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Clear price before work starts</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Parts quoted upfront</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Repair by a Gas Safe engineer</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Same-day slots where available</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section style="background:#eef3fa;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">Common boiler problems we fix</h2>
                    <div class="dc-problems">
                        <?php
                        $dc_probs = [
                            ['No heating', 'Radiators stay cold or the boiler will not fire up.'],
                            ['No hot water', 'Taps run cold while heating still works, or nothing works at all.'],
                            ['Low boiler pressure', 'The pressure gauge keeps dropping below 1 bar.'],
                            ['Strange noises', 'Banging, whistling or gurgling from the boiler or pipes.'],
                            ['Leaks or drips', 'Water around the boiler, flue or pipework.'],
                            ['Keeps switching off', 'The boiler cuts out, locks out or shows a fault code.'],
                        ];
                        foreach ($dc_probs as $dc_pb) :
                        ?>
                        <div class="dc-card dc-problem"><h3><?php echo esc_html($dc_pb[0]); ?></h3><p><?php echo esc_html($dc_pb[1]); ?></p></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">How it works</h2>
                    <div class="dc-steps">
                        <div class="dc-step"><div class="dc-step__number">1</div><h3>Get your quote</h3><p>Tell us your postcode and what is wrong. We&rsquo;ll give you a clear fixed price.</p></div>
                        <div class="dc-step"><div class="dc-step__number">2</div><h3>Book the repair</h3><p>Choose a date that suits you. Same-day and next-day slots where available.</p></div>
                        <div class="dc-step"><div class="dc-step__number">3</div><h3>We fix it</h3><p>A Gas Safe engineer diagnoses and repairs your boiler, then tests everything.</p></div>
                    </div>
                </div>
            </section>

            <section style="background:#eef3fa;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">Boiler repair questions in <?php echo esc_html($location_label); ?></h2>
                    <div class="dc-faq__grid">
                        <?php
                        $dc_faqs = [
                            ['How much does a boiler repair cost in ' . $location_label . '?', 'Repairs start from &pound;85, with clear fixed pricing agreed before any work begins.'],
                            ['Can you repair my boiler today?', 'Same-day diagnosis is available across ' . $location_label . ' where capacity allows.'],
                            ['Should I repair or replace my boiler?', 'We will tell you honestly. If a repair is uneconomical, we can quote a fixed price for a new boiler.'],
                            ['Do you cover my area?', 'We cover ' . $location_label . ' and surrounding areas. Enter your postcode in the quote form to check instantly.'],
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
                    <h2 class="dc-h2" style="margin-bottom:32px;">What <?php echo esc_html($location_label); ?> homeowners say</h2>
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
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(home_url('/boiler-repair-' . $dc_slug . '/')); ?>"><?php echo esc_html($dc_name); ?></a>
                        <?php endforeach; ?>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/boiler-installation-' . $location_slug . '/')); ?>">Boiler installation <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/boiler-service-' . $location_slug . '/')); ?>">Boiler servicing <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/emergency-boiler-repair-' . $location_slug . '/')); ?>">Emergency repair <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(home_url('/boiler-repair-near-me/')); ?>">Boiler repair near me</a>
                    </div>
                </div>
            </section>

            <?php get_template_part('template-parts/dc/cta'); ?>

            <?php if (function_exists('mbgroupltd_render_location_context_block')) {
                mbgroupltd_render_location_context_block('repair', $location_slug, $location_label);
            } ?>

            <?php if (function_exists('mbgroupltd_render_service_hub_links')) {
                mbgroupltd_render_service_hub_links('repair', $location_slug, $location_label);
            } ?>
        </main>
        <?php
    }
}
