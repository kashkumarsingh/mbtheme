<?php
/**
 * Fallback theme template - lists posts when no more specific template matches.
 */
get_header();
?>

<main id="primary" class="site-main" role="main">
    <div class="container block container-v5 mx-auto py-14">
        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-12 gap-y-8 md:gap-8">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('col-span-12 sm:col-span-6 md:col-span-4'); ?>>
                        <a href="<?php the_permalink(); ?>" class="group block">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', ['class' => 'w-full mb-4 rounded-lg']); ?>
                            <?php endif; ?>
                            <h2 class="text-2xl font-medium text-v5-dark-blue mb-2 group-hover:underline"><?php the_title(); ?></h2>
                            <p class="text-v5-dark-blue"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 22)); ?></p>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <h1 class="text-3xl font-medium text-v5-dark-blue">No content found</h1>
            <p class="mt-4">Please check back soon.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
