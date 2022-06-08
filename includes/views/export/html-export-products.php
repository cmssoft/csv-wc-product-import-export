<div class="tool-box">
	<h3 class="title"><img src="<?php echo CSV_PLUGIN_DIR_URL?>assets/images/export.png" />&nbsp;<?php _e('Product Export', CSV_TRANSLATE_NAME); ?></h3>
	<div class="description">
		<ol>
			<li><?php _e('Export your simple, grouped, external and variable products using this tool. This exported CSV will be in an importable format.', CSV_TRANSLATE_NAME); ?></li>
			<li><?php _e('Click export to save your products to your computer.', CSV_TRANSLATE_NAME); ?></li>
		</ol>
	</div>
	<form action="<?php echo admin_url('admin.php?page=csv_wc_import_export&action=export'); ?>" method="post">
		<table class="form-table">
			<tr style="display: none;">
				<th>
					<label for="v_limit"><?php _e( 'Limit', CSV_TRANSLATE_NAME ); ?></label>
				</th>
				<td>
					<input type="text" name="limit" id="v_limit" placeholder="<?php _e('Unlimited', CSV_TRANSLATE_NAME); ?>" class="input-text" />
				</td>
			</tr>
			<tr style="display: none;">
				<th>
					<label for="v_offset"><?php _e( 'Offset', CSV_TRANSLATE_NAME ); ?></label>
				</th>
				<td>
					<input type="text" name="offset" id="v_offset" placeholder="<?php _e('0', CSV_TRANSLATE_NAME); ?>" class="input-text" />
				</td>
			</tr>
			<tr style="display: none;">
				<th>
					<label for="v_columns"><?php _e( 'Columns', CSV_TRANSLATE_NAME ); ?></label>
				</th>
				<td>
					<select id="v_columns" name="columns[]" data-placeholder="<?php _e('All Columns', CSV_TRANSLATE_NAME); ?>" class="wc-enhanced-select" multiple="multiple">
						<?php
							foreach ($post_columns as $key => $column) {
								echo '<option value="'.$key.'">'.$column.'</option>';
							}
							echo '<option value="images">'.__('Images (featured and gallery)', CSV_TRANSLATE_NAME).'</option>';
							echo '<option value="file_paths">'.__('Downloadable file paths', CSV_TRANSLATE_NAME).'</option>';
							echo '<option value="taxonomies">'.__('Taxonomies (cat/tags/shipping-class)', CSV_TRANSLATE_NAME).'</option>';
							echo '<option value="attributes">'.__('Attributes', CSV_TRANSLATE_NAME).'</option>';
							echo '<option value="meta">'.__('Meta (custom fields)', CSV_TRANSLATE_NAME).'</option>';

							if ( function_exists( 'woocommerce_gpf_install' ) )
								echo '<option value="gpf">'.__('Google Product Feed fields', CSV_TRANSLATE_NAME).'</option>';
						?>
						</select>
				</td>
			</tr>
			<tr style="display: none;">
				<th>
					<label for="v_include_hidden_meta"><?php _e( 'Include hidden meta data', CSV_TRANSLATE_NAME ); ?></label>
				</th>
				<td>
					<input type="checkbox" name="include_hidden_meta" id="v_include_hidden_meta" class="checkbox" />
				</td>
			</tr>
		</table>

		<p class="submit"><input type="submit" class="button" value="<?php _e('Click to export', CSV_TRANSLATE_NAME); ?>" /></p>

	</form>
</div>