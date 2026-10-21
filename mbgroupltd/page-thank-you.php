<?php
/**
 * Template Name: Thank You
 * Description: Quote form success page with Google Ads enhanced conversion fields.
 */

if (!defined('ABSPATH')) {
    exit;
}

$token = isset($_GET['token']) ? sanitize_text_field(wp_unslash($_GET['token'])) : '';
$source = isset($_GET['source']) ? sanitize_text_field(wp_unslash($_GET['source'])) : '';

$ec = null;
if ($token !== '' && class_exists('CQF_Enhanced_Conversions')) {
    $ec = CQF_Enhanced_Conversions::consume($token);
}

// Fallbacks when token is missing/expired (page may still load from bookmarks)
$email = $ec['email'] ?? '';
$phone = $ec['phone_number'] ?? '';
$first_name = $ec['first_name'] ?? '';
$last_name = $ec['last_name'] ?? '';
$full_name = $ec['full_name'] ?? '';
$street = $ec['street'] ?? '';
$postal_code = $ec['postal_code'] ?? '';
$country = $ec['country'] ?? 'GB';
$form_type = $ec['form_type'] ?? $source;

$display_name = $first_name !== '' ? $first_name : ($full_name !== '' ? $full_name : '');
$has_ec_data = ($email !== '' || $phone !== '');

// User-data object for gtag / dataLayer (unhashed; Google hashes when EC is enabled)
$user_data = array_filter([
    'email' => $email !== '' ? strtolower(trim($email)) : null,
    'phone_number' => $phone !== '' ? preg_replace('/\s+/', '', $phone) : null,
    'address' => array_filter([
        'first_name' => $first_name !== '' ? $first_name : null,
        'last_name' => $last_name !== '' ? $last_name : null,
        'street' => $street !== '' ? $street : null,
        'postal_code' => $postal_code !== '' ? $postal_code : null,
        'country' => $country !== '' ? $country : null,
    ]),
], static function ($v) {
    return $v !== null && $v !== [] && $v !== '';
});

get_header();
?>

<div id="primary" class="content-area dc">
    <main id="main" class="site-main" role="main">
        <section style="background:#eef3fa;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;text-align:center;">
                <div style="max-width:760px;margin:0 auto;">
                    <div class="dc-done-badge" aria-hidden="true">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5L20 6"></path></svg>
                    </div>
                    <h1 style="font-size:52px;line-height:1.08;">
                        <?php
                        if ($display_name !== '') {
                            echo esc_html(sprintf('Thanks %s, we have your request', $display_name));
                        } else {
                            echo esc_html('Thanks, we have your request');
                        }
                        ?>
                    </h1>
                    <p class="dc-lead" style="margin-left:auto;margin-right:auto;">A MeraBoiler adviser will call you<?php echo $phone !== '' ? ' on ' . esc_html($phone) : ''; ?> to confirm your fixed price and book your slot.</p>
                    <div class="dc-card dc-done-card">
                        <div><span>Service</span><b><?php echo esc_html($form_type !== '' ? ucwords(str_replace(['-', '_'], ' ', $form_type)) : 'Boiler quote'); ?></b></div>
                        <div><span>Postcode</span><b><?php echo esc_html($postal_code !== '' ? $postal_code : '-'); ?></b></div>
                        <div><span>Reference</span><b><?php echo esc_html($token !== '' ? $token : '-'); ?></b></div>
                        <div><span>We will call you on</span><b><?php echo esc_html($phone !== '' ? $phone : 'your number'); ?></b></div>
                    </div>
                    <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;margin-top:28px;">
                        <a class="dc-btn" href="tel:02081502025">Call 020 8150 2025</a>
                        <a class="dc-btn dc-btn--wa" href="https://api.whatsapp.com/send/?phone=447894020000&text=Hi+Meraboiler+I+need+Quote+%2F+Assistance&type=phone_number&app_absent=0" target="_blank" rel="noopener">WhatsApp us</a>
                        <a class="dc-btn dc-btn--outline" href="<?php echo esc_url(home_url('/')); ?>">Back to home</a>
                    </div>
                </div>
            </div>
        </section>

        <section style="background:#fff;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:32px;">What happens next</h2>
                <div class="dc-steps">
                    <div class="dc-step"><div class="dc-step__number">1</div><h3>We call you</h3><p>An adviser confirms the details and your fixed price.</p></div>
                    <div class="dc-step"><div class="dc-step__number">2</div><h3>Book your slot</h3><p>Choose a date. Same-day and next-day slots where available.</p></div>
                    <div class="dc-step"><div class="dc-step__number">3</div><h3>We install or repair</h3><p>A Gas Safe engineer completes the job and registers your boiler.</p></div>
                </div>
            </div>
        </section>

        <section style="background:#eef3fa;">
            <div class="dc-container" style="padding-top:72px;padding-bottom:72px;">
                <h2 class="dc-h2" style="margin-bottom:8px;">While you wait</h2>
                <p class="dc-sub muted" style="margin-bottom:32px;">Useful guides from our Gas Safe registered team.</p>
                <div class="dc-cards-3">
                    <?php
                    $dc_wait = get_posts(['post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 3]);
                    foreach ($dc_wait as $post) : setup_postdata($post);
                    ?>
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
                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/dc/brands'); ?>
    </main>
</div>

<?php if ($has_ec_data) : ?>
    <?php
    /*
     * Enhanced conversion fields for Google Ads automatic / CSS-selector based capture.
     * Visible to the Google tag; visually hidden from visitors.
     * Values are only present immediately after a real form submit (token-based).
     */
    ?>
    <form id="google-enhanced-conversions" class="google-enhanced-conversions" autocomplete="off" aria-hidden="true">
        <label for="ec-email">Email</label>
        <input type="email" id="ec-email" name="email" value="<?php echo esc_attr($email); ?>" />

        <label for="ec-phone">Phone</label>
        <input type="tel" id="ec-phone" name="phone_number" value="<?php echo esc_attr($phone); ?>" />

        <label for="ec-first-name">First name</label>
        <input type="text" id="ec-first-name" name="first_name" value="<?php echo esc_attr($first_name); ?>" />

        <label for="ec-last-name">Last name</label>
        <input type="text" id="ec-last-name" name="last_name" value="<?php echo esc_attr($last_name); ?>" />

        <label for="ec-street">Street</label>
        <input type="text" id="ec-street" name="street" value="<?php echo esc_attr($street); ?>" />

        <label for="ec-postal">Postal code</label>
        <input type="text" id="ec-postal" name="postal_code" value="<?php echo esc_attr($postal_code); ?>" />

        <label for="ec-country">Country</label>
        <input type="text" id="ec-country" name="country" value="<?php echo esc_attr($country); ?>" />
    </form>

    <script>
    (function () {
        var userData = <?php echo wp_json_encode($user_data); ?>;
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: 'quote_form_conversion',
            enhanced_conversion_data: userData
        });

        if (typeof gtag === 'function' && userData && Object.keys(userData).length) {
            try {
                gtag('set', 'user_data', userData);
                gtag('event', 'generate_lead', {
                    event_category: 'quote_form',
                    event_label: <?php echo wp_json_encode($form_type ?: 'quote'); ?>
                });
            } catch (e) {
                console.warn('Thank-you: gtag enhanced conversions failed', e);
            }
        }
    })();
    </script>
<?php endif; ?>

<style>
/* Keep EC fields in DOM for Google tag; hide from visitors */
.google-enhanced-conversions {
    position: absolute !important;
    left: -10000px !important;
    top: auto !important;
    width: 1px !important;
    height: 1px !important;
    overflow: hidden !important;
}
</style>

<?php
get_footer();
