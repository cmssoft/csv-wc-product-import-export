<?php
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
global $wpdb;
$upload = wp_upload_dir();
$upload_dir = $upload['basedir'];
$wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix."cwpie_product_import_cron" );
$wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix."cwpie_product_import_data_log" );
$wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix."cwpie_product_import_file_log" );
/**
 * Deletes a directory, using the WordPress Filesystem API
 */
if(!function_exists( 'csv_upload_delete_directory')){
  function csv_upload_delete_directory(string $path) {
    // make it work from the frontend, as well
    require_once ABSPATH . 'wp-admin/includes/file.php';
    // this variable will hold the selected filesystem class
    global $wp_filesystem;
    // this function selects the appropriate filesystem class
    WP_Filesystem();
    // finally, you can call the 'delete' function on the selected class,
    // which is now stored in the global '$wp_filesystem'
    $wp_filesystem->delete($path, true);
  }
}
define('CWPIE_UPLOAD_DIR',$upload_dir."/cwpie_product_import_export/");
csv_upload_delete_directory(CWPIE_UPLOAD_DIR);
?>