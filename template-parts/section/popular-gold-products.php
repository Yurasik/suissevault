<?php
$args = array(
	'post_type'      => [ 'product' ],
	'posts_per_page' => 3,
	'tax_query'      => [
		[
			'taxonomy' => 'pa_metal',
			'field'    => 'slug',
			'terms'    => [ 'gold' ]
		]
	],
	'meta_key'       => 'total_sales',
	'orderby'        => 'meta_value_num',
	'order'          => 'desc',
);

$popular_products = new WP_Query( $args );
$api_price = get_api_price();
?>
<div class="product">
	<div class="bone">
		<div class="product_net flex__start">
			<div class="product_items grid grid__three">
				<?php if ( $popular_products->have_posts() ) : ?>
					<?php while ( $popular_products->have_posts() ) : $popular_products->the_post();
						global $product;
						$product_id = get_the_ID();
						$product = wc_get_product( $product_id );
						$dynamic_price = get_dynamic_price( $api_price, $product );
						?>
						<div class="product_item">
							<div class="product_item_img">
								<?php echo suissevault_get_picture_html( get_post_thumbnail_id() ); ?>
							</div>
							<div class="product_item_name"><?php the_title(); ?></div>
							<div class="product_item_price price" data-price-product-id="<?php echo $product->get_id(); ?>"><?php echo wc_price( $dynamic_price[ 'price_inc_vat' ] ); ?></div>
							<div class="product_item_btn">
								<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
									<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="btn btn-line single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
								</form>
							</div>
						</div>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>
			</div>

			<div class="product_info">
				<h2>Popular <br><i>Gold Products</i></h2>
				<?php $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) ); ?>
				<a href="<?php echo $shop_page_url; ?>" class="more-line"><?php _e( 'View all', 'suissevault' ); ?></a>
			</div>
		</div>
	</div>
</div>