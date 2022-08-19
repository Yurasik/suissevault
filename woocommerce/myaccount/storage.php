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
				$product           = $item->get_product();
				if ( class_exists( 'WC_Subscriptions_Product' ) && WC_Subscriptions_Product::is_subscription( $product ) ) {
					continue;
				}
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

	<h2>Storage Invoices</h2>
	<!--woocommerce_account_subscriptions-->
	<div class="cabinet_info my_account_subscriptions my_account_orders woocommerce-orders-table woocommerce-MyAccount-subscriptions shop_table shop_table_responsive woocommerce-orders-table--subscriptions">
		<?php if ( ! empty( $subscriptions ) ) : ?>
			<div class="cabinet_head grid">
				<div class="cabinet_col subscription-id order-number woocommerce-orders-table__header woocommerce-orders-table__header-order-number woocommerce-orders-table__header-subscription-id">
					<?php esc_html_e( 'Order', 'suissevault' ); ?>
				</div>
				<div class="cabinet_col subscription-next-payment order-date woocommerce-orders-table__header woocommerce-orders-table__header-order-date woocommerce-orders-table__header-subscription-next-payment">
					<?php echo _x( 'Start date', 'customer subscription table header', 'woocommerce-subscriptions' ) . " / " . esc_html_x( 'Next payment', 'table heading', 'woocommerce-subscriptions' ); ?>
				</div>
				<div class="cabinet_col subscription-actions order-actions woocommerce-orders-table__header woocommerce-orders-table__header-order-actions woocommerce-orders-table__header-subscription-actions">
					<?php esc_html_e( 'Actions', 'woocommerce-subscriptions' ); ?>
				</div>
				<div class="cabinet_col subscription-total order-total woocommerce-orders-table__header woocommerce-orders-table__header-order-total woocommerce-orders-table__header-subscription-total">
					<?php echo esc_html_x( 'Total', 'table heading', 'woocommerce-subscriptions' ); ?>
				</div>
				<div class="cabinet_col subscription-status order-status woocommerce-orders-table__header woocommerce-orders-table__header-order-status woocommerce-orders-table__header-subscription-status">
					<?php esc_html_e( 'Status', 'woocommerce-subscriptions' ); ?>
				</div>
			</div>

			<?php /** @var WC_Subscription $subscription */ ?>
			<?php foreach ( $subscriptions as $subscription_id => $subscription ) :
				$subscription_orders = $subscription->get_related_orders();
				$subscription_order = array_shift( $subscription_orders );
				$order = wc_get_order( $subscription_order );
				$order_date = $order->get_date_created();
				$actions = wcs_get_all_user_actions_for_subscription( $subscription, get_current_user_id() );
				?>
				<div class="cabinet_row grid order woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $subscription->get_status() ); ?>">
					<div class="cabinet_col subscription-order-id order-number woocommerce-orders-table__cell woocommerce-orders-table__cell-order-id woocommerce-orders-table__cell-order-number" data-title="<?php esc_attr_e( 'ID', 'woocommerce-subscriptions' ); ?>">
						<?php echo sprintf( esc_html_x( '#%s', 'hash before order number', 'woocommerce-subscriptions' ), esc_html( $order->get_order_number() ) ); ?>
					</div>
					<div class="cabinet_col subscription-next-payment order-date woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-next-payment woocommerce-orders-table__cell-order-date" data-title="<?php echo esc_attr_x( 'Next Payment', 'table heading', 'woocommerce-subscriptions' ); ?>">
						<time datetime="<?php echo esc_attr( $order_date->date( 'Y-m-d' ) ); ?>" title="<?php echo esc_attr( $order_date->getTimestamp() ); ?>">
							<?php echo esc_attr( $order_date->date( 'd.m.Y' ) ); ?>
						</time> /
						<?php echo esc_attr( date_i18n( 'd.m.Y', $subscription->get_time( 'next_payment', 'site' ) ) ); ?>
						<?php if ( ! $subscription->is_manual() && $subscription->has_status( 'active' ) && $subscription->get_time( 'next_payment' ) > 0 ) : ?>
							<br/><small><?php echo esc_attr( $subscription->get_payment_method_to_display( 'customer' ) ); ?></small>
						<?php endif; ?>
					</div>
					<div class="cabinet_col subscription-actions order-actions woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-actions woocommerce-orders-table__cell-order-actions">
						<?php foreach ( $actions as $key => $action ) : ?>
							<a href="<?php echo esc_url( $action['url'] ); ?>" class="button <?php echo sanitize_html_class( $key ) ?>"><?php echo esc_html( $action['name'] ); ?></a><br/>
						<?php endforeach; ?>
						<?php do_action( 'woocommerce_my_subscriptions_actions', $subscription ); ?>
					</div>
					<div class="cabinet_col subscription-total order-total woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-total woocommerce-orders-table__cell-order-total" data-title="<?php echo esc_attr_x( 'Total', 'Used in data attribute. Escaped', 'woocommerce-subscriptions' ); ?>">
						<?php echo wp_kses_post( $subscription->get_formatted_order_total() ); ?>
					</div>
					<div class="subscription-status order-status woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-status woocommerce-orders-table__cell-order-status" data-title="<?php esc_attr_e( 'Status', 'woocommerce-subscriptions' ); ?>">
						<?php echo esc_attr( wcs_get_subscription_status_name( $subscription->get_status() ) ); ?>
					</div>
				</div>
			<?php endforeach; ?>
		<?php else : ?>
			<div class="cabinet_row grid _one no_subscriptions woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
				<div class="cabinet_col">You don’t have any storage invoices.</div>
			</div>
		<?php endif; ?>
	</div>

<?php else : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Browse products', 'woocommerce' ); ?></a>
		<?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
