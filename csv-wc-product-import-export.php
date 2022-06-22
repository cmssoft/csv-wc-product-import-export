<?php
/**
 * Plugin Name: CSV WC Product Import Export
 * Plugin URI : https://github.com/cmssoft/csv-wc-product-import-export
 * Description: Manage your WooCommerce product data by import & export from CSV file.
 * Version: 1.0.0
 * Author: cmssoft
 * Author URI : https://github.com/cmssoft/
 * Text Domain : csv-wc-product-import-export
*/

if ( ! defined( 'ABSPATH' ) || ! is_admin() ) {
	//return;
}

/**
* Include Dependencies
*/
if ( ! class_exists( 'WC_Dependencies' ) ){
	require_once 'includes/cwpie-class-dependencies.php';
}

/**
* Include Functions
*/
if ( ! function_exists( 'is_woocommerce_active' ) ) {
	function is_woocommerce_active() {
		return WC_Dependencies::woocommerce_active_check();
	}
}

/**
* Check WooCommerce exists
*/
if ( ! is_woocommerce_active() ) {
	return;
}

if ( ! class_exists( 'CWPIE_Product_Import_Export' ) ) :

/*
* Plugin dir
*/
$upload = wp_upload_dir();
$upload_dir = $upload['basedir'];
define('CWPIE_PLUGIN_DIR_PATH',plugin_dir_path(__FILE__));
define('CWPIE_PLUGIN_DIR_URL',plugin_dir_url(__FILE__));
define('CWPIE_UPLOAD_DIR',$upload_dir."/cwpie_product_import_export/");
define('CWPIE_UPLOAD_DIR_NAME',$upload_dir."/cwpie_product_import_export/");
define('CWPIE_UPLOAD_CRON_DIR',CWPIE_UPLOAD_DIR."cron/");
define('CWPIE_UPLOAD_CRON_DIR_NAME',CWPIE_UPLOAD_DIR_NAME."cron/");
define('CWPIE_TRANSLATE_NAME','cwpie-product-import-export');

/*
* Cron Frequency 
*/
$freq = array('csv_one_time'=>__('One time'),
'csv_every_15_minutes'=>__('Every 15 minutes'),
'csv_every_30_minutes'=>__('Every 30 minutes'),
'csv_hourly'=>__('Once hourly'),
'csv_daily'=>__('Once daily'),
'csv_twicedaily'=>__('Twice daily'),
'csv_weekly'=>__('Once weekly'),
'csv_fifteendays'=>__('Every 15 days'),
'csv_monthly'=>__('Monthly'));
define('FREQ',$freq);

/*
* Cron Frequency interval
*/
$freq_interval = array('csv_one_time'=>'One time',
'csv_every_15_minutes'=>(15*60),
'csv_every_30_minutes'=>(30*60),
'csv_hourly'=>(60*60),
'csv_daily'=>(24*(60*60)),
'csv_twicedaily'=>(12*(60*60)),
'csv_weekly'=>(7*(24*(60*60))),
'csv_fifteendays'=>(15*(24*(60*60))),
'csv_monthly'=>(30*(24*(60*60))));
define('FREQ_INTERVAL',$freq_interval);


/**
* Main CSV Import class
*/
class CWPIE_Product_Import_Export {

	/**
	* Logging class
	*/
	private static $logger = false;

	/**
	* Constructor
	*/
	public function __construct() {
		define( 'CWPIE_FILE', __FILE__ );
		define( 'CWPIE_VERSION', '1.0.0' );

		if ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
            register_activation_hook( __FILE__, array( $this, 'activate' ) );
            register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );            
        }   
        if ( is_admin() ){
            register_uninstall_hook( __FILE__, array( $this, 'uninstall' ) );      
        }

		add_filter( 'woocommerce_screen_ids', array( $this, 'woocommerce_screen_ids' ) );
		add_action( 'init', array( $this, 'catch_export_request' ), 20 );
		add_action( 'admin_init', array( $this, 'register_importers' ) );

		include_once( 'includes/cwpie-functions.php' );
		include_once( 'includes/cwpie-class-admin-screen.php' );
		include_once( 'includes/importer/cwpie-class-importer.php' );

		if ( defined('DOING_AJAX') ) {
			include_once( 'includes/cwpie-class-ajax-handler.php' );
		}
	}

	/**
	* Add activate
	*/
	public function activate(){
		global $wpdb;
		
	    $tblname = 'cwpie_product_import_cron';
	    $wp_track_table = $wpdb->prefix . "$tblname";
	    #Check to see if the table exists already, if not, then create it
	    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) {	        
	        $sql = "CREATE TABLE IF NOT EXISTS `".$wp_track_table."` (
			  `cron_id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `file_name` varchar(255) NOT NULL,
			  `file_path` varchar(255) NOT NULL,
			  `start_date` datetime NOT NULL,
			  `frequency` varchar(20) NOT NULL COMMENT 'One Time, Every 5 minute, Every 15 minute, Every 30 minute, Once Hourly, Once Daily, Twice Daily, Once Weekly, Every 15 Days, Monthly',
			  `status` varchar(20) NOT NULL COMMENT 'Pending, Running, Completed',
			  `created_at` timestamp NOT NULL,
			  PRIMARY KEY (`cron_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
	        dbDelta($sql);
	    }

	    $tblname = 'cwpie_product_import_data_log';
	    $wp_track_table = $wpdb->prefix . "$tblname";
	    #Check to see if the table exists already, if not, then create it
	    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) {	        
	        $sql = "CREATE TABLE IF NOT EXISTS `".$wp_track_table."` (
			  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `file_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
			  `product_id` bigint(20) NOT NULL,
			  `product_sku` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
			  `product_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
			  `product_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
			  `status` int(11) NOT NULL,
			  `status_message` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
			  `created_at` timestamp NOT NULL,
			  PRIMARY KEY (`log_id`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;";
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
	        dbDelta($sql);
	    }

	    $tblname = 'cwpie_product_import_file_log';
	    $wp_track_table = $wpdb->prefix . "$tblname";
	    #Check to see if the table exists already, if not, then create it
	    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) {	        
	        $sql = "CREATE TABLE IF NOT EXISTS `".$wp_track_table."` (
			  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `file_name` varchar(255) NOT NULL,
			  `file_status` char(20) NOT NULL,
			  `file_date` datetime NOT NULL,
			  PRIMARY KEY (`log_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
	        dbDelta($sql);
	    }
	}

	/**
	* Add deactivate
	*/
	public function deactivate(){
	}

	/**
	* Add uninstall
	*/
	public function uninstall(){
		global $wpdb;
	    $wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix."cwpie_product_import_cron" );
	    $wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix."cwpie_product_import_data_log" );
	    $wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix."cwpie_product_import_file_log" );
	}

	/**
	* Add screen ID
	*/
	public function woocommerce_screen_ids( $ids ) {
		$ids[] = 'admin';
		return $ids;
	}

	/**
	* Catches an export request and exports the data. This class is only loaded in admin.
	*/
	public function catch_export_request() {
		if ( ! is_user_logged_in() ) {
			return;
		}

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		if ( ! empty( $_GET['action'] ) && ! empty( $_GET['page'] ) && 'csv_wc_import_export' === $_GET['page'] ) {
			switch ( $_GET['action'] ) {
				case 'export' :
					include_once( 'includes/exporter/cwpie-class-exporter.php' );
					CWPIE_Exporter::do_export( 'product' );
				break;
			}
		}
	}

	/**
	* Register importers for use
	*/
	public function register_importers() {
		register_importer( 'csv_wc', 'CSV Import (Product)', __('Import <strong>products</strong> to your store via a csv file.', CWPIE_TRANSLATE_NAME), 'CWPIE_Importer::product_importer' );
	}

	/**
	* Get meta data direct from DB, avoiding get_post_meta and caches
	*/
	public static function log( $message ) {
		if ( ! self::$logger ) {
			self::$logger = new WC_Logger();
		}
		self::$logger->add( 'csv-import', $message );
	}

	/**
	* Get meta data direct from DB, avoiding get_post_meta and caches
	*/
	public static function get_meta_data( $post_id, $meta_key ) {
		global $wpdb;
		$value = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value from $wpdb->postmeta WHERE post_id = %d and meta_key = %s", $post_id, $meta_key ) );
		return maybe_unserialize( $value );
	}
}
endif;

new CWPIE_Product_Import_Export();

/*
* Cron
*/
include_once( 'includes/cwpie-cron.php' );