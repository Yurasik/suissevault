<?php
/**
 * Suissevault template functions.
 *
 * @package suissevault
 */

/**
 * @param $mimes
 *
 * @return mixed
 */
function add_file_types_to_uploads( $mimes ) {

	$mimes[ 'svg' ] = 'image/svg+xml';

	return $mimes;
}

/**
 * @param $init
 *
 * @return mixed
 */
function tinyMCE_tags_exceptions( $init ) {
	// Command separated string of extended elements
	$ext = 'span[id|name|class|style]';

	// Add to extended_valid_elements if it alreay exists
	if ( isset( $init[ 'extended_valid_elements' ] ) ) {
		$init[ 'extended_valid_elements' ] .= ',' . $ext;
	}
	else {
		$init[ 'extended_valid_elements' ] = $ext;
	}

	return $init;
}

/**
 * @param $more
 *
 * @return string
 */
function remove_excerpt_more( $more ) {
	return '';
}

if ( !function_exists( 'suissevault_edit_post_link' ) ) {
	/**
	 * Display the edit link
	 */
	function suissevault_edit_post_link() {
		edit_post_link( sprintf( wp_kses( /* translators: %s: Name of current post. Only visible to screen readers */ __( 'Edit <span class="screen-reader-text">%s</span>', 'suissevault' ), array(
				'span' => array(
					'class' => array(),
				),
			) ), get_the_title() ), '<div class="edit-link">', '</div>' );
	}
}

if ( !function_exists( 'suissevault_auth_menu_atts' ) ) {

	function suissevault_auth_menu_atts( $atts, $item, $args ) {

		if ( $item->post_title == "Login" ) {
			$atts[ 'data-modal-name' ] = 'login';
			$atts[ 'class' ] = 'modal-link';
		}
		elseif ( $item->post_title == "Signup" ) {
			$atts[ 'data-modal-name' ] = 'register';
			$atts[ 'class' ] = 'modal-link';
		}

		return $atts;
	}
}

/****/
function walker_nav_menu_start_el_filter( $item_output, $menu_item, $depth, $args ){
    if($menu_item->ID==562){
        $item_output .= '<span class="menu-arrow"><span></span><span></span></span>';
    }
	return $item_output;
}

