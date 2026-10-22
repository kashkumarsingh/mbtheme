<?php
/**
 * Webhook Settings Handler - Manages webhook automation settings
 */

if (!defined('ABSPATH')) {
    exit;
}

class CQF_Webhook_Settings_Handler {

    public function register_section($menu_slug) {
        add_settings_section(
            'cqf_shared_webhook_section',
            __('Automation & Webhooks', 'custom-quote-form-shared'),
            [$this, 'render_section_description'],
            $menu_slug
        );

        add_settings_field(
            'webhook_enabled',
            __('Enable Webhook Automation', 'custom-quote-form-shared'),
            [$this, 'render_webhook_enabled_field'],
            $menu_slug,
            'cqf_shared_webhook_section'
        );

        add_settings_field(
            'webhook_url',
            __('Webhook URL (Quote Form / Homepage)', 'custom-quote-form-shared'),
            [$this, 'render_webhook_url_field'],
            $menu_slug,
            'cqf_shared_webhook_section'
        );

        add_settings_field(
            'webhook_wizard_url',
            __('Webhook URL (Quote Form Wizard)', 'custom-quote-form-shared'),
            [$this, 'render_webhook_wizard_url_field'],
            $menu_slug,
            'cqf_shared_webhook_section'
        );

        add_settings_field(
            'webhook_api_key',
            __('Webhook API Key (Optional)', 'custom-quote-form-shared'),
            [$this, 'render_webhook_api_key_field'],
            $menu_slug,
            'cqf_shared_webhook_section'
        );
    }

    public function render_section_description() {
        echo '<div class="cqf-settings-card-description">';
        echo '<p>' . esc_html__('Configure webhook automation to send form submissions to external services like Zapier, Make, n8n, or other automation platforms.', 'custom-quote-form-shared') . '</p>';
        echo '<p><strong>' . esc_html__('Note:', 'custom-quote-form-shared') . '</strong> ' . esc_html__('When webhook automation is enabled, form submissions will be sent to the webhook URL instead of email notifications. If the webhook fails after retries, the system will automatically fallback to email notifications.', 'custom-quote-form-shared') . '</p>';
        echo '</div>';
    }

    public function render_webhook_enabled_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $checked = checked(1, $settings['webhook_enabled'] ?? 0, false);
        $field_id = 'cqf_webhook_enabled';
        echo '<label><input type="checkbox" id="' . esc_attr($field_id) . '" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[webhook_enabled]" value="1" ' . $checked . ' /> ' . esc_html__('Enable Webhook Automation', 'custom-quote-form-shared') . '</label>';
        echo '<p class="description">' . esc_html__('When enabled, form submissions will be sent to the webhook URL as JSON payload instead of email notifications. Compatible with Zapier, Make, n8n, and other automation platforms.', 'custom-quote-form-shared') . '</p>';
    }

    public function render_webhook_url_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['webhook_url']);
        $field_id = 'cqf_webhook_url';
        $wrapper_id = 'cqf_webhook_url_wrapper';
        $enabled = !empty($settings['webhook_enabled']);
        $style = $enabled ? '' : 'display: none;';
        echo '<div id="' . esc_attr($wrapper_id) . '" style="' . esc_attr($style) . '">';
        echo '<input type="url" id="' . esc_attr($field_id) . '" class="regular-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[webhook_url]" value="' . $value . '" placeholder="https://hooks.zapier.com/hooks/catch/..." />';
        echo '<p class="description">' . esc_html__('Enter your webhook URL. Must start with http:// or https://', 'custom-quote-form-shared') . '</p>';
        echo '<p class="description"><strong>' . esc_html__('Examples:', 'custom-quote-form-shared') . '</strong></p>';
        echo '<ul class="description" style="margin-left: 20px;">';
        echo '<li><code>https://hooks.zapier.com/hooks/catch/123456/abc123/</code></li>';
        echo '<li><code>https://hook.integromat.com/abc123def456</code></li>';
        echo '<li><code>https://your-n8n-instance.com/webhook/abc123</code></li>';
        echo '</ul>';
        echo '</div>';
        echo '<script>
        (function() {
            var checkbox = document.getElementById("cqf_webhook_enabled");
            var wrapper = document.getElementById("cqf_webhook_url_wrapper");
            var urlField = document.getElementById("cqf_webhook_url");
            if (checkbox && wrapper && urlField) {
                checkbox.addEventListener("change", function() {
                    wrapper.style.display = this.checked ? "block" : "none";
                    if (!this.checked) {
                        urlField.value = "";
                    }
                });
            }
        })();
        </script>';
    }

    public function render_webhook_wizard_url_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['webhook_wizard_url'] ?? '');
        $field_id = 'cqf_webhook_wizard_url';
        $wrapper_id = 'cqf_webhook_wizard_url_wrapper';
        $enabled = !empty($settings['webhook_enabled']);
        $style = $enabled ? '' : 'display: none;';
        echo '<div id="' . esc_attr($wrapper_id) . '" style="' . esc_attr($style) . '">';
        echo '<input type="url" id="' . esc_attr($field_id) . '" class="regular-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[webhook_wizard_url]" value="' . $value . '" placeholder="https://hooks.zapier.com/hooks/catch/... (optional)" />';
        echo '<p class="description">' . esc_html__('Optional. Use a different webhook URL for the Quote Form Wizard. If empty, wizard submissions use the URL above.', 'custom-quote-form-shared') . '</p>';
        echo '</div>';
        echo '<script>
        (function() {
            var checkbox = document.getElementById("cqf_webhook_enabled");
            var wrapper = document.getElementById("cqf_webhook_wizard_url_wrapper");
            if (checkbox && wrapper) {
                checkbox.addEventListener("change", function() {
                    wrapper.style.display = this.checked ? "block" : "none";
                });
            }
        })();
        </script>';
    }

    public function render_webhook_api_key_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['webhook_api_key'] ?? '');
        $field_id = 'cqf_webhook_api_key';
        $wrapper_id = 'cqf_webhook_api_key_wrapper';
        $enabled = !empty($settings['webhook_enabled']);
        $style = $enabled ? '' : 'display: none;';
        echo '<div id="' . esc_attr($wrapper_id) . '" style="' . esc_attr($style) . '">';
        echo '<input type="text" id="' . esc_attr($field_id) . '" class="regular-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[webhook_api_key]" value="' . $value . '" placeholder="' . esc_attr__('Enter API key if required by your webhook service', 'custom-quote-form-shared') . '" autocomplete="off" />';
        echo '<p class="description">' . esc_html__('If your webhook service (like Make.com) requires API key authentication, enter it here. The key will be sent in the x-make-apikey header.', 'custom-quote-form-shared') . '</p>';
        echo '</div>';
        echo '<script>
        (function() {
            var checkbox = document.getElementById("cqf_webhook_enabled");
            var wrapper = document.getElementById("cqf_webhook_api_key_wrapper");
            var apiKeyField = document.getElementById("cqf_webhook_api_key");
            if (checkbox && wrapper && apiKeyField) {
                checkbox.addEventListener("change", function() {
                    wrapper.style.display = this.checked ? "block" : "none";
                    if (!this.checked) {
                        apiKeyField.value = "";
                    }
                });
            }
        })();
        </script>';
    }
}

