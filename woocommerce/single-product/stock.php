<?php
/**
 * Single Product stock.
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/stock.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$stock_status = $product->get_stock_status();
$status_text = "Coins will be shipped fully insured within 3-5 business days.";
if ( $stock_status == "outofstock" ) {
	$status_text = "Coins are items which are currently not available for purchase.";
}
elseif ( $stock_status == "awaitingstock" ) {
	$status_text = "Means we are awaiting a delivery of items.";
}
elseif ( $stock_status == "onbackorder" ) {
	$status_text = "Coins are items which can be bought at the live spot price on the day but can take 4-8 weeks to source and deliver.";
}
?>
<div class="buy_content_item_info icon stock <?php echo esc_attr( $class ); ?>">
	<span><?php echo wp_kses_post( $availability ); ?></span>
	<p><?php echo $status_text; ?></p>
</div>
