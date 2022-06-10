<?php
/**
 * Checkout Form
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$without_login = is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' );
$current_payment_method = WC()->session->get( 'chosen_payment_method' );
if ( !$current_payment_method ) {
	$current_payment_method = 'stripe';
	WC()->session->set( 'chosen_payment_method', $current_payment_method );
}
?>

<div class="checkout_net grid grid__twoo">
	<div class="checkout_form">

		<?php if ( !$without_login ): ?>
		<div class="checkout_form_tabs flex__align">
			<div class="checkout_form_tab active" data-tab="register">Register for an account here</div>
			<div class="checkout_form_tab" data-tab="login">Already a user? Log in here</div>
		</div>

		<div class="checkout_form_steps">
			<?php endif; ?>

			<?php if ( !$without_login ): ?>
				<div class="checkout_form_step form step-login" style="display: none;">
					<?php woocommerce_login_form( array(
						'message'  => esc_html__( 'If you are a registered client, enter your username / email and password, if you are not yet our client, then go to the "New customer" section and fill in the information.', 'woocommerce' ),
						'redirect' => wc_get_checkout_url(),
						'hidden'   => false,
					) ); ?>
				</div>
			<?php endif; ?>

			<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>

			<?php // If checkout registration is disabled and not logged in, the user cannot checkout.
			if ( !$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in() ) {
				echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
				return;
			} ?>

			<div class="checkout_form_step form step-register">
				<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

					<?php if ( $checkout->get_checkout_fields() ) : ?>

						<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

						<div class="col2-set" id="customer_details">
							<div class="col-1">
								<?php do_action( 'woocommerce_checkout_billing' ); ?>
							</div>

							<div class="col-2">
								<div class="shipping-wrapper" style="display: none;">
									<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

										<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

										<?php wc_cart_totals_shipping_html(); ?>

										<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

									<?php endif; ?>
								</div>

								<?php do_action( 'woocommerce_checkout_shipping' ); ?>
							</div>
						</div>

						<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

					<?php endif; ?>

					<?php do_action( 'suissevault_payment_details' ); ?>

				</form>

				<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
			</div>

			<?php if ( !$without_login ): ?>
		</div>
	<?php endif; ?>

	</div>

	<div class="checkout_info">
		<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

		<h2 id="order_review_heading">Cart totals</h2>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>

		<div class="checkout_info_edit">
			<a href="<?php echo wc_get_cart_url(); ?>" class="more-line"><?php _e( 'Edit Basket', 'suissevault' ); ?></a>
		</div>

		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

		<h2>Check payments</h2>
		<div class="checkout_payment">
			<p>Please note the following;</p>
			<ul>
				<li>All order by bank transfer require a 10% deposit by debit card (if below £10,000) or by same day/ CHAPS payment. Payment must be set up immediately to honor the price, full name or order number must be used as reference. Any payments not received within 24 hours of order being placed may be cancelled/ refunded/ redealt and subject to an administration as per our Terms.</li>
				<li>For our customers' security we can only accept card payments with cards registered with Verified by Visa or Mastercard SecureCode.</li>
				<li>For security reasons we can only dispatch debit & credit card orders to the card holder’s registered address. Please ensure the name on the card and address it is registered to matches the delivery details on your order.</li>
			</ul>
		</div>
		<div class="checkout_info_btn">
			<div id="place_order_btn" class="btn">Pay</div>
		</div>
	</div>
</div>