<?php
/**
 * Template Name: Secure vaults
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page page-policy storage">
		<div class="banner">
			<div class="banner_bg">
				<?php if ( has_post_thumbnail() ) {
					echo suissevault_get_picture_html( get_post_thumbnail_id() );
				} ?>
			</div>
			<div class="bone">
				<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

				<div class="banner_net">
					<h1><?php the_title(); ?></h1>
				</div>
			</div>
		</div>

		<div class="bone">
			<div class="policy_text">
				<?php the_content(); ?>
			</div>
		</div>
	</div>

<?php get_footer();