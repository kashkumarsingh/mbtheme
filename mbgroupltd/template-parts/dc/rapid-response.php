<?php
/**
 * Fault-code filter and video triage. Sticky call bar is in footer.php.
 */
$dc_wa = '447894020000';
$dc_video_text = rawurlencode('Hi Meraboiler, I will send a 10-second video of my boiler (display, flue, and any leak). Please quote before a visit.');
?>
<section class="dc-rapid" aria-label="Send a boiler fault code or video">
    <div class="dc-container dc-rapid__bar">
        <div class="dc-rapid__bar-copy">
            <div class="dc-eyebrow">BOILER FAULT?</div>
            <p id="dc-rapid-title-desk">Send the display code, or a 10-second video, before we leave the yard.</p>
        </div>
        <form class="dc-rapid__barform" id="dc-fault-form-desk" action="https://api.whatsapp.com/send/" method="get" target="_blank">
            <input type="hidden" name="phone" value="<?php echo esc_attr($dc_wa); ?>">
            <input type="hidden" name="type" value="phone_number">
            <input type="hidden" name="text" id="dc-fault-text-desk" value="">
            <label class="dc-rapid__sr" for="dc-fault-brand-desk">Boiler brand</label>
            <select id="dc-fault-brand-desk" required>
                <option value="">Brand</option>
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
            <label class="dc-rapid__sr" for="dc-fault-code-desk">Error code</label>
            <input id="dc-fault-code-desk" type="text" inputmode="text" maxlength="12" placeholder="Code, e.g. F22" required autocomplete="off">
            <button class="dc-btn" type="submit">Send code</button>
        </form>
        <a class="dc-btn dc-btn--wa dc-rapid__bar-video" href="<?php echo esc_url('https://api.whatsapp.com/send/?phone=' . $dc_wa . '&text=' . $dc_video_text . '&type=phone_number&app_absent=0'); ?>" target="_blank" rel="noopener">Send a video</a>
    </div>
    <div class="dc-container dc-rapid__stack">
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
    function bind(formId, brandId, codeId, textId) {
        var form = document.getElementById(formId);
        if (!form) return;
        form.addEventListener('submit', function () {
            var brand = document.getElementById(brandId).value;
            var code = document.getElementById(codeId).value.trim();
            document.getElementById(textId).value = 'Hi Meraboiler, boiler fault. Brand: ' + brand + '. Error code: ' + code + '. Please tell me the likely fix and a call-out time.';
        });
    }
    bind('dc-fault-form', 'dc-fault-brand', 'dc-fault-code', 'dc-fault-text');
    bind('dc-fault-form-desk', 'dc-fault-brand-desk', 'dc-fault-code-desk', 'dc-fault-text-desk');
})();
</script>
