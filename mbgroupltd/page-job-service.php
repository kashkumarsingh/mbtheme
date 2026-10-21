<?php
/*
Template Name: Job service detail
*/
get_header();

$dc_slug = get_post_field('post_name', get_queried_object_id());
$dc_job = function_exists('mbgroupltd_job_service') ? mbgroupltd_job_service($dc_slug) : null;
$dc_all = function_exists('mbgroupltd_job_services') ? mbgroupltd_job_services() : [];

if (!$dc_job) {
    echo '<div class="dc-container" style="padding:72px 0;"><p>This service is not available.</p></div>';
    get_footer();
    return;
}

$dc_index = function_exists('mbgroupltd_job_services_index_url') ? mbgroupltd_job_services_index_url() : home_url('/services/');
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <section class="dc-pagehead">
            <div class="dc-container">
                <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / <a href="<?php echo esc_url($dc_index); ?>">Services</a> / <?php echo esc_html($dc_job['title']); ?></div>
                <div class="dc-eyebrow" style="margin-bottom:12px;"><?php echo esc_html(strtoupper($dc_job['keyword'])); ?></div>
                <h1><?php echo esc_html($dc_job['h1']); ?></h1>
                <p class="dc-lead"><?php echo esc_html($dc_job['summary']); ?></p>
                <div class="dc-hero__price" style="margin-top:16px;"><?php echo wp_kses_post($dc_job['price']); ?></div>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:56px;padding-bottom:72px;">
                <div class="dc-art-grid">
                    <article>
                        <div style="margin-bottom:28px;">
                            <img class="dc-featured__img" src="<?php echo esc_url(mbgroupltd_image($dc_job['image'])); ?>" alt="<?php echo esc_attr($dc_job['h1'] . ' - MeraBoiler'); ?>" loading="eager" decoding="async">
                        </div>
                        <div class="dc-short"><b>THE SHORT ANSWER</b><p><?php echo esc_html($dc_job['short']); ?></p></div>
                        <nav class="dc-toc" id="dcToc" aria-label="On this page"><b>ON THIS PAGE</b></nav>
                        <div class="dc-prose" id="dcProse">
                            <?php foreach ($dc_job['sections'] as $dc_section) : ?>
                            <h2><?php echo esc_html($dc_section[0]); ?></h2>
                            <?php echo wp_kses_post($dc_section[1]); ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="dc-cta-card">
                            <h2>Book <?php echo esc_html(strtolower($dc_job['title'])); ?></h2>
                            <p>Tell us the job and your postcode. We confirm the price and a date before we start.</p>
                            <a class="dc-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Contact us</a>
                        </div>
                        <h2 class="dc-h2" style="font-size:30px;margin-bottom:20px;">Common questions</h2>
                        <div class="dc-faq__grid" style="grid-template-columns:1fr;">
                            <?php foreach ($dc_job['faqs'] as $dc_f) : ?>
                            <details class="dc-card dc-faq__item">
                                <summary><span><?php echo esc_html($dc_f[0]); ?></span><span class="dc-faq__plus" aria-hidden="true">+</span></summary>
                                <div class="dc-faq__answer"><?php echo esc_html($dc_f[1]); ?></div>
                            </details>
                            <?php endforeach; ?>
                        </div>
                    </article>
                    <aside class="dc-side" aria-label="Sidebar">
                        <?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Contact us about this job']); ?>
                        <div class="dc-card dc-side__block">
                            <b class="dc-side__heading">Other jobs</b>
                            <ul class="dc-side__recent">
                                <?php foreach ($dc_all as $dc_other_slug => $dc_other) :
                                    if ($dc_other_slug === $dc_slug) {
                                        continue;
                                    }
                                ?>
                                <li>
                                    <div>
                                        <a class="dc-side__title" href="<?php echo esc_url(mbgroupltd_job_service_url($dc_other_slug)); ?>"><?php echo esc_html($dc_other['title']); ?></a>
                                        <div class="dc-post-meta"><?php echo esc_html($dc_other['keyword']); ?></div>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <section style="background:#eef3fa;">
            <div class="dc-container" style="padding-top:56px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">Related services</h2>
                <div class="dc-cards-3">
                    <?php
                    $dc_shown = 0;
                    foreach ($dc_all as $dc_rel_slug => $dc_rel) :
                        if ($dc_rel_slug === $dc_slug) {
                            continue;
                        }
                        if ($dc_shown >= 3) {
                            break;
                        }
                        $dc_shown++;
                    ?>
                    <div class="dc-card dc-service">
                        <img src="<?php echo esc_url(mbgroupltd_image($dc_rel['image'])); ?>" alt="<?php echo esc_attr($dc_rel['title']); ?>" loading="lazy" decoding="async">
                        <div class="dc-service__body">
                            <h3><a href="<?php echo esc_url(mbgroupltd_job_service_url($dc_rel_slug)); ?>"><?php echo esc_html($dc_rel['title']); ?></a></h3>
                            <div class="dc-service__desc"><?php echo esc_html($dc_rel['summary']); ?></div>
                            <b class="dc-service__price"><?php echo wp_kses_post($dc_rel['price']); ?></b>
                            <a class="dc-link-red" href="<?php echo esc_url(mbgroupltd_job_service_url($dc_rel_slug)); ?>">View details</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/dc/cta'); ?>
    </main>
</div>

<script>
(function () {
    var prose = document.getElementById('dcProse');
    var toc = document.getElementById('dcToc');
    if (!prose || !toc) return;
    var heads = prose.querySelectorAll('h2');
    if (!heads.length) {
        toc.style.display = 'none';
        return;
    }
    Array.prototype.forEach.call(heads, function (h, i) {
        if (!h.id) h.id = 'dc-sec-' + (i + 1);
        var a = document.createElement('a');
        a.href = '#' + h.id;
        a.textContent = h.textContent;
        toc.appendChild(a);
    });
})();
</script>

<?php get_footer(); ?>
