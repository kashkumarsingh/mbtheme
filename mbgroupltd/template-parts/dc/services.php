<?php // New-design services grid ("Book the job you need"). ?>
<section class="dc-services">
    <div class="dc-container">
    <h2>Book the job you need</h2>
    <div class="dc-cards-3">
        <?php
        $dc_services = function_exists('mbgroupltd_job_services') ? mbgroupltd_job_services() : [];
        foreach ($dc_services as $dc_slug => $dc_s) :
            $dc_url = function_exists('mbgroupltd_job_service_url') ? mbgroupltd_job_service_url($dc_slug) : home_url('/contact-us/');
        ?>
        <div class="dc-card dc-service">
            <img src="<?php echo esc_url(mbgroupltd_image($dc_s['image'])); ?>" alt="<?php echo esc_attr($dc_s['title']); ?>" loading="lazy" decoding="async">
            <div class="dc-service__body">
                <h3><?php echo esc_html($dc_s['title']); ?></h3>
                <div class="dc-service__desc"><?php echo esc_html($dc_s['summary']); ?></div>
                <b class="dc-service__price"><?php echo wp_kses_post($dc_s['price']); ?></b>
                <span class="dc-service__actions">
                    <a class="dc-link-red" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Contact us</a>
                    <a class="dc-link-red" href="<?php echo esc_url($dc_url); ?>">View details</a>
                </span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    </div>
</section>
