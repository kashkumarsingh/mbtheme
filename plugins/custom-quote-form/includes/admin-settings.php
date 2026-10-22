<?php

if (!defined('ABSPATH')) {
    exit;
}

class CQF_Admin_Settings {
    const OPTION_KEY = 'cqf_settings';
    const MENU_SLUG = 'cqf-settings';

    public function __construct() {
        add_action('admin_menu', [$this, 'register_menu_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_menu_page() {
        add_options_page(
            __('Custom Quote Form', 'custom-quote-form'),
            __('Custom Quote Form', 'custom-quote-form'),
            'manage_options',
            self::MENU_SLUG,
            [$this, 'render_settings_page']
        );
    }

    public function register_settings() {
        register_setting(
            'cqf_settings_group',
            self::OPTION_KEY,
            ['sanitize_callback' => [$this, 'sanitize_settings']]
        );

        // No settings fields - all email settings are in Shared Settings
    }

    public function sanitize_settings($settings) {
        // No settings to sanitize - all settings are in Shared Settings
        return [];
    }

    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Custom Quote Form', 'custom-quote-form'); ?></h1>
            <div class="notice notice-info">
                <p><?php esc_html_e('All email settings (SMTP, notification recipients, etc.) are configured in the Shared Settings page.', 'custom-quote-form'); ?></p>
                <p><a href="<?php echo esc_url(admin_url('options-general.php?page=cqf-shared-settings')); ?>" class="button button-primary"><?php esc_html_e('Go to Shared Settings', 'custom-quote-form'); ?></a></p>
            </div>
        </div>
        <?php
    }

    private function get_settings() {
        return wp_parse_args(
            get_option(self::OPTION_KEY, []),
            $this->get_default_settings()
        );
    }

    private function get_default_settings() {
        return [];
    }
}

new CQF_Admin_Settings();

