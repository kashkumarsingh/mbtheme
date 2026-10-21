<?php
// New-design articles - uses the 3 latest live posts so cards always show
// real titles, excerpts and images (the mockup only had "[Image]" placeholders).
$dc_posts = get_posts(['numberposts' => 3, 'post_status' => 'publish']);
if ($dc_posts) :
    $dc_blog = get_permalink(get_option('page_for_posts')) ?: home_url('/blog/');
?>
<section class="dc-articles">
    <div class="dc-container">
    <h2>Expert advice and pricing tips</h2>
    <div class="dc-cards-3">
        <?php foreach ($dc_posts as $post) : setup_postdata($post); ?>
        <div class="dc-card dc-article">
            <?php if (has_post_thumbnail($post)) : ?>
            <a class="dc-article__img" href="<?php echo esc_url(get_permalink($post)); ?>" aria-hidden="true" tabindex="-1">
                <?php echo get_the_post_thumbnail($post, 'medium', ['loading' => 'lazy', 'alt' => esc_attr(get_the_title($post))]); ?>
            </a>
            <?php endif; ?>
            <div class="dc-article__body">
                <div class="dc-article__category">BOILER PRICING</div>
                <h3><a href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html(get_the_title($post)); ?></a></h3>
                <div class="dc-mut dc-article__meta"><?php echo esc_html(wp_trim_words(get_the_excerpt($post), 14, '&hellip;')); ?></div>
                <a class="dc-link-red" href="<?php echo esc_url(get_permalink($post)); ?>">Read article</a>
            </div>
        </div>
        <?php endforeach; wp_reset_postdata(); ?>
    </div>
    </div>
</section>
<?php endif; ?>
