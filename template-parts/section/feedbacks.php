<?php $feedbacks_display = ( is_product() )
	? true
	: get_field( 'feedbacks_display' ); ?>

<?php if ( $feedbacks_display ): ?>
	<?php $feedbacks = get_posts( [
		'post_type' => 'feedback'
	] ); ?>
	<div class="feetback">
		<div class="bone">
			<div class="feetback_net">
				<div class="feetback_left flex__start">
					<div>
						<div class="subtitle">feedbacks</div>
						<h2>Our <i>clients</i> say</h2>
					</div>
					<div class="feetback_slider">
						<?php foreach ( $feedbacks as $post ): setup_postdata( $post ); ?>
							<div class="feetback_slid">
								<?php the_content(); ?>
								<div class="subtitle"><?php the_title(); ?></div>
							</div>
						<?php endforeach; ?>
						<?php wp_reset_postdata(); ?>
					</div>
					<a class="more-line" href="#" target="_blank">Learn more</a>
					<div class="feetback_arrows"></div>
				</div>
				<div class="feetback_right">
					<div class="feetback_right_img">
						<picture>
							<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/f1.webp" type="image/webp">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/f1.jpg" alt srcset="<?php echo get_template_directory_uri(); ?>/assets/images/f1.jpg 1x, <?php echo get_template_directory_uri(); ?>/assets/images/f1@2x.jpg 2x">
						</picture>
					</div>
					<div class="feetback_right_img">
						<picture>
							<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/f2.webp" type="image/webp">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/f2.jpg" alt srcset="<?php echo get_template_directory_uri(); ?>/assets/images/f2.jpg 1x, <?php echo get_template_directory_uri(); ?>/assets/images/f2@2x.jpg 2x">
						</picture>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>