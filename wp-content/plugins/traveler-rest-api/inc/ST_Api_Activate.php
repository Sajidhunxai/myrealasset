<?php 
namespace Inc;
class ST_Api_Activate
{
    public function get_settings() {
      
       
        register_activation_hook( PLUGIN_PATH.'/traveler-rest-api.php', array($this,'st_create_database_customer' ));
    }

    public function st_create_database_customer(){
        global $wpdb;
       
        global $my_plg_db_version;
        $table_name = $wpdb->prefix . 'st_customer';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_domain text NOT NULL,
            user_name text NOT NULL,
            user_email text NOT NULL,
            section_name text NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY id (id)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        add_option( 'my_plg_db_version', $my_plg_db_version );
    }
}