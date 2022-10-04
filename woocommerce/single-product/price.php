<?php
/**
 * Single Product Price
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
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
	exit; // Exit if accessed directly
}

global $product;

$api_price = get_api_price();
$dynamic_price = get_dynamic_price( $api_price, $product );
$metal = $product->get_attribute( 'Metal' );
?>
<div class="subtitle"><?php _e( 'Price', 'suissevault' ); ?></div>
<?php if ( $metal == 'Silver' ): ?>
	<div class="price_wrapper">Total (inc. VAT):
		<div class="price_inc_vat <?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>" data-price-product-id="<?php echo $product->get_id(); ?>">
			<?php echo wc_price( $dynamic_price[ 'price_inc_vat' ] ); ?>
		</div>
	</div>
	<div class="price_wrapper">(excl. VAT):
		<div class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>" data-price-product-id="<?php echo $product->get_id(); ?>">
			<?php echo wc_price( $dynamic_price[ 'price' ] ); ?>
		</div>
	</div>
<?php else: ?>
	<div class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>" data-price-product-id="<?php echo $product->get_id(); ?>">
		<?php echo wc_price( $dynamic_price[ 'price' ] ); ?>
	</div>
<?php endif; ?>
