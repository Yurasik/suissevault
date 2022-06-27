<?php if ( have_rows( 'categories_with_products' ) ):
	$api_price = get_api_price();
	?>
	<?php while ( have_rows( 'categories_with_products' ) ): the_row();
		$background_color               = get_sub_field( 'background_color' );
		$market_background_color_class  = ( $background_color == "grey" )
			? ""
			: "market-$background_color";
		$product_background_color_class = ( $background_color == "grey" )
			? ""
			: "product-$background_color"; ?>

		<?php if ( have_rows( 'categories' ) ): ?>
			<div class="market <?php echo "$market_background_color_class"; ?>">
				<div class="bone">
					<div class="market_net grid grid__twoo">
						<?php while ( have_rows( 'categories' ) ): the_row();
							$category = get_sub_field( 'category' );
							$thumbnail_id = get_field( 'catalogue_image', $category );

							$exploded_name = explode( ' ', $category->name );
							$market_name   = "";
							foreach ( $exploded_name as $name_key => $name_value ) {
								$market_name .= ( $name_key == 0 )
									? "<span>$name_value</span> "
									: "<i>$name_value</i> ";
							} ?>
							<div class="market_item">
								<div class="market_bg">
									<?php echo suissevault_get_picture_html( $thumbnail_id ); ?>
								</div>
								<h2 class="market_name"><?php echo $market_name; ?></h2>
								<a href="<?php echo get_category_link( $category ); ?>" class="more-line">Buy <?php echo $category->name; ?></a>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>

			<?php $category_key = 1; ?>
			<?php while ( have_rows( 'categories' ) ): the_row();
				$category = get_sub_field( 'category' );
				$products = get_posts( [
					'post_type'   => 'product',
					'numberposts' => 3,
					'post_status' => 'publish',
					'tax_query'   => [
						[
							'taxonomy' => 'product_cat',
							'field'    => 'term_id',
							'terms'    => $category->term_id,
							'operator' => 'IN'
						]
					],
					'fields'      => 'ids'
				] ); ?>
				<?php if ( $products ):
					$product_reverse_class = ( $category_key % 2 == 0 )
						? "product_net-reverse"
						: ""; ?>
					<div class="product <?php echo "$product_background_color_class"; ?>">
						<div class="bone">
							<div class="product_net <?php echo "$product_reverse_class"; ?> flex__start">
								<div class="product_items grid grid__three">
									<?php foreach ( $products as $product_id ):
										$product = wc_get_product( $product_id );
										$dynamic_price = get_dynamic_price( $api_price, $product );
										?>
										<div class="product_item">
											<div class="product_item_img"><?php echo suissevault_get_picture_html( get_post_thumbnail_id( $product_id ) ); ?></div>
											<div class="product_item_name"><?php echo $product->get_title(); ?></div>
											<div class="product_item_price price" data-price-product-id="<?php echo $product->get_id(); ?>"><?php echo wc_price( $dynamic_price[ 'price_inc_vat' ] ); ?></div>
											<div class="product_item_btn">
												<a href="<?php echo $product->add_to_cart_url(); ?>" class="btn btn-line ajax_add_to_cart add_to_cart_button" data-product_id="<?php echo $product_id; ?>">
													<?php echo $product->single_add_to_cart_text(); ?>
												</a>
											</div>
										</div>
									<?php endforeach; ?>
									<?php wp_reset_postdata(); ?>
								</div>
								<div class="product_info">
									<h2>Buy <br><i><?php echo $category->name; ?></i></h2>
									<a href="<?php echo get_category_link( $category ); ?>" class="more-line">View all</a>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php $category_key++; ?>
			<?php endwhile; ?>
		<?php endif; ?>

	<?php endwhile; ?>
<?php endif;