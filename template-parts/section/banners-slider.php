<?php
$banners_slider_display = get_field( 'banners_slider_display' );
$banners_slider         = get_field( 'banners_slider' );

if ( $banners_slider_display && $banners_slider ): ?>
	<div class="main">
		<ul class="main_slider">
			<?php foreach ( $banners_slider as $post ):
				setup_postdata( $post );
				$title     = get_field( 'title' );
				$subtitle  = get_field( 'subtitle' );
				$link      = get_field( 'link' );
				$link_html = get_acf_link_html( $link, "main_href more", "", "<span></span>" ); ?>
				<li class="main_slid">
					<?php if ( has_post_thumbnail() ): ?>
						<div class="main_slid_bg">
							<?php echo suissevault_get_picture_html( get_post_thumbnail_id() ); ?>
							<div class="main_grid">
								<div class="main_grid_horizontal">
									<span></span> <span></span> <span></span>
								</div>
								<div class="main_grid_vertical">
									<span></span> <span></span> <span></span> <span></span> <span></span>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<div class="bone">
						<?php if ( get_field( 'with_product' ) ):
							$product = get_field( 'product' ); ?>
							<div class="main_slid_net flex__center">
								<div class="main_slid_img">
									<?php echo suissevault_get_picture_html( $product[ 'image' ] ); ?>
								</div>
								<div class="main_slid_info">
									<div class="subtitle"><?php echo $title; ?></div>
									<h2><span><?php echo "$product[weight]"; ?></span> <i><?php echo "$product[title]"; ?></i>
										<br>£ <?php echo "$product[price]"; ?></h2>
									<?php echo get_acf_link_html( $product[ 'link' ], "more-line" ); ?>
								</div>
								<?php echo $link_html; ?>
							</div>
						<?php else: ?>
							<div class="main_title"><?php echo $title; ?></div>
							<h3 class="main_subtitle"><?php echo $subtitle; ?></h3>
							<?php echo $link_html; ?>
						<?php endif; ?>
					</div>
				</li>
				<?php wp_reset_postdata(); ?>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>