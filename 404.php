<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package suissevault
 */

get_header();

$page_404 = get_field( 'page_404', 'options' );
?>

	<div class="page four">
		<div class="bone">
			<div class="four_content">
				<?php if ( $page_404[ 'image' ] ) {
					$image_data = suissevault_get_image_data( $page_404[ 'image' ] );
					$picture    = suissevault_get_picture_html( $image_data );

					echo $picture;
				} ?>
				<?php echo "$page_404[text]"; ?>
			</div>
		</div>
	</div>

<?php get_footer();