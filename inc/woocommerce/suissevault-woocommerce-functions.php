<?php
/**
 * Suissevault WooCommerce functions.
 *
 * @package suissevault
 */

/**
 * Checks if the current page is a product archive
 *
 * @return boolean
 */
function suissevault_is_product_archive() {
	if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
		return true;
	}
	else {
		return false;
	}
}

function suissevault_get_min_price_per_product_cat( $term_id ) {
	global $wpdb;

	$sql = "
    SELECT  MIN( meta_value+0 ) as minprice
    FROM {$wpdb->posts} 
    INNER JOIN {$wpdb->term_relationships} ON ({$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id)
    INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id) 
    WHERE  
      ( {$wpdb->term_relationships}.term_taxonomy_id IN (%d) ) 
        AND {$wpdb->posts}.post_type = 'product' 
        AND {$wpdb->posts}.post_status = 'publish' 
        AND {$wpdb->postmeta}.meta_key = '_price'
        AND {$wpdb->posts}.ID IN (SELECT posts.ID
                FROM {$wpdb->posts} AS posts
                INNER JOIN {$wpdb->term_relationships} AS term_relationships ON posts.ID = term_relationships.object_id
                INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy ON term_relationships.term_taxonomy_id = term_taxonomy.term_taxonomy_id
                INNER JOIN {$wpdb->terms} AS terms ON term_taxonomy.term_id = terms.term_id
                WHERE term_taxonomy.taxonomy = 'product_type'
                AND terms.slug = 'simple'
                AND posts.post_type = 'product')";
	return $wpdb->get_var( $wpdb->prepare( $sql, $term_id ) );
}
