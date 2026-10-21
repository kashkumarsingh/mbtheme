<?php // Service plans page - live pricing tiers, new design. ?>
<div class="dc">
<?php
$dc_wa = 'https://api.whatsapp.com/send/?phone=447894020000&text=Hi+Meraboiler+I+need+Quote+%2F+Assistance&type=phone_number&app_absent=0';
// Live tiers: price/month, included features (from the previous plan table).
$dc_plans = [
    ['Essential', '&pound;10', 'a month', false, ['Boiler parts &amp; labour', 'Main heat exchanger', 'Unlimited callouts'], 'Choose Essential'],
    ['Standard', '&pound;15', 'a month', true, ['Everything in Essential', 'Annual boiler service', 'Central heating &amp; radiators', 'Unlimited callouts'], 'Choose Standard'],
    ['Advanced', '&pound;20', 'a month', false, ['Everything in Standard', 'Plumbing cover', 'Priority booking'], 'Choose Advanced'],
    ['Complete', '&pound;25', 'a month', false, ['Everything in Advanced', 'Hot water cylinder cover', 'Yearly reminder'], 'Choose Complete'],
];
?>
<section class="dc-pagehead">
    <div class="dc-container">
        <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / Service plans</div>
        <div class="dc-pagehead-split">
            <div>
                <h1>Boiler service plans</h1>
                <p class="dc-lead">Keep your boiler safe, efficient and under guarantee with a yearly service from Gas Safe registered engineers.</p>
                <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:24px;">
                    <a class="dc-btn" href="<?php echo esc_url(home_url('/quote/')); ?>">Get a free quote</a>
                    <a class="dc-btn dc-btn--outline" href="tel:02081502025">Call 020 8150 2025</a>
                </div>
            </div>
            <div class="dc-ticks">
                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Gas Safe certificate included</div>
                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Helps keep your manufacturer guarantee valid</div>
                <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> Fixed prices, no surprises</div>
            </div>
        </div>
    </div>
</section>

<section style="background:#fff;">
    <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
        <div class="dc-tiers dc-tiers--4col">
            <?php foreach ($dc_plans as $dc_p) : ?>
            <div class="dc-card dc-tier<?php echo $dc_p[3] ? ' dc-tier--pop' : ''; ?>">
                <?php if ($dc_p[3]) : ?><span class="dc-pop-pill">MOST POPULAR</span><?php endif; ?>
                <h3><?php echo esc_html($dc_p[0]); ?></h3>
                <div class="dc-tier__price"><?php echo wp_kses_post($dc_p[1]); ?> <small><?php echo esc_html($dc_p[2]); ?></small></div>
                <ul>
                    <?php foreach ($dc_p[4] as $dc_f) : ?>
                    <li><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> <?php echo wp_kses_post($dc_f); ?></li>
                    <?php endforeach; ?>
                </ul>
                <a class="dc-btn<?php echo $dc_p[3] ? '' : ' dc-btn--outline'; ?>" href="<?php echo esc_url($dc_wa); ?>" target="_blank" rel="noopener"><?php echo esc_html($dc_p[5]); ?></a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section style="background:#eef3fa;">
    <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
        <h2 class="dc-h2" style="margin-bottom:32px;">Compare plans</h2>
        <div class="tbl-scroll">
        <table class="dc-compare">
            <thead><tr><th>What is included</th><th>Essential &pound;10</th><th>Standard &pound;15</th><th>Advanced &pound;20</th><th>Complete &pound;25</th></tr></thead>
            <tbody>
                <?php
                $dc_rows = [
                    ['Boiler parts &amp; labour', 1, 1, 1, 1],
                    ['Main heat exchanger', 1, 1, 1, 1],
                    ['Annual service', 0, 1, 1, 1],
                    ['Unlimited callouts', 1, 1, 1, 1],
                    ['Central heating &amp; radiators', 0, 1, 1, 1],
                    ['Plumbing', 0, 0, 1, 1],
                    ['Hot water storage cylinder', 0, 0, 0, 1],
                ];
                foreach ($dc_rows as $dc_r) :
                ?>
                <tr><th><?php echo wp_kses_post($dc_r[0]); ?></th>
                <?php for ($dc_i = 1; $dc_i <= 4; $dc_i++) : ?>
                    <td><?php echo $dc_r[$dc_i] ? '<span class="dc-yes" aria-label="Included"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1F5FBF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg></span>' : '<span class="dc-no" aria-label="Not included">No</span>'; ?></td>
                <?php endfor; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</section>

<section style="background:#fff;">
    <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
        <h2 class="dc-h2" style="margin-bottom:32px;">How a plan works</h2>
        <div class="dc-steps">
            <div class="dc-step"><div class="dc-step__number">1</div><h3>Choose your plan</h3><p>Choose the cover that suits your home or rental property.</p></div>
            <div class="dc-step"><div class="dc-step__number">2</div><h3>We book your visit</h3><p>A Gas Safe engineer visits at a time that suits you.</p></div>
            <div class="dc-step"><div class="dc-step__number">3</div><h3>Stay covered</h3><p>Get your certificate and a reminder before your next service.</p></div>
        </div>
    </div>
</section>

<section style="background:#eef3fa;">
    <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
        <h2 class="dc-h2" style="margin-bottom:32px;">Service plan questions</h2>
        <div class="dc-faq__grid">
            <?php
            $dc_faqs = [
                ['How often should I service my boiler?', 'Once a year, to keep it safe and efficient and to help keep your guarantee valid.'],
                ['What does a boiler service include?', 'A full strip-down service: flue and combustion checks, seals and pressures, controls test, and a Gas Safe certificate.'],
                ['Is a landlord certificate included?', 'The Complete plan covers landlord gas safety certificates (CP12) with reminders before expiry.'],
                ['Can I add a plan to my new boiler?', 'Yes. Ask us when you request your quote and we&rsquo;ll set everything up together.'],
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

<?php get_template_part('template-parts/dc/brands'); ?>
</div>
