<?php
/*
Template Name: Boiler Repair Near Me
*/
get_header();
$dc_quote = esc_url(home_url('/quote/'));
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <section class="dc-pagehead">
            <div class="dc-container">
                <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / Boiler repair near me</div>
                <div class="dc-pagehead-split">
                    <div>
                        <div class="dc-eyebrow" style="margin-bottom:12px;">BOILER REPAIR</div>
                        <h1>Boiler repair near me</h1>
                        <p class="dc-lead">Local Gas Safe registered engineers with same-day diagnosis and repair where available. Clear fixed pricing from &pound;85.</p>
                        <div class="dc-ticks">
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Same-day diagnosis where available</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Clear fixed pricing, call out and parts</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Emergency attendance aimed within the hour</div>
                        </div>
                    </div>
                    <div><?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Get your fixed price quote']); ?></div>
                </div>
            </div>
        </section>

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
                <h2 class="dc-h2" style="margin-bottom:32px;">Boiler repair in your area</h2>
                <div class="dc-areas__grid">
                    <?php
                    $dc_home = static fn($path) => esc_url(home_url($path));
                    foreach ([['London', '/boiler-repair-london/'], ['Bristol', '/boiler-repair-bristol/'], ['Birmingham', '/boiler-repair-birmingham/'], ['Manchester', '/boiler-repair-manchester/'], ['Leeds', '/boiler-repair-leeds/'], ['Coventry', '/boiler-repair-coventry/'], ['Nottingham', '/boiler-repair-nottingham/'], ['Surrey', '/boiler-repair-surrey/'], ['Bromley', '/boiler-repair-bromley/'], ['Gloucester', '/boiler-repair-gloucester/'], ['Southampton', '/boiler-repair-southampton/'], ['Kent', '/boiler-repair-kent/'], ['Liverpool', '/boiler-repair-liverpool/'], ['North London', '/boiler-repair-north-london/'], ['Potters Bar', '/boiler-repair-potters-bar/'], ['View all areas', '/service-areas/'], ['Repair near me', '/boiler-repair-near-me/']] as $dc_a) :
                    ?>
                    <a class="dc-card dc-areas__card" href="<?php echo $dc_home($dc_a[1]); ?>"><?php echo esc_html($dc_a[0]); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">How it works</h2>
                <div class="dc-steps">
                    <div class="dc-step"><div class="dc-step__number">1</div><h3>Check your area</h3><p>Enter your postcode and we confirm coverage.</p></div>
                    <div class="dc-step"><div class="dc-step__number">2</div><h3>Book a repair</h3><p>Choose a same-day or next-day slot where available.</p></div>
                    <div class="dc-step"><div class="dc-step__number">3</div><h3>We fix it</h3><p>A Gas Safe engineer diagnoses and repairs your boiler.</p></div>
                </div>
            </div>
        </section>

        <section style="background:#eef3fa;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">Boiler repair questions</h2>
                <div class="dc-faq__grid">
                    <?php
                    $dc_faqs = [
                        ['How much does a boiler repair cost?', 'From &pound;85, with clear fixed pricing agreed before any work begins.'],
                        ['Can you repair my boiler today?', 'Same-day diagnosis is available where capacity allows. Enter your postcode to check.'],
                        ['Do you cover my area?', 'Enter your postcode above and we confirm straight away.'],
                        ['Is it better to repair or replace?', 'We will tell you honestly and can quote a fixed price for a new boiler if needed.'],
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
                <h2 class="dc-h2" style="margin-bottom:32px;">What homeowners say</h2>
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
