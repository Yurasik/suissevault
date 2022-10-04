<?php

function suissevault_faq( $atts ) {

	$html      = "";
	$faq_posts = get_posts( [
		'numberposts'      => -1,
		'orderby'          => 'date',
		'order'            => 'ASC',
		'post_type'        => 'faq',
		'suppress_filters' => true,
	] );

	if ( $faq_posts ) {
		$faq_tabs  = "";
		$faq_steps = "";
		foreach ( $faq_posts as $key => $post ) {
			setup_postdata( $post );
			$active  = $key == 0
				? "active"
				: "";
			$display = $key == 0
				? ""
				: "style='display: none;'";

			$faq_tabs  .= "<div class='faq_tab $active icon icon-faq_arrow'>" . get_the_title(  $post) . "</div>";
			$faq_steps .= "<div class='faq_step step-faq' $display>" . get_the_content( $post ) . "</div>";
		}
		wp_reset_postdata();

		$html = "
		<div class='faq_net grid'>
			<div class='faq_tabs'>$faq_tabs</div>
			<div class='faq_steps'>$faq_steps</div>
		</div>";
	}

	return $html;

}
add_shortcode( 'suissevault_faq', 'suissevault_faq' );