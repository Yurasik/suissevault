<?php
/**
 * Customer note email
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-note.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

	<p><?php printf( esc_html__( 'Hello %s %s,', 'suissevault' ), esc_html( $order->get_billing_last_name() ), esc_html( $order->get_billing_first_name() ) ); ?></p>
	<hr/><br>
	<p>We thought you’d like to know that we’ve dispatched your item(s).</p>
	<br>
	<hr/><br>
	<p>If you have any questions please visit the
		<a class="link" href="<?php echo home_url( '/faq/' ); ?>">FAQ</a> page in case you didn’t find an answer to your question
		<a class="link" href="<?php echo home_url( '/contact-us/' ); ?>">contact us</a>.
	</p>
	<p>Your electronic invoice can be downloaded <a class="link" href="<?php echo home_url( '/personal-area/orders/' ); ?>">here</a>.</p>
	<p>Your order reference <?php echo $order->get_order_number(); ?>.</p>

<?php
/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email ); ?>

	<h4><?php esc_html_e( 'Your Package', 'suissevault' ); ?></h4>
	<p><?php echo wpautop( wptexturize( make_clickable( $customer_note ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
	<br>

<?php
/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php
/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
