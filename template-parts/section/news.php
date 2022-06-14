<?php
$news_display = ( !is_single() )
	? get_field( 'news_display' )
	: true;

if ( $news_display ):
	$posts = get_posts( [
		'post_type'   => 'post',
		'numberposts' => 5,
		'orderby'     => 'date',
		'order'       => 'DESC'
	] );

	if ( $posts ): ?>
		<div class="stay">
			<div class="bone">
				<div class="stay_net flex__end">
					<div>
						<div class="subtitle">Stay in touch</div>
						<h2>Latest <i>news</i></h2>
					</div>
					<a class="more-line" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">show more</a>
				</div>
			</div>
			<div class="stay_slider">
				<?php foreach ( $posts as $post ): setup_postdata( $post );
					$post_id    = get_the_ID();
					$categories = get_the_category( $post_id );
					?>
					<div class="stay_slid">
						<div class="stay_slid_img">
							<?php echo suissevault_get_picture_html( get_post_thumbnail_id() ); ?>
						</div>
						<div class="stay_slid_top flex__center">
							<time><?php the_date(); ?></time>
							<span><?php echo $categories[ 0 ]->name; ?></span>
						</div>
						<h4><?php the_title(); ?></h4>
						<a href="<?php the_permalink(); ?>">read more</a>
					</div>
					<?php wp_reset_postdata(); ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>