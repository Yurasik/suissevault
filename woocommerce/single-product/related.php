<?php
/**
 * Related Products
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) :
	$api_price = get_api_price();

	$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related <br><i>Products</i>', 'suissevault' ) );
	?>

	<section class="related products product">
		<div class="bone">
			<div class="product_net flex__start">
				<div class="product_items grid grid__three">
					<?php woocommerce_product_loop_start( false ); ?>

					<?php foreach ( $related_products as $related_product ) :
						$dynamic_price = get_dynamic_price( $api_price, $related_product );
						$related_product_id = $related_product->get_id();
						?>

						<?php $post_object = get_post( $related_product_id );
						setup_postdata( $GLOBALS[ 'post' ] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found ?>

						<div class="product_item">
							<div class="product_item_img">
								<?php echo suissevault_get_picture_html( $related_product->get_image_id() ); ?>
							</div>
							<div class="product_item_name"><?php the_title(); ?></div>
							<div class="product_item_price price" data-price-product-id="<?php echo $related_product_id; ?>"><?php echo wc_price( $dynamic_price[ 'price_inc_vat' ] ); ?></div>
							<div class="product_item_btn">
								<?php woocommerce_template_loop_add_to_cart( [ 'class' => 'btn btn-line' ] ); ?>
							</div>
						</div>

					<?php endforeach; ?>

					<?php woocommerce_product_loop_end( false ); ?>
				</div>

				<?php if ( $heading ) : ?>
					<div class="product_info">
						<h2><?php echo $heading; ?></h2>
						<?php $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) ); ?>
						<a href="<?php echo $shop_page_url; ?>" class="more-line"><?php _e( 'View all', 'suissevault' ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php
endif;

wp_reset_postdata();
