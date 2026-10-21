<?php // Boiler brand logo cards (shared). ?>
<section class="dc-brands">
    <div class="dc-container">
        <div class="dc-brands__eyebrow dc-mut">BOILER BRANDS WE INSTALL AND SERVICE</div>
        <div class="dc-brands__grid">
            <?php
            foreach (['brand-worcester.png|Worcester', 'brand-vaillant.png|Vaillant', 'brand-glowworm.png|Glow-worm', 'brand-ariston.png|Ariston'] as $dc_b) :
                [$dc_file, $dc_name] = explode('|', $dc_b);
            ?>
            <div class="dc-card dc-brands__card">
                <img src="<?php echo esc_url(mbgroupltd_image($dc_file)); ?>" alt="<?php echo esc_attr($dc_name); ?>" loading="lazy" decoding="async">
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
