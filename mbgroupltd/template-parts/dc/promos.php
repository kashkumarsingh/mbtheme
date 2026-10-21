<?php
// New-design promo offers slider. Add more entries to $dc_promo_slides to extend it.
$dc_quote = esc_url(home_url('/quote/'));
$dc_promo_slides = [
    [
        'theme' => 'dark',
        'flag' => 'WINTER OFFER',
        'flag_class' => 'dc-promo__flag--red',
        'ends' => 'Limited-time offer',
        'title' => 'Bosch Greenstar 25kW, fully fitted',
        'tick' => '#8DB4F0',
        'points' => ['Fitted by Gas Safe engineers', 'Fixed price agreed on the day', 'Up to a 7-year guarantee'],
        'image' => 'boiler-bosch-greenstar.png',
        'price_label' => 'From',
        'price' => '&pound;1,890',
        'price_class' => 'dc-promo__price',
        'cta_text' => 'Request this offer',
        'cta_class' => '',
        'cta_url' => $dc_quote,
    ],
    [
        'theme' => 'light',
        'flag' => 'HOT WATER UPGRADE',
        'flag_class' => 'dc-promo__flag--blue',
        'ends' => '',
        'title' => 'Unvented cylinders',
        'tick' => '#1F5FBF',
        'points' => ['Strong mains-pressure hot water', 'Steady supply for busy homes', 'Survey and fixed quote'],
        'image' => 'cylinder-unvented.png',
        'price_label' => 'Price',
        'price' => 'Fixed after survey',
        'price_class' => 'dc-promo__price--sm',
        'cta_text' => 'Get a free quote',
        'cta_class' => 'dc-btn--outline',
        'cta_url' => $dc_quote,
    ],
];
?>
<section class="dc-promos">
    <div class="dc-container">
    <div class="dc-slider" data-dc-slider data-autoplay="5000">
        <div class="dc-slider__view">
            <div class="dc-slider__track">
                <?php foreach ($dc_promo_slides as $dc_i => $dc_s) : ?>
                <div class="dc-slider__slide">
                    <div class="dc-promo dc-promo--<?php echo esc_attr($dc_s['theme']); ?>">
                        <div class="dc-promo__top">
                            <div class="dc-promo__copy">
                                <div class="dc-promo__flags">
                                    <span class="dc-promo__flag <?php echo esc_attr($dc_s['flag_class']); ?>"><?php echo esc_html($dc_s['flag']); ?></span>
                                    <?php if ($dc_s['ends'] !== '') : ?>
                                    <span class="dc-promo__ends"><?php echo esc_html($dc_s['ends']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <h3><?php echo esc_html($dc_s['title']); ?></h3>
                                <div class="dc-promo__points">
                                    <?php foreach ($dc_s['points'] as $dc_pt) : ?>
                                    <div><svg class="dc-tick" viewBox="0 0 24 24" fill="none" stroke="<?php echo esc_attr($dc_s['tick']); ?>" stroke-width="3" aria-hidden="true"><path d="M4 12l5 5L20 6"></path></svg> <?php echo esc_html($dc_pt); ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="dc-promo__img">
                                <img src="<?php echo esc_url(mbgroupltd_image($dc_s['image'])); ?>" alt="<?php echo esc_attr($dc_s['title']); ?>" width="280" height="280" <?php echo $dc_i === 0 ? 'fetchpriority="high" decoding="async"' : 'loading="lazy" decoding="async"'; ?>>
                            </div>
                        </div>
                        <div class="dc-promo__foot">
                            <div>
                                <div class="dc-promo__price-label"><?php echo esc_html($dc_s['price_label']); ?></div>
                                <div class="<?php echo esc_attr($dc_s['price_class']); ?>"><?php echo wp_kses_post($dc_s['price']); ?></div>
                            </div>
                            <a class="dc-btn <?php echo esc_attr($dc_s['cta_class']); ?>" href="<?php echo esc_url($dc_s['cta_url']); ?>"><?php echo esc_html($dc_s['cta_text']); ?></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<noscript><style>.dc-slider__view{overflow:visible}.dc-slider__track{flex-wrap:wrap}.dc-slider-nav{display:none}</style></noscript>
