<?php
/**
 * Database handler for Custom Quote Form Wizard submissions
 */

if (!defined('ABSPATH')) {
    exit;
}

class CQFW_Database {
    const TABLE_NAME = 'cqfw_submissions';
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
            owner_type varchar(255) DEFAULT NULL,
            full_name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            mobile varchar(50) DEFAULT NULL,
            mobile_international varchar(50) DEFAULT NULL,
            mobile_whatsapp_url varchar(500) DEFAULT NULL,
            street text DEFAULT NULL,
            postcode varchar(20) DEFAULT NULL,
            hear_about_us varchar(255) DEFAULT NULL,
            boiler_age varchar(255) DEFAULT NULL,
            boiler_working varchar(255) DEFAULT NULL,
            fuel_type varchar(255) DEFAULT NULL,
            existing_boiler varchar(255) DEFAULT NULL,
            desired_boiler varchar(255) DEFAULT NULL,
            property_type varchar(255) DEFAULT NULL,
            bedrooms varchar(50) DEFAULT NULL,
            bath_tubs varchar(50) DEFAULT NULL,
            showers varchar(50) DEFAULT NULL,
            occupants varchar(50) DEFAULT NULL,
            current_boiler_location varchar(255) DEFAULT NULL,
            new_boiler_location varchar(255) DEFAULT NULL,
            flue_exit varchar(255) DEFAULT NULL,
            flue_height varchar(255) DEFAULT NULL,
            flue_distance varchar(255) DEFAULT NULL,
            flue_structure varchar(255) DEFAULT NULL,
            flue_window_distance varchar(255) DEFAULT NULL,
            meter_distance varchar(255) DEFAULT NULL,
            radiators varchar(255) DEFAULT NULL,
            site_name varchar(255) DEFAULT NULL,
            site_url varchar(500) DEFAULT NULL,
            submitted_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY email (email),
            KEY submitted_at (submitted_at),
            KEY postcode (postcode)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Store database version
        update_option('cqfw_db_version', self::DB_VERSION);
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
            'owner_type' => $formData['owner_type'] ?? '',
            'full_name' => $formData['full_name'] ?? '',
            'email' => $formData['email'] ?? '',
            'mobile' => $formData['mobile'] ?? '',
            'mobile_international' => $formData['mobile_international'] ?? '',
            'mobile_whatsapp_url' => $formData['mobile_whatsapp_url'] ?? '',
            'street' => $formData['street'] ?? '',
            'postcode' => $formData['postcode'] ?? '',
            'hear_about_us' => $formData['hear_about_us'] ?? '',
            'boiler_age' => $formData['boiler_age'] ?? '',
            'boiler_working' => $formData['boiler_working'] ?? '',
            'fuel_type' => $formData['fuel_type'] ?? '',
            'existing_boiler' => $formData['existing_boiler'] ?? '',
            'desired_boiler' => $formData['desired_boiler'] ?? '',
            'property_type' => $formData['property_type'] ?? '',
            'bedrooms' => $formData['bedrooms'] ?? '',
            'bath_tubs' => $formData['bath_tubs'] ?? '',
            'showers' => $formData['showers'] ?? '',
            'occupants' => $formData['occupants'] ?? '',
            'current_boiler_location' => $formData['current_boiler_location'] ?? '',
            'new_boiler_location' => $formData['new_boiler_location'] ?? '',
            'flue_exit' => $formData['flue_exit'] ?? '',
            'flue_height' => $formData['flue_height'] ?? '',
            'flue_distance' => $formData['flue_distance'] ?? '',
            'flue_structure' => $formData['flue_structure'] ?? '',
            'flue_window_distance' => $formData['flue_window_distance'] ?? '',
            'meter_distance' => $formData['meter_distance'] ?? '',
            'radiators' => $formData['radiators'] ?? '',
            'site_name' => $formData['site_name'] ?? '',
            'site_url' => $formData['site_url'] ?? '',
        ];

        $result = $wpdb->insert($table_name, $data);

        if ($result === false) {
            error_log('CQFW: Failed to save submission to database: ' . $wpdb->last_error);
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

