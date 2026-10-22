(function () {
    var root = document.getElementById("smartwizard");
    var form = document.getElementById("quote-form");
    if (!root || !form || !window.cqfw_ajax_object) {
        return;
    }

    var steps = Array.prototype.slice.call(root.querySelectorAll(".tab-pane"));
    var index = 0;
    var busy = false;
    var nav = document.getElementById("step-navigation");
    if (nav) {
        nav.remove();
    }

    var progress = document.createElement("div");
    progress.className = "mb-progress";
    progress.innerHTML = "<span></span>";
    root.insertBefore(progress, root.firstChild);

    var bar = document.createElement("div");
    bar.className = "mb-wizard-bar";
    var prev = document.createElement("button");
    prev.type = "button";
    prev.className = "mb-wizard-prev";
    prev.textContent = "Previous";
    bar.appendChild(prev);
    root.appendChild(bar);

    function show(nextIndex) {
        index = Math.max(0, Math.min(steps.length - 1, nextIndex));
        steps.forEach(function (step, i) {
            step.classList.toggle("is-current", i === index);
            step.style.minHeight = i === index && stepMinHeight ? stepMinHeight + "px" : "";
        });
        prev.hidden = index === 0;
        var actions = steps[index].querySelector(".buttons-wrapper");
        if (!actions) {
            actions = steps[index].querySelector(".mb-step-actions");
            if (!actions) {
                actions = document.createElement("div");
                actions.className = "mb-step-actions";
                steps[index].appendChild(actions);
            }
        }
        actions.insertBefore(prev, actions.firstChild);
        bar.hidden = true;
        var fill = progress.querySelector("span");
        if (fill) {
            fill.style.width = (((index + 1) / steps.length) * 100) + "%";
        }
    }

    function stepIsChoice(step) {
        var typed = step.querySelector('input[type="text"], input[type="email"], input[type="tel"], textarea');
        return !typed && !!step.querySelector('input[type="radio"], select');
    }

    function choiceReady(step) {
        var radio = step.querySelector('input[type="radio"]');
        if (radio) {
            var name = radio.name;
            return !!step.querySelector('input[type="radio"][name="' + name + '"]:checked');
        }
        var select = step.querySelector("select");
        return !!(select && select.value);
    }

    prev.addEventListener("click", function () {
        show(index - 1);
    });

    var stepMinHeight = 0;
    var moveTimer = 0;
    function moveOn(step) {
        if (!step || steps[index] !== step || !stepIsChoice(step) || !choiceReady(step)) {
            return;
        }
        window.clearTimeout(moveTimer);
        moveTimer = window.setTimeout(function () {
            show(index + 1);
        }, 280);
    }

    root.addEventListener("click", function (event) {
        var item = event.target.closest(".data-item");
        if (!item) {
            return;
        }
        var input = item.querySelector('input[type="radio"]');
        if (!input) {
            return;
        }
        input.checked = true;
        moveOn(item.closest(".tab-pane"));
    });

    root.addEventListener("change", function (event) {
        if (event.target.tagName !== "SELECT") {
            return;
        }
        moveOn(event.target.closest(".tab-pane"));
    });

    function hashSHA256(value) {
        if (!window.crypto || !window.crypto.subtle || !value) {
            return Promise.resolve(null);
        }
        var data = new TextEncoder().encode(value);
        return window.crypto.subtle.digest("SHA-256", data).then(function (buffer) {
            return Array.prototype.map.call(new Uint8Array(buffer), function (b) {
                return b.toString(16).padStart(2, "0");
            }).join("");
        }).catch(function () {
            return null;
        });
    }

    function missingField(step) {
        var fields = step.querySelectorAll("input, select, textarea");
        for (var i = 0; i < fields.length; i++) {
            var field = fields[i];
            if (field.type === "radio") {
                var group = step.querySelectorAll('input[type="radio"][name="' + field.name + '"]');
                var checked = false;
                group.forEach(function (item) {
                    if (item.checked) checked = true;
                });
                if (!checked) return field;
                continue;
            }
            if (field.required && !String(field.value || "").trim()) {
                return field;
            }
        }
        return null;
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        if (busy) return;
        var last = steps[steps.length - 1];
        var invalid = missingField(last);
        if (invalid) {
            invalid.focus();
            return;
        }
        busy = true;
        var button = form.querySelector("#submitBtn");
        var loader = form.querySelector("#loader");
        if (button) button.disabled = true;
        if (loader) {
            loader.classList.remove("d-none");
            loader.hidden = false;
        }

        var body = new FormData(form);
        body.set("action", "quote_submit_form_wizard");
        var nonce = form.querySelector("#quote_wizard_nonce");
        if (nonce) body.set("quote_submit_form_wizard_nonce", nonce.value);

        fetch(window.cqfw_ajax_object.ajax_url, {
            method: "POST",
            body: body,
            credentials: "same-origin"
        }).then(function (response) {
            return response.json();
        }).then(function (response) {
            if (!response || response.success !== true) {
                var message = response && response.data && response.data.message ? response.data.message : "An error occurred. Please try again.";
                throw new Error(message);
            }
            var email = (form.querySelector('[name="email_"]') || {}).value || "";
            var phone = (form.querySelector('[name="mobile_"]') || {}).value || "";
            return Promise.all([
                hashSHA256(email.trim().toLowerCase()),
                hashSHA256(phone.trim())
            ]).then(function (hashed) {
                try {
                    if (typeof ttq !== "undefined") {
                        var identify = {};
                        if (hashed[0]) identify.email = hashed[0];
                        if (hashed[1]) identify.phone_number = hashed[1];
                        if (Object.keys(identify).length) ttq.identify(identify);
                        var eventId = response.data && response.data.event_id ? response.data.event_id : String(Date.now());
                        ttq.track("Lead", {
                            contents: [{
                                content_id: "custom_quote_form_wizard",
                                content_type: "lead",
                                content_name: "Boiler Quote Wizard"
                            }]
                        }, { event_id: eventId });
                    }
                } catch (err) {}
                var redirectUrl = window.cqfw_ajax_object.thank_you_url || (window.location.origin + "/thank-you/");
                var token = response.data && response.data.thank_you_token;
                if (token) {
                    redirectUrl += (redirectUrl.indexOf("?") === -1 ? "?" : "&") + "token=" + encodeURIComponent(token) + "&source=quote-form-wizard";
                }
                window.location.replace(redirectUrl);
            });
        }).catch(function (err) {
            busy = false;
            if (button) button.disabled = false;
            if (loader) {
                loader.classList.add("d-none");
                loader.hidden = true;
            }
            window.alert(err && err.message ? err.message : "An error occurred. Please try again.");
        });
    });

    function lockHeight() {
        var content = root.querySelector(".tab-content");
        if (!content) {
            return;
        }
        var max = 0;
        steps.forEach(function (step) {
            if (step.querySelector('input[type="text"], input[type="email"], input[type="tel"], textarea')) {
                return;
            }
            step.classList.add("is-measuring");
            max = Math.max(max, step.offsetHeight);
            step.classList.remove("is-measuring");
        });
        if (max > 0) {
            stepMinHeight = max;
            content.style.minHeight = "";
        }
        show(index);
    }

    show(0);
    lockHeight();
    window.addEventListener("resize", lockHeight);
})();
