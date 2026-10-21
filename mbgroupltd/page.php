<?php get_header(); ?>

<main id="primary" class="site-main" role="main">
    <div class="page-content page-content--<?php echo sanitize_html_class(get_post_field('post_name')); ?>">
        <?php
        if (have_posts()):
            while (have_posts()):
                the_post(); ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="page-header">
                        <div class="container">
                             <h1 class="page-title"><?php the_title(); ?></h1>
                        </div>
                    </header>

                    <div class="page-content-area">
                        <?php
                        the_content();
                        
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'mbgroupltd'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>
                
            <?php endwhile;
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>