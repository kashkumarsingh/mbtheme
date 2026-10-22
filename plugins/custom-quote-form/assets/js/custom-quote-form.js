// Wrap everything in a jQuery closure to ensure $ is available
(function($) {
    'use strict';

    // Ensure jQuery is available
    if (typeof $ === 'undefined' || typeof jQuery === 'undefined') {
        console.error('CQF: jQuery is not loaded!');
        return;
    }

    // Wait for both jQuery and document to be ready
    $(document).ready(function() {
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
                console.error('CQF: Failed to hash value for TikTok identify', err);
                return null;
            }
        }
        // Utility function to get URL parameter by name
        const getUrlParameter = (name) => {
            const url = new URL(window.location.href);
            const paramValue = url.searchParams.get(name);
            return paramValue ? decodeURIComponent(paramValue) : null;
        };

        // Default value for 'utm_source'
        const utmSource = getUrlParameter('utm_source') || 'Direct';
    const $form = $('#getStartedForm');
    const $loader = $('#loader');
    const $submitButton = $("#submitFormButton");
    const $utmField = $("#utmSourceField");

    if ($utmField.length) {
        $utmField.val(utmSource);
    }

    // Event listener for form submission
    $form.on('submit', handleFormSubmit);

    // Handle form submission
    async function handleFormSubmit(e) {
        e.preventDefault();

        const formData = $form.serialize();  // Serialize form fields
        const serviceType = $('select[name="service_type"]').val();  // Get selected service type
        const quoteAction = $form.data('action') || 'quote_submit_form';  // Dynamic action from form's data attribute
        const quoteNonce = $('#quote_nonce').val();  // Dynamic nonce value

        try {
            await submitQuoteForm(formData, serviceType, quoteAction, quoteNonce);
        } catch (error) {
            console.error('Form submission failed:', error);
            alert('Form submission failed. Please try again.');
        }
    }

    // AJAX request to submit the quote form
    const submitQuoteForm = async (formData, serviceType, quoteAction, quoteNonce) => {
        try {
            toggleLoader(true);

            const response = await $.ajax({
                type: 'POST',
                url: cqf_ajax_object.ajax_url,
                data: {
                    action: quoteAction,          // Dynamic action from form
                    quote_nonce: quoteNonce,      // Dynamic nonce value
                    formData,
                },
            });

            toggleLoader(false);

            if (response.success) {
                const transferToken = response.data.transfer_token || '';
                const eventId = response.data.event_id || '';
                console.log('CQF: Form submitted successfully. Token:', transferToken);
                if (!transferToken) {
                    console.warn('CQF: Warning - transfer_token is empty in response!');
                    console.log('CQF: Full response:', response);
                }
                handleFormSuccess(serviceType, transferToken, eventId);
            } else {
                console.error('CQF: Form submission failed:', response.data);
                alert(response.data.message);
            }
        } catch (error) {
            toggleLoader(false);
            throw new Error('AJAX request failed');
        }
    };

    // Handle successful form submission
   const handleFormSuccess = async (serviceType, transferToken, eventIdFromServer) => {
        try {
            // Collect PII from form fields
            const emailRaw = $form.find('input[name="cust_email"]').val() || '';
            const phoneRaw = $form.find('input[name="cust_mobile"]').val() || '';

            if (typeof ttq !== 'undefined' && (emailRaw || phoneRaw)) {
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
                const contentName = serviceType || 'Homepage Quote Form';
                const eventId = eventIdFromServer || `${Date.now()}`;

                // Omit value/currency for Lead with no purchase (TikTok rejects 0 as invalid)
                ttq.track('Lead', {
                    contents: [
                        {
                            content_id: 'custom_quote_form',
                            content_type: 'lead',
                            content_name: contentName,
                        },
                    ],
                }, {
                    event_id: eventId,
                });
            }
        } catch (err) {
            console.error('CQF: Error firing TikTok Lead event', err);
        }

        const redirectUrl = buildRedirectUrl(serviceType, transferToken);
        window.location.href = redirectUrl;
        $form[0].reset(); // Reset form after redirect
    };

    // Build redirect URL with secure token (no personal data in URL) → quote wizard
    const buildRedirectUrl = (serviceType, transferToken) => {
        const baseUrl = cqf_ajax_object.redirect_url || window.location.origin + '/quote';
        const params = new URLSearchParams({
            service_type: serviceType,
            token: transferToken, // Secure token instead of personal data
        });

        return `${baseUrl}?${params.toString()}`;
    };

    // Toggle loader visibility and disable/enable submit button
    const toggleLoader = (isLoading) => {
        $loader.toggleClass('d-none', !isLoading);
        $submitButton.prop("disabled", isLoading);
    };
    });

})(jQuery);






