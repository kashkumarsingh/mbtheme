<?php
/**
 * Fault-code filter and video triage. Sticky call bar is in footer.php.
 */
$dc_wa = '447894020000';
$dc_video_text = rawurlencode('Hi Meraboiler, I will send a 10-second video of my boiler (display, flue, and any leak). Please quote before a visit.');
?>
<section class="dc-rapid" aria-labelledby="dc-rapid-title">
    <div class="dc-container">
        <div class="dc-eyebrow">NO HOT WATER?</div>
        <h2 id="dc-rapid-title">Tell us the fault before we leave the yard</h2>
        <p class="dc-rapid__lead">Pick the brand and type the code on the boiler display. We open WhatsApp with that detail already written, so the engineer knows the likely part before the van starts.</p>
        <div class="dc-rapid__grid">
            <form class="dc-card dc-rapid__card" id="dc-fault-form" action="https://api.whatsapp.com/send/" method="get" target="_blank">
                <input type="hidden" name="phone" value="<?php echo esc_attr($dc_wa); ?>">
                <input type="hidden" name="type" value="phone_number">
                <input type="hidden" name="text" id="dc-fault-text" value="">
                <h3>Fault-code filter</h3>
                <label for="dc-fault-brand">Boiler brand</label>
                <select id="dc-fault-brand" name="brand" required>
                    <option value="">Select brand</option>
                    <option>Worcester Bosch</option>
                    <option>Vaillant</option>
                    <option>Ideal</option>
                    <option>Baxi</option>
                    <option>Bosch</option>
                    <option>Viessmann</option>
                    <option>Glow-worm</option>
                    <option>Alpha</option>
                    <option>Other</option>
                </select>
                <label for="dc-fault-code">Error code on the display</label>
                <input id="dc-fault-code" name="code" type="text" inputmode="text" maxlength="12" placeholder="For example F22 or EA" required autocomplete="off">
                <button class="dc-btn" type="submit">Send the code on WhatsApp</button>
                <p class="dc-rapid__fine">Same WhatsApp number the office already uses. No call-out is booked until you agree a price.</p>
            </form>
            <div class="dc-card dc-rapid__card">
                <h3>10-second video</h3>
                <p>If you would rather not pay a visit just for a look, film the boiler for about 10 seconds: the display, the flue, and any leak. Send it on WhatsApp and we quote from that.</p>
                <a class="dc-btn dc-btn--wa" href="<?php echo esc_url('https://api.whatsapp.com/send/?phone=' . $dc_wa . '&text=' . $dc_video_text . '&type=phone_number&app_absent=0'); ?>" target="_blank" rel="noopener">Send a boiler video</a>
                <p class="dc-rapid__fine">WhatsApp opens with the message ready. Attach the video in the chat before you send.</p>
            </div>
        </div>
    </div>
</section>
<script>
(function () {
    var form = document.getElementById('dc-fault-form');
    if (!form) return;
    form.addEventListener('submit', function () {
        var brand = document.getElementById('dc-fault-brand').value;
        var code = document.getElementById('dc-fault-code').value.trim();
        document.getElementById('dc-fault-text').value = 'Hi Meraboiler, boiler fault. Brand: ' + brand + '. Error code: ' + code + '. Please tell me the likely fix and a call-out time.';
    });
})();
</script>
