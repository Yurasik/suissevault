<?php
/**
 * Product Loop Start
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}
$columns_number = wc_get_loop_prop( 'columns' );
$grid_class     = '';
if ( $columns_number == 3 )
	$grid_class = 'grid__three';
elseif ( $columns_number == 2 )
	$grid_class = 'grid__twoo';
?>
<div class="products columns-<?php echo esc_attr( $columns_number ); ?> buy_content_items grid <?php echo $grid_class; ?>">
