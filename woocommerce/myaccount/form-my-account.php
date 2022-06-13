<?php defined( 'ABSPATH' ) || exit; ?>

<div class="cabinet_content cabinet_account">
	<?php do_action( 'suissevault_account_content_notices' ); ?>

	<?php do_action( 'woocommerce_before_my_account_form' ); ?>

	<h2 class="title">My Account</h2>

	<form class="my-account form" action="" method="post">
		<?php wp_nonce_field( 'save_my_account', 'save-my-account-nonce' ); ?>
		<input type="hidden" name="action" value="save_my_account"/>

		<div class="grid grid__twoo">
			<div class="woocommerce-form-row form_wrapper">
				<div class="form_label"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></div>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>"/>
			</div>
			<div class="woocommerce-form-row form_wrapper">
				<div class="form_label"><?php esc_html_e( 'Email', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></div>
				<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>"/>
			</div>
			<div class="woocommerce-form-row form_wrapper">
				<div class="form_label"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></div>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>"/>
			</div>
			<div class="woocommerce-form-row form_wrapper">
				<div class="form_label"><?php esc_html_e( 'Phone', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></div>
				<input type="tel" class="woocommerce-Input woocommerce-Input--tel input-text" name="account_billing_phone" id="account_billing_phone" value="<?php echo esc_attr( $user->billing_phone ); ?>"/>
			</div>
		</div>
		<button type="submit" class="woocommerce-Button button btn btn-line" name="save_my_account" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
	</form>

	<?php do_action( 'woocommerce_after_my_account_form' ); ?>
</div>
