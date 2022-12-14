<?php
/**
 * Suissevault functions.
 *
 * @package suissevault
 */

if ( !function_exists( 'suissevault_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function suissevault_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

/**
 * Call a shortcode function by tag name.
 *
 * @param string $tag The shortcode whose function to call.
 * @param array $atts The attributes to pass to the shortcode function. Optional.
 * @param array $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function suissevault_do_shortcode( $tag, array $atts = array(), $content = null ) {
	global $shortcode_tags;

	if ( !isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}

/**
 * @param $id
 *
 * @return array
 */
function suissevault_get_image_data( $id ): array {

	$image_data = array();

	$image_data[ 'src' ] = esc_attr( wp_get_attachment_image_src( $id, 'full' )[ 0 ] );
	$image_data[ 'srcset' ] = esc_attr( wp_get_attachment_image_srcset( $id ) );
	$image_data[ 'alt' ] = esc_attr( get_post_meta( $id, '_wp_attachment_image_alt', true ) );

	return $image_data;

}

/**
 * @param $thumbnail_id
 *
 * @return string
 */
function suissevault_get_picture_html( $thumbnail_id ) {

	if ( (bool)$thumbnail_id ) {
		$image_data = suissevault_get_image_data( $thumbnail_id );
		$picture = "<picture><source srcset='$image_data[src]' type='image/webp'><img src='$image_data[src]' alt='$image_data[alt]' srcset='$image_data[srcset]'></picture>";
	}
	else {
		$image_data = wc_placeholder_img_src();
		$picture = "<picture><source srcset='$image_data' type='image/webp'><img src='$image_data' alt='$image_data' srcset='$image_data'></picture>";
	}

	return $picture;
}

/**
 * @param $link
 * @param $link_class
 * @param string $before_title
 * @param string $after_title
 *
 * @return string
 */
function get_acf_link_html( $link, $link_class, $before_title = "", $after_title = "" ): string {

	$link_html = "";
	if ( $link ) {
		$link_url = $link[ 'url' ];
		$link_title = $link[ 'title' ];
		$link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';

		$link_html = "<a class='$link_class' href='" . esc_url( $link_url ) . "' target='" . esc_attr( $link_target ) . "'>$before_title" . esc_html( $link_title ) . "$after_title</a>";
	}

	return $link_html;

}

/**
 * @param $working_days
 *
 * @return array|string
 */
function abbreviated_days_of_the_week( $working_days ): string {

	$full_days_of_the_week = [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', ' ' ];
	$abbreviated_days_of_the_week = [ 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', '' ];

	return str_replace( $full_days_of_the_week, $abbreviated_days_of_the_week, $working_days );
}
