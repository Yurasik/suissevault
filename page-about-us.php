<?php
/**
 * Template Name: About Us
 *
 * @package suissevault
 */

get_header();

$title = get_field( 'title' );
$subtitle = get_field( 'subtitle' );
?>

	<div class="page about">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<div class="about_info">
				<?php if($title): ?>
					<h1><?php echo "$title"; ?></h1>
				<?php endif; ?>

				<?php if ( has_post_thumbnail() ) {
					echo suissevault_get_picture_html( get_post_thumbnail_id() );
				} ?>

				<?php the_content(); ?>
			</div>

			<?php get_template_part( 'template-parts/section/why', 'us' ); ?>
		</div>

		<?php get_template_part( 'template-parts/section/product', 'categories' ); ?>

		<?php get_template_part( 'template-parts/section/contact', 'us' ); ?>
	</div>

<?php get_footer();