<?php
/**
 * Template Name: Cart
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page lock">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<h1><?php the_title(); ?></h1>

			<?php the_content(); ?>
		</div>
	</div>

<?php get_footer();