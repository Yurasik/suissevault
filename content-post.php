<div id="post-<?php the_ID(); ?>" <?php post_class('investment_item flex'); ?>>
	<?php
	$picture = "<img src='" . get_theme_file_uri() . "/assets/images/no-image.png" . "' alt='no-image'>";
	if ( has_post_thumbnail() ) {
		$thumbnail_id = get_post_thumbnail_id();
		$image_data = suissevault_get_image_data( $thumbnail_id );
		$picture = suissevault_get_picture_html( $image_data );
	} ?>
	<div class="investment_item_img">
		<?php echo $picture; ?>
	</div>
	<div class="investment_item_info">
		<div class="flex__center">
			<h4><?php the_title(); ?></h4>
			<time><?php the_time( 'd/m/Y' ); ?></time>
		</div>
		<div class="investment_item_author"><?php echo get_the_author_meta('display_name'); ?></div>
		<div class="investment_item_text"><?php the_excerpt(); ?></div>
		<a href="<?php the_permalink(); ?>" class="more-line"><?php _e( 'read more', 'suissevault' ); ?></a>
	</div>
</div>