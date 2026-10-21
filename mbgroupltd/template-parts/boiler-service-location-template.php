<?php
if (!function_exists('mbgroupltd_render_boiler_service_location_page')) {
    function mbgroupltd_render_boiler_service_location_page($location_slug, $location_label = '')
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
                    <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / <a href="<?php echo esc_url(home_url('/service-areas/')); ?>">Locations</a> / <?php echo esc_html($location_label); ?> / Boiler servicing</div>
                    <div class="dc-pagehead-split">
                        <div>
                            <div class="dc-eyebrow" style="margin-bottom:12px;">BOILER SERVICING</div>
                            <h1>Boiler servicing in <?php echo esc_html($location_label); ?></h1>
                            <p class="dc-lead">Annual service from Gas Safe registered engineers keeps your boiler safe and guarantee valid. Includes Gas Safe certificate. Looking for a boiler service near you? Easy booking from &pound;69.</p>
                            <div class="dc-hero__price">From &pound;69</div>
                            <div class="dc-ticks">
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe certificate included</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Keeps your guarantee valid</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed price, easy booking</div>
                            </div>
                        </div>
                        <div><?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Book your ' . $location_label . ' service']); ?></div>
                    </div>
                </div>
            </section>

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <div class="dc-split">
                        <div><img class="dc-pic" src="<?php echo esc_url(mbgroupltd_image('service-servicing.png')); ?>" alt="Boiler servicing in <?php echo esc_attr($location_label); ?>" loading="lazy" decoding="async"></div>
                        <div>
                            <h2 class="dc-h2" style="margin-bottom:12px;">What is included</h2>
                            <div class="dc-ticks" style="margin-top:0;">
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Full strip-down boiler service</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe certificate</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Flue, combustion and safety checks</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed price, no surprises</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Easy booking in <?php echo esc_html($location_label); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section style="background:#eef3fa;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:8px;">Cover for the whole year</h2>
                    <p class="dc-sub muted" style="margin-bottom:32px;">One annual visit, or rolling cover with a service plan.</p>
                    <div class="dc-tiers">
                        <div class="dc-card dc-tier">
                            <h3>Annual Service</h3>
                            <div class="dc-tier__price">&pound;69 <small>one visit</small></div>
                            <ul>
                                <li><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Full boiler service</li>
                                <li><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe certificate</li>
                                <li><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed price</li>
                            </ul>
                            <a class="dc-btn dc-btn--outline" href="<?php echo esc_url(home_url('/quote/')); ?>">Book annual service</a>
                        </div>
                        <div class="dc-card dc-tier dc-tier--pop">
                            <span class="dc-pop-pill">MOST POPULAR</span>
                            <h3>Service Plan</h3>
                            <div class="dc-tier__price">From &pound;10 <small>a month</small></div>
                            <ul>
                                <li><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Annual boiler service</li>
                                <li><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Priority booking</li>
                                <li><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Repair cover options</li>
                            </ul>
                            <a class="dc-btn" href="<?php echo esc_url(home_url('/service-plan/')); ?>">See service plans</a>
                        </div>
                        <div class="dc-card dc-tier">
                            <h3>Landlord Plan</h3>
                            <div class="dc-tier__price">See plans <small>per year</small></div>
                            <ul>
                                <li><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Annual boiler service</li>
                                <li><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Landlord gas safety certificate (CP12)</li>
                                <li><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Reminders before expiry</li>
                            </ul>
                            <a class="dc-btn dc-btn--outline" href="<?php echo esc_url(home_url('/service-plan/')); ?>">See landlord options</a>
                        </div>
                    </div>
                </div>
            </section>

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">How it works</h2>
                    <div class="dc-steps">
                        <div class="dc-step"><div class="dc-step__number">1</div><h3>Get your quote</h3><p>Tell us your postcode. Fixed-price servicing from &pound;69.</p></div>
                        <div class="dc-step"><div class="dc-step__number">2</div><h3>Book the visit</h3><p>Choose a date that suits you in <?php echo esc_html($location_label); ?>.</p></div>
                        <div class="dc-step"><div class="dc-step__number">3</div><h3>Stay certified</h3><p>A Gas Safe engineer services your boiler and issues the certificate.</p></div>
                    </div>
                </div>
            </section>

            <section style="background:#eef3fa;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">Boiler servicing questions in <?php echo esc_html($location_label); ?></h2>
                    <div class="dc-faq__grid">
                        <?php
                        $dc_faqs = [
                            ['How much does a boiler service cost in ' . $location_label . '?', 'From &pound;69 including the Gas Safe certificate, confirmed when you book.'],
                            ['Will servicing keep my guarantee valid?', 'Yes. Annual servicing by a Gas Safe engineer is normally required to keep the manufacturer guarantee valid.'],
                            ['Do landlords need a CP12 certificate?', 'Yes, every year by law. Our landlord options include the CP12 with reminders before expiry.'],
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
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/boiler-service-' . $dc_slug . '/')); ?>"><?php echo esc_html($dc_name); ?></a>
                        <?php endforeach; ?>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/boiler-installation-' . $location_slug . '/')); ?>">Boiler installation <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/boiler-repair-' . $location_slug . '/')); ?>">Boiler repair <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(mbgroupltd_nearby_url('/emergency-boiler-repair-' . $location_slug . '/')); ?>">Emergency repair <?php echo esc_html($location_label); ?></a>
                        <a class="dc-card dc-areas__card" href="<?php echo esc_url(home_url('/service-plan/')); ?>">Service plans</a>
                    </div>
                </div>
            </section>

            <?php get_template_part('template-parts/dc/cta'); ?>

            <?php if (function_exists('mbgroupltd_render_location_context_block')) {
                mbgroupltd_render_location_context_block('service', $location_slug, $location_label);
            } ?>

            <?php if (function_exists('mbgroupltd_render_service_hub_links')) {
                mbgroupltd_render_service_hub_links('service', $location_slug, $location_label);
            } ?>
        </main>
        <?php
    }
}
