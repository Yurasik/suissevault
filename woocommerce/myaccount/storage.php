<?php
/**
 * Orders
 * Shows orders on the account page.
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<h2 class="title">Stored packages</h2>

<?php if ( $has_orders ) : ?>

	<div class="cabinet_info">
		<div class="cabinet_head grid">
			<?php
			$storage_columns = array(
				'order-number'   => __( 'Order', 'suissevault' ),
				'order-product'  => __( 'Product', 'suissevault' ),
				'order-quantity' => __( 'Quantity', 'suissevault' ),
				'order-date'     => __( 'Date Stored From', 'suissevault' ),
				'order-actions'  => __( '', 'suissevault' )
			);
			foreach ( $storage_columns as $column_id => $column_name ) : ?>
				<div class="cabinet_col cabinet_col-<?php echo esc_attr( $column_id ); ?>"><?php echo esc_html( $column_name ); ?></div>
			<?php endforeach; ?>
		</div>

		<?php foreach ( $customer_orders->orders as $customer_order ) {
			$order                 = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$order_shipping_method = $order->get_shipping_method();
			if ( $order_shipping_method != 'Storage' ) continue; ?>
			<?php foreach ( $order->get_items() as $item_id => $item ):
				$product = $item->get_product();
				$qty               = $item->get_quantity();
				$refunded_qty      = $order->get_qty_refunded_for_item( $item_id );
				$qty_display       = ( $refunded_qty )
					? '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>'
					: esc_html( $qty ); ?>
				<div class="cabinet_row grid status-<?php echo esc_attr( $order->get_status() ); ?> order">
					<?php foreach ( $storage_columns as $column_id => $column_name ) : ?>
						<?php if ( 'order-number' === $column_id ) : ?>
							<div class="cabinet_col cabinet_col-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
								<?php echo esc_html( $order->get_order_number() ); ?>
							</div>
						<?php elseif ( 'order-product' === $column_id ) : ?>
							<div class="cabinet_col cabinet_col-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
								<?php echo $product->get_name(); ?>
							</div>
						<?php elseif ( 'order-quantity' === $column_id ) : ?>
							<div class="cabinet_col cabinet_col-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
								<?php echo $qty_display; ?>
							</div>
						<?php elseif ( 'order-date' === $column_id ) : ?>
							<div class="cabinet_col cabinet_col-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created(), 'd.m.Y' ) ); ?></time>
							</div>
						<?php elseif ( 'order-actions' === $column_id ) : ?>
							<div class="cabinet_storage_print icon icon-eye"></div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		<?php } ?>
	</div>

	<h2>Storage Invoices</h2>
	<div class="cabinet_info">
		<div class="cabinet_head grid">
			<div class="cabinet_col">References</div>
			<div class="cabinet_col">Date</div>
			<div class="cabinet_col">Period</div>
			<div class="cabinet_col">Total</div>
		</div>
		<div class="cabinet_row grid _one">
			<div class="cabinet_col">You don’t have any storage invoices.</div>
		</div>
	</div>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Browse products', 'woocommerce' ); ?></a>
		<?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
