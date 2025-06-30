<?php

require_once('vendor/autoload.php');

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    require_once 'woo_functions.php';
}

// function for woocommerce

require_once 'divi_functions.php';
	
//	add_filter('woocommerce_csv_product_import_mapping_options', function ($columns) {
//		$columns['brand_desc'] = __( 'Brand Description', 'woocommerce' );
//		return $columns;
//	});
//
//	add_filter( 'woocommerce_csv_product_import_mapping_default_columns', function ($mappings) {
//		$new_mapping = array( __( 'Brand Description', 'woocommerce' ) => 'brand_desc' );
//		return array_merge( $mappings, $new_mapping );
//	});

//
//	add_action('woocommerce_product_import_inserted_product_object', function($product, $data) {
//		if ( empty( $data['brand_ids'] ) || empty( $data['brand_desc'] ) ) {
//			return;
//		}
//		$desc = $desc1 = $data['brand_desc'];
//		if ( empty( $desc ) ) {
//			return;
//		}
//
//		$desc = wc_format_product_short_description( $desc );
////		$desc1 = parse_description_field( $desc1 );
////		$desc11 = wc_sanitize_term_text_based( $desc1 );
////		$desc2 = sanitize_text_field( $desc1 );
////		$desc3 = wc_format_product_short_description( $desc1 );
////		$desc4 = wp_filter_post_kses( $desc1 );
//		$brand_obj = $GLOBALS['WC_Brands_Admin'];
//		$brand_ids = array_map( 'intval', $brand_obj->parse_brands_field( $data['brand_ids'] ) );
//		remove_filter('pre_term_description', 'wp_filter_kses');
//		remove_filter('term_description', 'wp_kses_data');
//		$result = update_brand_descriptions($brand_ids,  $desc);
//		apply_filters('pre_term_description', 'wp_filter_kses');
//		apply_filters('term_description', 'wp_kses_data');
//	}, 9, 2);
	
	
	
	/**
	 * Parse a description value field
	 *
	 * @param string $description field value.
	 *
	 * @return string
	 */
	function parse_description_field( $description ) {
	$parts = explode( "\\\\n", $description );
	foreach ( $parts as $key => $part ) {
		$parts[ $key ] = str_replace( '\n', "\n", $part );
	}
	
	return implode( '\\\n', $parts );
}


	/**
	 * Update the description of multiple terms in the 'product_brand' taxonomy.
	 *
	 * @param array  $brand_ids Array of term IDs.
	 * @param string $desc      New description to set.
	 *
	 * @return array List of updated term IDs or error messages.
	 */
	function update_brand_descriptions(array $brand_ids, string $desc): array {
		$results = [];
		
		// Validate description
		if (empty($desc)) {
			return ['error' => 'Description is empty.'];
		}
		
		// Validate term IDs
		if (empty($brand_ids) || !is_array($brand_ids)) {
			return ['error' => 'No term IDs provided.'];
		}
		
		foreach ($brand_ids as $term_id) {
			// Ensure it's a valid integer
			$term_id = intval($term_id);
			if ($term_id <= 0) {
				$results[] = "Invalid term ID: $term_id";
				continue;
			}
			
			// Check if the term exists and is in 'product_brand'
			$term = get_term($term_id, 'product_brand');
			if (!$term || is_wp_error($term)) {
				$results[] = "Term not found: $term_id";
				continue;
			}
			
			// Update the term description
			$updated = wp_update_term($term_id, 'product_brand', ['description' => $desc]);
			
			if (is_wp_error($updated)) {
				$results[] = "Failed to update term $term_id: " . $updated->get_error_message();
			} else {
				$results[] = "Term $term_id updated successfully.";
			}
		}
		
		return $results;
	}

