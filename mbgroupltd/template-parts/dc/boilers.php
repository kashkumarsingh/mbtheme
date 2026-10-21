<?php // Fixed-price boiler products. Args: title, sub (both have defaults).
$dc_boilers_title = isset($args['title']) && $args['title'] !== '' ? $args['title'] : 'Fixed-price boilers, installed';
$dc_boilers_sub = isset($args['sub']) && $args['sub'] !== '' ? $args['sub'] : 'Every price includes Gas Safe installation, a magnetic filter, a wireless thermostat and both safety certificates. Final quote confirmed after survey.';
?>
<section class="dc-boilers">
    <div class="dc-container">
    <h2><?php echo esc_html($dc_boilers_title); ?></h2>
    <p class="dc-sub muted"><?php echo esc_html($dc_boilers_sub); ?></p>
    <div class="dc-cards-4">
        <?php
        $dc_quote = esc_url(home_url('/quote/'));
        $dc_boilers = [
            ['boiler-bosch-greenstar.png', 'Worcester Bosch &bull; Combi', 'Greenstar', '25&ndash;35 kW &bull; 7-year guarantee', '&pound;1,890'],
            ['boiler-vaillant-ecotec.png', 'Vaillant &bull; Combi', 'ecoTEC Plus', '25&ndash;35 kW &bull; 10-year guarantee', '&pound;2,205'],
            ['boiler-glowworm-energy.png', 'Glow-worm &bull; Combi', 'Energy Combi', '25&ndash;35 kW &bull; 7-year guarantee', '&pound;1,875'],
            ['boiler-ariston-one.png', 'Ariston &bull; Combi', 'ONE Combi', '24&ndash;35 kW &bull; 5-year guarantee', '&pound;1,680'],
        ];
        foreach ($dc_boilers as $dc_b) :
        ?>
        <div class="dc-card dc-boiler">
            <img src="<?php echo esc_url(mbgroupltd_image($dc_b[0])); ?>" alt="<?php echo esc_attr(strip_tags($dc_b[2])); ?>" loading="lazy" decoding="async">
            <div class="dc-boiler__brand"><?php echo wp_kses_post($dc_b[1]); ?></div>
            <h3><?php echo esc_html($dc_b[2]); ?></h3>
            <div class="dc-boiler__spec"><?php echo wp_kses_post($dc_b[3]); ?></div>
            <div class="dc-boiler__price"><span class="dc-boiler__from">From</span><strong><?php echo wp_kses_post($dc_b[4]); ?></strong><span>fully fitted</span></div>
            <a class="dc-btn" href="<?php echo $dc_quote; ?>">Get this price</a>
        </div>
        <?php endforeach; ?>
    </div>
    </div>
</section>
