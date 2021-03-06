<?php
if (!defined( 'ABSPATH')) exit;
return apply_filters('woocommerce_csv_product_post_columns', array(
	'_sku'				=> 'sku',
	'post_parent'       => 'parent_sku',
	'post_title'		=> 'post_title',
	'post_excerpt'		=> 'post_excerpt',
	'post_content'		=> 'post_content',
	'post_status'		=> 'post_status',
	
	// Meta	
	'_featured'			=> 'featured',
	'_downloadable' 	=> 'downloadable',
	'_virtual'			=> 'virtual',
	'_visibility'		=> 'visibility',
	'_stock'			=> 'stock',
	'_stock_status'		=> 'stock_status',
	'_backorders'		=> 'backorders',
	'_manage_stock'		=> 'manage_stock',
	'_regular_price'	=> 'regular_price',
	'_sale_price'		=> 'sale_price',
	'_weight'			=> 'weight',
	'_length'			=> 'length',
	'_width'			=> 'width',
	'_height'			=> 'height',
	'_tax_status'		=> 'tax_status',
	'_tax_class'		=> 'tax_class',
	'_variation_description' => 'variation_description',
	'_upsell_ids'		=> 'upsell_skus',
	'_crosssell_ids'	=> 'crosssell_skus',

	'_sale_price_dates_from' 	=> 'sale_price_dates_from',
	'_sale_price_dates_to' 		=> 'sale_price_dates_to',

	// Downloadable products
	'_download_limit'	=> 'download_limit',
	'_download_expiry'	=> 'download_expiry',

	// Virtual products
	'_product_url'		=> 'product_url',
	'_button_text'		=> 'button_text',
) );