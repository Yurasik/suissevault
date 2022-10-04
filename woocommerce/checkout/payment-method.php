<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
	<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

	<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
		<?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?> <?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
	</label>

	<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<?php if( $gateway->id == 'stripe'): ?>
			<h2 class="payment-title">Payment Details</h2>

			<?php $display_card_type = false; ?>
			<?php if( $display_card_type ): ?>
				<div class="form_wrapper">
					<div class="form_label">Card Type *</div>
					<div class="grid grid__twoo">
						<label>
							<input type="radio" name="stripe_card_type" value="visa" class="input__hidden" checked required>
							<span>Visa</span>
						</label>
						<label>
							<input type="radio" name="stripe_card_type" value="mastercard" class="input__hidden">
							<span>Mastercard</span>
						</label>
						<label>
							<input type="radio" name="stripe_card_type" value="maestro_uk" class="input__hidden">
							<span>Maestro UK</span>
						</label>
						<label>
							<input type="radio" name="stripe_card_type" value="maestro_int" class="input__hidden">
							<span>Maestro Int.</span>
						</label>
					</div>
				</div>
			<?php endif; ?>

		<?php endif; ?>
		<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>
</li>
