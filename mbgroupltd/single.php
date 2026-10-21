<?php get_header(); ?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <?php if (have_posts()) : while (have_posts()) : the_post();
            $dc_cats = get_the_category();
            $dc_cat = $dc_cats ? $dc_cats[0] : null;
            $dc_blog_url = get_permalink(get_option('page_for_posts')) ?: home_url('/blog/');
            $dc_words = str_word_count(strip_tags((string) get_post_field('post_content', get_the_ID())));
            $dc_read = max(1, (int) ceil($dc_words / 200));
            $dc_author_id = (int) get_the_author_meta('ID');
            $dc_author_name = get_the_author_meta('display_name');
            $dc_bio = get_the_author_meta('description');
            if (trim((string) $dc_bio) === '') {
                $dc_bio = 'Heating specialist at MeraBoiler, helping UK homeowners with boiler installation, servicing and honest pricing advice.';
            }
            $dc_initials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), preg_split('/\s+/', trim((string) $dc_author_name), -1, PREG_SPLIT_NO_EMPTY))));
        ?>
        <section class="dc-pagehead">
            <div class="dc-container">
                <div class="dc-crumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> / <a href="<?php echo esc_url($dc_blog_url); ?>">Blog</a><?php if ($dc_cat) : ?> / <?php echo esc_html($dc_cat->name); ?><?php endif; ?> / <?php the_title(); ?></div>
                <?php if ($dc_cat) : ?><div class="dc-eyebrow" style="margin-bottom:12px;"><?php echo esc_html(strtoupper($dc_cat->name)); ?></div><?php endif; ?>
                <h1><?php the_title(); ?></h1>
                <div class="dc-post-meta" style="margin-top:16px;font-size:14px;">By <?php echo esc_html($dc_author_name); ?> | Published <?php echo esc_html(get_the_date('j F Y')); ?> | Updated <?php echo esc_html(get_the_modified_date('j F Y')); ?> | <?php echo esc_html((string) $dc_read); ?> min read</div>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:56px;padding-bottom:72px;">
                <div class="dc-art-grid">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                        <div style="margin-bottom:28px;"><?php the_post_thumbnail('large', ['class' => 'dc-featured__img', 'loading' => 'eager', 'alt' => esc_attr(get_the_title() . ' - MeraBoiler')]); ?></div>
                        <?php endif; ?>
                        <div class="dc-short"><b>THE SHORT ANSWER</b><p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 32, '&hellip;')); ?></p></div>
                        <nav class="dc-toc" id="dcToc" aria-label="On this page"><b>ON THIS PAGE</b></nav>
                        <div class="dc-prose" id="dcProse">
                            <?php the_content(); ?>
                        </div>
                        <div class="dc-cta-card">
                            <h2>Get your fixed price in 60 seconds</h2>
                            <p>Free, no obligation. Fixed prices, parts and labour included.</p>
                            <a class="dc-btn" href="<?php echo esc_url(home_url('/quote/')); ?>">Get a free quote</a>
                        </div>
                        <h2 class="dc-h2" style="font-size:30px;margin-bottom:20px;">Common questions</h2>
                        <div class="dc-faq__grid" style="grid-template-columns:1fr;">
                            <?php
                            $dc_faqs = [
                                ['How much does a new boiler cost?', 'A like-for-like combi swap starts from around &pound;1,680 fully fitted. Your fixed quote depends on the boiler model, controls and any pipework changes, agreed in writing before we start.'],
                                ['How long does installation take?', 'Most straightforward combi swaps are done in a day. Conversions or system moves can take two to three days. We&rsquo;ll confirm the plan at the survey.'],
                                ['Are your engineers Gas Safe registered?', 'Yes. Every MeraBoiler engineer is Gas Safe registered. Feel free to ask to see ID on arrival.'],
                            ];
                            foreach ($dc_faqs as $dc_f) :
                            ?>
                            <details class="dc-card dc-faq__item">
                                <summary><span><?php echo esc_html($dc_f[0]); ?></span><span class="dc-faq__plus" aria-hidden="true">+</span></summary>
                                <div class="dc-faq__answer"><?php echo wp_kses_post($dc_f[1]); ?></div>
                            </details>
                            <?php endforeach; ?>
                        </div>
                        <div class="dc-author">
                            <div class="dc-author__avatar" aria-hidden="true"><?php echo esc_html($dc_initials ?: 'MB'); ?></div>
                            <div><b><?php echo esc_html($dc_author_name); ?></b><span>MeraBoiler</span><span><?php echo esc_html($dc_bio); ?></span></div>
                        </div>
                    </article>
                    <aside class="dc-side" aria-label="Sidebar">
                        <?php get_template_part('template-parts/dc/quote-side', null, ['title' => 'Get your fixed price quote']); ?>
                        <div class="dc-card dc-side__block" role="search">
                            <b class="dc-side__heading">Search articles</b>
                            <form class="dc-blog-search" style="max-width:none;" method="get" action="<?php echo esc_url($dc_blog_url); ?>">
                                <input class="dc-in" type="search" name="s" placeholder="Search articles" aria-label="Search articles">
                            </form>
                        </div>
                        <?php
                        $dc_feat_id = 0;
                        $dc_sticky = get_option('sticky_posts', []);
                        if (!empty($dc_sticky)) {
                            $dc_feat = get_posts(['post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 1, 'include' => array_map('intval', (array) $dc_sticky)]);
                            if ($dc_feat) {
                                $dc_feat_id = (int) $dc_feat[0]->ID;
                            }
                        }
                        if (!$dc_feat_id) {
                            $dc_latest = get_posts(['post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 2, 'exclude' => [get_the_ID()], 'orderby' => 'date', 'order' => 'DESC']);
                            if ($dc_latest) {
                                $dc_feat_id = (int) $dc_latest[0]->ID;
                            }
                        }
                        if ($dc_feat_id && $dc_feat_id !== (int) get_the_ID()) :
                            $dc_fp = get_post($dc_feat_id);
                        ?>
                        <div class="dc-card dc-side__featured">
                            <b class="dc-side__heading">Featured post</b>
                            <?php if (has_post_thumbnail($dc_feat_id)) : ?>
                            <a href="<?php echo esc_url(get_permalink($dc_feat_id)); ?>" tabindex="-1" aria-hidden="true"><?php echo get_the_post_thumbnail($dc_feat_id, 'medium', ['loading' => 'lazy', 'alt' => esc_attr(get_the_title($dc_feat_id))]); ?></a>
                            <?php endif; ?>
                            <h3><a href="<?php echo esc_url(get_permalink($dc_feat_id)); ?>"><?php echo esc_html(get_the_title($dc_feat_id)); ?></a></h3>
                            <div class="dc-post-meta"><?php echo esc_html(get_the_date('j F Y', $dc_feat_id)); ?></div>
                            <a class="dc-link-red" href="<?php echo esc_url(get_permalink($dc_feat_id)); ?>">Read article</a>
                        </div>
                        <?php endif; ?>
                        <?php
                        $dc_exclude = array_filter([(int) get_the_ID(), $dc_feat_id]);
                        $dc_recent = get_posts(['post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 4, 'exclude' => $dc_exclude, 'orderby' => 'date', 'order' => 'DESC']);
                        if ($dc_recent) :
                        ?>
                        <div class="dc-card dc-side__block">
                            <b class="dc-side__heading">Recent posts</b>
                            <ul class="dc-side__recent">
                                <?php foreach ($dc_recent as $dc_rp) : ?>
                                <li>
                                    <?php if (has_post_thumbnail($dc_rp->ID)) : ?>
                                    <a class="dc-side__thumb" href="<?php echo esc_url(get_permalink($dc_rp)); ?>" tabindex="-1" aria-hidden="true"><?php echo get_the_post_thumbnail($dc_rp->ID, 'thumbnail', ['loading' => 'lazy', 'alt' => esc_attr(get_the_title($dc_rp))]); ?></a>
                                    <?php endif; ?>
                                    <div>
                                        <a class="dc-side__title" href="<?php echo esc_url(get_permalink($dc_rp)); ?>"><?php echo esc_html(get_the_title($dc_rp)); ?></a>
                                        <div class="dc-post-meta"><?php echo esc_html(get_the_date('j F Y', $dc_rp)); ?></div>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </aside>
                </div>
            </div>
        </section>

        <?php
        $dc_rel = new WP_Query([
            'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3,
            'post__not_in' => [get_the_ID()],
            'cat' => $dc_cat ? $dc_cat->term_id : '',
        ]);
        if ($dc_rel->have_posts()) :
        ?>
        <section style="background:#eef3fa;">
            <div class="dc-container" style="padding-top:56px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">Related articles</h2>
                <div class="dc-cards-3">
                    <?php while ($dc_rel->have_posts()) : $dc_rel->the_post(); ?>
                    <div class="dc-card dc-article">
                        <?php if (has_post_thumbnail()) : ?>
                        <a class="dc-article__img" href="<?php echo esc_url(get_permalink()); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail('medium', ['loading' => 'lazy']); ?></a>
                        <?php endif; ?>
                        <div class="dc-article__body">
                            <div class="dc-article__category">BOILER PRICING</div>
                            <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                            <div class="dc-mut dc-article__meta"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 14, '&hellip;')); ?></div>
                            <a class="dc-link-red" href="<?php echo esc_url(get_permalink()); ?>">Read article</a>
                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <?php get_template_part('template-parts/dc/brands'); ?>
        <?php get_template_part('template-parts/dc/cta'); ?>
        <?php endwhile; endif; ?>
    </main>
</div>

<script>
(function () {
    // Build "On this page" from article H2s.
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
