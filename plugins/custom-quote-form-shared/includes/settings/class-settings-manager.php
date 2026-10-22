<?php
/**
 * Settings Manager - Main orchestrator for admin settings
 */

if (!defined('ABSPATH')) {
    exit;
}

class CQF_Settings_Manager {
    const OPTION_KEY = 'cqf_shared_settings';
    const MENU_SLUG = 'cqf-shared-settings';

    private $email_handler;
    private $webhook_handler;
    private $sanitizer;

    public function __construct() {
        require_once __DIR__ . '/class-email-settings-handler.php';
        require_once __DIR__ . '/class-webhook-settings-handler.php';
        require_once __DIR__ . '/class-settings-sanitizer.php';

        $this->email_handler = new CQF_Email_Settings_Handler();
        $this->webhook_handler = new CQF_Webhook_Settings_Handler();
        $this->sanitizer = new CQF_Settings_Sanitizer();

        add_action('admin_menu', [$this, 'register_menu_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
    }

    public function register_menu_page() {
        add_options_page(
            __('Custom Quote Form Shared Utilities', 'custom-quote-form-shared'),
            __('Quote Form Shared', 'custom-quote-form-shared'),
            'manage_options',
            self::MENU_SLUG,
            [$this, 'render_settings_page']
        );
    }

    public function register_settings() {
        register_setting(
            'cqf_shared_settings_group',
            self::OPTION_KEY,
            ['sanitize_callback' => [$this->sanitizer, 'sanitize']]
        );

        // Register sections and fields from handlers
        $this->email_handler->register_section(self::MENU_SLUG);
        $this->webhook_handler->register_section(self::MENU_SLUG);
    }

    public function enqueue_admin_styles($hook) {
        if ($hook !== 'settings_page_' . self::MENU_SLUG) {
            return;
        }
        
        $css_path = plugin_dir_path(dirname(__DIR__)) . 'assets/css/admin-settings.css';
        $css_url = plugin_dir_url(dirname(__DIR__)) . 'assets/css/admin-settings.css';
        
        // Only enqueue if file exists
        if (file_exists($css_path)) {
            wp_enqueue_style(
                'cqf-admin-settings',
                $css_url,
                [],
                filemtime($css_path) // Use file modification time for cache busting
            );
        }
    }

    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        ?>
        <div class="wrap cqf-settings-wrapper">
            <div class="cqf-settings-header">
                <h1><?php esc_html_e('Custom Quote Form Shared Utilities', 'custom-quote-form-shared'); ?></h1>
                <p><?php esc_html_e('Configure shared settings for all quote form plugins including email notifications and webhook automation.', 'custom-quote-form-shared'); ?></p>
            </div>

            <form method="post" action="options.php">
                <?php
                settings_fields('cqf_shared_settings_group');
                ?>
                
                <div class="cqf-settings-grid">
                    <?php $this->render_email_card(); ?>
                    <?php $this->render_webhook_card(); ?>
                </div>

                <div class="cqf-settings-submit">
                    <?php submit_button(); ?>
                </div>
            </form>
        </div>
        <?php
    }

    private function render_email_card() {
        ?>
        <div class="cqf-settings-card">
            <div class="cqf-settings-card-header">
                <span class="cqf-settings-card-icon">✉️</span>
                <h2><?php esc_html_e('Email Settings', 'custom-quote-form-shared'); ?></h2>
            </div>
            <div class="cqf-settings-card-body">
                <?php
                $this->email_handler->render_section_description();
                $this->render_settings_fields('cqf_shared_email_section');
                ?>
            </div>
        </div>
        <?php
    }

    private function render_webhook_card() {
        ?>
        <div class="cqf-settings-card">
            <div class="cqf-settings-card-header">
                <span class="cqf-settings-card-icon">🔗</span>
                <h2><?php esc_html_e('Webhook Automation', 'custom-quote-form-shared'); ?></h2>
            </div>
            <div class="cqf-settings-card-body">
                <?php
                $this->webhook_handler->render_section_description();
                $this->render_settings_fields('cqf_shared_webhook_section');
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render settings fields for a section (without section header)
     */
    private function render_settings_fields($section_id) {
        global $wp_settings_fields;
        
        if (!isset($wp_settings_fields[self::MENU_SLUG][$section_id])) {
            return;
        }
        
        echo '<table class="form-table" role="presentation">';
        foreach ((array) $wp_settings_fields[self::MENU_SLUG][$section_id] as $field) {
            $class = '';
            if (!empty($field['args']['class'])) {
                $class = ' class="' . esc_attr($field['args']['class']) . '"';
            }
            
            echo "<tr{$class}>";
            
            if (!empty($field['args']['label_for'])) {
                echo '<th scope="row"><label for="' . esc_attr($field['args']['label_for']) . '">' . $field['title'] . '</label></th>';
            } else {
                echo '<th scope="row">' . $field['title'] . '</th>';
            }
            
            echo '<td>';
            call_user_func($field['callback'], $field['args']);
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    /**
     * Get all settings
     */
    public static function get_settings() {
        $stored = get_option(self::OPTION_KEY, []);
        $defaults = self::get_default_settings();
        
        // Preserve checkbox values
        $smtp_auth = array_key_exists('smtp_auth', $stored) ? (int) $stored['smtp_auth'] : $defaults['smtp_auth'];
        $smtp_enabled = array_key_exists('smtp_enabled', $stored) ? (int) $stored['smtp_enabled'] : $defaults['smtp_enabled'];
        $webhook_enabled = array_key_exists('webhook_enabled', $stored) ? (int) $stored['webhook_enabled'] : $defaults['webhook_enabled'];
        
        $settings = wp_parse_args($stored, $defaults);
        
        // Override with preserved checkbox values
        $settings['smtp_auth'] = $smtp_auth;
        $settings['smtp_enabled'] = $smtp_enabled;
        $settings['webhook_enabled'] = $webhook_enabled;
        
        // Preserve empty notification_recipients
        if (empty($stored['notification_recipients'])) {
            $settings['notification_recipients'] = '';
        }
        
        return $settings;
    }

    /**
     * Get default settings
     */
    public static function get_default_settings() {
        return [
            'email_from' => 'sales@meraboiler.com',
            'email_from_name' => 'Sales Team',
            'smtp_enabled' => 0,
            'smtp_host' => '',
            'smtp_port' => 587,
            'smtp_encryption' => 'tls',
            'smtp_auth' => 1,
            'smtp_username' => '',
            'smtp_password' => '',
            'phone_number' => '020 8150 2025',
            'whatsapp_number' => '447305988000',
            'notification_recipients' => '',
            'webhook_enabled' => 0,
            'webhook_url' => '',
            'webhook_wizard_url' => '',
            'webhook_api_key' => '',
        ];
    }

    /**
     * Public static methods for backward compatibility
     */
    public static function get_email_settings() {
        return self::get_settings();
    }

    public static function get_webhook_settings() {
        $settings = self::get_settings();
        return [
            'enabled' => !empty($settings['webhook_enabled']),
            'url' => $settings['webhook_url'] ?? '',
            'wizard_url' => $settings['webhook_wizard_url'] ?? '',
            'api_key' => $settings['webhook_api_key'] ?? '',
        ];
    }
}

