<?php
/*
Template Name: Front Page
*/
get_header();
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <?php
        get_template_part('template-parts/dc/hero');
        get_template_part('template-parts/dc/rapid-response');
        get_template_part('template-parts/dc/promos');
        get_template_part('template-parts/dc/hiw');
        get_template_part('template-parts/dc/services');
        get_template_part('template-parts/dc/brands');
        get_template_part('template-parts/dc/boilers');
        get_template_part('template-parts/dc/areas');
        get_template_part('template-parts/dc/testimonials');
        get_template_part('template-parts/dc/faqs');
        get_template_part('template-parts/dc/articles');
        get_template_part('template-parts/dc/cta');
        ?>
    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php
get_footer();
?>
