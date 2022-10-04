<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package suissevault
 */

if ( ! is_active_sidebar( 'sidebar-shop' ) ) {
	return;
}
?>

<div id="sidebar-shop" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-shop' ); ?>
</div><!-- #secondary -->
