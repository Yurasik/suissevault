<?php
/**
 * Template Name: Membership & Partners
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page membership">
		<div class="banner">
			<div class="banner_bg">
				<?php if ( has_post_thumbnail() ) {
					$thumbnail_id = get_post_thumbnail_id();
					$image_data   = suissevault_get_image_data( $thumbnail_id );
					$picture      = suissevault_get_picture_html( $image_data );

					echo $picture;
				} ?>
			</div>
			<div class="bone">
				<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

				<div class="banner_net">
					<h1><?php the_title(); ?></h1>
				</div>
			</div>
		</div>

		<?php if ( have_rows( 'image_text_blocks' ) ): ?>
			<?php while ( have_rows( 'image_text_blocks' ) ): the_row();
				$title  = get_sub_field( 'title' );
				$blocks = get_sub_field( 'blocks' ); ?>
				<div class="bone">
					<h3><i><?php echo "$title"; ?></i></h3>
					<?php if ( $blocks ): ?>
						<?php foreach ( $blocks as $key => $block) :
							$image       = $block[ 'image' ];
							$text        = $block[ 'text' ];
							$block_class = ( ($key+1) & 1 )
								? ""
								: "_reverse"; ?>
							<div class="membership_block flex__align <?php echo "$block_class"; ?>">
								<?php if ( $image ) {
									$image_data = suissevault_get_image_data( $image );
									$picture    = suissevault_get_picture_html( $image_data );

									echo "$picture";
								} ?>
								<div>
									<?php echo "$text"; ?>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>

<?php get_footer();