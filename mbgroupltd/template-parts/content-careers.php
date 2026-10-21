<?php // Careers page - live roles, new design. ?>
<div class="dc">
<section class="dc-pagehead">
    <div class="dc-container">
        <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / Careers</div>
        <div class="dc-pagehead-split">
            <div>
                <h1>Build your career with MeraBoiler</h1>
                <p class="dc-lead">Join a growing team of heating engineers and customer specialists keeping homes warm across the UK.</p>
                <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:24px;">
                    <a class="dc-btn" href="#dcRoles">View open roles</a>
                    <a class="dc-btn dc-btn--outline" href="mailto:info@meraboiler.com?subject=Job%20application">Send your CV</a>
                </div>
            </div>
            <div>
                <img class="dc-pic" src="<?php echo esc_url(mbgroupltd_image('service-repair.png')); ?>" alt="MeraBoiler engineer at work" loading="eager" fetchpriority="high" decoding="async">
            </div>
        </div>
    </div>
</section>

<section style="background:#fff;">
    <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
        <h2 class="dc-h2" style="margin-bottom:32px;">Why work with us</h2>
        <div class="dc-feats">
            <?php
            $dc_why = [
                ['Gas Safe support', 'Registration, certification and compliance handled with you, so you can focus on the work.'],
                ['Training', 'Ongoing manufacturer and skills training to keep you at the top of your trade.'],
                ['Steady work', 'A full diary of booked jobs across London and the South East, all year round.'],
                ['Clear pay', 'Competitive packages with realistic overtime and no-nonsense pay slips.'],
            ];
            foreach ($dc_why as $dc_w) :
            ?>
            <div class="dc-card dc-feat">
                <div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg></div>
                <h3><?php echo esc_html($dc_w[0]); ?></h3>
                <p><?php echo esc_html($dc_w[1]); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="dcRoles" style="background:#eef3fa;scroll-margin-top:120px;">
    <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
        <h2 class="dc-h2" style="margin-bottom:8px;">Open roles</h2>
        <p class="dc-sub muted" style="margin-bottom:32px;">Three live vacancies. Select a role to see the details, then apply below.</p>
        <div class="dc-jobs">
            <details class="dc-card dc-job" open>
                <summary>
                    <div class="dc-job__header">
                        <div><h3>Gas Boiler Service Engineer (London, Field Based)</h3><div class="dc-job__location">London &bull; Full time</div></div>
                        <span class="dc-faq__plus" aria-hidden="true">+</span>
                    </div>
                </summary>
                <div class="dc-job__body">
                    <h4>Why join us?</h4>
                    <p>At MeraBoiler, we offer a competitive salary along with eligibility for overtime, a company van, fuel card, and state-of-the-art tablet &amp; smartphone to ensure you&rsquo;re equipped with the best tools for the job.</p>
                    <p>We&rsquo;ve been at the forefront of heating homes across Britain, and we&rsquo;re excited about what the future holds. That&rsquo;s why we&rsquo;re looking for a passionate and experienced Heating Installation Engineer to join our team.</p>
                    <h4>Your responsibilities</h4>
                    <ul><li>Perform boiler servicing, maintenance, and installations</li><li>Ensure all work complies with safety regulations</li><li>Provide excellent customer service</li></ul>
                    <h4>What we&rsquo;re looking for</h4>
                    <ul><li>Must be ACS qualified with Gas Safe registration</li><li>A full UK driving licence (6 points or fewer)</li></ul>
                    <h4>What we offer</h4>
                    <ul><li>Competitive salary package with realistic OTE</li><li>Fully equipped company van with a fuel card</li><li>State-of-the-art tablet and smartphone provided</li><li>Excellent benefits and opportunities for overtime</li></ul>
                    <div class="dc-job__apply">
                        <a class="dc-btn dc-btn--outline" href="mailto:info@meraboiler.com?subject=Application%20-%20Gas%20Boiler%20Service%20Engineer">Email your CV</a>
                        <a class="dc-btn dc-btn--outline" href="tel:02081502025">020 8150 2025</a>
                    </div>
                </div>
            </details>
            <details class="dc-card dc-job">
                <summary>
                    <div class="dc-job__header">
                        <div><h3>Sub Contractor</h3><div class="dc-job__location">London &amp; South East &bull; Contract</div></div>
                        <span class="dc-faq__plus" aria-hidden="true">+</span>
                    </div>
                </summary>
                <div class="dc-job__body">
                    <h4>Why join us?</h4>
                    <p>We&rsquo;re looking for a passionate and experienced Heating Installation Engineer (Subcontractor) to join our team. You&rsquo;ll help us deliver on our promise of quality service while contributing to a greener, more sustainable future.</p>
                    <h4>Your responsibilities</h4>
                    <ul><li>Installing and upgrading central heating systems</li><li>Full installations, upgrades, and conversions, with associated plumbing works</li><li>Ensuring high levels of customer satisfaction</li></ul>
                    <h4>What we&rsquo;re looking for</h4>
                    <ul><li>A minimum of 3 years&rsquo; experience in domestic installations, upgrades and conversions</li><li>A full UK driving licence (6 points or fewer)</li><li>Gas Safe registration required</li><li>A strong commitment to high-quality workmanship and customer service</li></ul>
                    <h4>What we offer</h4>
                    <ul><li>Competitive package with realistic OTE</li><li>Steady pipeline of booked work</li><li>Supportive office team and clear scheduling</li></ul>
                    <div class="dc-job__apply">
                        <a class="dc-btn dc-btn--outline" href="mailto:info@meraboiler.com?subject=Application%20-%20Sub%20Contractor">Email your CV</a>
                        <a class="dc-btn dc-btn--outline" href="tel:02081502025">020 8150 2025</a>
                    </div>
                </div>
            </details>
            <details class="dc-card dc-job">
                <summary>
                    <div class="dc-job__header">
                        <div><h3>Drivers Wanted (UK Licence)</h3><div class="dc-job__location">London &bull; Full time</div></div>
                        <span class="dc-faq__plus" aria-hidden="true">+</span>
                    </div>
                </summary>
                <div class="dc-job__body">
                    <h4>Why join us?</h4>
                    <p>Join a growing operations team supporting daily engineer routes across London and surrounding areas. Ideal for reliable drivers who want steady work, clear schedules, and a supportive team environment.</p>
                    <h4>Your responsibilities</h4>
                    <ul><li>Deliver boilers, parts, and tools to field engineers on time</li><li>Support route planning and keep delivery notes up to date</li><li>Carry out daily vehicle checks and maintain safe loading standards</li></ul>
                    <h4>What we&rsquo;re looking for</h4>
                    <ul><li>Valid UK driving licence</li><li>Good route awareness, timekeeping, and communication skills</li><li>Professional, customer-friendly attitude</li></ul>
                    <h4>What we offer</h4>
                    <ul><li>Consistent workload and local route coverage</li><li>Supportive operations team and clear dispatch communication</li><li>Competitive pay based on experience and reliability</li></ul>
                    <div class="dc-job__apply">
                        <a class="dc-btn dc-btn--outline" href="mailto:info@meraboiler.com?subject=Application%20-%20Driver">Email your CV</a>
                        <a class="dc-btn dc-btn--outline" href="tel:02081502025">020 8150 2025</a>
                    </div>
                </div>
            </details>
        </div>
    </div>
</section>

<section style="background:#fff;">
    <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
        <h2 class="dc-h2" style="margin-bottom:32px;">How we hire</h2>
        <div class="dc-steps">
            <div class="dc-step"><div class="dc-step__number">1</div><h3>Email</h3><p>Email your CV to <a class="dc-link-red" href="mailto:info@meraboiler.com">info@meraboiler.com</a> or call <a class="dc-link-red" href="tel:02081502025">020 8150 2025</a>.</p></div>
            <div class="dc-step"><div class="dc-step__number">2</div><h3>Chat</h3><p>We call you for a short, friendly conversation.</p></div>
            <div class="dc-step"><div class="dc-step__number">3</div><h3>Start</h3><p>Meet the team, agree a start date and get set up.</p></div>
        </div>
    </div>
</section>

<section style="background:#eef3fa;">
    <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
        <div class="dc-split">
            <div>
                <img class="dc-pic" src="<?php echo esc_url(mbgroupltd_image('service-servicing.png')); ?>" alt="MeraBoiler team" loading="lazy" decoding="async">
            </div>
            <div>
                <h2 class="dc-h2" style="margin-bottom:12px;">Life at MeraBoiler</h2>
                <p class="dc-mut">A friendly crew of engineers, drivers and office specialists who take pride in warm homes and happy customers, with room to grow your skills every year.</p>
                <div class="dc-ticks"><div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Equal opportunities employer</div></div>
            </div>
        </div>
    </div>
</section>

<section style="background:#fff;">
    <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
        <div class="dc-split top">
            <div>
                <h2 class="dc-h2" style="margin-bottom:12px;">No perfect role listed?</h2>
                <p class="dc-mut">Send us your CV and tell us what you do best. We keep applications on file and get in touch when a suitable role opens.</p>
                <div class="dc-ticks"><div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Replies within 5 working days</div></div>
            </div>
            <div class="dc-card" style="padding:28px;">
                <h2 style="font-size:26px;margin-bottom:16px;">Send your application</h2>
                <p class="dc-mut" style="margin-bottom:20px;">Email your CV or call our hiring team directly.</p>
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a class="dc-btn" href="mailto:info@meraboiler.com?subject=Job%20application">Email your CV</a>
                    <a class="dc-btn dc-btn--outline" href="tel:02081502025">020 8150 2025</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_template_part('template-parts/dc/cta'); ?>
</div>
