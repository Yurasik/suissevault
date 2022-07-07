<?php
/**
 * Suissevault WooCommerce hooks
 *
 * @package suissevault
 */

/**
 * Login
 */
add_filter( 'woocommerce_login_redirect', 'suissevault_customer_login_redirect', 9999, 2 );

/**
 * Layout
 *
 * @see  suissevault_shop_messages()
 * @see  suissevault_before_content()
 * @see  suissevault_after_content()
 * @see  suissevault_breadcrumbs()
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_main_content', 'woocommerce_output_all_notices', 5 );
add_action( 'woocommerce_before_main_content', 'suissevault_shop_messages', 5 );
add_action( 'woocommerce_before_main_content', 'suissevault_before_content', 10 );
add_action( 'woocommerce_after_main_content', 'suissevault_after_content', 10 );
add_action( 'suissevault_breadcrumb', 'suissevault_breadcrumb', 10 );
add_action( 'suissevault_result_count', 'woocommerce_result_count', 10 );
add_action( 'suissevault_catalog_ordering', 'woocommerce_catalog_ordering', 10 );


/**
 * Products
 *
 * @see suissevault_template_loop_product_thumbnail()
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_before_shop_loop_item_title', 'suissevault_product_stock_status', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'suissevault_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_single_product_summary', 'suissevault_show_product_images', 10 );
add_action( 'woocommerce_single_product_summary', 'suissevault_breadcrumb', 1 );
add_action( 'woocommerce_single_product_summary', 'suissevault_edit_post_link', 6 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 9 );
add_action( 'woocommerce_single_product_summary', 'suissevault_quantities_list', 60 );
add_action( 'woocommerce_after_add_to_cart_quantity', 'woocommerce_template_single_price', 31 );
add_action( 'woocommerce_before_quantity_input_field', 'suissevault_before_quantity_input_field', 10 );
add_action( 'woocommerce_after_quantity_input_field', 'suissevault_after_quantity_input_field', 10 );
add_filter( 'woocommerce_product_tabs', 'suissevault_terms_delivery_tab', 10, 1 );
add_action( 'suissevault_output_related_products', 'woocommerce_output_related_products', 10 );
add_filter( 'woocommerce_output_related_products_args', 'suissevault_related_products_args', 20 );

add_filter( 'wc_price', 'suissevault_price_filter', 10, 3 );
add_filter( 'woocommerce_cart_totals_order_total_html', 'suissevault_totals_order_total_html_filter', 10, 1 );
// Stock Status
add_filter( 'woocommerce_product_stock_status_options', 'suissevault_product_stock_status_options', 10, 1 );
add_action( 'woocommerce_process_product_meta', 'suissevault_save_custom_stock_status', 99, 1 );
add_action( 'woocommerce_product_is_in_stock', 'suissevault_product_is_in_stock', 10, 2 );
add_filter( 'woocommerce_get_availability_text', 'suissevault_get_availability_text', 10, 2 );
add_filter( 'woocommerce_get_availability_class', 'suissevault_get_availability_class', 10, 2 );
add_filter( 'woocommerce_admin_stock_html', 'suissevault_admin_stock_html', 10, 2 );

/**
 * Cart
 */
add_filter( 'woocommerce_cart_shipping_method_full_label', 'suissevault_customize_cart_shipping_method_full_label', 10, 2 );
remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
add_action( 'woocommerce_after_cart', 'woocommerce_button_proceed_to_checkout', 10 );
add_action( 'woocommerce_cart_item_subtotal', 'suissecault_cart_item_subtotal', 10, 3 );


/**
 * Checkout
 */
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'suissevault_payment_details', 'woocommerce_checkout_payment', 10 );
add_filter( 'woocommerce_checkout_fields', 'suissevault_checkout_fields', 10, 1 );
add_filter( 'woocommerce_checkout_update_user_meta', 'suissevault_checkout_field_update_user_meta', 10, 2 );
add_action( 'woocommerce_checkout_update_order_meta', 'suissevault_checkout_field_update_order_meta', 10, 1 );
add_action( 'woocommerce_checkout_process', 'suissevault_checkout_fields_process' );
add_filter( 'woocommerce_form_field', 'suissevault_customize_form_field', 10, 4 );
// JQuery: Needed for checkout fields to Remove "(optional)" from our non required fields
add_filter( 'wp_footer', 'suissevault_remove_checkout_optional_fields_label_script' );
add_filter( 'woocommerce_form_field_args', 'suissevault_add_form_field_args', 10, 3 );

/**
 * My Account
 */
// Register new endpoint (URL) for My Account page
add_action( 'init', 'suissevault_add_custom_endpoints' );
// Add new query var
add_filter( 'query_vars', 'suissevault_custom_endpoints_query_vars', 0 );
// Insert the new endpoint into the My Account menu
add_filter( 'woocommerce_account_menu_items', 'suissevault_account_menu_items', 10, 2 );
// Add content to the new tabs (Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format)
add_action( 'woocommerce_account_password_endpoint', 'suissevault_password_content' );
add_action( 'woocommerce_account_storage_endpoint', 'suissevault_storage_content' );
add_action( 'woocommerce_account_refer_endpoint', 'suissevault_refer_content' );
// Orders
add_filter( 'woocommerce_account_orders_columns', 'suissevault_account_orders_columns', 10, 1 );
// Payment And Billing
add_filter( 'woocommerce_account_payment_methods_columns', 'suissevault_account_payment_methods_columns', 10, 1 );
// Billing fields on my account edit-addresses and checkout
add_filter( 'woocommerce_billing_fields', 'suissevault_billing_fields_conditions' );
add_filter( 'woocommerce_customer_save_address', 'suissevault_customer_save_address', 10, 2 );


/** Dynamic Price */
add_action( 'woocommerce_before_calculate_totals', 'dynamic_price_totals', 10, 1 );

