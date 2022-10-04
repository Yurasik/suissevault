<?php
/**
 * Suissevault hooks
 *
 * @package suissevault
 */

add_filter( 'upload_mimes', 'add_file_types_to_uploads' );
add_filter( 'tiny_mce_before_init', 'tinyMCE_tags_exceptions' );
add_filter( 'excerpt_more', 'remove_excerpt_more' );
add_filter( 'nav_menu_link_attributes', 'suissevault_auth_menu_atts', 10, 3 );
/****/
add_filter( 'walker_nav_menu_start_el', 'walker_nav_menu_start_el_filter', 10, 4 );
