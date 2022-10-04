<?php
/**
 * Template Name: Storage Information
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page storage">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<div class="storage_content">
				<?php the_content(); ?>
			</div>
		</div>
	</div>

<?php get_footer();