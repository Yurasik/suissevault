<?php
/**
 * The Blog page
 *
 * @package suissevault
 */

get_header();

$page_for_posts = get_option( 'page_for_posts' );
?>

	<div class="page investment">
		<?php $banner_display = get_field( 'banner_display', $page_for_posts );
		if ( $banner_display ):
			$banner = get_field( 'banner', $page_for_posts );
			$title            = get_field( 'title', $banner );
			$subtitle         = get_field( 'subtitle', $banner ); ?>
			<div class="banner">
				<?php if ( has_post_thumbnail( $banner ) ): ?>
					<div class="banner_bg">
						<?php echo suissevault_get_picture_html( get_post_thumbnail_id( $banner ) ); ?>
					</div>
				<?php endif; ?>

				<div class="bone">
					<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

					<div class="banner_net">
						<?php if ( $title ): ?>
							<h1><?php echo "$title"; ?></h1>
						<?php endif; ?>

						<?php if ( $subtitle ): ?>
							<h3><?php echo "$subtitle"; ?></h3>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/widget/ticker-tape' ); ?>

		<div class="bone">
			<div class="investment_net">
				<?php get_template_part( 'template-parts/sidebar/categories' ); ?>

				<div class="investment_content">
					<div class="investment_content_search">
						<form class="search search-form flex__align" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
							<input type="hidden" name="post_type" value="post" />
							<button type="submit" class="search-submit">
								<svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M19.6959 18.2168L14.7656 13.2662C16.0332 11.8113 16.7278 9.98069 16.7278 8.07499C16.7278 3.62251 12.9757 0 8.36391 0C3.75212 0 0 3.62251 0 8.07499C0 12.5275 3.75212 16.15 8.36391 16.15C10.0952 16.15 11.7451 15.6458 13.1557 14.6888L18.1235 19.677C18.3311 19.8852 18.6104 20 18.9097 20C19.193 20 19.4617 19.8957 19.6657 19.7061C20.0992 19.3034 20.113 18.6357 19.6959 18.2168ZM8.36391 2.10652C11.7727 2.10652 14.5459 4.78391 14.5459 8.07499C14.5459 11.3661 11.7727 14.0435 8.36391 14.0435C4.95507 14.0435 2.18189 11.3661 2.18189 8.07499C2.18189 4.78391 4.95507 2.10652 8.36391 2.10652Z" fill="var(--color)"/>
								</svg>
							</button>
							<input type="search" class="input__search search-field" name="s" value="<?php echo get_search_query() ?>" placeholder="<?php _e( 'Search articles', 'suissevault' ); ?>">
						</form>
					</div>

					<div class="investment_items">
						<?php if ( have_posts() ) : ?>
							<?php get_template_part( 'loop' ); ?>
						<?php else : ?>
							<?php get_template_part( 'content', 'none' ); ?>
						<?php endif; ?>
					</div>
				</div>

				<?php //the_posts_pagination(); ?>
			</div>
		</div>


	</div>

<?php get_footer();