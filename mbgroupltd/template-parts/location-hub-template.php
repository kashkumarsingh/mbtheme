<?php
// Location hub (e.g. London): all services in one city. Dynamic $location_label.
if (!function_exists('mbgroupltd_render_location_hub_page')) {
    function mbgroupltd_render_location_hub_page($location_slug, $location_label = '')
    {
        $location_slug = sanitize_title($location_slug);
        $location_label = $location_label ?: ucwords(str_replace('-', ' ', $location_slug));
        $dc_quote = esc_url(home_url('/quote/'));
        $dc_services = [
            ['service-installation.png', 'Boiler installation', 'A-rated boilers fitted in a day by Gas Safe engineers.', 'From &pound;1,680*', mbgroupltd_nearby_url('/boiler-installation-' . $location_slug . '/')],
            ['service-repair.png', 'Boiler repair', 'Same-day diagnosis and repair with clear fixed pricing.', 'From &pound;85*', mbgroupltd_nearby_url('/boiler-repair-' . $location_slug . '/')],
            ['service-servicing.png', 'Boiler servicing', 'Annual service to keep the guarantee and appliance safe.', 'From &pound;69-120*', mbgroupltd_nearby_url('/boiler-service-' . $location_slug . '/')],
            ['service-thermostat.png', 'Smart thermostat fitting', 'Hive, Nest and manufacturer controls installed and paired.', 'Free survey', home_url('/quote/')],
            ['service-powerflush.png', 'Power flushing', 'Remove sludge and restore heat to cold radiators.', 'Quoted as a fixed price', home_url('/quote/')],
            ['service-repair.png', 'Emergency repair', 'No heating or hot water? We aim to attend within the hour.', 'Day and night', mbgroupltd_nearby_url('/emergency-boiler-repair-' . $location_slug . '/')],
        ];
        ?>
        <main id="main" class="site-main dc" role="main">
            <section class="dc-pagehead">
                <div class="dc-container">
                    <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / <a href="<?php echo esc_url(home_url('/service-areas/')); ?>">Locations</a> / <?php echo esc_html($location_label); ?></div>
                    <div class="dc-pagehead-split">
                        <div>
                            <h1>Boiler installation, repair and servicing in <?php echo esc_html($location_label); ?></h1>
                            <p class="dc-lead">Gas Safe registered engineers across <?php echo esc_html($location_label); ?>. Fixed prices and same-day attendance where available.</p>
                            <div class="dc-ticks">
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Same-day installation across <?php echo esc_html($location_label); ?></div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed price, parts and labour included</div>
                                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe registered engineers</div>
                            </div>
                        </div>
                        <div><?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Get your ' . $location_label . ' quote']); ?></div>
                    </div>
                </div>
            </section>

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">Our services in <?php echo esc_html($location_label); ?></h2>
                    <div class="dc-cards-3">
                        <?php foreach ($dc_services as $dc_s) : ?>
                        <div class="dc-card dc-service">
                            <img src="<?php echo esc_url(mbgroupltd_image($dc_s[0])); ?>" alt="<?php echo esc_attr($dc_s[1]); ?>" loading="lazy" decoding="async">
                            <div class="dc-service__body">
                                <h3><?php echo esc_html($dc_s[1]); ?></h3>
                                <div class="dc-service__desc"><?php echo esc_html($dc_s[2]); ?></div>
                                <b class="dc-service__price"><?php echo wp_kses_post($dc_s[3]); ?></b>
                                <div style="display:flex;gap:16px;margin-top:4px;">
                                    <a class="dc-link-red" href="<?php echo esc_url($dc_s[4]); ?>">View details</a>
                                    <a class="dc-link-red" href="<?php echo $dc_quote; ?>">Get a quote</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section style="background:#eef3fa;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">Why <?php echo esc_html($location_label); ?> chooses MeraBoiler</h2>
                    <div class="dc-feats">
                        <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.2 7.8-8 9-4.8-1.2-8-4.5-8-9V6l8-3z"></path><path d="M8.5 12l2.5 2.5 4.5-5"></path></svg></div><h3>Fixed prices</h3><p>Parts, labour and a magnetic filter included. Final quote after survey.</p></div>
                        <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.2 7.8-8 9-4.8-1.2-8-4.5-8-9V6l8-3z"></path><path d="M8.5 12l2.5 2.5 4.5-5"></path></svg></div><h3>Gas Safe registered</h3><p>Every engineer is Gas Safe registered. We fit, test and register your boiler.</p></div>
                        <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 3"></path></svg></div><h3>Same-day slots</h3><p>Same-day and next-day installation slots where available.</p></div>
                        <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.2 7.8-8 9-4.8-1.2-8-4.5-8-9V6l8-3z"></path><path d="M8.5 12l2.5 2.5 4.5-5"></path></svg></div><h3>Real guarantees</h3><p>Up to a 12-year manufacturer guarantee, depending on the model (5 years on Ariston).</p></div>
                    </div>
                </div>
            </section>

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;">Areas we cover near <?php echo esc_html($location_label); ?></h2>
                    <div class="dc-areas__grid">
                        <?php
                        $dc_home = static fn($path) => esc_url(home_url($path));
                        foreach ([['London', '/boiler-installation-london/'], ['Bristol', '/boiler-installation-bristol/'], ['Birmingham', '/boiler-installation-birmingham/'], ['Manchester', '/boiler-installation-manchester/'], ['Leeds', '/boiler-installation-leeds/'], ['Coventry', '/boiler-installation-coventry/'], ['Nottingham', '/boiler-installation-nottingham/'], ['Surrey', '/boiler-installation-surrey/'], ['Bromley', '/boiler-installation-bromley/'], ['Gloucester', '/boiler-installation-gloucester/'], ['Southampton', '/boiler-installation-southampton/'], ['Kent', '/boiler-installation-kent/'], ['Liverpool', '/boiler-installation-liverpool/'], ['North London', '/boiler-installation-north-london/'], ['Potters Bar', '/boiler-installation-potters-bar/'], ['View all areas', '/service-areas/'], ['Repair near me', '/boiler-repair-near-me/']] as $dc_a) :
                        ?>
                        <a class="dc-card dc-areas__card" href="<?php echo $dc_home($dc_a[1]); ?>"><?php echo esc_html($dc_a[0]); ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section style="background:#eef3fa;">
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

            <section style="background:#fff;">
                <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                    <h2 class="dc-h2" style="margin-bottom:32px;"><?php echo esc_html($location_label); ?> boiler questions</h2>
                    <div class="dc-faq__grid">
                        <?php
                        $dc_faqs = [
                            ['Do you cover my area?', 'We cover ' . $location_label . ' and many surrounding areas. Enter your postcode in the quote form to check instantly.'],
                            ['How quickly can you install?', 'Same-day and next-day slots are available across ' . $location_label . ', subject to engineer availability.'],
                            ['How much does a new boiler cost in ' . $location_label . '?', 'Guide prices start from &pound;1,680 fully fitted, confirmed after a free survey.'],
                            ['Are your engineers Gas Safe registered?', 'Yes. Every MeraBoiler engineer is Gas Safe registered. Feel free to ask to see ID on arrival.'],
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

            <?php get_template_part('template-parts/dc/cta'); ?>

            <?php if (function_exists('mbgroupltd_render_location_context_block')) {
                mbgroupltd_render_location_context_block('hub', $location_slug, $location_label);
            } ?>
        </main>
        <?php
    }
}
