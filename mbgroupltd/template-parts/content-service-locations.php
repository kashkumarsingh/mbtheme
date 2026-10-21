<?php // Boiler service locations strip (service-plan page) - new design, live URLs. ?>
<section style="background:#fff;">
    <div class="dc-container" style="padding-top:56px;padding-bottom:72px;">
        <h2 class="dc-h2" style="margin-bottom:32px;">Boiler service locations</h2>
        <div class="dc-areas__grid">
            <?php
            $mb_home = static fn($path) => esc_url(home_url($path));
            foreach ([['London', '/boiler-service-london/'], ['Sheffield', '/boiler-service-sheffield/'], ['Boiler service near you', '/boiler-service-london/'], ['View all locations', '/service-areas/']] as $dc_a) :
            ?>
            <a class="dc-card dc-areas__card" href="<?php echo $mb_home($dc_a[1]); ?>"><?php echo esc_html($dc_a[0]); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
