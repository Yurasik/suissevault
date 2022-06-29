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
		return class_exists( 'WooCommerce' ) ? true : false;
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

	$image_data[ 'src' ] = esc_attr( wp_get_attachment_image_src( $id, 'full' )[ 0 ] );
	$image_data[ 'srcset' ] = esc_attr( wp_get_attachment_image_srcset( $id ) );
	$image_data[ 'alt' ] = esc_attr( get_post_meta( $id, '_wp_attachment_image_alt', true ) );

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
		$picture = "<picture><source srcset='$image_data[src]' type='image/webp'><img src='$image_data[src]' alt='$image_data[alt]' srcset='$image_data[srcset]'></picture>";
	}
	else {
		$image_data = wc_placeholder_img_src();
		$picture = "<picture><source srcset='$image_data' type='image/webp'><img src='$image_data' alt='$image_data' srcset='$image_data'></picture>";
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
		$link_url = $link[ 'url' ];
		$link_title = $link[ 'title' ];
		$link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';

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

	$full_days_of_the_week = [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', ' ' ];
	$abbreviated_days_of_the_week = [ 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', '' ];

	return str_replace( $full_days_of_the_week, $abbreviated_days_of_the_week, $working_days );
}

function suissevault_is_checkout() {
	$checkout_path = wp_parse_url( wc_get_checkout_url(), PHP_URL_PATH );
	$current_url_path = wp_parse_url( "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", PHP_URL_PATH );

	return ( $checkout_path !== null && $current_url_path !== null && trailingslashit( $checkout_path ) === trailingslashit( $current_url_path ) );
}

function get_api_price( $currency = 'GBP', $with_date = false ) {

	$curl = curl_init();

	curl_setopt_array( $curl, array(
		CURLOPT_URL            => "https://data-asg.goldprice.org/dbXRates/$currency",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING       => '',
		CURLOPT_MAXREDIRS      => 10,
		CURLOPT_TIMEOUT        => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST  => 'GET',
		CURLOPT_HTTPHEADER     => array(
			'Cookie: lagrange_session=0c8e58e6-1996-4c54-8459-21163c876d4b'
		),
	) );

	$response = curl_exec( $curl );

	curl_close( $curl );

	$result = json_decode( $response );

	return ( $with_date ) ? $result : $result->items[ 0 ];

}

function get_dynamic_price( $api_price, $product ) {

	$result = [];

	// Product data
	$markup_percentage = ( get_field( 'markup_percentage', $product ) ) ? : 0;
	$weight = $product->get_attribute( 'Weight' );
	$metal = $product->get_attribute( 'Metal' );
	$weight_number = (int)preg_replace( '/[^\d+]/', '', $weight );
	$weight_symbol = str_replace( $weight_number, '', $weight );
	$exploded_weight = explode( '/', $weight );
	if ( count( $exploded_weight ) > 1 ) {
		$weight_number = (int)preg_replace( '/[^\d+]/', '', $exploded_weight[ 0 ] ) / (int)preg_replace( '/[^\d+]/', '', $exploded_weight[ 1 ] );
	}
	$price = ( $metal == 'Gold' ) ? $api_price->xauPrice : $api_price->xagPrice;

	// Weight
	if ( $weight_symbol == 'g' ) {
		$price = $price / 28.3495231 * $weight_number;
	}
	elseif ( $weight_symbol == 'kg' ) {
		$price = $price * 35.2739619 * $weight_number;
	}
	else {
		$price = $price * $weight_number;
	}

	// Markup
	$price = ( !$markup_percentage ) ? $price : $price + ( $price / 100 * $markup_percentage );
	$price_inc_vat = $price;

	// VAT
	$tax_rate_number = 0;
	if ( $product->get_tax_status() == 'taxable' ) {
		$tax_rates = WC_Tax::get_rates( $product->get_tax_class() );
		if ( !empty( $tax_rates ) ) {
			$tax_rate = reset( $tax_rates );
			$tax_rate_number = $tax_rate[ 'rate' ];
		}
	}
	if ( $tax_rate_number ) {
		$price_inc_vat = $price + ( $price / 100 * $tax_rate_number );
	}

	$result[ 'price' ] = $price;
	$result[ 'price_inc_vat' ] = $price_inc_vat;
	$result[ 'vat' ] = $tax_rate_number;

	return $result;
}

function get_min_dynamic_price_by_cat( $term_id ) {

	$api_price = get_api_price();
	$cat_products = new WP_Query( [
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'tax_query'      => [
			[
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $term_id,
				'operator' => 'IN'
			]
		]
	] );

	$min_price = 0;
	if ( $cat_products->have_posts() ) {
		while ( $cat_products->have_posts() ) {
			$cat_products->the_post();
			$product_id = get_the_ID();
			$product = wc_get_product( $product_id );
			$dynamic_price = get_dynamic_price( $api_price, $product );

			$min_price_conditions = $min_price == 0 || $min_price > $dynamic_price[ 'price_inc_vat' ] && $dynamic_price[ 'price_inc_vat' ] != 0;
			$min_price = ( $min_price_conditions ) ? $dynamic_price[ 'price_inc_vat' ] : $min_price;
		}
		wp_reset_postdata();
	}

	return $min_price;
}

function get_checkout_time_limit() {
	return 5 * 60; // 5 minutes
}

function checkout_time() {

	$time_limit = get_checkout_time_limit();

	if ( !$api_price_time = WC()->session->get( 'api_price_time' ) )
		return $time_limit;

	$current_time = time();
	$time_passed = $current_time - $api_price_time;
	$time_left = $time_limit - $time_passed;

	if ( $time_left < 0 ) {
		WC()->session->__unset( 'api_price' );
		WC()->session->__unset( 'api_price_time' );
		wp_safe_redirect( esc_url( wc_get_cart_url() ) );
		die();
	}

	return $time_left;
}

// AJAX
add_action( 'wp_ajax_suissevault_payment_method', 'suissevault_payment_method' );
add_action( 'wp_ajax_nopriv_suissevault_payment_method', 'suissevault_payment_method' );
function suissevault_payment_method() {

	check_ajax_referer( 'ajax-payment-method-nonce', 'security' );

	$response = [];

	$payment_method = $_POST[ 'payment_method' ];
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

	$response = [];
	$cart_delivery_method = [];

	$delivery_method = sanitize_text_field( $_POST[ 'delivery_method' ] );
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

add_action( 'wp_ajax_live_price_filter', 'live_price_filter' );
add_action( 'wp_ajax_nopriv_live_price_filter', 'live_price_filter' );
function live_price_filter() {

	$response = [];

	$currency = sanitize_text_field( $_POST[ 'currency' ] );
	$weight = sanitize_text_field( $_POST[ 'weight' ] );

	$api_price = get_api_price( $currency );

	ob_start();
	get_template_part( 'template-parts/ajax/live', 'price', [ 'api_price' => $api_price, 'weight' => $weight ] );
	$response[ 'live_content_steps_html' ] = ob_get_clean();

	wp_send_json( $response );
	die();
}

add_action( 'wp_ajax_header_price', 'header_price' );
add_action( 'wp_ajax_nopriv_header_price', 'header_price' );
function header_price() {

	$response = [];

	$currency = sanitize_text_field( $_POST[ 'currency' ] );
	$metal = sanitize_text_field( $_POST[ 'metal' ] );

	$api_price = get_api_price( $currency );

	session_start();
	$_SESSION[ 'suissevault_api_metal' ] = $metal;
	$_SESSION[ 'suissevault_api_currency' ] = $currency;

	ob_start();
	get_template_part( 'template-parts/ajax/header', 'price', [ 'api_price' => $api_price, 'metal' => $metal ] );
	$response[ 'header_price_html' ] = ob_get_clean();

	wp_send_json( $response );
	die();
}

add_action( 'wp_ajax_dynamic_price', 'dynamic_price' );
add_action( 'wp_ajax_nopriv_dynamic_price', 'dynamic_price' );
function dynamic_price() {

	$response = [];
	$api_price = get_api_price();
	$products = wc_get_products( [
		'limit'  => -1,
		'status' => 'publish'
	] );

	foreach ( $products as $product ) {
		$dynamic_price = get_dynamic_price( $api_price, $product );
		$response[ $product->get_id() ] = [
			'price'         => wc_price( $dynamic_price[ 'price' ] ),
			'price_inc_vat' => wc_price( $dynamic_price[ 'price_inc_vat' ] ),
			'vat'           => number_format( $dynamic_price[ 'vat' ], 2 ),
			'valid'         => true
		];
	}

	if ( isset( $_POST[ 'quantities_discount' ] ) && intval( $_POST[ 'quantities_discount' ] ) ) {
		$product_id = intval( $_POST[ 'product_id' ] );
		$product = wc_get_product( $product_id );
		ob_start();
		get_template_part( 'template-parts/ajax/quantities', 'discount', [ 'api_price' => $api_price, 'product' => $product ] );
		$response[ 'quantities_discount_html' ] = ob_get_clean();
	}

	wp_send_json( $response );
	die();
}

add_action( 'wp_ajax_dynamic_min_price', 'dynamic_min_price' );
add_action( 'wp_ajax_nopriv_dynamic_min_price', 'dynamic_min_price' );
function dynamic_min_price() {

	$response = [];

	$terms = get_terms( [
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
	] );

	foreach ( $terms as $term ) {
		$min_dynamic_price_by_cat = get_min_dynamic_price_by_cat( $term->term_id );
		$response[ $term->term_id ] = [
			'price' => "from " . wc_price( $min_dynamic_price_by_cat )
		];
	}

	wp_send_json( $response );
	die();
}
