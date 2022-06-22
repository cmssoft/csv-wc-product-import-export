<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class CWPIE_Admin_Screen {
	/**
	* Constructor
	*/
	public function __construct() {
		add_filter( 'woocommerce_screen_ids', array( $this, 'screen_id' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_print_styles', array( $this, 'admin_scripts' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	* Add screen id
	*/
	public function screen_id( $ids ) {
		$wc_screen_id = sanitize_title( __( 'WooCommerce', 'woocommerce' ) );
		$ids[]        = $wc_screen_id . '_page_csv_wc_import_export';
		return $ids;
	}

	/**
	* Notices in admin
	*/
	public function admin_notices() {
		if ( ! function_exists( 'mb_detect_encoding' ) ) {
			echo '<div class="error"><p>' . __( 'CSV Import/Export requires the function <code>mb_detect_encoding</code> to import and export CSV files. Please ask your hosting provider to enable this function.', CWPIE_TRANSLATE_NAME ) . '</p></div>';
		}
	}

	/**
	* Admin Menu
	*/
	public function admin_menu() {
		$page = add_submenu_page( 'woocommerce', __( 'Product Import/Export', CWPIE_TRANSLATE_NAME ), __( 'Product Import/Export', CWPIE_TRANSLATE_NAME ), apply_filters( 'csv_wc_product_role', 'manage_woocommerce' ), 'csv_wc_import_export', array( $this, 'output' ));
	}

	/**
	* Admin Scripts
	*/
	public function admin_scripts() {
		wp_enqueue_style( 'cwpie-product-importer', plugins_url( basename( plugin_dir_path( CWPIE_FILE ) ) . '/assets/css/style.css', basename( __FILE__ ) ), '', CWPIE_VERSION, 'screen' );
		wp_enqueue_style( 'cwpie-product-loader', plugins_url( basename( plugin_dir_path( CWPIE_FILE ) ) . '/assets/css/loader.css', basename( __FILE__ ) ), '', CWPIE_VERSION, 'screen' );
		wp_enqueue_style( 'cwpie-product-datetimepicker', plugins_url( basename( plugin_dir_path( CWPIE_FILE ) ) . '/assets/css/jquery.datetimepicker.min.css', basename( __FILE__ ) ), '', CWPIE_VERSION, 'screen' );

		wp_enqueue_script( 'jquery-validate-min', plugins_url( basename( plugin_dir_path( CWPIE_FILE ) ) . '/assets/js/jquery.validate.min.js', basename( __FILE__ ) ), array( 'jquery' ) );
		wp_enqueue_script( 'additional-methods-min', plugins_url( basename( plugin_dir_path( CWPIE_FILE ) ) . '/assets/js/additional-methods.min.js', basename( __FILE__ ) ), array( 'jquery' ) );
		wp_enqueue_script( 'jquery-datetimepicker', plugins_url( basename( plugin_dir_path( CWPIE_FILE ) ) . '/assets/js/jquery.datetimepicker.full.js', basename( __FILE__ ) ), array( 'jquery' ) );		
		wp_enqueue_script( 'import-custom', plugins_url( basename( plugin_dir_path( CWPIE_FILE ) ) . '/assets/js/import-custom.js', basename( __FILE__ ) ), array( 'jquery' ), '', true );
		wp_localize_script( 'import-custom', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );		
	}

	/**
	* Admin Screen output
	*/
	public function output() {
		$tab = ! empty( $_GET['tab'] ) ? $_GET['tab'] : 'import';
		$log_file = ! empty( $_GET['log_file'] ) ? $_GET['log_file'] : '';
		include( 'views/html-admin-screen.php' );
	}

	/**
	* Admin page for importing
	*/
	public function admin_import_page() {
		include( 'views/html-getting-started.php' );
		include( 'views/import/html-import-products.php' );
	}

	/**
	* Admin Page for exporting
	*/
	public function admin_export_page() {
		include( 'views/export/html-export-products.php' );
	}

	/**
	* Admin page for log
	*/
	public function admin_log_page($log_file='') {
		include( 'views/import/html-import-logs.php' );
	}

	/**
	* Admin page for cron
	*/
	public function admin_cron_page() {
		include( 'views/import/html-import-cron.php' );
	}
}

new CWPIE_Admin_Screen();
