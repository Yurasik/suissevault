<?php $product_categories_display = get_field( 'product_categories_display' );
if ( $product_categories_display ): ?>
	<div class="browse">
		<div class="bone">
			<div class="browse_info">
				<div class="subtitle">Browse All Products</div>
				<h2>We <i>offer</i> a wide range of gold and silver bars and coins available <br> at low premiums.</h2>
				<a href="<?php echo get_post_type_archive_link( 'product' ); ?>" class="more-line">Find out more</a>
			</div>
		</div>

		<?php $product_categories = get_terms( array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
		) ); ?>
		<?php if ( $product_categories ): ?>
			<div class="browse_bottom">
				<div class="browse_arrows"></div>
				<div class="browse_slider">
					<?php foreach ( $product_categories as $product_category ):
						$term_id = $product_category->term_id;
						$thumbnail_id = get_term_meta( $term_id, 'thumbnail_id', true );
						$min_dynamic_price_by_cat = get_min_dynamic_price_by_cat( $term_id );
						?>
						<div class="browse_slid">
							<a class="browse_slid_img" href="<?php echo get_category_link( $product_category ); ?>">
								<?php echo suissevault_get_picture_html( $thumbnail_id ); ?>
							</a>
							<div class="browse_slid_bottom flex__center">
								<span><?php echo $product_category->name; ?></span> <span class="min_price" data-min-price-term-id="<?php echo $term_id; ?>"><?php echo "from " . wc_price( $min_dynamic_price_by_cat ); ?></span>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>