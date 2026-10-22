<?php
/**
 * Database handler for Custom Quote Form submissions
 */

if (!defined('ABSPATH')) {
    exit;
}

class CQF_Database {
    const TABLE_NAME = 'cqf_submissions';
    const DB_VERSION = '1.0';

    /**
     * Create the database table on plugin activation
     */
    public static function create_table() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . self::TABLE_NAME;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            service_type varchar(255) DEFAULT NULL,
            cust_fullname varchar(255) NOT NULL,
            cust_email varchar(255) NOT NULL,
            cust_mobile varchar(50) DEFAULT NULL,
            cust_mobile_international varchar(50) DEFAULT NULL,
            cust_mobile_whatsapp_url varchar(500) DEFAULT NULL,
            cust_pin varchar(20) DEFAULT NULL,
            cust_address text DEFAULT NULL,
            utm_source varchar(255) DEFAULT NULL,
            site_name varchar(255) DEFAULT NULL,
            site_url varchar(500) DEFAULT NULL,
            submitted_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY email (cust_email),
            KEY submitted_at (submitted_at),
            KEY postcode (cust_pin)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Update existing table if columns are missing
        self::update_table();

        // Store database version
        update_option('cqf_db_version', self::DB_VERSION);
    }

    /**
     * Update table structure if columns are missing
     */
    public static function update_table() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . self::TABLE_NAME;
        
        // Check if table exists
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            return;
        }

        // Check and add site_name column if missing
        $column_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'site_name'");
        if (empty($column_exists)) {
            $result = $wpdb->query("ALTER TABLE $table_name ADD COLUMN site_name varchar(255) DEFAULT NULL AFTER utm_source");
            if ($result !== false) {
                error_log('CQF: Added site_name column to database table');
            } else {
                error_log('CQF: Failed to add site_name column: ' . $wpdb->last_error);
            }
        }

        // Check and add site_url column if missing
        $column_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'site_url'");
        if (empty($column_exists)) {
            $result = $wpdb->query("ALTER TABLE $table_name ADD COLUMN site_url varchar(500) DEFAULT NULL AFTER site_name");
            if ($result !== false) {
                error_log('CQF: Added site_url column to database table');
            } else {
                error_log('CQF: Failed to add site_url column: ' . $wpdb->last_error);
            }
        }
    }

    /**
     * Save form submission to database
     * 
     * @param array $formData Form submission data
     * @return int|false Submission ID on success, false on failure
     */
    public static function save_submission($formData) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . self::TABLE_NAME;

        $data = [
            'service_type' => $formData['service_type'] ?? '',
            'cust_fullname' => $formData['cust_fullname'] ?? '',
            'cust_email' => $formData['cust_email'] ?? '',
            'cust_mobile' => $formData['cust_mobile'] ?? '',
            'cust_mobile_international' => $formData['cust_mobile_international'] ?? '',
            'cust_mobile_whatsapp_url' => $formData['cust_mobile_whatsapp_url'] ?? '',
            'cust_pin' => $formData['cust_pin'] ?? '',
            'cust_address' => $formData['cust_address'] ?? '',
            'utm_source' => $formData['utm_source'] ?? '',
            'site_name' => $formData['site_name'] ?? get_bloginfo('name'),
            'site_url' => $formData['site_url'] ?? get_site_url(),
        ];

        $result = $wpdb->insert($table_name, $data);

        if ($result === false) {
            error_log('CQF: Failed to save submission to database: ' . $wpdb->last_error);
            return false;
        }

        return $wpdb->insert_id;
    }

    /**
     * Get submission by ID
     * 
     * @param int $id Submission ID
     * @return object|null Submission object or null if not found
     */
    public static function get_submission($id) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . self::TABLE_NAME;
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d",
            $id
        ));
    }

    /**
     * Get all submissions with pagination
     * 
     * @param int $limit Number of records to retrieve
     * @param int $offset Offset for pagination
     * @return array Array of submission objects
     */
    public static function get_submissions($limit = 50, $offset = 0) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . self::TABLE_NAME;
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table_name ORDER BY submitted_at DESC LIMIT %d OFFSET %d",
            $limit,
            $offset
        ));
    }

    /**
     * Get total count of submissions
     * 
     * @return int Total count
     */
    public static function get_total_count() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . self::TABLE_NAME;
        
        return (int) $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    }

    /**
     * Delete submission by ID
     * 
     * @param int $id Submission ID
     * @return bool True on success, false on failure
     */
    public static function delete_submission($id) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . self::TABLE_NAME;
        
        return $wpdb->delete(
            $table_name,
            ['id' => $id],
            ['%d']
        ) !== false;
    }
}

