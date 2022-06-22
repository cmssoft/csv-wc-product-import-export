<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class CWPIE_Importer {
	/**
	* Product Exporter Tool
	*/
	public static function load_wp_importer() {
		// Load Importer API
		require_once ABSPATH . 'wp-admin/includes/import.php';

		if ( ! class_exists( 'WP_Importer' ) ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if ( file_exists( $class_wp_importer ) ) {
				require $class_wp_importer;
			}
		}
	}

	/**
	* Product Importer Tool
	*/
	public static function product_importer() {
		
		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			return;
		}

		self::load_wp_importer();

		// includes
		if ( !defined('DOING_AJAX') ) {
			$tab = ! empty( $_GET['tab'] ) ? $_GET['tab'] : 'import';
			echo '<div class="wrap woocommerce">';
			require CWPIE_PLUGIN_DIR_PATH.'includes/views/html-admin-tabs.php';
		}

			require 'cwpie-class-product-import.php';
			require 'cwpie-class-product_variation-import.php';
			require 'cwpie-class-parser.php';

			// Dispatch
			$GLOBALS['CWPIE_Product_Import'] = new CWPIE_Product_Import();
			$GLOBALS['CWPIE_Product_Import'] ->dispatch();
			

		if ( !defined('DOING_AJAX') ) {	
			echo '</div>';
		}	
	}

	/**
	* Variation Importer Tool
	*/
	public static function variation_importer() {
		
		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			return;
		}

		self::load_wp_importer();

		// includes
		if ( !defined('DOING_AJAX') ) {
			$tab = ! empty( $_GET['tab'] ) ? $_GET['tab'] : 'import';
			echo '<div class="wrap woocommerce">';
			require CWPIE_PLUGIN_DIR_PATH.'includes/views/html-admin-tabs.php';
		}

			require 'cwpie-class-product-import.php';
			require 'cwpie-class-product_variation-import.php';
			require 'cwpie-class-parser.php';

			// Dispatch
			$GLOBALS['CWPIE_Product_Import'] = new CWPIE_Product_Variation_Import();
			$GLOBALS['CWPIE_Product_Import'] ->dispatch();


		if ( !defined('DOING_AJAX') ) {	
			echo '</div>';
		}
	}
}
