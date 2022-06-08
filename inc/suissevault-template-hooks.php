<?php
/**
 * Suissevault hooks
 *
 * @package suissevault
 */

add_filter( 'upload_mimes', 'add_file_types_to_uploads' );

add_filter( 'tiny_mce_before_init', 'tinyMCE_tags_exceptions' );

add_filter( 'excerpt_more', 'remove_excerpt_more' );