<?php // New-design FAQ (accessible toggles, no JS needed). ?>
<section class="dc-faq">
    <div class="dc-container">
    <h2>Common questions before you book</h2>
    <div class="dc-faq__grid">
        <?php
        $dc_faqs = [
            ['How much does a new boiler cost?', 'A like-for-like combi swap starts from around &pound;1,680 fully fitted. Your fixed quote depends on the boiler model, controls and any pipework changes, agreed in writing before we start.'],
            ['Do you cover my area?', 'We install and repair across London and the surrounding areas, plus Bristol, Birmingham, Manchester, Leeds and more. Enter your postcode in the quote form to check instantly.'],
            ['How long does a boiler installation take?', 'Most straightforward combi swaps are done in a day. Conversions or system moves can take two to three days. We&rsquo;ll confirm the plan at the survey.'],
            ['What guarantee do I get with a new boiler?', 'Up to 12 years, depending on the boiler model (5 years on Ariston, up to 10 years on Vaillant and up to 12 years on Worcester Bosch), including parts and labour once registered and subject to yearly servicing. We handle all the paperwork for you.'],
            ['Are your engineers Gas Safe registered?', 'Yes. Every MeraBoiler engineer is Gas Safe registered. Feel free to ask to see ID on arrival.'],
            ['How often should I service my boiler?', 'Once a year. An annual service keeps the appliance safe, protects the guarantee and is often required by the manufacturer.'],
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
