<?php
/**
 * My Addresses
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();
$customer_id = $current_user->ID;

if ( !wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing'  => __( 'Billing address', 'woocommerce' ),
		'shipping' => __( 'Shipping address', 'woocommerce' ),
	), $customer_id );
}
else {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => __( 'Billing address', 'woocommerce' ),
	), $customer_id );
}
?>

<?php if ( !wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	<div class="u-columns woocommerce-Addresses col2-set addresses">
<?php endif; ?>

<?php foreach ( $get_addresses as $load_address => $address_title ) :
	$load_address = sanitize_key( $load_address );
	$country      = get_user_meta( $customer_id, $load_address . '_country', true );

	if ( ! $country ) {
		$country = WC()->countries->get_base_country();
	}

	if ( 'billing' === $load_address ) {
		$allowed_countries = WC()->countries->get_allowed_countries();

		if ( ! array_key_exists( $country, $allowed_countries ) ) {
			$country = current( array_keys( $allowed_countries ) );
		}
	}

	if ( 'shipping' === $load_address ) {
		$allowed_countries = WC()->countries->get_shipping_countries();

		if ( ! array_key_exists( $country, $allowed_countries ) ) {
			$country = current( array_keys( $allowed_countries ) );
		}
	}

	$address = WC()->countries->get_address_fields( $country, $load_address . '_' ); ?>
	<table class="woocommerce-Address">
		<?php foreach( $address as $key => $value ): ?>
			<tr>
				<td><?php echo $value['label']; ?></td>
				<td><?php echo $current_user->$key; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endforeach; ?>

	<a class="modal-link btn btn-line edit" data-modal-name="billing"><?php echo $address ? esc_html__( 'Edit' . ' ' . esc_html( $address_title ), 'suissevault' ) : esc_html__( 'Add' . ' ' . esc_html( $address_title ), 'suissevault' ); ?></a>

<?php if ( !wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	</div>
<?php endif;
