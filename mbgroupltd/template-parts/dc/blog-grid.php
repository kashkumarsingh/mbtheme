<?php
// Shared post grid + pager. Args: query (WP_Query), paged (int), add_args (array).
$dc_q = isset($args['query']) ? $args['query'] : null;
$dc_paged = isset($args['paged']) ? (int) $args['paged'] : 1;
$dc_add_args = isset($args['add_args']) && is_array($args['add_args']) ? $args['add_args'] : [];
if (!$dc_q || !$dc_q->have_posts()) :
?>
<p class="dc-mut">No articles found. Try a different search or category.</p>
<?php else : ?>
<div class="dc-post-grid">
    <?php while ($dc_q->have_posts()) : $dc_q->the_post(); ?>
    <div class="dc-card dc-article">
        <?php if (has_post_thumbnail()) : ?>
        <a class="dc-article__img" href="<?php echo esc_url(get_permalink()); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail('medium', ['loading' => 'lazy']); ?></a>
        <?php endif; ?>
        <div class="dc-article__body">
            <div class="dc-article__category">BOILER PRICING</div>
            <div class="dc-post-meta"><?php echo esc_html(get_the_date('j F Y')); ?></div>
            <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
            <div class="dc-mut dc-article__meta"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 16, '&hellip;')); ?></div>
            <a class="dc-link-red" href="<?php echo esc_url(get_permalink()); ?>">Read article</a>
        </div>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
</div>
<?php if ($dc_q->max_num_pages > 1) : ?>
<div class="dc-pager">
    <?php
    echo paginate_links([
        'total' => $dc_q->max_num_pages,
        'current' => $dc_paged,
        'prev_text' => 'Previous',
        'next_text' => 'Next',
        'add_args' => $dc_add_args,
    ]);
    ?>
</div>
<?php endif; ?>
<?php endif; ?>
