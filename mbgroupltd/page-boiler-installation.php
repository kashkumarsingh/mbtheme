<?php
/*
Template Name: Boiler Installation
*/
get_header();
$dc_quote = esc_url(home_url('/quote/'));
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <section class="dc-pagehead">
            <div class="dc-container">
                <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / Services / Boiler installation</div>
                <div class="dc-pagehead-split">
                    <div>
                        <div class="dc-eyebrow" style="margin-bottom:12px;">BOILER INSTALLATION</div>
                        <h1>New boiler fitted in a day</h1>
                        <p class="dc-lead">A-rated boiler installation, fitted in a day by Gas Safe engineers. Fixed price, parts and labour included.</p>
                        <div class="dc-hero__price">From &pound;1,680*</div>
                        <div class="dc-ticks">
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe registered engineers</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed price agreed before we start</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Up to a 12-year manufacturer guarantee, depending on the model</div>
                        </div>
                    </div>
                    <div><?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Get your installation price']); ?></div>
                </div>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <div class="dc-split">
                    <div><img class="dc-pic" src="<?php echo esc_url(mbgroupltd_image('service-installation.png')); ?>" alt="Boiler installation" loading="lazy" decoding="async"></div>
                    <div>
                        <h2 class="dc-h2" style="margin-bottom:12px;">What is included</h2>
                        <div class="dc-ticks" style="margin-top:0;">
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe registered installation</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Parts and labour</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Magnetic filter fitted</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Wireless thermostat included</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safety and Building Regulations certificates</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Boiler tested and registered</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Same-day and next-day slots where available</div>
                            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed price, final quote after survey</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/dc/brands'); ?>
        <?php get_template_part('template-parts/dc/boilers', null, ['title' => 'Boilers we fit', 'sub' => 'Every price includes Gas Safe installation, a magnetic filter, a wireless thermostat and both safety certificates. Final quote confirmed after survey.']); ?>

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
                <h2 class="dc-h2" style="margin-bottom:32px;">Installation questions</h2>
                <div class="dc-faq__grid">
                    <?php
                    $dc_faqs = [
                        ['How much does a new boiler cost?', 'A like-for-like combi swap starts from around &pound;1,680 fully fitted. Your fixed quote depends on the boiler model, controls and any pipework changes, agreed in writing before we start.'],
                        ['How long does a boiler installation take?', 'Most straightforward combi swaps are done in a day. Conversions or system moves can take two to three days. We&rsquo;ll confirm the plan at the survey.'],
                        ['What guarantee do I get with a new boiler?', 'Up to 12 years, depending on the boiler model (5 years on Ariston, up to 10 years on Vaillant and up to 12 years on Worcester Bosch), including parts and labour once registered and subject to yearly servicing. We handle all the paperwork for you.'],
                        ['Is a powerflush included?', 'Where your system needs it, we quote a powerflush at a fixed price before we start: a chemical, thermal and magnetic flush with inhibitor to protect the new boiler.'],
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

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">Related services</h2>
                <div class="dc-cards-3">
                    <?php
                    $dc_rel = [
                        ['service-repair.png', 'Boiler repair', 'Same-day diagnosis and repair with clear fixed pricing.', 'From &pound;85*', '/boiler-repair-london/'],
                        ['service-servicing.png', 'Boiler servicing', 'Annual service to keep the guarantee and appliance safe.', 'From &pound;69-120*', '/boiler-service-london/'],
                        ['service-powerflush.png', 'Power flushing', 'Remove sludge and restore heat to cold radiators.', 'Quoted as a fixed price', '/quote/'],
                    ];
                    foreach ($dc_rel as $dc_s) :
                    ?>
                    <div class="dc-card dc-service">
                        <img src="<?php echo esc_url(mbgroupltd_image($dc_s[0])); ?>" alt="<?php echo esc_attr($dc_s[1]); ?>" loading="lazy" decoding="async">
                        <div class="dc-service__body">
                            <h3><?php echo esc_html($dc_s[1]); ?></h3>
                            <div class="dc-service__desc"><?php echo esc_html($dc_s[2]); ?></div>
                            <b class="dc-service__price"><?php echo wp_kses_post($dc_s[3]); ?></b>
                            <a class="dc-link-red" href="<?php echo esc_url(home_url($dc_s[4])); ?>">View details</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/dc/cta'); ?>
    </main>
</div>

<?php get_footer(); ?>
