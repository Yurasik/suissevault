<?php
/**
 * @param string $currency
 *
 * @return false|mixed
 */
function api_price_main( $currency = 'GBP' ) {

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

	if ( !$result )
		return false;

	return $result->items[ 0 ];
}

/**
 * @return false|mixed
 */
function api_price_additional() {

	$curl = curl_init();
	curl_setopt_array( $curl, array(
		CURLOPT_URL            => 'https://prices.lbma.org.uk/json/gold_pm.json',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING       => '',
		CURLOPT_MAXREDIRS      => 10,
		CURLOPT_TIMEOUT        => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST  => 'GET',
	) );
	$response = curl_exec( $curl );
	curl_close( $curl );

	$gold_result = json_decode( $response );
	if ( !$gold_result )
		return false;

	$curl = curl_init();
	curl_setopt_array( $curl, array(
		CURLOPT_URL            => 'https://prices.lbma.org.uk/json/silver.json',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING       => '',
		CURLOPT_MAXREDIRS      => 10,
		CURLOPT_TIMEOUT        => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST  => 'GET',
	) );
	$response = curl_exec( $curl );
	curl_close( $curl );

	$silver_result = json_decode( $response );
	if ( !$silver_result )
		return false;

	$result[ 'gold' ] = $gold_result[ count( $gold_result ) - 1 ];
	$result[ 'silver' ] = $silver_result[ count( $silver_result ) - 1 ];

	return $result;
}

/**
 * @param string $currency
 * @param int $attempt
 *
 * @return false|mixed
 */
function get_api_price( $currency = 'GBP', $attempt = 0 ) {

	$api_price = api_price_main( $currency );

	if ( !$api_price ) {
		$option_api_price_main_data = get_option( 'api_price_main_data' );
		$option_api_price_additional_data = get_option( 'api_price_additional_data' );
		$api_price = ( $option_api_price_main_data->updated_time > $option_api_price_additional_data->updated_time ) ? $option_api_price_main_data->$currency : $option_api_price_additional_data->$currency;
	}

	return $api_price;

}

/**
 * @param $api_price
 * @param $product
 *
 * @return array
 */
function get_dynamic_price( $api_price, $product ) {

	$result = [];

	// Product data
	$markup_percentage = ( get_field( 'markup_percentage', $product->get_id() ) ) ? : 0;
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

/**
 * @param $term_id
 *
 * @return int
 */
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

/**
 * @return float|int
 */
function get_checkout_time_limit() {
	return 5 * 60; // 5 minutes
}

/**
 * @return array|float|int|string
 */
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

		if ( wp_doing_ajax() ) {
			global $woocommerce;
			$woocommerce->cart->empty_cart();
			wc_add_notice( '<div class="woocommerce-error">' . __( 'Sorry, time to buy with a locked price is over.', 'woocommerce' ) . ' <a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="wc-backward">' . __( 'Return to shop', 'woocommerce' ) . '</a></div>', 'error' );
		}
		else {
			wp_safe_redirect( esc_url( wc_get_cart_url() ) );
			exit();
		}
	}

	return $time_left;
}

/**
 * @return bool
 */
function is_storage() {

	$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );

	return ( $chosen_shipping_methods[ 0 ] == 'local_pickup:6' );

}

/**
 * @return int[]
 */
function get_quantities_discount() {

	return [
		1  => 0,
		2  => 1,
		5  => 2,
		10 => 3,
		20 => 5
	];
}

/**
 * @param $product
 * @param $current_quantity
 * @param $api_price
 *
 * @return float|int|mixed
 */
function get_quantity_discount_price( $product, $current_quantity, $api_price ) {

	$quantities_discount = get_quantities_discount();
	$dynamic_price = get_dynamic_price( $api_price, $product );
	$discount_price = $dynamic_price[ 'price' ];

	foreach ( $quantities_discount as $quantity => $discount ) {
		if ( $current_quantity >= $quantity ) {
			$discount_for_price = $dynamic_price[ 'price' ] / 100 * $discount;
			$discount_price = $dynamic_price[ 'price' ] - $discount_for_price;

			if ( $current_quantity == $quantity ) {
				continue;
			}
		}
		else {
			continue;
		}
	}

	return $discount_price;
}

/**
 * @return string[]
 */
function get_currencies() {
	return [
		'GBP',
		'USD',
		'EUR'
	];
}

$dynamic_price_route_needed = false;
if ( $dynamic_price_route_needed ) {
	/**
	 * Register new route for cron task
	 */
	add_action( 'init', 'dynamic_price_route' );
	function dynamic_price_route() {

		add_rewrite_rule( '^(dynamic-price)/([^/]+)/?$', 'index.php?request=$matches[1]&action=$matches[2]', 'top' );

		add_filter( 'query_vars', function ( $vars ) {
			$vars[] = 'request';
			$vars[] = 'action';

			return $vars;
		} );
	}

	// Route for Cron task
	add_action( "template_redirect", 'dynamic_price_route_template_redirect' );
	function dynamic_price_route_template_redirect() {
		$request = get_query_var( 'request' );
		$action = get_query_var( 'action' );

		if ( $request && $request == 'dynamic-price' && false ) {
			if ( $action == 'update' ) {
				$api_price_additional = api_price_additional();
				$api_price_main_data = (object)array(
					'updated_time' => time()
				);
				$api_price_additional_data = (object)array(
					'updated_time' => strtotime( $api_price_additional[ 'gold' ]->d )
				);

				$currencies = get_currencies();
				$api_price_additional_data_currency_key = 1; // 0 => USD, 1 => GBP, 2 => EUR
				foreach ( $currencies as $key => $currency ) {
					$api_price_main = api_price_main( $currency );

					if ( $currency == 'USD' ) {
						$api_price_additional_data_currency_key = 0;
					}
					elseif ( $currency == 'EUR' ) {
						$api_price_additional_data_currency_key = 2;
					}

					$api_price_main_data->$currency = $api_price_main;
					$api_price_additional_data->$currency = [
						'curr'     => $currency,
						'xauPrice' => $api_price_additional[ 'gold' ]->v[ $api_price_additional_data_currency_key ],
						'xagPrice' => $api_price_additional[ 'silver' ]->v[ $api_price_additional_data_currency_key ],
						'chgXau'   => 0,
						'chgXag'   => 0,
						'pcXau'    => 0,
						'pcXag'    => 0,
						'xauClose' => $api_price_additional[ 'gold' ]->v[ $api_price_additional_data_currency_key ],
						'xagClose' => $api_price_additional[ 'silver' ]->v[ $api_price_additional_data_currency_key ],
					];
				}

				update_option( 'api_price_main_data', $api_price_main_data );
				update_option( 'api_price_additional_data', $api_price_additional_data );
			}
		}

	}
}

// Preservation of spare dynamic prices in case of API failure
function dynamic_price_cron() {

	$api_price_main_gbp = api_price_main();
	if ( $api_price_main_gbp ) {
		$api_price_main_data = (object)array(
			'updated_time' => time()
		);
		$current_api_price_main_data = get_option( 'api_price_main_data' );
	}

	$api_price_additional = api_price_additional();
	if ( $api_price_additional ) {
		$api_price_additional_data = (object)array(
			'updated_time' => strtotime( $api_price_additional[ 'gold' ]->d )
		);
		$api_price_additional_data_currency_key = 1; // 0 => USD, 1 => GBP, 2 => EUR
	}

	if ( $api_price_additional || $api_price_main_gbp ) {
		foreach ( get_currencies() as $key => $currency ) {
			if ( $api_price_main_gbp ) {
				$api_price_main = api_price_main( $currency );
				if ( $api_price_main ) {
					$api_price_main_data->$currency = $api_price_main;
				}
				else {
					$api_price_main_data->$currency = $current_api_price_main_data->$currency;
				}
			}

			if ( $api_price_additional ) {
				if ( $currency == 'USD' ) {
					$api_price_additional_data_currency_key = 0;
				}
				elseif ( $currency == 'EUR' ) {
					$api_price_additional_data_currency_key = 2;
				}
				$api_price_additional_data->$currency = [
					'curr'     => $currency,
					'xauPrice' => $api_price_additional[ 'gold' ]->v[ $api_price_additional_data_currency_key ],
					'xagPrice' => $api_price_additional[ 'silver' ]->v[ $api_price_additional_data_currency_key ],
					'chgXau'   => 0,
					'chgXag'   => 0,
					'pcXau'    => 0,
					'pcXag'    => 0,
					'xauClose' => $api_price_additional[ 'gold' ]->v[ $api_price_additional_data_currency_key ],
					'xagClose' => $api_price_additional[ 'silver' ]->v[ $api_price_additional_data_currency_key ],
				];
			}
		}

		if ( $api_price_main_gbp ) {
			update_option( 'api_price_main_data', $api_price_main_data );
		}

		if ( $api_price_additional ) {
			update_option( 'api_price_additional_data', $api_price_additional_data );
		}
	}
}

if ( !wp_next_scheduled( 'suissevault_cron_hook' ) ) {
	wp_schedule_event( time(), 'twicedaily', 'suissevault_cron_hook' );
}

function suissevault_cron_hook() {
	dynamic_price_cron();
}