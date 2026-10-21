<?php
/*
Template Name: Quote Template
*/
get_header();
?>
<div id="primary" class="content-area mb-quote-page">
    <main id="main" class="site-main" role="main">
        <h1 style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">Get a fixed-price boiler quote</h1>
        <?php
        get_template_part('template-parts/quote/content', 'quote-wizard');
        ?>
    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php
get_footer();
?>
