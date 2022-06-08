<?php
$about_us_display = get_field( 'about_us_display' );
if ( $about_us_display && have_rows( 'about_us' ) ):
	while ( have_rows( 'about_us' ) ): the_row();
		$title       = get_sub_field( 'title' );
		$left_image  = get_sub_field( 'left_image' );
		$content     = get_sub_field( 'content' );
		$right_image = get_sub_field( 'right_image' );
		$link        = get_sub_field( 'link' ); ?>
		<div class="suisse">
			<div class="bone">
				<div class="suisse_net flex__center">
					<div class="suisse_left flex">
						<?php if ( $left_image ):
							$image_data = suissevault_get_image_data( $left_image );
							$picture = suissevault_get_picture_html( $image_data ); ?>
							<div class="suisse_left_img">
								<?php echo $picture; ?>
							</div>
						<?php endif; ?>
						<div class="suisse_info">
							<div class="subtitle">SUISSE VAULT</div>
							<h2><?php echo $title; ?></h2>
							<p><?php echo $content; ?></p>
							<?php if ( $link ):
								$link_url = $link[ 'url' ];
								$link_title = $link[ 'title' ];
								$link_target = $link[ 'target' ]
									? $link[ 'target' ]
									: '_self'; ?>
								<a class="more-line" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
							<?php endif; ?>
						</div>
					</div>
					<?php if ( $right_image ):
						$image_data = suissevault_get_image_data( $right_image );
						$picture = suissevault_get_picture_html( $image_data ); ?>
						<div class="suisse_img">
							<?php echo $picture; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
<?php endif; ?>