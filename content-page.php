<div class="banner">
	<?php if ( has_post_thumbnail() ) :
		$thumbnail_id = get_post_thumbnail_id();
		$image_data = suissevault_get_image_data( $thumbnail_id );
		$picture = suissevault_get_picture_html( $image_data ); ?>
		<div class="banner_bg">
			<?php echo $picture; ?>
		</div>
	<?php endif; ?>

	<div class="bone">
		<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

		<div class="banner_net">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
</div>

<div class="bone">
	<?php the_content(); ?>
</div>