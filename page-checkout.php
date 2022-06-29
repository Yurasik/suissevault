<?php
/**
 * Template Name: Checkout
 *
 * @package suissevault
 */

get_header();

$checkout_time = checkout_time();
$page_class = ( !empty( is_wc_endpoint_url( 'order-received' ) ) ) ? "thank" : "checkout";
?>

	<div class="page <?php echo $page_class; ?>">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<?php if ( empty( is_wc_endpoint_url( 'order-received' ) ) ) : ?>
				<h1><?php the_title(); ?></h1>
				<div class="checkout_time">Time to confirm your order: <b><?php echo date( 'i', $checkout_time ) . "m " . date( 's', $checkout_time ) . "s"; ?></b></div>
			<?php endif; ?>

			<?php the_content(); ?>
		</div>
	</div>

<?php get_footer();