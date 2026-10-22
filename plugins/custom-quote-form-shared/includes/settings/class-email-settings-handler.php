<?php
/**
 * Email Settings Handler - Manages email and SMTP settings
 */

if (!defined('ABSPATH')) {
    exit;
}

class CQF_Email_Settings_Handler {

    public function register_section($menu_slug) {
        add_settings_section(
            'cqf_shared_email_section',
            __('Email Settings', 'custom-quote-form-shared'),
            [$this, 'render_section_description'],
            $menu_slug
        );

        add_settings_field(
            'email_from',
            __('From Email', 'custom-quote-form-shared'),
            [$this, 'render_email_from_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );

        add_settings_field(
            'email_from_name',
            __('From Name', 'custom-quote-form-shared'),
            [$this, 'render_email_from_name_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );

        add_settings_field(
            'smtp_enabled',
            __('Enable SMTP', 'custom-quote-form-shared'),
            [$this, 'render_smtp_enabled_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );

        add_settings_field(
            'smtp_host',
            __('SMTP Host', 'custom-quote-form-shared'),
            [$this, 'render_smtp_host_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );

        add_settings_field(
            'smtp_port',
            __('SMTP Port', 'custom-quote-form-shared'),
            [$this, 'render_smtp_port_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );

        add_settings_field(
            'smtp_encryption',
            __('Encryption', 'custom-quote-form-shared'),
            [$this, 'render_smtp_encryption_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );

        add_settings_field(
            'smtp_auth',
            __('SMTP Authentication', 'custom-quote-form-shared'),
            [$this, 'render_smtp_auth_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );

        add_settings_field(
            'smtp_username',
            __('SMTP Username', 'custom-quote-form-shared'),
            [$this, 'render_smtp_username_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );

        add_settings_field(
            'smtp_password',
            __('SMTP Password', 'custom-quote-form-shared'),
            [$this, 'render_smtp_password_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );

        add_settings_field(
            'phone_number',
            __('Phone Number', 'custom-quote-form-shared'),
            [$this, 'render_phone_number_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );

        add_settings_field(
            'whatsapp_number',
            __('WhatsApp Number', 'custom-quote-form-shared'),
            [$this, 'render_whatsapp_number_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );

        add_settings_field(
            'notification_recipients',
            __('Notification Recipients', 'custom-quote-form-shared'),
            [$this, 'render_notification_recipients_field'],
            $menu_slug,
            'cqf_shared_email_section'
        );
    }

    public function render_section_description() {
        echo '<div class="cqf-settings-card-description">';
        echo '<p>' . esc_html__('Configure email settings for form notifications. These settings are shared by all quote form plugins. Enable SMTP for better deliverability.', 'custom-quote-form-shared') . '</p>';
        echo '</div>';
    }

    public function render_email_from_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['email_from']);
        echo '<input type="email" class="regular-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[email_from]" value="' . $value . '" placeholder="sales@meraboiler.com" />';
        echo '<p class="description">' . esc_html__('Email address used as the sender for form notifications.', 'custom-quote-form-shared') . '</p>';
    }

    public function render_email_from_name_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $brand = class_exists('CQF_Shared_Utilities') ? CQF_Shared_Utilities::brand_from_host() : '';
        $suffix = class_exists('CQF_Shared_Utilities')
            ? CQF_Shared_Utilities::from_name_suffix()
            : ($settings['email_from_name'] ?: 'Sales Team');
        echo '<span class="cqf-from-name-brand" style="display:inline-block;margin-right:6px;padding:4px 8px;background:#f0f0f1;border:1px solid #c3c4c7;border-radius:3px;">[' . esc_html($brand) . ']</span>';
        echo '<input type="text" class="regular-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[email_from_name]" value="' . esc_attr($suffix) . '" placeholder="Sales Team" />';
        echo '<p class="description">' . esc_html__('The brand in brackets comes from the site and cannot be edited. The text after it is the sender name, for example [Meraboiler] Sales Team.', 'custom-quote-form-shared') . '</p>';
    }

    public function render_smtp_enabled_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $checked = checked(1, $settings['smtp_enabled'] ?? 0, false);
        echo '<label><input type="checkbox" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[smtp_enabled]" value="1" ' . $checked . ' /> ' . esc_html__('Enable SMTP', 'custom-quote-form-shared') . '</label>';
        echo '<p class="description">' . esc_html__('Use SMTP for sending emails instead of PHP mail(). Required for Gmail and GoDaddy email.', 'custom-quote-form-shared') . '</p>';
    }

    public function render_smtp_host_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['smtp_host']);
        echo '<input type="text" class="regular-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[smtp_host]" value="' . $value . '" placeholder="localhost or smtp.gmail.com" />';
        echo '<p class="description">' . esc_html__('SMTP server hostname. For GoDaddy use "localhost", for Gmail use "smtp.gmail.com".', 'custom-quote-form-shared') . '</p>';
    }

    public function render_smtp_port_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['smtp_port']);
        echo '<input type="number" class="small-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[smtp_port]" value="' . $value . '" min="1" max="65535" placeholder="587" />';
        echo '<p class="description">' . esc_html__('SMTP port (587 for TLS, 465 for SSL, 25 for unencrypted).', 'custom-quote-form-shared') . '</p>';
    }

    public function render_smtp_encryption_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['smtp_encryption'] ?? 'tls');
        echo '<select name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[smtp_encryption]">';
        echo '<option value="tls" ' . selected('tls', $value, false) . '>TLS</option>';
        echo '<option value="ssl" ' . selected('ssl', $value, false) . '>SSL</option>';
        echo '<option value="none" ' . selected('none', $value, false) . '>None (for GoDaddy)</option>';
        echo '</select>';
        echo '<p class="description">' . esc_html__('Encryption method. For GoDaddy use "None", for Gmail use "TLS".', 'custom-quote-form-shared') . '</p>';
    }

    public function render_smtp_auth_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $checked = checked(1, (int) ($settings['smtp_auth'] ?? 1), false);
        echo '<label><input type="checkbox" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[smtp_auth]" value="1" ' . $checked . ' /> ' . esc_html__('Enable SMTP authentication', 'custom-quote-form-shared') . '</label>';
        echo '<p class="description">' . esc_html__('Enable if your SMTP server requires authentication. For GoDaddy, uncheck this. For Gmail, keep it checked.', 'custom-quote-form-shared') . '</p>';
    }

    public function render_smtp_username_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['smtp_username']);
        $field_id = 'smtp_username_' . uniqid();
        echo '<input type="text" id="' . esc_attr($field_id) . '" class="regular-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[smtp_username]" value="' . $value . '" placeholder="your-email@gmail.com" autocomplete="off" data-form-type="other" readonly onfocus="this.removeAttribute(\'readonly\')" />';
        echo '<p class="description">' . esc_html__('SMTP authentication username (usually your email address). Required only if SMTP Authentication is enabled. Leave empty for GoDaddy.', 'custom-quote-form-shared') . '</p>';
    }

    public function render_smtp_password_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['smtp_password']);
        $field_id = 'smtp_password_' . uniqid();
        echo '<input type="password" id="' . esc_attr($field_id) . '" class="regular-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[smtp_password]" value="' . $value . '" placeholder="Your SMTP password or app password" autocomplete="new-password" data-form-type="other" data-lpignore="true" readonly onfocus="this.removeAttribute(\'readonly\')" />';
        echo '<p class="description">' . esc_html__('SMTP password or app password (for Gmail, use an app password). Required only if SMTP Authentication is enabled. Leave empty for GoDaddy.', 'custom-quote-form-shared') . '</p>';
    }

    public function render_phone_number_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['phone_number'] ?? '');
        echo '<input type="text" class="regular-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[phone_number]" value="' . $value . '" placeholder="020 8150 2025" />';
        echo '<p class="description">' . esc_html__('Number used in the call link in the customer thank-you email. You can include spaces, for example 020 8150 2025. Leave empty to hide the link.', 'custom-quote-form-shared') . '</p>';
    }

    public function render_whatsapp_number_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['whatsapp_number'] ?? '');
        echo '<input type="text" class="regular-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[whatsapp_number]" value="' . $value . '" placeholder="447305988000" />';
        echo '<p class="description">' . esc_html__('Number used in the WhatsApp link in the customer thank-you email. Include the country code and leave out spaces, for example 447305988000. Leave empty to hide the link.', 'custom-quote-form-shared') . '</p>';
    }

    public function render_notification_recipients_field() {
        $settings = CQF_Settings_Manager::get_settings();
        $value = esc_attr($settings['notification_recipients']);
        echo '<textarea class="large-text" name="' . esc_attr(CQF_Settings_Manager::OPTION_KEY) . '[notification_recipients]" rows="3" placeholder="email1@example.com, email2@example.com, email3@example.com">' . $value . '</textarea>';
        echo '<p class="description">' . esc_html__('Comma-separated list of email addresses to receive form submission notifications. Used by all quote form plugins.', 'custom-quote-form-shared') . '</p>';
        echo '<p class="description"><strong>' . esc_html__('Example:', 'custom-quote-form-shared') . '</strong> <code>meraboiler@gmail.com, meraboiler.io@gmail.com, sales@meraboiler.com</code></p>';
    }
}

