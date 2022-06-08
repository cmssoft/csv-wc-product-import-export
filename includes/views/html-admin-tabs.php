<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
	<a href="<?php echo admin_url('admin.php?page=csv_wc_import_export') ?>" class="nav-tab <?php echo ($tab == 'import') ? 'nav-tab-active' : ''; ?>"><?php _e('Product Import', CSV_TRANSLATE_NAME); ?></a><a href="<?php echo admin_url('admin.php?page=csv_wc_import_export&tab=export') ?>" class="nav-tab <?php echo ($tab == 'export') ? 'nav-tab-active' : ''; ?>"><?php _e('Product Export', CSV_TRANSLATE_NAME); ?></a>
	<a href="<?php echo admin_url('admin.php?page=csv_wc_import_export&tab=logs') ?>" class="nav-tab <?php echo ($tab == 'logs') ? 'nav-tab-active' : ''; ?>"><?php _e('Logs', CSV_TRANSLATE_NAME); ?></a>
	<a href="<?php echo admin_url('admin.php?page=csv_wc_import_export&tab=cron') ?>" class="nav-tab <?php echo ($tab == 'cron') ? 'nav-tab-active' : ''; ?>"><?php _e('CRON Scheduler', CSV_TRANSLATE_NAME); ?></a>
</h2>

<div id="page-preloader" style="display:none;" class="loading_wrap preloader-loaded"><div class="page-preloader-spin"></div></div>