<?php
/**
 * The front page template file.
 *
 * @package suissevault
 */

get_header(); ?>

<?php get_template_part( 'template-parts/section/banners', 'slider' ); ?>

<?php get_template_part( 'template-parts/widget/ticker-tape' ); ?>

<?php get_template_part( 'template-parts/section/about', 'us' ); ?>

<?php get_template_part( 'template-parts/section/product', 'categories' ); ?>

<?php get_template_part( 'template-parts/section/banner' ); ?>

<?php get_template_part( 'template-parts/section/feedbacks' ); ?>

<?php get_template_part( 'template-parts/section/news' ); ?>

<?php get_template_part( 'template-parts/section/contact', 'us' ); ?>

<?php get_footer();