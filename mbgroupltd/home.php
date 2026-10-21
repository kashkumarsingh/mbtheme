<?php
/*
Template Name: Blog Index
*/
get_header();

$dc_blog_url = get_permalink(get_option('page_for_posts')) ?: home_url('/blog/');
$dc_search = isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '';
$dc_cat = isset($_GET['dc_cat']) ? sanitize_title(wp_unslash($_GET['dc_cat'])) : '';
$dc_paged = max(1, (int) get_query_var('paged'), (int) (isset($_GET['paged']) ? $_GET['paged'] : 1));

$dc_cats = get_categories(['hide_empty' => true, 'number' => 8]);

$dc_q_args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 7,
    'paged' => $dc_paged,
    'ignore_sticky_posts' => false,
];
if ($dc_search !== '') {
    $dc_q_args['s'] = $dc_search;
}
if ($dc_cat !== '') {
    $dc_q_args['category_name'] = $dc_cat;
}
$dc_q = new WP_Query($dc_q_args);
$dc_posts = $dc_q->posts;

$dc_featured = null;
if ($dc_paged === 1 && $dc_search === '' && $dc_cat === '' && !empty($dc_posts)) {
    $sticky = get_option('sticky_posts', []);
    foreach ($dc_posts as $dc_p) {
        if (in_array($dc_p->ID, (array) $sticky, true)) {
            $dc_featured = $dc_p;
            break;
        }
    }
    if (!$dc_featured) {
        $dc_featured = $dc_posts[0];
    }
}
if ($dc_featured) {
    // Re-run without the featured post so it never doubles up in the grid.
    // Page one shows six in the grid (1 featured + 6); later pages show seven,
    // so nothing repeats and the pager total stays exact.
    $dc_q_args['post__not_in'] = [$dc_featured->ID];
    if ($dc_paged === 1) {
        $dc_q_args['posts_per_page'] = 6;
    }
    $dc_q = new WP_Query($dc_q_args);
    $dc_q->max_num_pages = (int) ceil($dc_q->found_posts / 7);
}
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <section class="dc-pagehead">
            <div class="dc-container">
                <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / Blog</div>
                <h1>Boiler advice and pricing tips</h1>
                <p class="dc-lead">Clear guides on boiler costs, servicing and repairs from Gas Safe registered engineers.</p>
                <?php if ($dc_search !== '') : ?>
                <p class="dc-mut" style="margin:12px 0 0;"><?php echo esc_html((string) $dc_q->found_posts); ?> result<?php echo (int) $dc_q->found_posts === 1 ? '' : 's'; ?> for &ldquo;<?php echo esc_html($dc_search); ?>&rdquo; &middot; <a href="<?php echo esc_url($dc_blog_url); ?>">clear search</a></p>
                <?php endif; ?>
                <form class="dc-blog-tools" role="search" method="get" action="<?php echo esc_url($dc_blog_url); ?>">
                    <div class="dc-blog-search">
                        <input class="dc-in" type="search" name="s" value="<?php echo esc_attr($dc_search); ?>" placeholder="Search articles" aria-label="Search articles">
                    </div>
                    <div class="dc-pills" role="group" aria-label="Filter by category">
                        <a class="dc-pill<?php echo $dc_cat === '' ? ' dc-pill--active' : ''; ?>" href="<?php echo esc_url($dc_blog_url); ?>">All</a>
                        <?php foreach ($dc_cats as $dc_c) : ?>
                        <a class="dc-pill<?php echo $dc_cat === $dc_c->slug ? ' dc-pill--active' : ''; ?>" href="<?php echo esc_url(add_query_arg('dc_cat', $dc_c->slug, $dc_blog_url)); ?>"><?php echo esc_html($dc_c->name); ?></a>
                        <?php endforeach; ?>
                    </div>
                </form>
            </div>
        </section>

        <?php if ($dc_featured) : ?>
        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:56px;padding-bottom:8px;">
                <div class="dc-featured">
                    <?php if (has_post_thumbnail($dc_featured->ID)) : ?>
                    <a href="<?php echo esc_url(get_permalink($dc_featured)); ?>" tabindex="-1" aria-hidden="true"><?php echo get_the_post_thumbnail($dc_featured->ID, 'large', ['class' => 'dc-featured__img', 'loading' => 'eager']); ?></a>
                    <?php endif; ?>
                    <div>
                        <div class="dc-article__category">FEATURED &bull; BOILER PRICING</div>
                        <h2 class="dc-h2" style="margin:8px 0 12px;"><a href="<?php echo esc_url(get_permalink($dc_featured)); ?>"><?php echo esc_html(get_the_title($dc_featured)); ?></a></h2>
                        <p class="dc-mut"><?php echo esc_html(wp_trim_words(get_the_excerpt($dc_featured), 24, '&hellip;')); ?></p>
                        <div class="dc-post-meta" style="margin:12px 0 20px;">By <?php echo esc_html(get_the_author_meta('display_name', $dc_featured->post_author)); ?> | <?php echo esc_html(get_the_date('j F Y', $dc_featured)); ?> | <?php echo esc_html((string) max(1, (int) ceil(str_word_count(strip_tags((string) $dc_featured->post_content)) / 200))); ?> min read</div>
                        <a class="dc-btn" href="<?php echo esc_url(get_permalink($dc_featured)); ?>">Read article</a>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:40px;padding-bottom:72px;">
                <?php get_template_part('template-parts/dc/blog-grid', null, ['query' => $dc_q, 'paged' => $dc_paged, 'add_args' => array_filter(['s' => $dc_search ?: false, 'dc_cat' => $dc_cat ?: false])]); ?>
            </div>
        </section>

        <?php get_template_part('template-parts/dc/cta'); ?>
    </main>
</div>

<?php get_footer(); ?>
