<?php
/**
 * Desktop-only fault tools, kept away from the offer slider.
 * Phones use the bottom call bar.
 */
?>
<section class="dc-fault-band" aria-label="Send a boiler fault code or video">
    <div class="dc-container">
        <div class="dc-fault-band__row">
            <div class="dc-fault-band__copy">
                <div class="dc-eyebrow">BOILER FAULT</div>
                <p>Send the display code, or a short video, before we leave the yard.</p>
            </div>
            <form class="dc-fault dc-fault-band__choice" id="dc-fault-form-desk" action="https://api.whatsapp.com/send/" method="get" target="_blank">
                <span class="dc-fault-band__label">Have the code</span>
                <input type="hidden" name="phone" value="447894020000">
                <input type="hidden" name="type" value="phone_number">
                <input type="hidden" name="text" id="dc-fault-text-desk" value="">
                <label class="dc-rapid__sr" for="dc-fault-brand-desk">Boiler brand</label>
                <select id="dc-fault-brand-desk" required>
                    <option value="">Boiler brand</option>
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
                <button class="dc-btn" type="submit">Send the code</button>
            </form>
            <span class="dc-fault-band__or" aria-hidden="true">or</span>
            <div class="dc-fault-band__choice dc-fault-band__choice--video">
                <span class="dc-fault-band__label">No code handy</span>
                <a class="dc-btn dc-btn--wa" href="https://api.whatsapp.com/send/?phone=447894020000&amp;text=Hi+Meraboiler%2C+I+will+send+a+10-second+video+of+my+boiler.+Please+quote+before+a+visit.&amp;type=phone_number&amp;app_absent=0" target="_blank" rel="noopener">Send a video</a>
            </div>
        </div>
    </div>
</section>
<script>
(function () {
    var form = document.getElementById('dc-fault-form-desk');
    if (!form) return;
    form.addEventListener('submit', function () {
        var brand = document.getElementById('dc-fault-brand-desk').value;
        var code = document.getElementById('dc-fault-code-desk').value.trim();
        document.getElementById('dc-fault-text-desk').value = 'Hi Meraboiler, boiler fault. Brand: ' + brand + '. Error code: ' + code + '. Please tell me the likely fix and a call-out time.';
    });
})();
</script>
