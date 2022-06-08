<?php
/**
 * The template for displaying all single posts.
 *
 * @package suissevault
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php //get_template_part( 'content', 'single' ); ?>

	<div class="page news">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<h1><?php the_title(); ?></h1>

			<?php if ( has_post_thumbnail() ):
				$thumbnail_id = get_post_thumbnail_id();
				$image_data = suissevault_get_image_data( $thumbnail_id );
				$picture = suissevault_get_picture_html( $image_data ); ?>
				<div class="news_img_shadow">
					<?php echo $picture; ?>
				</div>
			<?php endif; ?>

			<h2><?php the_date( 'jS <\i>M Y</\i>' ); ?></h2>
			<div class="news_net grid">
				<div class="news_text">
					<?php the_content(); ?>
				</div>

				<?php get_template_part( 'template-parts/sidebar/categories' ); ?>
			</div>
		</div>

	</div>

	<?php get_template_part( 'template-parts/section/product', 'market' ); ?>

	<?php get_template_part( 'template-parts/section/news' ); ?>

<?php endwhile; // End of the loop. ?>

<?php get_footer();