<?php
/*
Template Name: Book the job you need
*/
get_header();
$dc_jobs = function_exists('mbgroupltd_job_services') ? mbgroupltd_job_services() : [];
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <section class="dc-pagehead">
            <div class="dc-container">
                <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / Services</div>
                <h1>Book the job you need</h1>
                <p class="dc-lead">Boiler installation, repair, servicing and heating work, priced before we start and carried out by Gas Safe engineers.</p>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:56px;padding-bottom:72px;">
                <div class="dc-cards-3">
                    <?php foreach ($dc_jobs as $dc_slug => $dc_job) : ?>
                    <div class="dc-card dc-service">
                        <a href="<?php echo esc_url(mbgroupltd_job_service_url($dc_slug)); ?>" tabindex="-1" aria-hidden="true">
                            <img src="<?php echo esc_url(mbgroupltd_image($dc_job['image'])); ?>" alt="<?php echo esc_attr($dc_job['title']); ?>" loading="lazy" decoding="async">
                        </a>
                        <div class="dc-service__body">
                            <div class="dc-article__category"><?php echo esc_html(strtoupper($dc_job['keyword'])); ?></div>
                            <h2 style="font-size:22px;margin:8px 0;"><a href="<?php echo esc_url(mbgroupltd_job_service_url($dc_slug)); ?>"><?php echo esc_html($dc_job['title']); ?></a></h2>
                            <div class="dc-service__desc"><?php echo esc_html($dc_job['summary']); ?></div>
                            <b class="dc-service__price"><?php echo wp_kses_post($dc_job['price']); ?></b>
                            <span class="dc-service__actions">
                                <a class="dc-link-red" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Contact us</a>
                                <a class="dc-link-red" href="<?php echo esc_url(mbgroupltd_job_service_url($dc_slug)); ?>">View details</a>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/dc/cta'); ?>
    </main>
</div>

<?php get_footer(); ?>
