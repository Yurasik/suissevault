<?php
/**
 * The template for displaying search results pages.
 *
 * @package suissevault
 */

get_header(); ?>

	<div class="page search">
		<div class="bone">
			<div class="search_content">
				<?php if ( have_posts() ) : ?>
					<h1 class="page-title">
						<?php /* translators: %s: search term */
						printf( esc_attr__( 'Search Results for: %s', 'storefront' ), '<span>' . get_search_query() . '</span>' ); ?>
					</h1>

					<?php ob_start();
					while ( have_posts() ) { the_post();
						if ( get_post_type() == 'product' ) {
							global $product;
							$product = wc_get_product( get_the_ID() );
							wc_get_template_part( 'content', 'product' );
						}
					}
					$products = ob_get_clean();
					if ( $products ):?>
						<h4 class="post_types_title">Products:</h4>
						<div class="products columns-3 buy_content_items grid grid__three">
							<?php echo $products; ?>
						</div>
					<?php endif; ?>

					<?php ob_start();
					while ( have_posts() ) { the_post();
						if ( get_post_type() == 'post' ) {
							get_template_part( 'content', 'post' );
						}
					}
					$news = ob_get_clean();
					if ( $news ):?>
						<h4 class="post_types_title">News:</h4>
						<div class="investment_items">
							<?php echo $news; ?>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>

<?php get_footer();
