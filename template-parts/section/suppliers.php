<?php $display_suppliers = get_field( 'display_suppliers' ); ?>
<?php if ( $display_suppliers ): ?>
	<?php $suppliers = get_posts( [
		'post_type' => 'supplier',
		'order'     => 'ASC',
	] ); ?>
	<div class="our">
		<div class="bone">
			<h2>Our <i>Suppliers</i></h2>
			<div class="our_net flex__center">
				<?php foreach ( $suppliers as $post ) { setup_postdata( $post );
					echo suissevault_get_picture_html( get_post_thumbnail_id() );
				}
				wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
<?php endif;