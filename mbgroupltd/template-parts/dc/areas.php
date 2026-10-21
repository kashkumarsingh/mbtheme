<?php // New-design areas grid - reuses the theme's real location URLs. ?>
<section class="dc-areas">
    <div class="dc-container">
    <h2>Installation and repair near you</h2>
    <div class="dc-areas__grid">
        <?php
        $dc_home = static fn($path) => esc_url(home_url($path));
        $dc_areas = [
            ['London', '/boiler-installation-london/'],
            ['Bristol', '/boiler-installation-bristol/'],
            ['Birmingham', '/boiler-installation-birmingham/'],
            ['Manchester', '/boiler-installation-manchester/'],
            ['Leeds', '/boiler-installation-leeds/'],
            ['Coventry', '/boiler-installation-coventry/'],
            ['Nottingham', '/boiler-installation-nottingham/'],
            ['Surrey', '/boiler-installation-surrey/'],
            ['Bromley', '/boiler-installation-bromley/'],
            ['Gloucester', '/boiler-installation-gloucester/'],
            ['Southampton', '/boiler-installation-southampton/'],
            ['Kent', '/boiler-installation-kent/'],
            ['Liverpool', '/boiler-installation-liverpool/'],
            ['North London', '/boiler-installation-north-london/'],
            ['Potters Bar', '/boiler-installation-potters-bar/'],
            ['View all areas', '/service-areas/'],
            ['Repair near me', '/boiler-repair-near-me/'],
        ];
        foreach ($dc_areas as $dc_a) :
        ?>
        <a class="dc-card dc-areas__card" href="<?php echo $dc_home($dc_a[1]); ?>"><?php echo esc_html($dc_a[0]); ?></a>
        <?php endforeach; ?>
    </div>
    </div>
</section>
