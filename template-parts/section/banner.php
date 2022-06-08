<?php $banner_display = get_field( 'banner_display' );
if ( $banner_display ):
	$banner = get_field( 'banner' );
	$title            = get_field( 'title', $banner );
	$subtitle         = get_field( 'subtitle', $banner );
	$link             = get_field( 'link', $banner );
	$link_html        = ( $link )
		? get_acf_link_html( $link, "property_href more", "", "<span></span>" )
		: ""; ?>
	<div class="property">
		<?php if ( has_post_thumbnail( $banner ) ):
			$thumbnail_id = get_post_thumbnail_id( $banner );
			$image_data = suissevault_get_image_data( $thumbnail_id );
			$picture = suissevault_get_picture_html( $image_data ); ?>
			<div class="property_bg">
				<?php echo $picture; ?>
			</div>
		<?php endif; ?>
		<div class="property_watermark">
			<picture>
				<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/svg/watermark.svg" type="image/webp">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/svg/watermark.svg" alt="watermark">
			</picture>
		</div>
		<div class="bone">
			<div class="property_net">
				<div class="property_title"><?php echo $title; ?></div>
				<h3><?php echo $subtitle; ?></h3>
				<?php echo $link_html; ?>
			</div>
		</div>
	</div>
<?php endif; ?>