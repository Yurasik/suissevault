<?php
/**
 * WooCommerce Template Functions.
 *
 * @package suissevault
 */
function remove_bacs_from_thank_you_page() {
	if ( ! function_exists( 'WC' ) ) {
		return;
	}
	$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
	$gateway = isset( $available_gateways['bacs'] ) ? $available_gateways['bacs'] : false;
	if ( false == $gateway ) {
		return;
	}
	remove_action( 'woocommerce_thankyou_bacs', array( $gateway, 'thankyou_page' ) );
    add_action( 'woocommerce_thankyou_bacs', function($order_id){
        include __DIR__.'/class-wc-gateway-bacs.php';
    });
}
if ( !function_exists( 'suissevault_customer_login_redirect' ) ) {
	function suissevault_customer_login_redirect( $redirect, $user ) {

		if ( wc_user_has_role( $user, 'customer' ) ) {
			$redirect = get_home_url(); // homepage
			//$redirect = wc_get_page_permalink( 'shop' ); // shop page
			//$redirect = '/custom_url'; // custom URL same site
			//$redirect = 'https://custom.url'; // custom URL other site
			//$redirect = add_query_arg( 'password-reset', 'true', wc_get_page_permalink( 'myaccount' ) ); // custom My Account tab
		}

		return $redirect;
	}
}

if ( !function_exists( 'suissevault_woo_cart_available' ) ) {
	/**
	 * Validates whether the Woo Cart instance is available in the request
	 *
	 * @return bool
	 * @since 2.6.0
	 */
	function suissevault_woo_cart_available() {
		$woo = WC();
		return $woo instanceof \WooCommerce && $woo->cart instanceof \WC_Cart;
	}
}

if ( !function_exists( 'suissevault_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @return  void
	 */
	function suissevault_before_content() {
		if ( is_single() ) {
			echo '<div class="page buy_name"><div class="bone">';
		}
		else {
			echo '<div class="page buy"><div class="bone">';
		}
	}
}

if ( !function_exists( 'suissevault_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @return  void
	 */
	function suissevault_after_content() {
		?>
		</div>
		</div>
		<?php
		do_action( 'suissevault_sidebar' );
	}
}

if ( !function_exists( 'suissevault_breadcrumb' ) ) {
	function suissevault_breadcrumb() {
		get_template_part( 'template-parts/breadcrumbs' );
	}
}

if ( !function_exists( 'suissevault_shop_messages' ) ) {
	/**
	 * suissevault shop messages
	 *
	 * @since   1.4.4
	 * @uses    suissevault_do_shortcode
	 */
	function suissevault_shop_messages() {
		if ( !is_checkout() ) {
			echo wp_kses_post( suissevault_do_shortcode( 'woocommerce_messages' ) );
		}
	}
}

if ( !function_exists( 'suissevault_template_loop_product_thumbnail' ) ) {

	/**
	 * Get the product thumbnail for the loop.
	 */
	function suissevault_template_loop_product_thumbnail() {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<div class="buy_content_item_img">' . woocommerce_get_product_thumbnail() . '</div>';
	}
}

if ( !function_exists( 'suissevault_product_stock_status' ) ) {
	function suissevault_product_stock_status() {

		global $product;
		echo wc_get_stock_html( $product );
	}
}

if ( !function_exists( 'suissevault_show_product_images' ) ) {

	/**
	 * Get the product thumbnail for the loop.
	 */
	function suissevault_show_product_images() {
		global $product;
		$thumbnail_id = $product->get_image_id();
		$attachment_ids = $product->get_gallery_image_ids();
		?>
		<div class="buy_name_left">
			<div class="btn icon icon-play">watch video</div>
			<div class="active_slider">
				<?php
				if ( $thumbnail_id ) {
					echo suissevault_get_picture_html( $thumbnail_id );
				}
				if ( $attachment_ids ) {
					foreach ( $attachment_ids as $attachment_id ) {
						echo suissevault_get_picture_html( $attachment_id );
					}
				} ?>
			</div>
			<div class="slider">
				<?php
				if ( $thumbnail_id ) {
					echo "<div class='slid'>" . suissevault_get_picture_html( $thumbnail_id ) . "</div>";
				}
				if ( $attachment_ids ) {
					foreach ( $attachment_ids as $attachment_id ) {
						echo "<div class='slid'>" . suissevault_get_picture_html( $attachment_id ) . "</div>";
					}
				} ?>
			</div>
		</div>
		<?php
	}
}

if ( !function_exists( 'suissevault_before_quantity_input_field' ) ) {

	function suissevault_before_quantity_input_field() {
		echo '<div class="amount flex__align"><div class="amount_btn amount__subtract"></div>';
	}
}

if ( !function_exists( 'suissevault_after_quantity_input_field' ) ) {

	function suissevault_after_quantity_input_field() {
		echo '<div class="amount_btn amount__add"></div></div>';
	}
}

if ( !function_exists( 'suissevault_quantities_list' ) ) {

	function suissevault_quantities_list() {

		global $product;
		$api_price = get_api_price();

		get_template_part( 'template-parts/ajax/quantities', 'discount', [ 'api_price' => $api_price, 'product' => $product ] );
	}
}

if ( !function_exists( 'suissevault_terms_delivery_tab' ) ) {

	function suissevault_terms_delivery_tab( $tabs ) {

		$tabs[ 'terms_delivery' ] = array(
			'title'    => __( 'Terms & Delivery', 'suissevault' ),
			'callback' => 'suissevault_terms_delivery_tab_callback'
		);

		$tabs[ 'additional_information' ][ 'priority' ] = 10;
		$tabs[ 'description' ][ 'priority' ] = 20;
		$tabs[ 'terms_delivery' ][ 'priority' ] = 30;

		return $tabs;
	}

	function suissevault_terms_delivery_tab_callback( $tab_name, $args ) {

		$product_terms_delivery_text = get_field( 'product_terms_delivery_text', 'options' );

		echo "<h6>$args[title]</h6>";
		echo "<div>$product_terms_delivery_text</div>";
	}

}

if ( !function_exists( 'suissevault_related_products_args' ) ) {

	function suissevault_related_products_args( $args ) {

		$args[ 'posts_per_page' ] = 3;
		$args[ 'columns' ] = 1;

		return $args;
	}

}

if ( !function_exists( 'suissevault_header_cart_link' ) ) {
	function suissevault_header_cart_link() {
		if ( !suissevault_woo_cart_available() ) {
			return;
		}
		?>
		<a class="header_href_cart cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'suissevault' ); ?>">
			<span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
			<svg width="21" height="24" viewbox="0 0 21 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M20.4406 23.2112L18.6453 5.84052C18.6076 5.47687 18.3059 5.20074 17.9461 5.20074H14.5717V4.41907C14.5717 1.98248 12.6205 0 10.2223 0C7.82398 0 5.87277 1.98248 5.87277 4.41907V5.20074H2.49838C2.13849 5.20074 1.83681 5.47687 1.79914 5.84052L0.00381699 23.2112C-0.016908 23.4124 0.0474295 23.6133 0.18061 23.7638C0.313971 23.9141 0.50392 24 0.703059 24H19.7412C19.9405 24 20.1305 23.9141 20.2636 23.7638C20.3972 23.6133 20.4613 23.4124 20.4406 23.2112ZM7.27882 4.41907C7.27882 2.7702 8.59927 1.42859 10.2223 1.42859C11.8452 1.42859 13.1656 2.7702 13.1656 4.41907V5.20074H7.27882V4.41907ZM1.48376 22.5714L3.13149 6.62933H5.87277V8.20349C5.87277 8.5979 6.18761 8.91779 6.5758 8.91779C6.96398 8.91779 7.27882 8.5979 7.27882 8.20349V6.62933H13.1656V8.20349C13.1656 8.5979 13.4805 8.91779 13.8686 8.91779C14.2568 8.91779 14.5717 8.5979 14.5717 8.20349V6.62933H17.313L18.9607 22.5714H1.48376Z" fill="#D2D1CF"/>
			</svg>
		</a>
		<?php
	}
}

if ( !function_exists( 'suissevault_price_filter' ) ) {
	function suissevault_price_filter( $price ) {
		if ( /*is_checkout() || is_cart()*/ true ) {
			$price = str_replace( [
				'<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">',
				'</span>',
				'</bdi>'
			], [ '' ], $price );
		}

		return $price;
	}
}

if ( !function_exists( 'suissevault_totals_order_total_html_filter' ) ) {
	function suissevault_totals_order_total_html_filter( $price ) {
		if ( is_checkout() || is_cart() ) {
			$price = str_replace( [
				'<strong>',
				'</strong>',
			], [ '' ], $price );
		}

		return $price;
	}
}

if ( !function_exists( 'suissevault_product_stock_status_options' ) ) {
	function suissevault_product_stock_status_options( $status ) {

		$status[ 'onbackorder' ] = __( 'On back order', 'suissevault' );
		$status[ 'awaitingstock' ] = __( 'Awaiting stock', 'suissevault' );

		return $status;
	}
}

if ( !function_exists( 'suissevault_save_custom_stock_status' ) ) {
	function suissevault_save_custom_stock_status( $product_id ) {
		update_post_meta( $product_id, '_stock_status', wc_clean( $_POST[ '_stock_status' ] ) );
	}
}

if ( !function_exists( 'suissevault_product_is_in_stock' ) ) {
	function suissevault_product_is_in_stock( $is_in_stock, $product ) {

		if ( $product->get_stock_status() == 'awaitingstock' ) {
			$is_in_stock = false;
		}

		return $is_in_stock;
	}
}

if ( !function_exists( 'suissevault_get_availability_text' ) ) {
	function suissevault_get_availability_text( $availability, $product ) {

		switch ( $product->get_stock_status() ) {
			case 'awaitingstock':
				$availability = __( 'Awaiting stock', 'woocommerce' );
				break;
		}

		return $availability;
	}
}

if ( !function_exists( 'suissevault_get_availability_class' ) ) {
	function suissevault_get_availability_class( $class, $product ) {

		switch ( $product->get_stock_status() ) {
			case 'awaitingstock':
				$class = 'awaiting-stock';
				break;
		}

		return $class;
	}
}

if ( !function_exists( 'suissevault_admin_stock_html' ) ) {
	function suissevault_admin_stock_html( $stock_html, $product ) {

		// Simple
		if ( $product->is_type( 'simple' ) ) {
			// Get stock status
			$product_stock_status = $product->get_stock_status();
			// Variable
		}
		elseif ( $product->is_type( 'variable' ) ) {
			foreach ( $product->get_visible_children() as $variation_id ) {
				// Get product
				$variation = wc_get_product( $variation_id );

				// Get stock status
				$product_stock_status = $variation->get_stock_status();

				/*
				Currently the status of the last variant in the loop will be displayed.

				So from here you need to add your own logic, depending on what you expect from your custom stock status.

				By default, for the existing statuses. The status displayed on the admin products list table for variable products is determined as:

				- Product should be in stock if a child is in stock.
				- Product should be out of stock if all children are out of stock.
				- Product should be on backorder if all children are on backorder.
				- Product should be on backorder if at least one child is on backorder and the rest are out of stock.
				*/
			}
		}

		// Stock status
		switch ( $product_stock_status ) {
			case 'awaitingstock':
				$stock_html = '<mark class="awaitingstock" style="font-weight: 700; background: transparent none; line-height: 1; color: #004eff;">' . __( 'Awaiting stock', 'suissevault' ) . '</mark>';
				break;
		}

		return $stock_html;
	}
}

if ( !function_exists( 'suissevault_checkout_fields' ) ) {
	function suissevault_checkout_fields( $fields ) {

		// Add New fields
		$fields[ 'billing' ][ 'birth_day' ] = [
			'type'         => 'number',
			'label'        => 'DATE OF BIRTHD (DD)',
			'placeholder'  => '',
			'required'     => true,
			'class'        => [ 'form_wrapper' ],
			'autocomplete' => '',
			'label_class'  => 'form_label',
			'priority'     => 21,
		];
		$fields[ 'billing' ][ 'birth_month' ] = [
			'type'         => 'number',
			'label'        => 'MONTH (MM)',
			'placeholder'  => '',
			'required'     => true,
			'class'        => [ 'form_wrapper' ],
			'autocomplete' => '',
			'label_class'  => 'form_label',
			'priority'     => 22
		];
		$fields[ 'billing' ][ 'birth_year' ] = [
			'type'         => 'number',
			'label'        => 'YEAR (YYYY)',
			'placeholder'  => '',
			'required'     => true,
			'class'        => [ 'form_wrapper' ],
			'autocomplete' => '',
			'label_class'  => 'form_label',
			'priority'     => 23
		];

		// Edit exists fields
		$fields[ 'billing' ][ 'billing_country' ][ 'label' ] = "Country";

		// Remove label
		unset( $fields[ 'billing' ][ 'billing_address_2' ][ 'label' ] );

		return $fields;
	}
}

if ( !function_exists( 'suissevault_checkout_field_update_user_meta' ) ) {
	function suissevault_checkout_field_update_user_meta( $customer_id, $posted ) {
		if ( !empty( $_POST[ 'birth_day' ] ) ) {
			update_user_meta( $customer_id, 'birth_day', sanitize_text_field( $posted[ 'birth_day' ] ) );
		}
		if ( !empty( $_POST[ 'birth_month' ] ) ) {
			update_user_meta( $customer_id, 'birth_month', sanitize_text_field( $posted[ 'birth_month' ] ) );
		}
		if ( !empty( $_POST[ 'birth_year' ] ) ) {
			update_user_meta( $customer_id, 'birth_year', sanitize_text_field( $posted[ 'birth_year' ] ) );
		}
	}
}

if ( !function_exists( 'suissevault_checkout_field_update_order_meta' ) ) {
	function suissevault_checkout_field_update_order_meta( $order_id ) {

		if ( !empty( $_POST[ 'birth_day' ] ) ) {
			update_post_meta( $order_id, 'DATE OF BIRTHD (DD)', sanitize_text_field( $_POST[ 'birth_day' ] ) );
		}
		if ( !empty( $_POST[ 'birth_month' ] ) ) {
			update_post_meta( $order_id, 'MONTH (MM)', sanitize_text_field( $_POST[ 'birth_day' ] ) );
		}
		if ( !empty( $_POST[ 'birth_year' ] ) ) {
			update_post_meta( $order_id, 'YEAR (YYYY)', sanitize_text_field( $_POST[ 'birth_day' ] ) );
		}

	}
}

if ( !function_exists( 'suissevault_checkout_fields_process' ) ) {
	function suissevault_checkout_fields_process( $fields ) {

		if ( !empty( $_POST[ 'birth_day' ] ) && !preg_match( '/^(0[1-9]|[1-2][0-9]|3[0-1])$/', $_POST[ 'birth_day' ] ) ) {
			wc_add_notice( __( '<strong>DATE OF BIRTHD (DD)</strong> Invalid date format' ), 'error' );
		}
		if ( !empty( $_POST[ 'birth_month' ] ) && !preg_match( '/^(0[1-9]|1[0-2])$/', $_POST[ 'birth_month' ] ) ) {
			wc_add_notice( __( '<strong>MONTH (MM)</strong> Invalid date format' ), 'error' );
		}
		if ( !empty( $_POST[ 'birth_year' ] ) && !preg_match( '/^[0-9]{4}$/', $_POST[ 'birth_year' ] ) ) {
			wc_add_notice( __( '<strong>YEAR (YYYY)</strong> Invalid date format' ), 'error' );
		}

	}
}

if ( !function_exists( 'suissevault_customize_form_field' ) ) {
	function suissevault_customize_form_field( $field, $key, $args, $value ) {

		if ( is_checkout() || is_wc_endpoint_url() ) {
			$optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';

			$field = str_replace( [
				$optional,
				'<p',
				'</p>',
				'<span',
				'</span>',
				'<label',
				'</label>',
				'form-row',
				'woocommerce-input-wrapper"><input',
				'woocommerce-input-wrapper"><select',
			], [
				'',
				'<div',
				'</div>',
				'<div',
				'</div>',
				'<div',
				'</div>',
				'form_wrapper',
				'woocommerce-input-wrapper input"><input',
				'woocommerce-input-wrapper select"><select',
			], $field );
		}

		if ( is_checkout() ) {
			if ( $key == "billing_first_name" || $key == "billing_phone" ) {
				$field = '<div class="grid grid__twoo">' . $field;
			}
			elseif ( $key == "birth_day" ) {
				$field = '<div class="grid grid__three">' . $field;
			}
			elseif ( $key == "billing_last_name" || $key == "billing_email" || $key == "birth_year" ) {
				$field = $field . '</div>';
			}
		}

		return $field;

	}
}

if ( !function_exists( 'suissevault_remove_checkout_optional_fields_label_script' ) ) {
	function suissevault_remove_checkout_optional_fields_label_script() {
		// Only on checkout page
		if ( !( is_checkout() && !is_wc_endpoint_url() ) )
			return;

		$optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
		?>
		<script>
            jQuery(function ($) {
                // On "update" checkout form event
                $(document.body).on('update_checkout', function () {
                    // Billing
                    $('#billing_country_field label > .optional').remove();
                    $('#billing_address_1_field label > .optional').remove();
                    $('#billing_address_2_field label > .optional').remove();
                    $('#billing_postcode_field label > .optional').remove();
                    $('#billing_state_field label > .optional').remove();
                    // Shipping
                    $('#shipping_country_field label > .optional').remove();
                    $('#shipping_address_1_field label > .optional').remove();
                    $('#shipping_postcode_field label > .optional').remove();
                    $('#shipping_state_field label > .optional').remove();
                });
            });
		</script>
		<?php
	}
}

if ( !function_exists( 'suissevault_add_form_field_args' ) ) {
	function suissevault_add_form_field_args( $args, $key, $value ) {

		if ( is_checkout() || is_wc_endpoint_url() ) {
			$args[ 'label_class' ] = [ 'form_label' ];
		}

		return $args;
	}
}

if ( !function_exists( 'suissevault_clean_temporary_data' ) ) {
	function suissevault_clean_temporary_data( $order_id ) {

		if ( ! $order_id )
			return;

		WC()->session->__unset( 'api_price' );
		WC()->session->__unset( 'api_price_time' );
		WC()->session->__unset( 'chosen_payment_method' );
		WC()->session->__unset( 'chosen_shipping_methods' );
		WC()->session->__unset( 'cart_delivery_method' );
	}
}

if ( !function_exists( 'suissevault_customize_cart_shipping_method_full_label' ) ) {
	function suissevault_customize_cart_shipping_method_full_label( $label, $method ) {

		if ( is_cart() ) {
			if ( $method->get_method_id() == 'free_shipping' ) {
				$label .= " (" . get_woocommerce_currency_symbol() . $method->get_cost() . ")";
			}
			elseif ( $method->get_method_id() == 'flat_rate' ) {
				$label_array = explode( ":", $label );
				$label_array[ count( $label_array ) - 1 ] = " (" . trim( $label_array[ count( $label_array ) - 1 ] ) . ")";
				$label = implode( "", $label_array );
			}
			else {
				$label_array = explode( ":", $label );
				$label_array[ count( $label_array ) - 1 ] = " (" . trim( $label_array[ count( $label_array ) - 1 ] ) . ")";
				$label = implode( ":", $label_array );
			}
		}

		return $label;
	}
}

if ( !function_exists( 'suissecault_cart_item_subtotal' ) ) {
	function suissecault_cart_item_subtotal( $product_subtotal, $cart_item, $cart_item_key ) {

		$product_subtotal = str_replace( '<small class="tax_label">(incl. VAT)</small>', '', $product_subtotal );

		return $product_subtotal;
	}
}

if ( !function_exists( 'suissevault_add_custom_endpoints' ) ) {
	function suissevault_add_custom_endpoints() {
		add_rewrite_endpoint( 'password', EP_ROOT | EP_PAGES );
		add_rewrite_endpoint( 'storage', EP_ROOT | EP_PAGES );
		add_rewrite_endpoint( 'refer', EP_ROOT | EP_PAGES );
	}
}

if ( !function_exists( 'suissevault_custom_endpoints_query_vars' ) ) {
	function suissevault_custom_endpoints_query_vars( $vars ) {

		$vars[] = 'password';
		$vars[] = 'storage';
		$vars[] = 'refer';

		return $vars;
	}
}

if ( !function_exists( 'suissevault_account_menu_items' ) ) {
	function suissevault_account_menu_items( $items, $endpoints ) {

		// Unnecessary
		unset( $items[ 'downloads' ] );

		// Reorder
		unset( $items[ 'dashboard' ] );
		unset( $items[ 'edit-account' ] );
		unset( $items[ 'orders' ] );
		unset( $items[ 'payment-methods' ] );
		unset( $items[ 'edit-address' ] );

		// Rename
		$items[ 'customer-logout' ] = 'Exit';

		$reorder_items = [
			'dashboard'       => 'My Account',
			'orders'          => 'Order history',
			'password'        => 'Change Password',
			'storage'         => 'Storage',
			'payment-methods' => 'Billing & Payments',
			//'refer'           => 'Refer a friend',
		];

		$items = array_merge( $reorder_items, $items );

		return $items;
	}
}

if ( !function_exists( 'suissevault_password_content' ) ) {
	function suissevault_password_content() {
		wc_get_template( 'myaccount/form-change-password.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) );
	}
}

if ( !function_exists( 'suissevault_storage_content' ) ) {
	function suissevault_storage_content( $current_page ) {
		$current_page = empty( $current_page ) ? 1 : absint( $current_page );
		$customer_orders = wc_get_orders( array(
			'customer' => get_current_user_id(),
			'page'     => $current_page,
			'paginate' => true,
		) );

		wc_get_template( 'myaccount/storage.php', array(
			'current_page'    => absint( $current_page ),
			'customer_orders' => $customer_orders,
			'has_orders'      => 0 < $customer_orders->total,
		) );
	}
}

if ( !function_exists( 'suissevault_refer_content' ) ) {
	function suissevault_refer_content() {
		wc_get_template( 'myaccount/refer.php' );
	}
}

if ( !function_exists( 'suissevault_account_orders_columns' ) ) {
	function suissevault_account_orders_columns( $columns ) {

		$columns[ 'order-number' ] = 'Order number';
		$columns[ 'order-total' ] = 'Total amount';
		$columns[ 'order-actions' ] = '';

		return $columns;
	}
}

if ( !function_exists( 'suissevault_account_payment_methods_columns' ) ) {
	function suissevault_account_payment_methods_columns( $columns ) {

		// Unset for reorder
		unset( $columns[ 'actions' ] );

		// New Fields with reorder fields
		$columns[ 'method' ] = 'Type';
		$columns[ 'expires' ] = 'Details';
		$columns[ 'primary' ] = 'Primary';
		$columns[ 'actions' ] = '&nbsp;';

		return $columns;
	}
}

if ( !function_exists( 'suissevault_billing_fields_conditions' ) ) {
	function suissevault_billing_fields_conditions( $fields ) {

		if ( is_account_page() ) {
			unset( $fields[ 'billing_company' ] );
			unset( $fields[ 'billing_country' ] );
			unset( $fields[ 'billing_email' ] );

			//$fields[ 'billing_state' ]['autocomplete'] = '';
		}

		return $fields;
	}
}

if ( !function_exists( 'suissevault_customer_save_address' ) ) {
	function suissevault_customer_save_address( $user_id, $load_address ) {

		$current_url = ( isset( $_SERVER[ 'HTTPS' ] ) ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		if ( is_account_page() && ( wc_get_endpoint_url( 'payment-methods' ) == $current_url || wc_get_endpoint_url( 'payment-methods', 'billing' ) == $current_url ) ) {
			wp_safe_redirect( wc_get_endpoint_url( 'payment-methods', 'billing', wc_get_page_permalink( 'myaccount' ) ) );
			exit;
		}
	}
}

if ( !function_exists( 'dynamic_price_totals' ) ) {
	function dynamic_price_totals( $cart_object ) {

 		//calculate storage 13 333
        $storage_product = get_field( 'storage_product', 'options' );
        $storage_product_id = $storage_product->ID;
        $storage_price = 0;
        $cart_storage = false;

		$api_price = get_api_price();

		// Checkout Locked Price Validation
		if ( is_checkout() ) {
			if ( WC()->session->get( 'api_price' ) ) {
				checkout_time();
				$api_price = WC()->session->get( 'api_price' );
			}
			else {
				WC()->session->set( 'api_price', $api_price );
				WC()->session->set( 'api_price_time', time() );
			}
		}

		// Cart Dynamic Price
		foreach ( $cart_object->get_cart() as $hash => $value ) {
			if( $value['product_id'] == $storage_product_id ) {
                $cart_storage = $value; 
			}

			// Skip storage
			if ( class_exists( 'WC_Subscriptions_Product' ) && WC_Subscriptions_Product::is_subscription( $value[ 'data' ] ) ) continue;

			//$dynamic_price = get_dynamic_price( $api_price, $value[ 'data' ] );
			$dynamic_price = get_quantity_discount_price( $value[ 'data' ], $value[ 'quantity' ], $api_price )."<br>";
			$value[ 'data' ]->set_price( $dynamic_price );
            
            if($dynamic_price>13333){
                $storage_price += $dynamic_price*0.0065;
            }

			// Cart Storage Validation
			if ( is_storage() ) {
				$value[ 'data' ]->set_tax_status( 'none' );
			}
		}
        
        //calculate storage 13 333
        if($cart_storage && $storage_price>0){
            $cart_storage['data']->set_price($storage_price);
        }
	}
}

if ( !function_exists( 'suissevault_mailchimp_woocommerce_newsletter_field' ) ) {
	function suissevault_mailchimp_woocommerce_newsletter_field( $checkbox, $status, $label ) {

		$checkbox = str_replace( [
			'<p class="form-row form-row-wide mailchimp-newsletter">',
			'</p>',
			'<input class="woocommerce-form__input',
			'<label for="mailchimp_woocommerce_newsletter" class="woocommerce-form__label woocommerce-form__label-for-checkbox inline"><span>' . $label . '</span></label>'
		], [
			'<div class="input mailchimp-newsletter"><label>',
			'</label></div>',
			'<input class="input__hidden woocommerce-form__input',
			'<span>' . $label . '</span>'
		], $checkbox );

		$checkbox = '<div class="form_wrapper">' . $checkbox . '</div>';

		return $checkbox;
	}
}

if ( false ) {
	if ( !function_exists( 'suissevault_cart_link_fragment' ) ) {
		/**
		 * Cart Fragments
		 * Ensure cart contents update when products are added to the cart via AJAX
		 *
		 * @param array $fragments Fragments to refresh via AJAX.
		 *
		 * @return array            Fragments to refresh via AJAX
		 */
		function suissevault_cart_link_fragment( $fragments ) {
			global $woocommerce;

			ob_start();
			suissevault_cart_link();
			$fragments[ 'a.cart-contents' ] = ob_get_clean();

			ob_start();
			suissevault_handheld_footer_bar_cart_link();
			$fragments[ 'a.footer-cart-contents' ] = ob_get_clean();

			return $fragments;
		}
	}

	if ( !function_exists( 'suissevault_cart_link' ) ) {
		/**
		 * Cart Link
		 * Displayed a link to the cart including the number of items present and the cart total
		 *
		 * @return void
		 * @since  1.0.0
		 */
		function suissevault_cart_link() {
			if ( !suissevault_woo_cart_available() ) {
				return;
			}
			?>
			<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'suissevault' ); ?>">
				<?php /* translators: %d: number of items in cart */ ?>
				<?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?>
				<span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'suissevault' ), WC()->cart->get_cart_contents_count() ) ); ?></span>
			</a>
			<?php
		}
	}

	if ( !function_exists( 'suissevault_product_search' ) ) {
		/**
		 * Display Product Search
		 *
		 * @return void
		 * @uses  suissevault_is_woocommerce_activated() check if WooCommerce is activated
		 * @since  1.0.0
		 */
		function suissevault_product_search() {
			if ( suissevault_is_woocommerce_activated() ) {
				?>
				<div class="site-search">
					<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
				</div>
				<?php
			}
		}
	}

	if ( !function_exists( 'suissevault_header_cart' ) ) {
		/**
		 * Display Header Cart
		 *
		 * @return void
		 * @uses  suissevault_is_woocommerce_activated() check if WooCommerce is activated
		 * @since  1.0.0
		 */
		function suissevault_header_cart() {
			if ( suissevault_is_woocommerce_activated() ) {
				if ( is_cart() ) {
					$class = 'current-menu-item';
				}
				else {
					$class = '';
				}
				?>
				<ul id="site-header-cart" class="site-header-cart menu">
					<li class="<?php echo esc_attr( $class ); ?>">
						<?php suissevault_cart_link(); ?>
					</li>
					<li>
						<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
					</li>
				</ul>
				<?php
			}
		}
	}

	if ( !function_exists( 'suissevault_upsell_display' ) ) {
		/**
		 * Upsells
		 * Replace the default upsell function with our own which displays the correct number product columns
		 *
		 * @return  void
		 * @since   1.0.0
		 * @uses    woocommerce_upsell_display()
		 */
		function suissevault_upsell_display() {
			$columns = apply_filters( 'suissevault_upsells_columns', 3 );
			woocommerce_upsell_display( -1, $columns );
		}
	}

	if ( !function_exists( 'suissevault_loop_columns' ) ) {
		/**
		 * Default loop columns on product archives
		 *
		 * @return integer products per row
		 * @since  1.0.0
		 */
		function suissevault_loop_columns() {
			$columns = 3; // 3 products per row

			if ( function_exists( 'wc_get_default_products_per_row' ) ) {
				$columns = wc_get_default_products_per_row();
			}

			return apply_filters( 'suissevault_loop_columns', $columns );
		}
	}

	if ( !function_exists( 'suissevault_woocommerce_pagination' ) ) {
		/**
		 * suissevault WooCommerce Pagination
		 * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
		 * but since suissevault adds pagination before that function is excuted we need a separate function to
		 * determine whether or not to display the pagination.
		 *
		 * @since 1.4.4
		 */
		function suissevault_woocommerce_pagination() {
			if ( woocommerce_products_will_display() ) {
				woocommerce_pagination();
			}
		}
	}

	if ( !function_exists( 'suissevault_product_categories' ) ) {
		/**
		 * Display Product Categories
		 * Hooked into the `homepage` action in the homepage template
		 *
		 * @param array $args the product section args.
		 *
		 * @return void
		 * @since  1.0.0
		 */
		function suissevault_product_categories( $args ) {
			$args = apply_filters( 'suissevault_product_categories_args', array(
				'limit'            => 3,
				'columns'          => 3,
				'child_categories' => 0,
				'orderby'          => 'menu_order',
				'title'            => __( 'Shop by Category', 'suissevault' ),
			) );

			$shortcode_content = suissevault_do_shortcode( 'product_categories', apply_filters( 'suissevault_product_categories_shortcode_args', array(
				'number'  => intval( $args[ 'limit' ] ),
				'columns' => intval( $args[ 'columns' ] ),
				'orderby' => esc_attr( $args[ 'orderby' ] ),
				'parent'  => esc_attr( $args[ 'child_categories' ] ),
			) ) );

			/**
			 * Only display the section if the shortcode returns product categories
			 */
			if ( false !== strpos( $shortcode_content, 'product-category' ) ) {
				echo '<section class="suissevault-product-section suissevault-product-categories" aria-label="' . esc_attr__( 'Product Categories', 'suissevault' ) . '">';

				do_action( 'suissevault_homepage_before_product_categories' );

				echo '<h2 class="section-title">' . wp_kses_post( $args[ 'title' ] ) . '</h2>';

				do_action( 'suissevault_homepage_after_product_categories_title' );

				echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				do_action( 'suissevault_homepage_after_product_categories' );

				echo '</section>';
			}
		}
	}

	if ( !function_exists( 'suissevault_recent_products' ) ) {
		/**
		 * Display Recent Products
		 * Hooked into the `homepage` action in the homepage template
		 *
		 * @param array $args the product section args.
		 *
		 * @return void
		 * @since  1.0.0
		 */
		function suissevault_recent_products( $args ) {
			$args = apply_filters( 'suissevault_recent_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'date',
				'order'   => 'desc',
				'title'   => __( 'New In', 'suissevault' ),
			) );

			$shortcode_content = suissevault_do_shortcode( 'products', apply_filters( 'suissevault_recent_products_shortcode_args', array(
				'orderby'  => esc_attr( $args[ 'orderby' ] ),
				'order'    => esc_attr( $args[ 'order' ] ),
				'per_page' => intval( $args[ 'limit' ] ),
				'columns'  => intval( $args[ 'columns' ] ),
			) ) );

			/**
			 * Only display the section if the shortcode returns products
			 */
			if ( false !== strpos( $shortcode_content, 'product' ) ) {
				echo '<section class="suissevault-product-section suissevault-recent-products" aria-label="' . esc_attr__( 'Recent Products', 'suissevault' ) . '">';

				do_action( 'suissevault_homepage_before_recent_products' );

				echo '<h2 class="section-title">' . wp_kses_post( $args[ 'title' ] ) . '</h2>';

				do_action( 'suissevault_homepage_after_recent_products_title' );

				echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				do_action( 'suissevault_homepage_after_recent_products' );

				echo '</section>';
			}
		}
	}

	if ( !function_exists( 'suissevault_featured_products' ) ) {
		/**
		 * Display Featured Products
		 * Hooked into the `homepage` action in the homepage template
		 *
		 * @param array $args the product section args.
		 *
		 * @return void
		 * @since  1.0.0
		 */
		function suissevault_featured_products( $args ) {
			$args = apply_filters( 'suissevault_featured_products_args', array(
				'limit'      => 4,
				'columns'    => 4,
				'orderby'    => 'date',
				'order'      => 'desc',
				'visibility' => 'featured',
				'title'      => __( 'We Recommend', 'suissevault' ),
			) );

			$shortcode_content = suissevault_do_shortcode( 'products', apply_filters( 'suissevault_featured_products_shortcode_args', array(
				'per_page'   => intval( $args[ 'limit' ] ),
				'columns'    => intval( $args[ 'columns' ] ),
				'orderby'    => esc_attr( $args[ 'orderby' ] ),
				'order'      => esc_attr( $args[ 'order' ] ),
				'visibility' => esc_attr( $args[ 'visibility' ] ),
			) ) );

			/**
			 * Only display the section if the shortcode returns products
			 */
			if ( false !== strpos( $shortcode_content, 'product' ) ) {
				echo '<section class="suissevault-product-section suissevault-featured-products" aria-label="' . esc_attr__( 'Featured Products', 'suissevault' ) . '">';

				do_action( 'suissevault_homepage_before_featured_products' );

				echo '<h2 class="section-title">' . wp_kses_post( $args[ 'title' ] ) . '</h2>';

				do_action( 'suissevault_homepage_after_featured_products_title' );

				echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				do_action( 'suissevault_homepage_after_featured_products' );

				echo '</section>';
			}
		}
	}

	if ( !function_exists( 'suissevault_popular_products' ) ) {
		/**
		 * Display Popular Products
		 * Hooked into the `homepage` action in the homepage template
		 *
		 * @param array $args the product section args.
		 *
		 * @return void
		 * @since  1.0.0
		 */
		function suissevault_popular_products( $args ) {
			$args = apply_filters( 'suissevault_popular_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'rating',
				'order'   => 'desc',
				'title'   => __( 'Fan Favorites', 'suissevault' ),
			) );

			$shortcode_content = suissevault_do_shortcode( 'products', apply_filters( 'suissevault_popular_products_shortcode_args', array(
				'per_page' => intval( $args[ 'limit' ] ),
				'columns'  => intval( $args[ 'columns' ] ),
				'orderby'  => esc_attr( $args[ 'orderby' ] ),
				'order'    => esc_attr( $args[ 'order' ] ),
			) ) );

			/**
			 * Only display the section if the shortcode returns products
			 */
			if ( false !== strpos( $shortcode_content, 'product' ) ) {
				echo '<section class="suissevault-product-section suissevault-popular-products" aria-label="' . esc_attr__( 'Popular Products', 'suissevault' ) . '">';

				do_action( 'suissevault_homepage_before_popular_products' );

				echo '<h2 class="section-title">' . wp_kses_post( $args[ 'title' ] ) . '</h2>';

				do_action( 'suissevault_homepage_after_popular_products_title' );

				echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				do_action( 'suissevault_homepage_after_popular_products' );

				echo '</section>';
			}
		}
	}

	if ( !function_exists( 'suissevault_on_sale_products' ) ) {
		/**
		 * Display On Sale Products
		 * Hooked into the `homepage` action in the homepage template
		 *
		 * @param array $args the product section args.
		 *
		 * @return void
		 * @since  1.0.0
		 */
		function suissevault_on_sale_products( $args ) {
			$args = apply_filters( 'suissevault_on_sale_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'date',
				'order'   => 'desc',
				'on_sale' => 'true',
				'title'   => __( 'On Sale', 'suissevault' ),
			) );

			$shortcode_content = suissevault_do_shortcode( 'products', apply_filters( 'suissevault_on_sale_products_shortcode_args', array(
				'per_page' => intval( $args[ 'limit' ] ),
				'columns'  => intval( $args[ 'columns' ] ),
				'orderby'  => esc_attr( $args[ 'orderby' ] ),
				'order'    => esc_attr( $args[ 'order' ] ),
				'on_sale'  => esc_attr( $args[ 'on_sale' ] ),
			) ) );

			/**
			 * Only display the section if the shortcode returns products
			 */
			if ( false !== strpos( $shortcode_content, 'product' ) ) {
				echo '<section class="suissevault-product-section suissevault-on-sale-products" aria-label="' . esc_attr__( 'On Sale Products', 'suissevault' ) . '">';

				do_action( 'suissevault_homepage_before_on_sale_products' );

				echo '<h2 class="section-title">' . wp_kses_post( $args[ 'title' ] ) . '</h2>';

				do_action( 'suissevault_homepage_after_on_sale_products_title' );

				echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				do_action( 'suissevault_homepage_after_on_sale_products' );

				echo '</section>';
			}
		}
	}

	if ( !function_exists( 'suissevault_best_selling_products' ) ) {
		/**
		 * Display Best Selling Products
		 * Hooked into the `homepage` action in the homepage template
		 *
		 * @param array $args the product section args.
		 *
		 * @return void
		 * @since 2.0.0
		 */
		function suissevault_best_selling_products( $args ) {
			$args = apply_filters( 'suissevault_best_selling_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'popularity',
				'order'   => 'desc',
				'title'   => esc_attr__( 'Best Sellers', 'suissevault' ),
			) );

			$shortcode_content = suissevault_do_shortcode( 'products', apply_filters( 'suissevault_best_selling_products_shortcode_args', array(
				'per_page' => intval( $args[ 'limit' ] ),
				'columns'  => intval( $args[ 'columns' ] ),
				'orderby'  => esc_attr( $args[ 'orderby' ] ),
				'order'    => esc_attr( $args[ 'order' ] ),
			) ) );

			/**
			 * Only display the section if the shortcode returns products
			 */
			if ( false !== strpos( $shortcode_content, 'product' ) ) {
				echo '<section class="suissevault-product-section suissevault-best-selling-products" aria-label="' . esc_attr__( 'Best Selling Products', 'suissevault' ) . '">';

				do_action( 'suissevault_homepage_before_best_selling_products' );

				echo '<h2 class="section-title">' . wp_kses_post( $args[ 'title' ] ) . '</h2>';

				do_action( 'suissevault_homepage_after_best_selling_products_title' );

				echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				do_action( 'suissevault_homepage_after_best_selling_products' );

				echo '</section>';
			}
		}
	}

	if ( !function_exists( 'suissevault_promoted_products' ) ) {
		/**
		 * Featured and On-Sale Products
		 * Check for featured products then on-sale products and use the appropiate shortcode.
		 * If neither exist, it can fallback to show recently added products.
		 *
		 * @param integer $per_page total products to display.
		 * @param integer $columns columns to arrange products in to.
		 * @param boolean $recent_fallback Should the function display recent products as a fallback when there are no featured or on-sale products?.
		 *
		 * @return void
		 * @uses  suissevault_is_woocommerce_activated()
		 * @uses  wc_get_featured_product_ids()
		 * @uses  wc_get_product_ids_on_sale()
		 * @uses  suissevault_do_shortcode()
		 * @since  1.5.1
		 */
		function suissevault_promoted_products( $per_page = '2', $columns = '2', $recent_fallback = true ) {
			if ( suissevault_is_woocommerce_activated() ) {

				if ( wc_get_featured_product_ids() ) {

					echo '<h2>' . esc_html__( 'Featured Products', 'suissevault' ) . '</h2>';

					// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
					echo suissevault_do_shortcode( 'featured_products', array(
						'per_page' => $per_page,
						'columns'  => $columns,
					) );
					// phpcs:enable
				}
				elseif ( wc_get_product_ids_on_sale() ) {

					echo '<h2>' . esc_html__( 'On Sale Now', 'suissevault' ) . '</h2>';

					// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
					echo suissevault_do_shortcode( 'sale_products', array(
						'per_page' => $per_page,
						'columns'  => $columns,
					) );
					// phpcs:enable
				}
				elseif ( $recent_fallback ) {

					echo '<h2>' . esc_html__( 'New In Store', 'suissevault' ) . '</h2>';

					// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
					echo suissevault_do_shortcode( 'recent_products', array(
						'per_page' => $per_page,
						'columns'  => $columns,
					) );
					// phpcs:enable
				}
			}
		}
	}

}
