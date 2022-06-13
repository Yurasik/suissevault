<?php defined( 'ABSPATH' ) || exit; ?>

<?php do_action( 'woocommerce_before_change_password_form' ); ?>

	<h2 class="title">Change Password</h2>

	<form class="change-password form" action="" method="post">
		<?php wp_nonce_field( 'save_changed_password', 'save-changed-password-nonce' ); ?>
		<input type="hidden" name="action" value="save_changed_password"/>

		<div class="grid grid__twoo">
			<div class="form_wrapper">
				<div class="form_label"><?php esc_html_e( 'Old password', 'woocommerce' ); ?></div>
				<div class="input">
					<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off"/>
				</div>
			</div>
		</div>
		<div class="grid grid__twoo">
			<div class="form_wrapper">
				<div class="form_label"><?php esc_html_e( 'New password', 'woocommerce' ); ?></div>
				<div class="input">
					<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off"/>
				</div>
			</div>
			<div class="form_wrapper">
				<div class="form_label"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></div>
				<div class="input">
					<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off"/>
				</div>
			</div>
		</div>

		<button type="submit" class="woocommerce-Button button btn btn-line" name="save_changed_password" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
	</form>

<?php do_action( 'woocommerce_after_change_password_form' );
