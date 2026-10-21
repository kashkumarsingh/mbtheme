<?php
if (!function_exists('mbgroupltd_render_condensing_boiler_installation_page')) {
    function mbgroupltd_render_condensing_boiler_installation_page()
    {
        ?>
        <style>
            .mb-cbi-hero{background:linear-gradient(135deg,#1A202C 0%,#1A3A8A 60%,#1e4ba0 100%);padding:70px 0;color:#fff}
            .mb-cbi-wrap{max-width:1200px;margin:0 auto;padding:0 24px}
            .mb-cbi-grid{display:grid;grid-template-columns:1fr 380px;gap:36px;align-items:start}
            .mb-cbi-badge{display:inline-block;border:1px solid #F59E0B;color:#F59E0B;padding:6px 12px;border-radius:24px;font-size:12px;text-transform:uppercase}
            .mb-cbi-title{font-size:clamp(34px,5vw,56px);line-height:1.05;text-transform:uppercase;margin:16px 0}
            .mb-cbi-copy{max-width:620px;color:rgba(255,255,255,.9)}
            .mb-cbi-card{background:#fff;color:#1A202C;border-radius:10px;padding:22px}
            .mb-cbi-card h3{margin:0 0 12px;text-transform:uppercase;color:#1A3A8A}
            .mb-cbi-section{padding:60px 0}
            .mb-cbi-light{background:#F5F7FB}
            .mb-cbi-h2{text-transform:uppercase;font-size:clamp(28px,4vw,40px);line-height:1.1}
            .mb-cbi-grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:20px}
            .mb-cbi-box{background:#fff;border:1px solid #E8EBF2;border-radius:8px;padding:18px}
            .mb-cbi-cta{padding:52px 0;background:#1A202C;color:#fff;text-align:center}
            @media (max-width: 1024px){.mb-cbi-grid{grid-template-columns:1fr}.mb-cbi-grid-3{grid-template-columns:1fr}}
        </style>
        <main id="main" class="site-main" role="main">
            <section class="mb-cbi-hero">
                <div class="mb-cbi-wrap">
                    <div class="mb-cbi-grid">
                        <div>
                            <span class="mb-cbi-badge">Energy Efficient Boilers</span>
                            <h1 class="mb-cbi-title">Condensing Boiler Installation</h1>
                            <p class="mb-cbi-copy">Upgrade to a modern condensing boiler for better efficiency, lower bills, and improved heating performance. Our Gas Safe engineers handle specification, installation, and setup.</p>
                        </div>
                        <div class="mb-cbi-card">
                            <h3>Get Installation Quote</h3>
                            <?php echo do_shortcode('[cqf_quote_form]'); ?>
                        </div>
                    </div>
                </div>
            </section>
            <section class="mb-cbi-section mb-cbi-light">
                <div class="mb-cbi-wrap">
                    <h2 class="mb-cbi-h2">Why Choose Condensing Boilers</h2>
                    <div class="mb-cbi-grid-3">
                        <article class="mb-cbi-box"><h3>Higher Efficiency</h3><p>Reuses heat from flue gases to improve performance.</p></article>
                        <article class="mb-cbi-box"><h3>Lower Energy Bills</h3><p>Reduced fuel use can help cut monthly running costs.</p></article>
                        <article class="mb-cbi-box"><h3>Lower Emissions</h3><p>Cleaner combustion and lower carbon output than older units.</p></article>
                    </div>
                </div>
            </section>
            <section class="mb-cbi-section">
                <div class="mb-cbi-wrap">
                    <h2 class="mb-cbi-h2">Installation Process</h2>
                    <div class="mb-cbi-grid-3">
                        <article class="mb-cbi-box"><h3>Survey & Sizing</h3><p>We match output and controls to your home requirements.</p></article>
                        <article class="mb-cbi-box"><h3>Safe Installation</h3><p>Gas Safe compliant installation with full system checks.</p></article>
                        <article class="mb-cbi-box"><h3>Commissioning</h3><p>Final setup, testing, and handover guidance included.</p></article>
                    </div>
                </div>
            </section>
            <section class="mb-cbi-cta">
                <div class="mb-cbi-wrap">
                    <h2 class="mb-cbi-h2">Ready to Upgrade to a Condensing Boiler?</h2>
                    <p><a href="tel:02081502025" style="color:#fff;font-size:30px;font-weight:700;text-decoration:none;">020 8150 2025</a></p>
                </div>
            </section>
        </main>
        <?php
    }
}
