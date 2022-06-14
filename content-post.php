<div id="post-<?php the_ID(); ?>" <?php post_class('investment_item flex'); ?>>
	<div class="investment_item_img">
		<?php echo suissevault_get_picture_html( get_post_thumbnail_id() ); ?>
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