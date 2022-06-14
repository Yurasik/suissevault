<?php $product_categories_display = get_field( 'product_categories_display' );
if ( $product_categories_display ): ?>
	<div class="browse">
		<div class="bone">
			<?php $pages   = get_pages( array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => 'page-catalogue.php'
			) );
			$catalogue_url = ( isset( $pages[ 0 ] ) )
				? get_page_link( $pages[ 0 ]->ID )
				: "#"; ?>
			<div class="browse_info">
				<div class="subtitle">Browse All Products</div>
				<h2>We <i>offer</i> a wide range of gold and silver bars and coins available <br> at low premiums.</h2>
				<a href="<?php echo $catalogue_url; ?>" class="more-line">Find out more</a>
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
						$thumbnail_id = get_term_meta( $product_category->term_id, 'thumbnail_id', true );
						$min_product_category_price = suissevault_get_min_price_per_product_cat( $product_category->term_id ); ?>
						<div class="browse_slid">
							<a class="browse_slid_img" href="<?php echo get_category_link( $product_category ); ?>">
								<?php echo suissevault_get_picture_html( $thumbnail_id ); ?>
							</a>
							<div class="browse_slid_bottom flex__center">
								<span><?php echo $product_category->name; ?></span> <span><?php echo "from  £$min_product_category_price"; ?></span>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>