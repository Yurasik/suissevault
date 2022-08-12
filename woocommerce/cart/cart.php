<?php
/**
 * Cart Page
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

$current_payment_method = WC()->session->get( 'chosen_payment_method' );
$cart_delivery_method = WC()->session->get( 'cart_delivery_method' );
?>

<?php do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<div class="lock_cart">
		<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
			<thead>
				<tr>
					<th class="product-remove">&nbsp;</th>
					<th class="product-thumbnail">&nbsp;</th>
					<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
					<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
					<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
					<th class="product-tax"><?php esc_html_e( 'VAT', 'woocommerce' ); ?></th>
					<th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item[ 'data' ], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item[ 'product_id' ], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item[ 'quantity' ] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible()
						? $_product->get_permalink( $cart_item )
						: '', $cart_item, $cart_item_key ); ?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						<td class="product-remove">
							<?php echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove close" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'woocommerce' ), esc_attr( $product_id ), esc_attr( $_product->get_sku() ) ), $cart_item_key ); ?>
						</td>
						<td class="product-thumbnail">
							<?php $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( !$product_permalink ) {
								echo $thumbnail; // PHPCS: XSS ok.
							}
							else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
							} ?>
						</td>
						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
							<?php
							if ( !$product_permalink ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
							}
							else {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
							}

							do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

							// Meta data.
							echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

							// Backorder notification.
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item[ 'quantity' ] ) ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
							} ?>
						</td>
						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
							<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							}
							else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'   => "cart[{$cart_item_key}][qty]",
									'input_value'  => $cart_item[ 'quantity' ],
									'max_value'    => $_product->get_max_purchase_quantity(),
									'min_value'    => '0',
									'product_name' => $_product->get_name(),
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok. ?>
						</td>
						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php $price_excluding_tax = wc_get_price_excluding_tax( $_product ); ?>
							<?php $cart_item_price = apply_filters( 'woocommerce_cart_item_price', $price_excluding_tax, $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>
							<?php echo wc_price( $cart_item_price ); ?>
						</td>
						<td class="product-tax" data-title="<?php esc_attr_e( 'VAT', 'woocommerce' ); ?>">
							<?php $cart_item_tax = apply_filters( 'woocommerce_cart_item_tax', wc_get_price_including_tax( $_product ) - $price_excluding_tax, $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>
							<?php echo wc_price( $cart_item_tax ); ?>
						</td>
						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
							<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item[ 'quantity' ] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>
						</td>
					</tr>
					<?php
				}
			} ?>
			</tbody>
		</table>
	</div>

	<?php do_action( 'woocommerce_cart_contents' ); ?>

	<div class="cart_net flex__end actions">
		<?php if ( wc_coupons_enabled() ) { ?>
			<div class="cart_code coupon">
				<label for="coupon_code" class="cart_code_label">COUPON CODE</label>
				<div class="cart_code_input flex__start">
					<div class="input">
						<div class="input">
							<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>"/>
						</div>
					</div>
					<button type="submit" class="button btn" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
				</div>
				<?php do_action( 'woocommerce_cart_coupon' ); ?>
			</div>
		<?php } ?>

		<button style="display: none;" id="update_cart_btn" type="submit" class="button btn" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

		<?php do_action( 'woocommerce_cart_actions' ); ?>

		<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_contents' ); ?>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<form id="cart-delivery-form" class="lock_radio lock_radio-small flex__align">
	<?php wp_nonce_field( 'ajax-delivery-method-nonce', 'delivery-security' ); ?>
	<label>
		<input type="radio" name="delivery_method" value="shipping" data-checked="shipping" class="input__hidden" <?php checked( 'shipping', $cart_delivery_method['method'] ); ?>>
		<span>
			<picture><source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/svg/car.svg" type="image/webp"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/svg/car.svg" alt="Delivery"></picture>
			Delivery
		</span>
	</label>
	<label>
		<input type="radio" name="delivery_method" value="storage" data-checked="storage" class="input__hidden" <?php checked( 'storage', $cart_delivery_method['method'] ); ?>>
		<span>
			<picture><source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/svg/safe.svg" type="image/webp"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/svg/safe.svg" alt="Storage"></picture>
			Storage
		</span>
	</label>
</form>

<ul class="lock_radio_checked">
	<li id="shipping">
		<p class="lock_radio_label">Delivery option:</p>
		<div class="select">
			<select name="shipping">
				<option value="free_shipping:4" <?php echo ( isset( $cart_delivery_method['value'] ) && $cart_delivery_method['value'] == 'free_shipping:4' ) ? "selected" : ""; ?>>Free Insured Special Delivery (£0.00)</option>
				<option value="flat_rate:5" <?php echo ( isset( $cart_delivery_method['value'] ) && $cart_delivery_method['value'] == 'flat_rate:5' ) ? "selected" : ""; ?>>Fast Delivery (£10.00)</option>
			</select>
		</div>
	</li>
	<li id="storage">
		<p>Minimum £10.00 per month inc VAT <a class="icon icon-i modal-link" data-modal-name="allocated">more info</a></p>
		<p class="color">Please note your order will not be delivered, it will be sent to secure storage.</p>
	</li>
</ul>

<p class="lock_label">To order for collection call us on 0207 889 (GOLD) 4653</p>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<?php
	/**
	 * Cart collaterals hook.
	 *
	 * @hooked woocommerce_cross_sell_display
	 * @hooked woocommerce_cart_totals - 10
	 */
	do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<div class="lock_payment">
	<div class="lock_payment_title">Payment Method</div>
	<p>Please select a payment method from below to pay for your metal. You will need to set-up a Direct Debit in order to pay for your storage on the final page.</p>
	<form id="cart-payment-form" class="lock_radio grid grid__three">
		<?php wp_nonce_field( 'ajax-payment-method-nonce', 'payment-security' ); ?>
		<label>
			<input type="radio" data-checked="stripe" name="payment_method" value="stripe" class="input__hidden" <?php checked( 'stripe', $current_payment_method ); ?>>
			<span>
				<picture><source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/svg/debit-card.svg" type="image/webp"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/svg/card.svg" alt></picture>
				Debit Card <br>(Payment limit £10,000)
			</span>
		</label>
		<label>
			<input type="radio" data-checked="stripe" name="payment_method" value="stripe" class="input__hidden">
			<span>
				<picture><source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/svg/credit-card.svg" type="image/webp"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/svg/card.svg" alt></picture>
				Credit Card <br>(Payment limit £10,000)
			</span>
		</label>
		<?php $display_bacs = false; ?>
		<?php if( $display_bacs ): ?>
			<label>
				<input type="radio" data-checked="bacs" name="payment_method" value="bacs" class="input__hidden" <?php checked( 'bacs', $current_payment_method ); ?>>
				<span>
				<picture><source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/svg/bank.svg" type="image/webp"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/svg/bank.svg" alt></picture>
				Bank Transfer <br>Deposit Required of 10%
			</span>
			</label>
		<?php endif; ?>
	</form>

	<div class="lock_payment_label">For large orders please call us on 0207 889 (GOLD) 4653 <br>between 9am - 6pm Monday to Friday.</div>

	<ul class="lock_radio_checked">
		<li id="stripe">
			<p>Pay online using a Debit card up to the value of £10,000. Debit card payments must be completed immediately for the full balance. Once the payment has been completed you may not cancel your order. This does NOT include Pre-Pay Cards. For security purposes we can only dispatch orders paid by debit and credit card to the card holder’s registered address. Please ensure the name on the card and the address it is registered to matches the name and delivery address on your order.</p>
		</li>
		<li id="bacs">
			<p>Take deposit (10%) by debit/ credit card. <br>You must initiate a Bank Transfer by the end of the next working day or your order may be cancelled. You will receive your Order Number and our Bank Details at the end of the checkout process and within your order confirmation email. As soon as we receive cleared funds we will release your order for dispatch. Bank Transfers clear between 2 hours and 4 working days depending on who you bank with</p>
		</li>
	</ul>
</div>

<div class="lock_gold">
	<div class="lock_gold_title">Please review and accept to continue with your order</div>
	<p>By ticking the checkbox below and placing your order you are committing to purchase the products at the price displayed. Please review the points made below and the terms and conditions of sale before continuing with your order.</p>
	<p><b>Cancellations</b> - As the goods supplied are dependent on fluctuations in financial markets, under the Financial Services (Distance Marketing) Regulations 2004 there is no statutory right to cancel. Any cancellations will incur a £25 termination fee plus any adverse movement in the underlying metal prices.</p>
	<p><?php echo wc_replace_policy_page_link_placeholders( 'By ticking the checkbox below you are confirming that you understand the above and agree to the <span class="hover__line-active">[terms]</span> of sale.' ); ?></p>
	<label>
		<input type="checkbox" class="input__hidden woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); // WPCS: input var ok, csrf ok. ?> id="terms" />
		<span>Yes, I understand the above and agree to the terms and conditions.</span>
	</label>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
