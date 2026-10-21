<?php
/*
Template Name: Boiler Install Repair North London
*/
get_header();
$dc_quote = esc_url(home_url('/quote/'));
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <section class="dc-pagehead">
            <div class="dc-container">
                <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / <a href="<?php echo esc_url(home_url('/service-areas/')); ?>">Locations</a> / North London</div>
                <div class="dc-pagehead-split">
                    <div>
                        <div class="dc-eyebrow" style="margin-bottom:12px;">INSTALLATION AND REPAIR</div>
                        <h1>Boiler installation and repair in North London</h1>
                        <p class="dc-lead">One local team for new boilers and repairs. Gas Safe registered, fixed prices, same-day slots across North London postcodes.</p>
                        <div class="dc-ticks">
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> New boilers fitted in a day</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Same-day diagnosis and repair</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed prices, parts and labour included</div>
                        </div>
                    </div>
                    <div><?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Get your North London quote']); ?></div>
                </div>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">Choose your service</h2>
                <div class="dc-choice__grid">
                    <div class="dc-card dc-choice">
                        <img src="<?php echo esc_url(mbgroupltd_image('service-installation.png')); ?>" alt="Boiler installation in North London" loading="lazy" decoding="async">
                        <div class="dc-choice__body">
                            <h3>Boiler installation</h3>
                            <div class="dc-service__desc">A-rated boilers fitted in a day by Gas Safe engineers.</div>
                            <b class="dc-service__price">From &pound;1,680*</b>
                            <div class="dc-choice__links">
                                <a class="dc-link-red" href="<?php echo esc_url(home_url('/boiler-installation-north-london/')); ?>">View details</a>
                                <a class="dc-link-red" href="<?php echo $dc_quote; ?>">Get a quote</a>
                            </div>
                        </div>
                    </div>
                    <div class="dc-card dc-choice">
                        <img src="<?php echo esc_url(mbgroupltd_image('service-repair.png')); ?>" alt="Boiler repair in North London" loading="lazy" decoding="async">
                        <div class="dc-choice__body">
                            <h3>Boiler repair</h3>
                            <div class="dc-service__desc">Same-day diagnosis and repair with clear fixed pricing.</div>
                            <b class="dc-service__price">From &pound;85*</b>
                            <div class="dc-choice__links">
                                <a class="dc-link-red" href="<?php echo esc_url(mbgroupltd_nearby_url('/boiler-repair-north-london/')); ?>">View details</a>
                                <a class="dc-link-red" href="<?php echo $dc_quote; ?>">Get a quote</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/dc/brands'); ?>
        <?php get_template_part('template-parts/dc/boilers', null, ['title' => 'Boilers we fit in North London', 'sub' => 'Every price includes Gas Safe installation, a magnetic filter, a wireless thermostat and both safety certificates. Final quote confirmed after survey.']); ?>

        <section style="background:#fff;">
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

        <section style="background:#eef3fa;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">North London boiler questions</h2>
                <div class="dc-faq__grid">
                    <?php
                    $dc_faqs = [
                        ['Do you cover my area?', 'We cover North London and surrounding areas. Enter your postcode in the quote form to check instantly.'],
                        ['How quickly can you attend?', 'Same-day and next-day slots are available across North London, subject to engineer availability.'],
                        ['How much does a new boiler cost?', 'Guide prices start from &pound;1,680 fully fitted, confirmed after a free survey.'],
                        ['How much does a repair cost?', 'Repairs start from &pound;85, with clear fixed pricing agreed before any work begins.'],
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
                <h2 class="dc-h2" style="margin-bottom:32px;">What North London homeowners say</h2>
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

        <?php get_template_part('template-parts/dc/cta'); ?>
    </main>
</div>

<?php get_footer(); ?>
