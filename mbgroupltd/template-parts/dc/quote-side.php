<?php
// Compact sticky quote card for sidebars. Args: title (default below).
$dc_side_title = isset($args['title']) && $args['title'] !== '' ? $args['title'] : 'Get your fixed price quote';
$dc_quote_shortcode = '[cqf_quote_form]';
?>
<div class="dc-card dc-quote">
    <div class="dc-eyebrow">FREE QUOTE &bull; 60 SECONDS</div>
    <h2><?php echo esc_html($dc_side_title); ?></h2>
    <?php echo do_shortcode($dc_quote_shortcode); ?>
    <div class="dc-quote__fine">Takes about 2 minutes. Continue to your full quote. Free, with no obligation.</div>
</div>
