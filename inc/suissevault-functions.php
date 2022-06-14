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
 * @param $image_data
 *
 * @return string
 */
function suissevault_get_picture_html( $image_data ): string {

	return "<picture><source srcset='$image_data[src]' type='image/webp'><img src='$image_data[src]' alt='$image_data[alt]' srcset='$image_data[srcset]'></picture>";
}

function suissevault_get_placeholder_picture_html() {

	$image = wc_placeholder_img_src();

	return "<picture><source srcset='$image' type='image/webp'><img src='$image' alt='$image' srcset='$image'></picture>";
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