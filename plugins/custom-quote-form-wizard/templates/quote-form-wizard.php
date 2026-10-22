<?php 
$service_type = isset($_GET['service_type']) ? sanitize_text_field($_GET['service_type']) : '';
$transfer_token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';

// Get plugin directory URL for images
$plugin_url = plugin_dir_url(__DIR__);

// Retrieve form data from transient using secure token
$prefill_data = [];
if (!empty($transfer_token)) {
    $transient_key = 'cqf_transfer_' . $transfer_token;
    $stored_data = get_transient($transient_key);
    if ($stored_data !== false) {
        $prefill_data = $stored_data;
        // Delete transient after retrieval (one-time use)
        delete_transient($transient_key);
    }
}

$prefill_full_name = $prefill_data['cust_fullname'] ?? '';
$prefill_email = $prefill_data['cust_email'] ?? '';
$prefill_mobile = $prefill_data['cust_mobile'] ?? '';
$prefill_address = $prefill_data['cust_address'] ?? '';
$prefill_postcode = $prefill_data['cust_pin'] ?? '';
?>
<section id="getquote" class="dtr-section quote-form gb-smartwizards-quotes">

    <div class="container block container-v5 mx-auto text-center">

            <form method="POST" id="quote-form" data-parsley-validate>
            <?php wp_nonce_field('quote_submit_form_wizard_nonce', 'quote_wizard_nonce'); ?>
            <input type="hidden" name="action" value="quote_submit_form_wizard">
            <input type="hidden" name="service_type" value="<?php echo esc_attr($service_type); ?>">

                    
            <div id="smartwizard">
                <ul class="nav" id="step-navigation"><!--step navigation--></ul>

                <div class="tab-content">

                    <!-- Dynamically generate content for each step -->

                    <!-- Adjust the range in the loop to match the number of steps you have -->



                    <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">

                        <h4>1. What kind of fuel does your boiler use ? <span class="required"
                                style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm-12 col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item">

                                    <input id="q1Option1" type="radio" name="q1" value="Main Gas"
                                        class="form-control form-check-input" data-parsley-trigger="change" required>

                                    <label for="q1Option1"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/GAS.svg'; ?>"
                                            class="img-responsive"><span>Main Gas</span></label>

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item">

                                    <input id="q1Option2" type="radio" name="q1" value="LPG"
                                        class="form-control form-check-input" data-parsley-trigger="change" required>

                                    <label for="q1Option2">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/LPG.svg'; ?>"
                                            class="img-responsive"><span>LPG</span>

                                    </label>

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item">

                                    <input id="q1Option3" type="radio" name="q1" value="Electric"
                                        class="form-control form-check-input" data-parsley-trigger="change" required>

                                    <label for="q1Option3" required>

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/Electric.svg'; ?>"
                                            class="img-responsive"><span>Electric</span>

                                    </label>

                                </div>

                            </div>



                        </div>

                    </div>

                    <!-- step1 -->

                    <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">

                        <h4>2. Select Your Existing Boiler <span class="required" style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm-12 col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item">

                                    <input id="q2Option1" type="radio" name="q2" value="Combi" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q2Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/combi_boiler.svg'; ?>"
                                            class="img-responsive"><span>Combi</span>

                                    </label>

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item">

                                    <input id="q2Option2" type="radio" name="q2" value="Boiler & Tank"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q2Option2"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/boiler_and_tank.svg'; ?>"
                                            class="img-responsive"><span>Boiler & Tank</span></label>

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item">

                                    <input id="q2Option3" type="radio" name="q2" value="Back Boiler"
                                        class="form-control">

                                    <label for="q2Option3" data-parsley-trigger="change" required>

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/back_boiler.svg'; ?>"
                                            class="img-responsive"><span>Back

                                            Boiler</span>

                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step2 -->

                    <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">

                        <h4>3. What Type of Boiler Do You Want to Install? <span class="required"
                                style="color:red">*</span></h4>

                        <div class="row">

                            <div class="mb-3 col-sm-12 col-md-3 col-lg-3 mg-tp-15">

                                <div class="data-item">

                                    <input id="q3Option1" type="radio" name="q3" value="Combi"
                                        data-parsley-trigger="change" class="form-control" required>

                                    <label for="q3Option1"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/combi_boiler.svg'; ?>"
                                            class="img-responsive"><span>Combi</span></label>

                                </div>

                            </div>

                            <div class="mb-3 col-sm-12 col-md-3 col-lg-3">

                                <div class="data-item">

                                    <input id="q3Option2" type="radio" name="q3" data-parsley-trigger="change"
                                        value="Boiler & Tank" class="form-control" required>

                                    <label for="q3Option2"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/boiler_and_tank.svg'; ?>"
                                            class="img-responsive"><span>Boiler & Tank</span></label>

                                </div>

                            </div>

                            <div class="mb-3 col-sm-12 col-md-3 col-lg-3">

                                <div class="data-item">

                                    <input id="q3Option3" type="radio" name="q3" value="Cylinder Only"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q3Option3"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/cylinder.svg'; ?>"
                                            class="img-responsive"><span>Cylinder Only</span></label>

                                </div>

                            </div>

                            <div class="mb-3 col-sm-12 col-md-3 col-lg-3">

                                <div class="data-item">

                                    <input id="q3Option4" type="radio" name="q3" value="Boiler & unvented tank"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q3Option4"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/boiler_unvented_tank.svg'; ?>"
                                            class="img-responsive"><span>Boiler & unvented

                                            tank</span></label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step3 -->

                    <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">

                        <h4>4. What type of property do you have? <span class="required" style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q4Option1" type="radio" name="q4" value="Detached" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q4Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/detached.svg'; ?>"
                                            class="img-responsive">

                                        <span>Detached</span>

                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q4Option2" type="radio" name="q4" value="Semi-Detached"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q4Option2">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/semi_detached.svg'; ?>"
                                            class="img-responsive">

                                        <span>Semi-Detached</span>

                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q4Option3" type="radio" name="q4" value="Terrace" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q4Option3">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/terraced.svg'; ?>"
                                            class="img-responsive">

                                        <span>Terrace</span>

                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q4Option4" type="radio" name="q4" value="Flat" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q4Option4">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/flats.svg'; ?>"
                                            class="img-responsive">

                                        <span>Flat</span>

                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="answer_1" type="radio" name="q4" value="Bungalow" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="answer_1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/Bungalow.svg'; ?>"
                                            class="img-responsive">



                                        <span>Bungalow</span>



                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step4 -->

                    <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">

                        <h4>5. How many bedrooms does your property have? <span class="required"
                                style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q5Option1" name="q5" value="1" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q5Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/one_bedroom.svg'; ?>"
                                            class="img-responsive">



                                        <span>1 Bedroom</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q5Option2" name="q5" value="2" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q5Option2">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/two_bedroom.svg'; ?>"
                                            class="img-responsive">



                                        <span>2 Bedroom</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q5Option3" name="q5" value="3" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q5Option3">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/three_bedroom.svg'; ?>"
                                            class="img-responsive">



                                        <span>3 Bedroom</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q5Option4" name="q5" value="3+" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q5Option4">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/three_plus_bedroom.svg'; ?>"
                                            class="img-responsive">



                                        <span>3 + Bedroom</span>



                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step5 -->

                    <div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-6">

                        <h4>6.How many bath tubs do you have? <span class="required" style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q6Option1" name="q6" value="0" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q6Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/zero_bath.svg'; ?>"
                                            class="img-responsive">



                                        <span>0 Bath</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q6Option2" name="q6" value="1" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q6Option2">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/one_bath.svg'; ?>"
                                            class="img-responsive">



                                        <span>1 Bath</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q6Option3" name="q6" value="2" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q6Option3">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/two_bath.svg'; ?>"
                                            class="img-responsive" required>



                                        <span>2 Bath</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q6Option4" name="q6" value="3+" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q6Option4">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/three_plus_bath.svg'; ?>"
                                            class="img-responsive">



                                        <span>3 + Bath</span>



                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step6 -->

                    <div id="step-7" class="tab-pane" role="tabpanel" aria-labelledby="step-7">

                        <h4>7. How many Showers do you have? <span class="required" style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q7Option1" name="q7" value="0" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q7Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/zero_shower.svg'; ?>"
                                            class="img-responsive">



                                        <span>0 Shower</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q7Option2" name="q7" value="1" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q7Option2">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/one_shower.svg'; ?>"
                                            class="img-responsive">



                                        <span>1 Shower</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q7Option3" name="q7" value="2" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q7Option3">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/two_shower.svg'; ?>"
                                            class="img-responsive">



                                        <span>2 Shower</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q7Option4" name="q7" value="3+" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q7Option4">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/three_plus_shower.svg'; ?>"
                                            class="img-responsive">



                                        <span>3 + Shower</span>



                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step7 -->

                    <div id="step-8" class="tab-pane" role="tabpanel" aria-labelledby="step-8">

                        <h4>8. How many People live in your property? <span class="required" style="color:red">*</span>

                        </h4>

                        <div class="row">



                            <div class="col-sm col-md-4 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q8Option2" type="radio" name="q8" value="2" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q8Option2">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/two_people.svg'; ?>"
                                            class="img-responsive">



                                        <span>2 People</span>



                                    </label>

                                </div>

                            </div>



                            <div class="col-sm col-md-4 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q8Option4" name="q8" value="4" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q8Option4">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/four_people.svg'; ?>"
                                            class="img-responsive">



                                        <span>4 People</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-4 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q8Option5" name="q8" value="6+" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q8Option5">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/five_people.svg'; ?>"
                                            class="img-responsive">



                                        <span>6 People +</span>



                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step8 -->

                    <div id="step-9" class="tab-pane" role="tabpanel" aria-labelledby="step-9">

                        <h4>9. Where is your current boiler located? <span class="required" style="color:red">*</span>

                        </h4>

                        <div class="row">

                            <div class="col-sm col-md-4 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="answer_1" type="radio" name="q9" value="Utility Room"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="answer_1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/utility_room.svg'; ?>"
                                            class="img-responsive">



                                        <span>Utility Room</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-4 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q9Option1" type="radio" name="q9" value="Kitchen" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q9Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/kitchen.svg'; ?>"
                                            class="img-responsive">



                                        <span>Kitchen</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-4 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q9Option2" type="radio" name="q9" value="Garage" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q9Option2">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/garage.svg'; ?>"
                                            class="img-responsive">



                                        <span>Garage</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-4 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q9Option3" name="q9" value="Airing Cupboard"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q9Option3">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/airing_cupboard.svg'; ?>"
                                            class="img-responsive">



                                        <span>Airing Cupboard</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-4 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q9Option4" name="q9" value="Living Room"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q9Option4">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/living_room.svg'; ?>"
                                            class="img-responsive">



                                        <span>Living Room</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-4 col-lg-3 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q9Option4" name="q9" value="Other" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q9Option4">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/other_room.svg'; ?>"
                                            class="img-responsive">



                                        <span>Other</span>



                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step9 -->

                    <div id="step-10" class="tab-pane" role="tabpanel" aria-labelledby="step-10">

                        <h4>10. Do you want your new boiler in a different place? <span class="required"
                                style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm col-md-6 col-lg-6 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q10Option1" name="q10" value="Same" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q10Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/same_place.svg'; ?>"
                                            class="img-responsive">

                                        <span>Same</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-6 mg-tp-15">

                                <div class="data-item select-item">

                                    <input type="radio" id="q10Option2" name="q10" value="Not Same" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q10Option2">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/different_place.svg'; ?>"
                                            class="img-responsive">

                                        <span>Not Same</span>



                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step10 -->

                    <div id="step-11" class="tab-pane" role="tabpanel" aria-labelledby="step-11">

                        <h4>11. Where does your flue come out? <span class="required" style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q11Option1" type="radio" name="q11" value="Slopped" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q11Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/pitched_roof.svg'; ?>"
                                            class="img-responsive">



                                        <span>Slopped Roof</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q11Option2" type="radio" name="q11" value="Flat Roof"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q11Option2">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/flat_roof.svg'; ?>"
                                            class="img-responsive">



                                        <span>Flat Roof</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q11Option3" type="radio" name="q11" value="Wall" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q11Option3">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/external_wall.svg'; ?>"
                                            class="img-responsive">



                                        <span>Wall</span>



                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step11 -->

                    <div id="step-12" class="tab-pane" role="tabpanel" aria-labelledby="step-12">

                        <h4>12. How close to the ground is your flue ? <span class="required" style="color:red">*</span>
                            <a tabindex="0" style="cursor:pointer; text-decoration:underline; font-size:1.2rem;"
                                data-toggle="popover" data-trigger="focus" title="Flue distance from the ground"
                                data-content="If your flue is less than two meters from the ground, we'll include a free safety guard in your flue pack. This will help to prevent children and pets from getting too close to the hot flue, which could cause serious burns."><i
                                    class="icon-info1 color-red"></i> How to find out</a>

                        </h4>

                        <div class="row">

                            <div class="col-sm col-md-6 col-lg-6 mg-tp-15">

                                <div class="data-item">

                                    <input id="q12Option1" type="radio" name="q12" value="Less than 2 Metre"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q12Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/less_than_two_meter.svg'; ?>"
                                            class="img-responsive">

                                        <span>Less Than 2 Metre</span>

                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-6 mg-tp-15">

                                <div class="data-item">

                                    <input id="q12Option2" type="radio" name="q12" value="More than 2 metre"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q12Option2"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/more_than_two_meter.svg'; ?>"
                                            class="img-responsive">

                                        <span>More than 2 metre</span></label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step12 -->

                    <div id="step-13" class="tab-pane" role="tabpanel" aria-labelledby="step-13">

                        <h4>13. How close to another property is your flue? <span class="required"
                                style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm col-md-6 col-lg-6 mg-tp-15">

                                <div class="data-item">

                                    <input id="q13Option1" type="radio" name="q13" value="Less Than 2 Metre"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q13Option1"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/less_than_two_meters.svg'; ?>"
                                            class="img-responsive">

                                        <span>Less Than 2 Metre</span></label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-6 mg-tp-15">

                                <div class="data-item">

                                    <input id="q13Option2" type="radio" name="q13" value="More than 2 metre"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q13Option2"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/more_than_two_meter.svg'; ?>"
                                            class="img-responsive">

                                        <span>More than 2 metre</span></label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step13 -->

                    <div id="step-14" class="tab-pane" role="tabpanel" aria-labelledby="step-14">

                        <h4>14. Is the flue under a carport, balcony or other structure ? <span class="required"
                                style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm col-md-6 col-lg-6 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q14Option1" type="radio" name="q14" value="Yes" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q14Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/carport_yes.svg'; ?>"
                                            class="img-responsive">



                                        <span>Yes</span>



                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-6 mg-tp-15">

                                <div class="data-item select-item">

                                    <input id="q14Option2" type="radio" name="q14" value="No" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q14Option2">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/carport_no.svg'; ?>"
                                            class="img-responsive">



                                        <span>No</span>



                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step14 -->

                    <div id="step-15" class="tab-pane" role="tabpanel" aria-labelledby="step-15">

                        <h4>15.Is your flue more than 30Cm(300mm or 1 Feet) from a door or window ? <span
                                class="required" style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm col-md-6 col-lg-6 mg-tp-15">

                                <div class="data-item">

                                    <input id="q15Option1" type="radio" name="q15" value="Less than 30cm"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q15Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/less_than_30_cm.svg'; ?>"
                                            class="img-responsive">



                                        <span>Yes</span>

                                    </label>

                                </div>

                            </div>

                            <div class="col-sm col-md-6 col-lg-6 mg-tp-15">

                                <div class="data-item">

                                    <input id="q15Option2" type="radio" name="q15" value="More than 30cm"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q15Option2"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/more_than_30_cm.svg'; ?>"
                                            class="img-responsive">



                                        <span>No</span></label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step15 -->

                    <div id="step-16" class="tab-pane" role="tabpanel" aria-labelledby="step-16">

                        <h4>16. Gas Meter Distance Form Boiler? <span class="required" style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item">

                                    <input id="q16Option1" type="radio" name="q16" value="5 meter" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q16Option1">

                                        <img src="<?php echo $plugin_url . 'assets/images/svg/gasmeter_5_meter.svg'; ?>"
                                            class="img-responsive">

                                        <span>5 meter</span></label>

                                </div>

                            </div>

                            <div class="col-sm col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item">

                                    <input id="q16Option2" type="radio" name="q16" value="5 meter Plus"
                                        class="form-control" data-parsley-trigger="change" required>

                                    <label for="q16Option2"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/gasmeter_5_plus_meter.svg'; ?>"
                                            class="img-responsive">

                                        <span>5 meter Plus</span></label>

                                </div>

                            </div>

                            <div class="col-sm col-md-4 col-lg-4 mg-tp-15">

                                <div class="data-item">

                                    <input id="q16Option3" type="radio" name="q16" value="Not Sure" class="form-control"
                                        data-parsley-trigger="change" required>

                                    <label for="q16Option3"><img
                                            src="<?php echo $plugin_url . 'assets/images/svg/gasmeter_not_sure.svg'; ?>"
                                            class="img-responsive">

                                        <span>Not Sure</span></label>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- step16 -->

                    <div id="step-17" class="tab-pane" role="tabpanel" aria-labelledby="step-17">

                        <h4>17. How many radiators do you have including towel rails in the bathroom and

                            toilet ? <span class="required" style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-12 mg-tp-15">

                                <select class="form-control" data-parsley-trigger="change" name="q17" required="">

                                    <option value="">Please Select </option>

                                    <option value="1">1</option>

                                    <option value="2">2</option>

                                    <option value="3">3</option>

                                    <option value="4">4</option>

                                    <option value="5">5</option>

                                    <option value="6">6</option>

                                    <option value="7">7</option>

                                    <option value="8">8</option>

                                    <option value="9">9</option>

                                    <option value="10">10</option>

                                    <option value="11">11</option>

                                    <option value="12">12</option>

                                    <option value="13">13</option>

                                    <option value="14">14</option>

                                    <option value="15">15</option>

                                    <option value="16">16</option>

                                    <option value="17">17</option>

                                    <option value="18">18</option>

                                    <option value="19">19</option>

                                    <option value="20">20</option>

                                    <option value="21">21</option>

                                    <option value="22">22</option>

                                    <option value="23">23</option>

                                    <option value="24">24</option>

                                    <option value="25">25</option>

                                    <option value="26">26</option>

                                    <option value="27">27</option>

                                    <option value="28">28</option>

                                    <option value="29">29</option>

                                    <option value="30">30</option>

                                </select>

                            </div>

                        </div>

                    </div>

                    <!-- step17 -->

                    <div id="step-18" class="tab-pane" role="tabpanel" aria-labelledby="step-18">

                        <h4>18. Personal Details <span class="required" style="color:red">*</span></h4>

                        <div class="row">

                            <div class="col-sm-12 col-md-6 col-lg-6 mg-tp-15">

                                <div class="form-group">

                                    <select class="form-control" name="owner_type" data-parsley-trigger="change"
                                        required="">

                                        <option value="">Are you a..* </option>

                                        <option value="Homeowner">Homeowner</option>

                                        <option value="Landlord">Landlord</option>

                                        <option value="Tennant">Tennant</option>

                                    </select>

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 mg-tp-15">

                                <div class="form-group">

                                    <select class="form-control" name="boiler_working" data-parsley-trigger="change"
                                        required="">

                                        <option value="">Is your current boiler functioning correctly?*</option>

                                        <option value="Yes">Yes</option>

                                        <option value="No">No</option>

                                        <option value="Intermittent">Intermittent</option>

                                    </select>

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 mg-tp-15">

                                <div class="form-group">

                                    <select class="form-control" name="boiler_age" data-parsley-trigger="change"
                                        required="">

                                        <option value="">How old is your current boiler?*</option>

                                        <option value="1-3 Years">1-3 Years</option>

                                        <option value="3-5 Years">3-5 Years</option>

                                        <option value="5+ Years">5+ Years</option>

                                    </select>

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 mg-tp-15">

                                <div class="form-group">

                                    <input type="text" class="form-control" name="f_name" value="<?php echo esc_attr($prefill_full_name); ?>"
                                        placeholder="Full Name*"
                                        title="It must contain only letters and a length of minimum 2 characters!"
                                        autocomplete="off" data-parsley-trigger="input" required="" data-parsley-trigger="input" data-parsley-error-message="Please enter a valid name.">

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 mg-tp-15">

                                <div class="form-group">

                                    <input type="email" class="form-control" name="email_" placeholder="Your e-mail*"
                                        value="<?php echo esc_attr($prefill_email); ?>" autocomplete="off"
                                        title="It must contain a valid email address e.g. 'someone@provider.com' !"
                                        required data-parsley-trigger="change" data-parsley-error-message="Please enter a valid email address.">

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 mg-tp-15">

                                <div class="form-group">

                                    <input type="text" class="form-control" placeholder="Telephone*"
                                        title="It must contain10 digit mobile mnumber!" name="mobile_" maxlength="15"
                                        value="<?php echo esc_attr($prefill_mobile); ?>" autocomplete="off"
                                        data-parsley-pattern="^(?:(?:\+44)|(?:0))(?:(?:(?:1\d{3})|(?:7[1-9]\d{2})|(?:20\d{2})|(?:3(?:0[0-5]|[68]\d)\d)|(?:4[0-4]\d{2})|(?:5[0-5]\d{2})|(?:9(?:6[0-9]|7[0-2])\d))\s?\d{6,8}|((?:(?:1\d{2}|20\d{1}|3(?:0[0-5]|[68]\d{1})|4[0-4]\d{1}|5[0-5]\d{1}|9(?:6[0-9]|7[0-2])\d{1}))\s?\d{3,4}\s?\d{3,4}))$"
                                        data-parsley-error-message="Invalid phone number" data-parsley-trigger="input"
                                        required="">

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 mg-tp-15">
                                <div class="form-group">
                                    <input type="text" id="cust_pin" name="cust_pin" class="form-control" 
                                        placeholder="Postal Code*" 
                                        value="<?php echo esc_attr($prefill_postcode); ?>" 
                                        autocomplete="postal-code" 
                                        data-parsley-trigger="input"
                                        data-parsley-pattern="^[A-Z]{1,2}[0-9]{1,2}[A-Z]?\s?[0-9][A-Z]{2}$"
                                        data-parsley-error-message="Please enter a valid UK postcode (e.g., SW1A 1AA)"
                                        required>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 mg-tp-15">
                                <div class="form-group">
                                    <input type="text" id="cust_street" name="cust_street" class="form-control" 
                                        placeholder="Enter your address*" 
                                        value="<?php echo esc_attr($prefill_address); ?>" 
                                        autocomplete="street-address" 
                                        data-parsley-trigger="input"
                                        required>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-12 mg-tp-15 ">
                                <div class="form-group">
                                    <select class="form-control" name="hearaboutus_" data-parsley-trigger="change"
                                        required="">
                                        <option value="" selected="">How Did you hear about Us?*</option>
                                        <option value="Google">Google</option>
                                        <option value="Facebook/Instagram">Facebook/Instagram</option>
                                        <option value="Tiktok Ad">Tiktok Ad</option>
                                        <option value="Word of mouth">Word of mouth</option>
                                        <option value="Returning Customer">ReturningCustomer</option>
                                        <option value="Green Street Walk-in customer">GreenStreet Walk-in customer</option>
                                        <option value="Potters Bar Walk-in customer">Potters Bar Walk-in customer</option>
                                        <option value="Television Advertisement">Television Advertisement</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- row1 -->
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="buttons-wrapper">
                                    <button type="submit" id="submitBtn" class="btn btn-danger"
                                        name="quote_submit">Submit
                                        <img id="loader"
                                            src="<?php echo cqf_shared_asset_url('images/loader.svg'); ?>"
                                            width="30" height="30" alt="" class="d-none" hidden>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- step17 -->
                </div>

            </div>

        </form>

    </div>

</section>

<!-- quote section ends -->

