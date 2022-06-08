<?php
/**
 * Review order table
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

$cart_delivery_method = WC()->session->get( 'cart_delivery_method' );
?>

<div class="checkout_totals shop_table woocommerce-checkout-review-order-table">
	<ul>
		<?php do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item[ 'data' ], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item[ 'quantity' ] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) { ?>
				<li class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<div class="checkout_totals_item flex">
						<div class="checkout_totals_item_img">
							<?php
							$thumbnail_id = $_product->get_image_id();
							$image_data   = suissevault_get_image_data( $thumbnail_id );
							$picture      = suissevault_get_picture_html( $image_data );

							echo $picture; ?>
						</div>
						<div class="checkout_totals_item_info">
							<div class="checkout_totals_item_name"><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?></div>
							<div class="checkout_totals_item_right">
								<p>
									<span>Qty</span><?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', $cart_item[ 'quantity' ], $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</p>
								<p>
									<span>Each</span><?php echo wc_price( wc_get_price_including_tax( $_product ) ); ?>
								</p>
								<p>
									<span>Total</span><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item[ 'quantity' ] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</p>
								<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</div>
					</div>
				</li>
			<?php }
		}

		do_action( 'woocommerce_review_order_after_cart_contents' ); ?>

		<li class="cart-subtotal">
			<p class="flex__center">
				<span><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
				<?php echo wc_price( WC()->cart->get_subtotal() ); ?>
			</p>
		</li>

		<?php $cart_tax_totals = WC()->cart->get_total_tax(); ?>
		<?php if ( $cart_tax_totals ): ?>
			<li>
				<p class="flex__center">
					<span><?php esc_html_e( 'VAT', 'suissevault' ); ?></span>
					<?php echo wc_price( $cart_tax_totals ); ?>
				</p>
			</li>
		<?php endif; ?>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<li class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<p class="flex__center">
					<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
					<?php wc_cart_totals_coupon_html( $coupon ); ?>
				</p>
			</li>
		<?php endforeach; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<li class="fee">
				<p class="flex__center">
					<span><?php echo esc_html( $fee->name ); ?></span>
					<?php wc_cart_totals_fee_html( $fee ); ?>
				</p>
			</li>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && !WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<li class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<p class="flex__center">
							<span><?php echo esc_html( $tax->label ); ?></span>
							<?php echo wp_kses_post( $tax->formatted_amount ); ?>
						</p>
					</li>
				<?php endforeach; ?>
			<?php else : ?>
				<li class="tax-total">
					<p class="flex__center">
						<span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
						<?php wc_cart_totals_taxes_total_html(); ?>
					</p>
				</li>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<?php if ( isset( $cart_delivery_method[ 'method' ] ) ): ?>
			<li>
				<?php if( $cart_delivery_method[ 'method' ] == 'shipping' && $cart_delivery_method[ 'value' ] == 'free_shipping' ): ?>
					<p class="flex__center"><span>Delivery (Free Insured UK Delivery)</span>Free</p>
				<?php elseif( $cart_delivery_method[ 'method' ] == 'shipping' && $cart_delivery_method[ 'value' ] == 'flat_rate' ): ?>
					<p class="flex__center"><span>Fast Delivery</span><?php echo wc_price(10); ?></p>
				<?php elseif( $cart_delivery_method[ 'method' ] == 'storage' ): ?>
					<p class="flex__center"><span>Storage</span><?php echo wc_price(10); ?> per month</p>
				<?php endif; ?>
			</li>
		<?php endif; ?>

		<li class="order-total">
			<div class="checkout_total flex__center">
				<?php
				$total_price             = floatval( preg_replace( '#[^\d.]#', '', WC()->cart->get_total() ) );
				$more_than_5k            = $total_price > 5000;
				$more_than_5k_class      = ( $more_than_5k )
					? "icon icon-total"
					: "";
				$more_than_5k_popup_link = ( $more_than_5k ) ? '<a class="modal-link" data-modal-name="identification"><img src="'. get_template_directory_uri() . '/assets/images/icon/i.svg" alt="Identification"></a>' : '';
				$total_title             = ( wc_tax_enabled() && WC()->cart->display_prices_including_tax() )
					? "Total (inc. VAT)"
					: "Total"; ?>
				<div class="checkout_total_left <?php echo "$more_than_5k_class"; ?>"><?php echo "$total_title $more_than_5k_popup_link"; ?>

				</div>
				<div class="checkout_total_price"><?php wc_cart_totals_order_total_html(); ?></div>
			</div>
		</li>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
	</ul>
</div>
