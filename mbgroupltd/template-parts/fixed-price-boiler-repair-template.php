<?php
if (!function_exists('mbgroupltd_render_fixed_price_boiler_repair_page')) {
    function mbgroupltd_render_fixed_price_boiler_repair_page($location_label = '')
    {
        $location_label = trim((string) $location_label);
        $suffix = $location_label !== '' ? ' in ' . $location_label : '';
        ?>
        <style>
            .mb-fpr-hero{background:linear-gradient(135deg,#1A202C 0%,#7a0f14 55%,#C0131A 100%);padding:70px 0;color:#fff}
            .mb-fpr-wrap{max-width:1200px;margin:0 auto;padding:0 24px}
            .mb-fpr-grid{display:grid;grid-template-columns:1fr 380px;gap:36px;align-items:start}
            .mb-fpr-badge{display:inline-block;border:1px solid #F59E0B;color:#F59E0B;padding:6px 12px;border-radius:24px;font-size:12px;text-transform:uppercase}
            .mb-fpr-title{font-size:clamp(34px,5vw,56px);line-height:1.05;text-transform:uppercase;margin:16px 0}
            .mb-fpr-copy{max-width:620px;color:rgba(255,255,255,.9)}
            .mb-fpr-card{background:#fff;color:#1A202C;border-radius:10px;padding:22px}
            .mb-fpr-card h3{margin:0 0 12px;text-transform:uppercase;color:#8B0E13}
            .mb-fpr-section{padding:60px 0}
            .mb-fpr-light{background:#F5F7FB}
            .mb-fpr-h2{text-transform:uppercase;font-size:clamp(28px,4vw,40px);line-height:1.1}
            .mb-fpr-grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:20px}
            .mb-fpr-box{background:#fff;border:1px solid #E8EBF2;border-radius:8px;padding:18px}
            .mb-fpr-cta{padding:52px 0;background:#1A202C;color:#fff;text-align:center}
            @media (max-width: 1024px){.mb-fpr-grid{grid-template-columns:1fr}.mb-fpr-grid-3{grid-template-columns:1fr}}
        </style>
        <main id="main" class="site-main" role="main">
            <section class="mb-fpr-hero">
                <div class="mb-fpr-wrap">
                    <div class="mb-fpr-grid">
                        <div>
                            <span class="mb-fpr-badge">Fixed Price Repair</span>
                            <h1 class="mb-fpr-title">Fixed Price Boiler Repair<?php echo esc_html($suffix); ?></h1>
                            <p class="mb-fpr-copy">Get transparent boiler repair pricing with no hidden charges. We diagnose faults, confirm costs before work starts, and complete repairs safely with Gas Safe engineers.</p>
                        </div>
                        <div class="mb-fpr-card">
                            <h3>Book a Repair</h3>
                            <?php echo do_shortcode('[cqf_quote_form]'); ?>
                        </div>
                    </div>
                </div>
            </section>
            <section class="mb-fpr-section mb-fpr-light">
                <div class="mb-fpr-wrap">
                    <h2 class="mb-fpr-h2">How Fixed Price Repair Works</h2>
                    <div class="mb-fpr-grid-3">
                        <article class="mb-fpr-box"><h3>1. Fault Diagnosis</h3><p>Engineer inspects your boiler and confirms the issue.</p></article>
                        <article class="mb-fpr-box"><h3>2. Clear Quote</h3><p>You receive a fixed repair quote before any work starts.</p></article>
                        <article class="mb-fpr-box"><h3>3. Safe Repair</h3><p>Repairs are completed with quality parts and safety checks.</p></article>
                    </div>
                </div>
            </section>
            <section class="mb-fpr-section">
                <div class="mb-fpr-wrap">
                    <h2 class="mb-fpr-h2">What Is Included</h2>
                    <div class="mb-fpr-grid-3">
                        <article class="mb-fpr-box"><h3>Transparent Pricing</h3><p>No hidden extras after the job is agreed.</p></article>
                        <article class="mb-fpr-box"><h3>Gas Safe Engineers</h3><p>Qualified professionals for compliant and safe repairs.</p></article>
                        <article class="mb-fpr-box"><h3>Emergency Availability</h3><p>Fast callouts available for urgent breakdowns.</p></article>
                    </div>
                </div>
            </section>
            <section class="mb-fpr-cta">
                <div class="mb-fpr-wrap">
                    <h2 class="mb-fpr-h2">Need a Fixed Price Repair Quote<?php echo esc_html($suffix); ?>?</h2>
                    <p><a href="tel:02081502025" style="color:#fff;font-size:30px;font-weight:700;text-decoration:none;">020 8150 2025</a></p>
                </div>
            </section>
        </main>
        <?php
    }
}
