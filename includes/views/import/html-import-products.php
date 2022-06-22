<div class="tool-box">
	<h3 class="title"><img src="<?php echo CWPIE_PLUGIN_DIR_URL?>assets/images/import.png" />&nbsp;<?php _e('Product Import', CWPIE_TRANSLATE_NAME); ?></h3>
	<div class="description">
		<ol>
			<li><?php _e('Import simple, grouped, external and variable products into WooCommerce using this tool.', CWPIE_TRANSLATE_NAME); ?></li>
			<li><?php _e('Upload a CSV from your computer. Click import your CSV as new products (existing products will be skipped).'); ?></li>
			<li><?php _e('Importing requires the <code>post_title</code> and <code>sku</code> columns.', CWPIE_TRANSLATE_NAME); ?></li>
			<li><?php _e('Variation must be mapped to a variable product via a <code>parent_sku</code> column in order to import successfully.', CWPIE_TRANSLATE_NAME); ?></li>
		</ol>
	</div>
	<p class="submit"><a class="button" href="<?php echo admin_url('admin.php?import=csv_wc'); ?>"><?php _e('Click next >', CWPIE_TRANSLATE_NAME); ?></a> <!--<a class="button" href="<?php echo admin_url('admin.php?import=csv_wc&merge=1'); ?>"><?php _e('Merge Products', CWPIE_TRANSLATE_NAME); ?></a>--></p>
</div>