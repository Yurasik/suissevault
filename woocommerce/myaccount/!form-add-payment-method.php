<?php
/**
 * Add payment method form form
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-add-payment-method.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

$available_gateways = WC()->payment_gateways->get_available_payment_gateways();

if ( $available_gateways ) : ?>
	<form id="add_payment_method" class="form" method="post">
		<?php wp_nonce_field( 'suissevault-add-payment-method', 'suissevault-add-payment-method-nonce' ); ?>

		<div id="payment" class="woocommerce-Payment">
			<ul class="woocommerce-PaymentMethods payment_methods methods">
				<?php
				// Chosen Method.
				if ( count( $available_gateways ) ) {
					current( $available_gateways )->set_current();
				}

				foreach ( $available_gateways as $gateway ) { ?>
					<li class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $gateway->id ); ?> payment_method_<?php echo esc_attr( $gateway->id ); ?>">
						<div class="<?php echo ( count( $available_gateways ) == 1 )
							? "hidden"
							: ""; ?>">
							<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> />
							<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>"><?php echo wp_kses_post( $gateway->get_title() ); ?><?php echo wp_kses_post( $gateway->get_icon() ); ?></label>
						</div>

						<?php
						if ( $gateway->has_fields() || $gateway->get_description() ) {
							echo '<div class="woocommerce-PaymentBox woocommerce-PaymentBox--' . esc_attr( $gateway->id ) . ' payment_box payment_method_' . esc_attr( $gateway->id ) . '" style="display: none;">';
							$gateway->payment_fields();
							echo '</div>';
						}
						?>
					</li>
				<?php } ?>
			</ul>

			<?php do_action( 'woocommerce_add_payment_method_form_bottom' ); ?>

			<p>If you add a payment method, all future renewals will be charged on that new payment method</p>

			<div class="modal_btn">
				<button type="submit" class="woocommerce-Button woocommerce-Button--alt button btn alt" id="place_order" value="<?php esc_attr_e( 'Add payment method', 'woocommerce' ); ?>"><?php esc_html_e( 'Add new credit card', 'suissevault' ); ?></button>
			</div>
		</div>
	</form>
<?php else : ?>
	<p class="woocommerce-notice woocommerce-notice--info woocommerce-info"><?php esc_html_e( 'New payment methods can only be added during checkout. Please contact us if you require assistance.', 'woocommerce' ); ?></p>
<?php endif; ?>
