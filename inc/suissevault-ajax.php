<?php

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