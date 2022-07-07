<?php
$current_url = ( isset( $_SERVER[ 'HTTPS' ] ) ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$is_payment_methods = wc_get_endpoint_url( 'payment-methods' ) == $current_url;
$is_billing = wc_get_endpoint_url( 'payment-methods', 'billing' ) == $current_url;

if ( is_account_page() && is_user_logged_in() && ( $is_payment_methods || $is_billing ) ) : ?>
	<!-- Modal-payment. -->
	<div class="modal modal-payment">
		<div class="modal_wrapper">
			<div class="modal_top">
				<span class="close"></span> Add payment method
			</div>
			<div class="modal_scroll">
				<?php wc_get_template( 'myaccount/form-add-payment-method.php' ); ?>
			</div>
		</div>
		<div class="modal_viel"></div>
	</div>
	<!-- Modal-payment. -->

	<!-- Modal-billing. -->
	<div class="modal modal-billing">
		<div class="modal_wrapper">
			<div class="modal_top">
				<span class="close"></span> Edit Billing Address
			</div>
			<div class="modal_scroll">
				<?php woocommerce_account_edit_address( 'billing' ); ?>
			</div>
		</div>
		<div class="modal_viel"></div>
	</div>
	<!-- Modal-billing. -->
<?php endif; ?>