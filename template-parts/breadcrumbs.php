<?php
/**
 * The Breadcrumbs template file.
 *
 * @package suissevault
 */

$title = get_the_title();
$post_type = get_post_type();
$parent_link_html = "";

if ( is_home() ) {
	$page_for_posts = get_option( 'page_for_posts' );
	$title = get_the_title( $page_for_posts );
}
elseif ( is_single() && $post_type == 'post' ) {
	$page_for_posts = get_option( 'page_for_posts' );
	$parent_title = get_the_title( $page_for_posts );
	$parent_permalink = get_permalink( $page_for_posts );
	$parent_link_html = "<li><a class='hover__line' href='$parent_permalink'>$parent_title</a></li>";
}
elseif ( is_category() ) {
	$title = single_cat_title( '', false );
	$parent_link_html = "<li>Category</li>";
}
elseif ( suissevault_is_product_archive() ) {
	$title = woocommerce_page_title( false );
}
elseif ( is_product() ) {
	$shop_page = wc_get_page_id( 'shop' );
	$parent_title = woocommerce_page_title( false );
	$parent_permalink = get_permalink( $shop_page );
	$parent_link_html = "<li><a class='hover__line' href='$parent_permalink'>$parent_title</a></li>";
}
?>
<!-- Breadcrumbs. -->
<ul class="breadcrumbs flex__align">
	<li>
		<a class="hover__line" href="<?php echo home_url(); ?>"><?php echo _e( 'Home', 'suissevault' ); ?></a>
	</li>
	<?php echo $parent_link_html; ?>
	<li><?php echo $title; ?></li>
</ul>
<!-- Breadcrumbs. -->