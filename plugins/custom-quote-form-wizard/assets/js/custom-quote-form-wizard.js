 jQuery(document).ready(function($) {
    // Helper: SHA-256 hash with Web Crypto, returns hex string
    async function hashSHA256(value) {
        try {
            if (!window.crypto || !window.crypto.subtle || !value) {
                return null;
            }
            const encoder = new TextEncoder();
            const data = encoder.encode(value);
            const hashBuffer = await window.crypto.subtle.digest('SHA-256', data);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        } catch (err) {
            console.error('CQFW: Failed to hash value for TikTok identify', err);
            return null;
        }
    }
    // Initialize a variable to count the steps
    let totalSteps = 0;
    // Loop to find elements with IDs starting with "step-"
    for (let i = 1;; i++) {
        const elementId = `step-${i}`;
        const stepElement = $(`#${elementId}`);
        // Check if the element with the current ID exists
        if (stepElement.length === 0) {
            break; // Exit the loop if no more elements are found
        }
        // Increment the totalSteps count
        totalSteps++;
        // Create a navigation link for the current step
        const navLink = ` <li class="nav-item"><a class="nav-link" href="#${elementId}"><span class="num">${i}</span></a></li>`;
        // Append the navigation link to the ul with id "step-navigation"
        $("#step-navigation").append(navLink);
    }

    // Initialize the SmartWizard plugin
    $("#smartwizard").smartWizard({
        selected: 0, // Initial selected step, 0 = first step
        autoAdjustHeight: false,
        enableAllSteps: true,
        transitionEffect: "none",
        transitionSpeed: 0,
        easing: "easeInOutExpo",
        enableUrlHash: false,
        theme: "dots",
        backButtonSupport: true,
        toolbarSettings: {
            toolbarPosition: "bottom", // Show the toolbar at the bottom
            showNextButton: false,
        },
        onLeaveStep: function(anchorObject, stepIndex, stepDirection) {
            // Disable the "Submit" button by default
            $('.dtr-btn[name="quote_submit"]').prop("disabled", true);

            // Enable the "Submit" button on the last step
            if (stepIndex === totalSteps - 1) {
                $('.dtr-btn[name="quote_submit"]').prop("disabled", false);
            }
            return true;
        },
    });

    function cqfwNextButtons() {
        return $(".sw-btn-next, .sw .toolbar button, .sw .toolbar a").filter(function () {
            return $(this).text().replace(/\s+/g, " ").trim() === "Next";
        });
    }

    function cqfwStepNeedsNext(stepNumber) {
        var step = $("#step-" + (stepNumber + 1));
        if (!step.length) {
            return false;
        }
        var hasChoice = step.find('input[type="radio"], select').length > 0;
        var hasTyped = step.find('input[type="text"], input[type="email"], input[type="tel"], textarea').length > 0;
        return hasTyped && !hasChoice;
    }

    // Choice steps move on by themselves. Next stays available only when the visitor must type.
    $("#smartwizard").on(
        "showStep",
        function(e, anchorObject, stepNumber) {
            if (stepNumber === 0) {
                $(".sw-btn-prev").hide();
            } else {
                $(".sw-btn-prev").show();
            }
            if (cqfwStepNeedsNext(stepNumber)) {
                cqfwNextButtons().show();
            } else {
                cqfwNextButtons().hide();
            }
        }
    );

    var cqfwAdvancing = false;
    $(document).on("change", '#quote-form input[type="radio"], #quote-form select', function () {
        var field = $(this);
        if (cqfwAdvancing) {
            return;
        }
        if (field.is("select") && !field.val()) {
            return;
        }
        if (field.is(":radio") && !field.is(":checked")) {
            return;
        }
        cqfwAdvancing = true;
        $("#smartwizard").smartWizard("next");
        window.setTimeout(function () {
            cqfwAdvancing = false;
        }, 350);
    });


    //quote form ajax
      $("#quote-form").on("submit", function(e) {
            e.preventDefault(); // Prevent default form submission
            e.stopPropagation(); // Stop event bubbling
    
            var formData = $(this).serializeArray();
            formData.push({ name: 'action', value: 'quote_submit_form_wizard' });
            formData.push({ name: 'quote_submit_form_wizard_nonce', value: $('#quote_wizard_nonce').val() });
    
            if ($("#quote-form").parsley().isValid()) { // Check Parsley validation
                const submitButton = $('#submitBtn, button[name="quote_submit"]');
                const loader = $('#loader');
                
                // Prevent multiple submissions
                if (submitButton.prop('disabled')) {
                    return false;
                }
                
                $.ajax({
                    type: "POST",
                    url: cqfw_ajax_object.ajax_url,
                    data: formData,
                    dataType: "json",
                    timeout: 30000, // 30 second timeout - safety net for database save
                    beforeSend: function() {
                        loader.removeClass('d-none');
                        submitButton.prop("disabled", true);
                    },
                    success: async function(response) {
                        console.log('CQFW: AJAX Success Response:', response);
                        
                        // Hide loader immediately
                        loader.addClass('d-none');
                        
                        // Check response format (WordPress wp_send_json_success format)
                        if (response && response.success === true) {
                            console.log('CQFW: Form submitted successfully');

                            // TikTok identify + Lead (PII hashed client-side)
                            try {
                                if (typeof ttq !== 'undefined') {
                                    const $form = $('#quote-form');
                                    const emailRaw = $form.find('input[name="email_"]').val() || '';
                                    const phoneRaw = $form.find('input[name="mobile_"]').val() || '';

                                    const emailNormalized = emailRaw.trim().toLowerCase();
                                    const phoneNormalized = phoneRaw.trim();

                                    const identifyPayload = {};
                                    const hashedEmail = emailNormalized ? await hashSHA256(emailNormalized) : null;
                                    const hashedPhone = phoneNormalized ? await hashSHA256(phoneNormalized) : null;

                                    if (hashedEmail) {
                                        identifyPayload.email = hashedEmail;
                                    }
                                    if (hashedPhone) {
                                        identifyPayload.phone_number = hashedPhone;
                                    }

                                    if (Object.keys(identifyPayload).length) {
                                        ttq.identify(identifyPayload);
                                    }

                                    // Fire Lead event
                                    const serviceType = $form.find('select[name="service_type"]').val() || 'Boiler Quote Wizard';
                                    const contentName = serviceType;
                                    const eventIdFromServer = response.data && response.data.event_id ? response.data.event_id : null;
                                    const eventId = eventIdFromServer || `${Date.now()}`;

                                    // Omit value/currency for Lead with no purchase (TikTok rejects 0 as invalid)
                                    ttq.track('Lead', {
                                        contents: [
                                            {
                                                content_id: 'custom_quote_form_wizard',
                                                content_type: 'lead',
                                                content_name: contentName,
                                            },
                                        ],
                                    }, {
                                        event_id: eventId,
                                    });
                                }
                            } catch (tikTokErr) {
                                console.error('CQFW: Error firing TikTok Lead event', tikTokErr);
                            }
                            
                            // Redirect to thank-you page for Google Ads enhanced conversions
                            // (no PII in URL — server holds snapshot under thank_you_token)
                            const thankYouToken = (response.data && response.data.thank_you_token)
                                ? response.data.thank_you_token
                                : '';
                            let redirectUrl = (cqfw_ajax_object && cqfw_ajax_object.thank_you_url)
                                ? cqfw_ajax_object.thank_you_url
                                : (window.location.origin + '/thank-you/');
                            if (thankYouToken) {
                                const sep = redirectUrl.indexOf('?') === -1 ? '?' : '&';
                                redirectUrl = redirectUrl + sep + 'token=' + encodeURIComponent(thankYouToken) + '&source=quote-form-wizard';
                            } else if (cqfw_ajax_object && cqfw_ajax_object.home_url) {
                                // Fallback if token missing — never break submit UX
                                redirectUrl = cqfw_ajax_object.home_url;
                            }
                            console.log('CQFW: Redirecting to thank-you:', redirectUrl);
                            
                            try {
                                window.location.replace(redirectUrl);
                            } catch (err) {
                                console.warn('CQFW: window.location.replace failed, using href:', err);
                                window.location.href = redirectUrl;
                            }
                        } else {
                            // Show error message if response format is unexpected
                            console.warn('CQFW: Unexpected response format:', response);
                            submitButton.prop("disabled", false);
                            const errorMsg = (response && response.data && response.data.message) 
                                ? response.data.message 
                                : 'An error occurred. Please try again.';
                            alert(errorMsg);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Always hide loader on error
                        loader.addClass('d-none');
                        submitButton.prop("disabled", false);
                        
                        // Handle timeout specifically
                        if (status === 'timeout') {
                            loader.addClass('d-none');
                            submitButton.prop("disabled", false);
                            submitButton.html('Submit'); // Reset button text
                            alert('Request timed out. The form may have been submitted. Please check your email or try again.');
                            console.error("CQFW: AJAX Timeout - Request took longer than 30 seconds");
                            return;
                        }
                        
                        // Try to parse error response
                        let errorMsg = 'An error occurred. Please try again.';
                        try {
                            if (xhr.responseText) {
                                const response = JSON.parse(xhr.responseText);
                                if (response && response.data && response.data.message) {
                                    errorMsg = response.data.message;
                                }
                            }
                        } catch (e) {
                            // If parsing fails, use default message
                            console.warn('CQFW: Could not parse error response:', e);
                        }
                        
                        alert(errorMsg);
                        console.error("CQFW: AJAX Error:", error, "Status:", status, "Response:", xhr.responseText);
                    },
                    complete: function() {
                        // Only ensure loader is hidden (button state handled in success/error)
                        loader.addClass('d-none');
                    }
                });
            }
            
            return false; // Prevent form submission
        });
    
        // Pre-fill form if data exists (now from PHP, not URL params)
        // Data is already pre-filled server-side via PHP template
        // Just need to mark fields as validated
        
        // Helper function to mark field as successfully validated
        function markFieldAsSuccess($field) {
            if ($field.length && $field.val()) {
                $field.addClass('parsley-success');
                $field.removeClass('parsley-error');
                // Trigger Parsley validation to update UI
                if ($field.parsley) {
                    $field.parsley().validate();
                }
            }
        }
        
        // Mark pre-filled fields as validated
        const $fullNameField = $('#quote-form input[name="f_name"]');
        const $emailField = $('#quote-form input[name="email_"]');
        const $mobileField = $('#quote-form input[name="mobile_"]');
        const $addressField = $('#quote-form input[name="cust_street"]');
        
        if ($fullNameField.val()) {
            markFieldAsSuccess($fullNameField);
        }
        if ($emailField.val()) {
            markFieldAsSuccess($emailField);
        }
        if ($mobileField.val()) {
            markFieldAsSuccess($mobileField);
        }
        if ($addressField.val()) {
            markFieldAsSuccess($addressField);
        }

});
