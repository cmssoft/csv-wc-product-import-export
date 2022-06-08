<?php
global $wpdb;
?>
<?php
if($log_file!=""){
	?>
	<p class="submit"><a class="docs button-primary" href="admin.php?page=csv_wc_import_export&tab=logs"><?php _e('< Back to Logs', CSV_TRANSLATE_NAME); ?></a>
	<?php
}
?>
<div class="tool-box">
	<div class="import_form_details">
		<?php
		if($log_file!=""){
			?>
			<h3 class="title"><img src="<?php echo CSV_PLUGIN_DIR_URL?>assets/images/log.png" />&nbsp;<?php _e('View import logs', CSV_TRANSLATE_NAME); ?></h3>
			
			<div id="datalog_list_table"></div>
			<input type="hidden" id="datalog_file" value="<?php echo $log_file;?>" />
			<input type="hidden" id="datalog_sort" value="" />
			<input type="hidden" id="datalog_order" value="" />
			<?php
		}else{
			?>
			<h3 class="title"><img src="<?php echo CSV_PLUGIN_DIR_URL?>assets/images/log.png" />&nbsp;<?php _e('Logs', CSV_TRANSLATE_NAME); ?></h3>
			
			<div id="filelog_list_table"></div>
			<input type="hidden" id="filelog_sort" value="" />
			<input type="hidden" id="filelog_order" value="" />
			<?php
		}
		?>
	</div>
</div>