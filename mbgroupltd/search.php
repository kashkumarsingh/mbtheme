<?php
// Blog search results.
get_header();

$dc_s = get_search_query();
$dc_paged = max(1, (int) get_query_var('paged'));
$dc_blog_url = get_permalink(get_option('page_for_posts')) ?: home_url('/blog/');

$dc_q = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 9,
    'paged' => $dc_paged,
    's' => $dc_s,
]);
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <section class="dc-pagehead">
            <div class="dc-container">
                <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / <a href="<?php echo esc_url($dc_blog_url); ?>">Blog</a> / Search</div>
                <h1>Search results for &ldquo;<?php echo esc_html($dc_s); ?>&rdquo;</h1>
                <p class="dc-lead"><?php echo esc_html((string) $dc_q->found_posts); ?> article<?php echo (int) $dc_q->found_posts === 1 ? '' : 's'; ?> found.</p>
                <form class="dc-blog-tools" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="dc-blog-search">
                        <input class="dc-in" type="search" name="s" value="<?php echo esc_attr($dc_s); ?>" placeholder="Search articles" aria-label="Search articles">
                    </div>
                </form>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:40px;padding-bottom:72px;">
                <?php get_template_part('template-parts/dc/blog-grid', null, ['query' => $dc_q, 'paged' => $dc_paged, 'add_args' => ['s' => $dc_s]]); ?>
            </div>
        </section>

        <?php get_template_part('template-parts/dc/cta'); ?>
    </main>
</div>

<?php get_footer(); ?>
