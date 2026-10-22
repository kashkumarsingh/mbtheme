<?php
// New-design hero + trust strip. Quote form keeps the working shortcode.
$dc_quote_shortcode = '[cqf_quote_form]';
?>
<section class="dc-hero">
    <div class="dc-container dc-hero__grid">
    <div class="dc-hero__copy">
        <div class="dc-eyebrow">BOILER INSTALLATION, REPAIR AND SERVICING</div>
        <h1>New boiler fitted today, from &pound;1,680*</h1>
        <p class="dc-hero__lead">Fixed-price boiler installation across London, with parts and labour included, up to a 12-year manufacturer guarantee, depending on the boiler model, and same-day fitting.</p>
        <div class="dc-hero__points">
            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe registered engineers</div>
            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed price, parts and labour included</div>
            <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Up to a 12-year guarantee, depending on the model (5 years on Ariston)</div>
        </div>
        <p class="dc-hero__links">
            <a href="<?php echo esc_url(home_url('/fixed-price-boiler-installation/')); ?>">Fixed-price boiler installation</a>
            <a href="<?php echo esc_url(home_url('/blog/boiler-finance-london-pay-monthly-0-interest/')); ?>">0% boiler finance, explained</a>
        </p>
        <div class="dc-hero__fine">*Price and model subject to terms and conditions. Guarantee length depends on boiler model and registration, and stays valid only with yearly servicing (servicing not included).</div>
    </div>
    <div class="dc-card dc-quote">
        <div class="dc-eyebrow">FREE QUOTE &bull; 60 SECONDS</div>
        <h2>Get your fixed price quote</h2>
        <?php echo do_shortcode($dc_quote_shortcode); ?>
        <div class="dc-quote__fine">Takes about 2 minutes. Continue to your full quote. Free, with no obligation.</div>
    </div>
    </div>
</section>
<section class="dc-trust" aria-label="Why choose MeraBoiler">
    <div class="dc-container dc-trust__grid">
    <div>Gas Safe registered engineers</div>
    <div><?php echo esc_html(mbgroupltd_google_review_sentence()); ?></div>
    <div>Fixed price, no hidden extras</div>
    <div>Up to a 12-year guarantee</div>
    </div>
</section>
