<?php
/**
 * Suissevault functions.
 *
 * @package suissevault
 */

if ( !function_exists( 'suissevault_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function suissevault_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' )
			? true
			: false;
	}
}

/**
 * Call a shortcode function by tag name.
 *
 * @param string $tag The shortcode whose function to call.
 * @param array $atts The attributes to pass to the shortcode function. Optional.
 * @param array $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function suissevault_do_shortcode( $tag, array $atts = array(), $content = null ) {
	global $shortcode_tags;

	if ( !isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}

/**
 * @param $id
 *
 * @return array
 */
function suissevault_get_image_data( $id ): array {

	$image_data = array();

	$image_data[ 'src' ]    = esc_attr( wp_get_attachment_image_src( $id, 'full' )[ 0 ] );
	$image_data[ 'srcset' ] = esc_attr( wp_get_attachment_image_srcset( $id ) );
	$image_data[ 'alt' ]    = esc_attr( get_post_meta( $id, '_wp_attachment_image_alt', true ) );

	return $image_data;

}

/**
 * @param $thumbnail_id
 *
 * @return string
 */
function suissevault_get_picture_html( $thumbnail_id ) {

	if ( (bool)$thumbnail_id ) {
		$image_data = suissevault_get_image_data( $thumbnail_id );
		$picture    = "<picture><source srcset='$image_data[src]' type='image/webp'><img src='$image_data[src]' alt='$image_data[alt]' srcset='$image_data[srcset]'></picture>";
	}
	else {
		$image_data = wc_placeholder_img_src();
		$picture    = "<picture><source srcset='$image_data' type='image/webp'><img src='$image_data' alt='$image_data' srcset='$image_data'></picture>";
	}

	return $picture;
}

/**
 * @param $link
 * @param $link_class
 * @param string $before_title
 * @param string $after_title
 *
 * @return string
 */
function get_acf_link_html( $link, $link_class, $before_title = "", $after_title = "" ): string {

	$link_html = "";
	if ( $link ) {
		$link_url    = $link[ 'url' ];
		$link_title  = $link[ 'title' ];
		$link_target = $link[ 'target' ]
			? $link[ 'target' ]
			: '_self';

		$link_html = "<a class='$link_class' href='" . esc_url( $link_url ) . "' target='" . esc_attr( $link_target ) . "'>$before_title" . esc_html( $link_title ) . "$after_title</a>";
	}

	return $link_html;

}

/**
 * @param $working_days
 *
 * @return array|string
 */
function abbreviated_days_of_the_week( $working_days ): string {

	$full_days_of_the_week        = [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', ' ' ];
	$abbreviated_days_of_the_week = [ 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', '' ];

	return str_replace( $full_days_of_the_week, $abbreviated_days_of_the_week, $working_days );
}


// AJAX
add_action( 'wp_ajax_suissevault_payment_method', 'suissevault_payment_method' );
add_action( 'wp_ajax_nopriv_suissevault_payment_method', 'suissevault_payment_method' );
function suissevault_payment_method() {

	check_ajax_referer( 'ajax-payment-method-nonce', 'security' );

	$response = [];

	$payment_method             = $_POST[ 'payment_method' ];
	$available_payment_gateways = WC()->payment_gateways()->get_available_payment_gateways();

	if ( isset( $available_payment_gateways[ $payment_method ] ) ) {
		WC()->session->set( 'chosen_payment_method', $payment_method );
		$response[ 'chosen_payment_method' ] = $payment_method;
	}

	wp_send_json( $response );
	die();
}

add_action( 'wp_ajax_suissevault_delivery_method', 'suissevault_delivery_method' );
add_action( 'wp_ajax_nopriv_suissevault_delivery_method', 'suissevault_delivery_method' );
function suissevault_delivery_method() {

	check_ajax_referer( 'ajax-delivery-method-nonce', 'security' );

	$response             = [];
	$cart_delivery_method = [];

	$delivery_method                  = sanitize_text_field( $_POST[ 'delivery_method' ] );
	$cart_delivery_method[ 'method' ] = $delivery_method;

	if ( $delivery_method == 'shipping' ) {
		$cart_delivery_method[ 'value' ] = sanitize_text_field( $_POST[ 'shipping_method' ] );
	}
	elseif ( $delivery_method == 'storage' ) {
		$cart_delivery_method[ 'value' ] = 'local_pickup:6';
	}

	WC()->session->set( 'chosen_shipping_methods', array( $cart_delivery_method[ 'value' ] ) );
	WC()->session->set( 'cart_delivery_method', $cart_delivery_method );
	$response[ 'cart_delivery_method' ] = $cart_delivery_method;

	wp_send_json( $response );
	die();
}

add_action( 'wp_ajax_suissevault_add_payment_method', 'suissevault_add_payment_method' );
add_action( 'wp_ajax_nopriv_suissevault_add_payment_method', 'suissevault_add_payment_method' );
function suissevault_add_payment_method() {

	wc_nocache_headers();

	check_ajax_referer( 'suissevault-add-payment-method', 'security' );

	$response = [];

	// Test rate limit.
	$current_user_id = get_current_user_id();
	$rate_limit_id   = 'add_payment_method_' . $current_user_id;
	$delay           = (int)apply_filters( 'woocommerce_payment_gateway_add_payment_method_delay', 20 );

	if ( WC_Rate_Limiter::retried_too_soon( $rate_limit_id ) ) {
		wc_add_notice( sprintf( /* translators: %d number of seconds */ _n( 'You cannot add a new payment method so soon after the previous one. Please wait for %d second.', 'You cannot add a new payment method so soon after the previous one. Please wait for %d seconds.', $delay, 'woocommerce' ), $delay ), 'error' );
		//return_response_notices();
		var_dump( 'WC_Rate_Limiter' );
		wp_die();
	}

	WC_Rate_Limiter::set_rate_limit( $rate_limit_id, $delay );

	ob_start();

	$payment_method_id  = wc_clean( wp_unslash( $_POST[ 'payment_method' ] ) );
	$available_gateways = WC()->payment_gateways->get_available_payment_gateways();

	if ( isset( $available_gateways[ $payment_method_id ] ) ) {
		$gateway = $available_gateways[ $payment_method_id ];

		if ( !$gateway->supports( 'add_payment_method' ) && !$gateway->supports( 'tokenization' ) ) {
			wc_add_notice( __( 'Invalid payment gateway.', 'woocommerce' ), 'error' );
			//return_response_notices();
			var_dump( 'add_payment_method' );
			wp_die();
		}

		$gateway->validate_fields();

		if ( wc_notice_count( 'error' ) > 0 ) {
			//return_response_notices();
			var_dump( 'wc_notice_count' );
			wp_die();
		}

		$result = $gateway->add_payment_method();
		var_dump( $result );
		wp_die();

		if ( 'success' === $result[ 'result' ] ) {
			wc_add_notice( __( 'Payment method successfully added.', 'woocommerce' ) );
		}

		if ( 'failure' === $result[ 'result' ] ) {
			wc_add_notice( __( 'Unable to add payment method to your account.', 'woocommerce' ), 'error' );
		}

		if ( !empty( $result[ 'redirect' ] ) ) {
			wp_redirect( $result[ 'redirect' ] ); //phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
			exit();
		}
	}

	wp_send_json( $response );
	die();
}
function return_response_notices() {

	$notices = wc_get_notices();
	//wc_clear_notices();

	wp_send_json( $notices );
	die();
}

