<?php
/**
 * Template Name: Personal Area
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page cabinet">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<h1><?php the_title(); ?></h1>

			<?php the_content(); ?>
		</div>
	</div>

<?php get_footer();