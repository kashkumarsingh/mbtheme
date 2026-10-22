<?php
/*
Template Name: Fixed Price Boiler Installation
*/
get_header();
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <section class="dc-pagehead">
            <div class="dc-container">
                <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / Services / Fixed-price installation</div>
                <div class="dc-pagehead-split">
                    <div>
                        <div class="dc-eyebrow" style="margin-bottom:12px;">FIXED PRICE</div>
                        <h1>Fixed-price boiler installation, from &pound;1,680*</h1>
                        <p class="dc-lead">One price for the boiler, parts and labour, fitted by Gas Safe registered engineers. Same-day and next-day slots where available.</p>
                        <div class="dc-ticks">
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe registered engineers</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed price, parts and labour included</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Up to a 12-year manufacturer guarantee, depending on the model</div>
                        </div>
                        <div class="dc-mut" style="font-size:13px;margin-top:16px;">*Price and model subject to terms and conditions. Guarantee length depends on boiler model and registration.</div>
                    </div>
                    <div><?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Get your fixed price quote']); ?></div>
                </div>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:56px;padding-bottom:8px;">
                <div class="dc-trust__grid" style="border-bottom:0;padding:0;">
                    <div>Gas Safe registered</div>
                    <div>Excellent reviews on Trustpilot</div>
                    <div>Fixed price, no extras</div>
                    <div>Up to a 12-year guarantee</div>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/dc/brands'); ?>
        <?php get_template_part('template-parts/dc/boilers', null, ['title' => 'Pick your boiler', 'sub' => 'Every price includes Gas Safe installation, a magnetic filter, a wireless thermostat and both safety certificates. Final quote confirmed after survey.']); ?>

        <section style="background:#eef3fa;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">Why a fixed price matters</h2>
                <div class="dc-feats">
                    <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg></div><h3>One clear price</h3><p>Parts, labour and a magnetic filter are included.</p></div>
                    <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.2 7.8-8 9-4.8-1.2-8-4.5-8-9V6l8-3z"></path><path d="M8.5 12l2.5 2.5 4.5-5"></path></svg></div><h3>Gas Safe registered</h3><p>We fit, test and register your boiler.</p></div>
                    <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 3"></path></svg></div><h3>Fast slots</h3><p>Same-day and next-day where available.</p></div>
                    <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.2 7.8-8 9-4.8-1.2-8-4.5-8-9V6l8-3z"></path><path d="M8.5 12l2.5 2.5 4.5-5"></path></svg></div><h3>Real guarantees</h3><p>Up to 12 years, depending on the model (5 years on Ariston).</p></div>
                </div>
            </div>
        </section>

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
                <h2 class="dc-h2" style="margin-bottom:32px;">Before you book</h2>
                <div class="dc-faq__grid">
                    <?php
                    $dc_faqs = [
                        ['How much does a new boiler cost?', 'Guide prices start from &pound;1,680 fully fitted, confirmed after a survey.'],
                        ['How long does installation take?', 'Most installations are completed in a day.'],
                        ['What guarantee do I get?', 'Up to 12 years, depending on the boiler model (5 years on Ariston) and registration, subject to yearly servicing.'],
                        ['Is a powerflush included?', 'Where your system needs it, we quote a powerflush at a fixed price before we start: a chemical, thermal and magnetic flush with inhibitor to protect the new boiler.'],
                        ['Are your engineers Gas Safe registered?', 'Yes. We fit, test and register your boiler.'],
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
                <h2 class="dc-h2" style="margin-bottom:12px;">What homeowners say</h2>
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

        <?php get_template_part('template-parts/dc/cta'); ?>
    </main>
</div>

<?php get_footer(); ?>
