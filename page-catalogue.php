<?php
/**
 * Template Name: Catalogue
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page cataloge">

		<?php get_template_part( 'template-parts/section/banners', 'slider' ); ?>

		<?php get_template_part( 'template-parts/widget/ticker-tape' ); ?>

		<?php get_template_part( 'template-parts/section/categories-with-products' ); ?>

		<?php get_template_part( 'template-parts/section/suppliers' ); ?>

		<?php get_template_part( 'template-parts/section/news' ); ?>

		<div class="cataloge_bottom">
			<div class="bone">
				<div class="subtitle">Suisse Vault</div>
				<?php the_content(); ?>
			</div>
		</div>

	</div>

<?php get_footer();