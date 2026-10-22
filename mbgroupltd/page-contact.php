<?php
/*
Template Name: Contact Us Page
*/
get_header();
$dc_wa = 'https://api.whatsapp.com/send/?phone=447894020000&text=Hi+Meraboiler+I+need+Quote+%2F+Assistance&type=phone_number&app_absent=0';
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <section class="dc-pagehead">
            <div class="dc-container">
                <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / Contact us</div>
                <h1>Contact MeraBoiler</h1>
                <p class="dc-lead">Call, message us on WhatsApp or request a fixed-price quote. Emergency repairs are available day and night.</p>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <div class="dc-pagehead-split">
                    <div class="dc-contact__rows">
                        <a class="dc-card dc-contact__card" href="tel:02081502025">
                            <span class="dc-feat__icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 005 5L15 13l5 2v4a2 2 0 01-2 2A16 16 0 013 6a2 2 0 012-2z"></path></svg></span>
                            <span><span class="dc-contact__label">CALL US</span><span class="dc-contact__value">020 8150 2025</span><span class="dc-contact__sub">Mon&ndash;Sun, 8am&ndash;8pm &middot; Emergency 24/7</span></span>
                        </a>
                        <a class="dc-card dc-contact__card" href="<?php echo esc_url($dc_wa); ?>" target="_blank" rel="noopener">
                            <span class="dc-feat__icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linejoin="round"><path d="M12 3a9 9 0 00-7.8 13.5L3 21l4.7-1.2A9 9 0 1012 3z"></path><path d="M9 8.5c0 3.5 3 6.5 6.5 6.5l1-2-2-1-1 .8a4 4 0 01-2-2l.8-1-1-2-1.3.7z" fill="#fff" stroke="none"></path></svg></span>
                            <span><span class="dc-contact__label">WHATSAPP</span><span class="dc-contact__value">Message us any time</span><span class="dc-contact__sub">Chat with sales and engineering support</span></span>
                        </a>
                        <a class="dc-card dc-contact__card" href="mailto:info@meraboiler.com">
                            <span class="dc-feat__icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M3 7l9 6 9-6"></path></svg></span>
                            <span><span class="dc-contact__label">EMAIL</span><span class="dc-contact__value">info@meraboiler.com</span><span class="dc-contact__sub">Replies within 2 hours in office hours</span></span>
                        </a>
                        <div class="dc-card dc-contact__card">
                            <span class="dc-feat__icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-5.5-7-11a7 7 0 0114 0c0 5.5-7 11-7 11z"></path><circle cx="12" cy="10" r="2.5"></circle></svg></span>
                            <span><span class="dc-contact__label">VISIT US</span><span class="dc-contact__value">Potters Bar, Hertfordshire</span><span class="dc-contact__sub">Suite #1, Greenleaf House, Darkes Lane, EN6 1AD</span></span>
                        </div>
                    </div>
                    <div><?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Get your fixed price quote']); ?></div>
                </div>
            </div>
        </section>

        <section style="background:#eef3fa;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">Areas we cover</h2>
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

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">Common questions before you book</h2>
                <div class="dc-faq__grid">
                    <?php
                    $dc_faqs = [
                        ['How much does a new boiler cost?', 'A like-for-like combi swap starts from around &pound;1,680 fully fitted. Your fixed quote depends on the boiler model, controls and any pipework changes, agreed in writing before we start.'],
                        ['Do you cover my area?', 'We install and repair across London and the surrounding areas, plus Bristol, Birmingham, Manchester, Leeds and more. Enter your postcode in the quote form to check instantly.'],
                        ['How long does a boiler installation take?', 'Most straightforward combi swaps are done in a day. Conversions or system moves can take two to three days. We&rsquo;ll confirm the plan at the survey.'],
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
    </main>
</div>

<?php get_footer(); ?>
