<?php
/**
 * Template Name: FAQ
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page faq">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<h1><?php the_title(); ?></h1>

			<?php the_content(); ?>
		</div>
	</div>

<?php get_footer();