<?php // About us page - live story content, new design. ?>
<div class="dc">
<section class="dc-pagehead">
    <div class="dc-container">
        <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / About us</div>
        <div class="dc-pagehead-split" style="align-items:center;">
            <div>
                <h1>Boiler experts. Fixed prices. No surprises.</h1>
                <p class="dc-lead">MeraBoiler supplies and fits boilers across the UK. Gas Safe registered engineers, fixed prices and same-day attendance where capacity allows.</p>
                <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:24px;">
                    <a class="dc-btn" href="<?php echo esc_url(home_url('/quote/')); ?>">Get a free quote</a>
                    <a class="dc-btn dc-btn--outline" href="tel:02081502025">Call 020 8150 2025</a>
                </div>
            </div>
            <div>
                <img class="dc-pic" src="<?php echo esc_url(mbgroupltd_image('service-servicing.png')); ?>" alt="MeraBoiler engineer with a customer" loading="eager" fetchpriority="high" decoding="async">
            </div>
        </div>
    </div>
</section>

<section style="background:#fff;">
    <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
        <h2 class="dc-h2" style="margin-bottom:32px;">What we stand for</h2>
        <div class="dc-feats">
            <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg></div><h3>Fixed prices</h3><p>Parts, labour and a magnetic filter are included in every price. Final quote after survey.</p></div>
            <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.2 7.8-8 9-4.8-1.2-8-4.5-8-9V6l8-3z"></path><path d="M8.5 12l2.5 2.5 4.5-5"></path></svg></div><h3>Gas Safe registered</h3><p>Every engineer is Gas Safe registered. We fit, test and register your boiler.</p></div>
            <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 3"></path></svg></div><h3>Fast attendance</h3><p>Same-day and next-day slots where available. Emergency attendance aimed within the hour.</p></div>
            <div class="dc-card dc-feat"><div class="dc-feat__icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.2 7.8-8 9-4.8-1.2-8-4.5-8-9V6l8-3z"></path><path d="M8.5 12l2.5 2.5 4.5-5"></path></svg></div><h3>Real guarantees</h3><p>Up to a 12-year manufacturer guarantee, depending on the boiler model and registration (5 years on Ariston).</p></div>
        </div>
    </div>
</section>

<section style="background:#eef3fa;">
    <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
        <div class="dc-split top">
            <div><img class="dc-pic" src="<?php echo esc_url(mbgroupltd_image('service-repair.png')); ?>" alt="MeraBoiler engineer fitting a boiler" loading="lazy" decoding="async"></div>
            <div>
                <h2 class="dc-h2" style="margin-bottom:12px;">Who we are</h2>
                <p style="font-size:19px;font-weight:600;margin:0 0 8px;">It all started with a frustrated plumber.</p>
                <p class="dc-mut">MeraBoiler is a Gas Safe boiler installation, repair and servicing company based in Potters Bar. The team built an online quoting process so homeowners can see a like-for-like figure before an engineer visits.</p>
                <blockquote style="border-left:4px solid #c8102e;margin:20px 0 0;padding:4px 0 4px 18px;font-size:20px;font-weight:600;">&ldquo;To give customers a fast, easy and reliable experience when installing, servicing or repairing a boiler.&rdquo;<span class="dc-mut" style="display:block;font-size:14px;font-weight:400;margin-top:6px;">Our mission</span></blockquote>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:12px;">
                    <details class="dc-card dc-faq__item">
                        <summary><span>Who we are</span><span class="dc-faq__plus" aria-hidden="true">+</span></summary>
                        <div class="dc-faq__answer">The team behind MeraBoiler combines tech and trade: skilled web developers and expert heating engineers, changing how you buy and install boilers.</div>
                    </details>
                    <details class="dc-card dc-faq__item">
                        <summary><span>The problem we solve</span><span class="dc-faq__plus" aria-hidden="true">+</span></summary>
                        <div class="dc-faq__answer">Getting a new boiler used to be a long, drawn-out process, often taking up to two weeks. We thought there had to be a better way.</div>
                    </details>
                    <details class="dc-card dc-faq__item">
                        <summary><span>Our solution</span><span class="dc-faq__plus" aria-hidden="true">+</span></summary>
                        <div class="dc-faq__answer">A straightforward online service: choose your new boiler and book an installation quickly and easily from the comfort of your home.</div>
                    </details>
                    <details class="dc-card dc-faq__item">
                        <summary><span>Why MeraBoiler?</span><span class="dc-faq__plus" aria-hidden="true">+</span></summary>
                        <div class="dc-faq__answer">Fast, reliable service from an expert team, so you can get warm again without the wait or the hassle.</div>
                    </details>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_template_part('template-parts/dc/brands'); ?>

<section style="background:#fff;">
    <div class="dc-container" style="padding-top:56px;padding-bottom:72px;">
        <h2 class="dc-h2" style="margin-bottom:12px;">What homeowners say after the job</h2>
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
</div>
