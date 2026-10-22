<div class="getstarted_quote_form p-6 bg-v5-light-gray rounded-2xl">
  <div class="form_wrapper">
    <form id="getStartedForm" method="POST" class="contact__form form-row" data-parsley-validate="">
    <?php wp_nonce_field('quote_submit_form_nonce', 'quote_nonce'); ?>
      <input type="hidden" name="action" value="quote_submit_form">
      <input type="hidden" name="utm_source" id="utmSourceField" value="">
      <div class="row">
        <div class="col-sm col-md-6 col-lg-12 mb-3">
        <div class="form-group">
            <select class="form-control" name="service_type" data-parsley-trigger="change" required="">
                <option value="">Select a Type*</option>
                <option value="Fully New Boiler Installation">Fully New Boiler Installation</option>
                <option value="Boiler Replacement or Upgrade">Boiler Replacement or Upgrade</option>
                <option value="Underfloor Heating with a Boiler">Underfloor Heating with a Boiler</option>
                <option value="Central Heating Installation">Central Heating Installation</option>
                <option value="Radiator Power Flushing or Upgrade">Radiator Power Flushing or Upgrade</option>
                <option value="Existing Boiler Parts Upgrade or Repair">Existing Boiler Parts Upgrade or Repair</option>
                 <option value="Boiler Water Leaking Repair or Upgrade">Boiler Water Leaking Repair or Upgrade</option>
                <option value="Emergency Boiler Call Outs or Heating Repairs">Emergency Boiler Call Outs or Heating Repairs</option>
                <option value="Annual Boiler Servicing">Annual Boiler Servicing</option>
                <option value="Boiler Service Plan">Boiler Service Plan</option>
                <option value="Gas Safe Certificate">Gas Safe Certificate</option>
                <option value="Other">Other</option>
                
            </select>
        </div>
    </div>
        <div class="col-sm col-md-6 col-lg-6 mb-3">

          <div class="form-group">

            <input type="text" id="custFullName" name="cust_fullname" class="form-control" placeholder="Full Name*"

              required="">

          </div>

        </div>
        <div class="col-sm col-md-6 col-lg-6 mb-3">

          <div class="form-group">

            <input type="email" name="cust_email" id="custEmail" class="form-control" placeholder="Email Address*"

              data-parsley-trigger="change" required="">

          </div>

        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 mb-3">

          <div class="form-group">

            <input type="tel" id="custMobile" inputmode="numeric" name="cust_mobile"

              class="form-control intl-phone-form-control" placeholder="07400123456*" minlength="10" maxlength="15"

              autocomplete="off" data-intl-tel-input-id="0" data-parsley-trigger="input"

              data-parsley-pattern="^(?:(?:\+44)|(?:0))(?:(?:(?:1\d{3})|(?:7[1-9]\d{2})|(?:20\d{2})|(?:3(?:0[0-5]|[68]\d)\d)|(?:4[0-4]\d{2})|(?:5[0-5]\d{2})|(?:9(?:6[0-9]|7[0-2])\d))\s?\d{6,8}|((?:(?:1\d{2}|20\d{1}|3(?:0[0-5]|[68]\d{1})|4[0-4]\d{1}|5[0-5]\d{1}|9(?:6[0-9]|7[0-2])\d{1}))\s?\d{3,4}\s?\d{3,4}))$"

              data-parsley-error-message="Invalid phone number" required>

          </div>

        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 mb-3">

          <div class="form-group">

            <input type="text" id="postcode" class="form-control" name="cust_pin" placeholder="Postal Code*"

              data-parsley-trigger="input"

              data-parsley-pattern="([Gg][Ii][Rr]0[Aa]{2})|((([A-Za-z][0-9]{1,2}\s?)|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2}\s?)|(([A-Za-z][0-9][A-Za-z]\s?)|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?\s?))))[0-9]\s?[A-Za-z]{2})"

              data-parsley-error-message="Invalid postcode" required="">

          </div>

        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
          <div class="form-group">
            <input type="text" id="custAddress" name="cust_address" class="form-control" placeholder="Enter your address*" autocomplete="street-address" required>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="cta-wrapper">
            <button type="submit" id="submitFormButton" class="btn btn-danger btn-lg rounded-pill mt-3 d-flex">
              <span id="buttonText" class="text-white">Quick Contact</span>
              <img id="loader" src="<?php echo cqf_shared_asset_url('images/loader.svg'); ?>" width="30px"
                height="30px" alt="Loader" class="d-none">
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>