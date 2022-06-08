<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}
?>
<nav class="woocommerce-pagination">
	<div class="pagination">
		<?php
		$left_arrow = '<svg width="7" height="14" viewbox="0 0 7 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 14L-2.67732e-07 7.875L-3.45546e-07 6.09483L7 -3.0598e-07L7 1.8556L1.10084 6.98491L7 12.2047L7 14Z" fill="var(--color)"/></svg>';
		$right_arrow = '<svg width="7" height="14" viewbox="0 0 7 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M-4.76837e-07 14L7 7.875L7 6.09483L1.35122e-07 -3.0598e-07L5.40113e-08 1.8556L5.89916 6.98491L-3.98364e-07 12.2047L-4.76837e-07 14Z" fill="var(--color)"/></svg>';
		$paginate_links = paginate_links(
			apply_filters(
				'woocommerce_pagination_args',
				array( // WPCS: XSS ok.
					'base'      => $base,
					'format'    => $format,
					'add_args'  => false,
					'current'   => max( 1, $current ),
					'total'     => $total,
					'prev_text' => is_rtl() ? $right_arrow : $left_arrow,
					'next_text' => is_rtl() ? $left_arrow : $right_arrow,
					'type'      => 'list',
					'end_size'  => 1,
					'mid_size'  => 2,
				)
			)
		);
		$paginate_links = str_replace( "<ul class='page-numbers", "<ul class='page-numbers pagination_net flex__align", $paginate_links );
		echo $paginate_links;
		?>
	</div>
</nav>
