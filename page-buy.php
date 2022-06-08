<?php
/**
 * Template Name: Buy
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page buy">
		<div class="bone">
			<div class="buy_net grid">
				<div class="buy_top">
					<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

					<h1><?php the_title(); ?></h1>
				</div>

				<div class="buy_filter">
					<div class="buy_filter_clear">Clear filters <span class="close"></span></div>

					<div class="buy_filter_block">
						<div class="buy_filter_label">Price, £</div>
						<div class="buy_filter_range range__inputs flex__center">
							<input type="text" class="range__input range__input-min" value="100"> <span></span>
							<input type="text" class="range__input range__input-max" value="800">
						</div>
						<div class="range" data-min="0" data-max="2000"></div>
					</div>

					<div class="buy_filter_block">
						<div class="buy_filter_label icon icon-arrow">Design</div>
						<ul class="buy_filter_choice">
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>Lunar (1)</span> </label>
							</li>
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>Cast (6)</span> </label>
							</li>
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>Wafer (7)</span> </label>
							</li>
						</ul>
					</div>

					<div class="buy_filter_block">
						<div class="buy_filter_label icon icon-arrow">Weight / Size</div>
						<ul class="buy_filter_choice">
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>5g (10)</span> </label>
							</li>
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>10g (2)</span> </label>
							</li>
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>20g (4)</span> </label>
							</li>
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>50g (7)</span> </label>
							</li>
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>1oz (14)</span> </label>
							</li>
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>100g (6)</span> </label>
							</li>
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>250g (1)</span> </label>
							</li>
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>500g (1)</span> </label>
							</li>
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>550g (1)</span> </label>
							</li>
							<li>
								<label> <input type="checkbox" class="input__hidden"> <span>800g (1)</span> </label>
							</li>
							<li class="more_items icon icon-arrow">Show more</li>
						</ul>
					</div>

					<div class="buy_filter_block">
						<div class="buy_filter_label">Year</div>
						<div class="buy_filter_range range__inputs flex__center">
							<input type="text" class="range__input range__input-min" value="100"> <span></span>
							<input type="text" class="range__input range__input-max" value="800">
						</div>
						<div class="range" data-min="0" data-max="2000"></div>
					</div>
				</div>

				<div class="buy_content">
					<div class="buy_content_top flex__center">
						<div class="buy_content_number">Showed items <span>75</span></div>
						<div class="buy_content_select flex__align">
							<span>Sort by:</span>
							<div class="select">
								<select name="Sort">
									<option value="0">£ Per Oz / Best Deals</option>
									<option value="1">£ Per Oz / Best Deals 2</option>
									<option value="2">£ Per Oz / Best Deals 3</option>
								</select>
							</div>
						</div>
					</div>
					<div class="buy_content_items grid grid__three">
						<a class="buy_content_item" href="#">
							<div class="buy_content_item_img">
								<picture>
									<source srcset="/develop/suisse/images/gold.webp" type="image/webp">
									<img src="/develop/suisse/images/gold.jpg" alt srcset="/develop/suisse/images/gold.jpg 1x, /develop/suisse/images/gold@2x.jpg 2x"></picture>
							</div>
							<div class="buy_content_item_name">1 Kg Gold Bar - Our Choice Pre-Owned</div>
							<div class="buy_content_item_price">£41,668.04</div>
						</a> <a class="buy_content_item" href="#">
							<div class="buy_content_item_img">
								<picture>
									<source srcset="/develop/suisse/images/i2.webp" type="image/webp">
									<img src="/develop/suisse/images/i2.jpg" alt srcset="/develop/suisse/images/i2.jpg 1x, /develop/suisse/images/i2@2x.jpg 2x"></picture>
							</div>
							<div class="buy_content_item_name">500g Gold Bar - Our Choice Pre-Owned</div>
							<div class="buy_content_item_price">£20,939.67</div>
						</a> <a class="buy_content_item" href="#">
							<div class="buy_content_item_img">
								<picture>
									<source srcset="/develop/suisse/images/i3.webp" type="image/webp">
									<img src="/develop/suisse/images/i3.jpg" alt srcset="/develop/suisse/images/i3.jpg 1x, /develop/suisse/images/i3@2x.jpg 2x"></picture>
							</div>
							<div class="buy_content_item_name">500g Gold Bar Johnson Matthey & Pauwels - Pre-Owned</div>
							<div class="buy_content_item_price">£20,944.26</div>
						</a> <a class="buy_content_item" href="#">
							<div class="buy_content_item_img">
								<picture>
									<source srcset="/develop/suisse/images/i4.webp" type="image/webp">
									<img src="/develop/suisse/images/i4.jpg" alt srcset="/develop/suisse/images/i4.jpg 1x, /develop/suisse/images/i4@2x.jpg 2x"></picture>
							</div>
							<div class="buy_content_item_name">250g Gold Bar - Our Choice Pre-Owned</div>
							<div class="buy_content_item_price">£10,523.63</div>
						</a> <a class="buy_content_item" href="#">
							<div class="buy_content_item_img">
								<picture>
									<source srcset="/develop/suisse/images/i5.webp" type="image/webp">
									<img src="/develop/suisse/images/i5.jpg" alt srcset="/develop/suisse/images/i5.jpg 1x, /develop/suisse/images/i5@2x.jpg 2x"></picture>
							</div>
							<div class="buy_content_item_name">Gold 5 oz Bar Baird - Pre-Owned</div>
							<div class="buy_content_item_price">£6,540.32</div>
						</a> <a class="buy_content_item" href="#">
							<div class="buy_content_item_img">
								<picture>
									<source srcset="/develop/suisse/images/i6.webp" type="image/webp">
									<img src="/develop/suisse/images/i6.jpg" alt srcset="/develop/suisse/images/i6.jpg 1x, /develop/suisse/images/i6@2x.jpg 2x"></picture>
							</div>
							<div class="buy_content_item_name">5 oz Gold Bar Perth Mint - Pre-Owned</div>
							<div class="buy_content_item_price">£6,541.86</div>
						</a> <a class="buy_content_item" href="#">
							<div class="buy_content_item_img">
								<picture>
									<source srcset="/develop/suisse/images/i7.webp" type="image/webp">
									<img src="/develop/suisse/images/i7.jpg" alt srcset="/develop/suisse/images/i7.jpg 1x, /develop/suisse/images/i7@2x.jpg 2x"></picture>
							</div>
							<div class="buy_content_item_name">500g Gold Bar Umicore - Pre-Owned</div>
							<div class="buy_content_item_price">£21,030.04</div>
						</a> <a class="buy_content_item" href="#">
							<div class="buy_content_item_img">
								<picture>
									<source srcset="/develop/suisse/images/i8.webp" type="image/webp">
									<img src="/develop/suisse/images/i8.jpg" alt srcset="/develop/suisse/images/i8.jpg 1x, /develop/suisse/images/i8@2x.jpg 2x"></picture>
							</div>
							<div class="buy_content_item_name">1 Kg Gold Bar Metalor - Cast</div>
							<div class="buy_content_item_price">£42,104.12</div>
						</a> <a class="buy_content_item" href="#">
							<div class="buy_content_item_img">
								<picture>
									<source srcset="/develop/suisse/images/i6.webp" type="image/webp">
									<img src="/develop/suisse/images/i6.jpg" alt srcset="/develop/suisse/images/i6.jpg 1x, /develop/suisse/images/i6@2x.jpg 2x"></picture>
							</div>
							<div class="buy_content_item_name">5 oz Gold Bar Perth Mint - Pre-Owned</div>
							<div class="buy_content_item_price">£21,073.38</div>
						</a>
					</div>
					<div class="buy_content_pagination">

						<!-- Pagination. -->
						<div class="pagination">
							<ul class="pagination_net flex__align">
								<li class="pagination__arrow">
									<a href="#">
										<svg width="7" height="14" viewbox="0 0 7 14" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M7 14L-2.67732e-07 7.875L-3.45546e-07 6.09483L7 -3.0598e-07L7 1.8556L1.10084 6.98491L7 12.2047L7 14Z" fill="var(--color)"/>
										</svg>
									</a>
								</li>
								<li class="active"><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">12</a></li>
								<li class="pagination__arrow">
									<a href="#">
										<svg width="7" height="14" viewbox="0 0 7 14" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M-4.76837e-07 14L7 7.875L7 6.09483L1.35122e-07 -3.0598e-07L5.40113e-08 1.8556L5.89916 6.98491L-3.98364e-07 12.2047L-4.76837e-07 14Z" fill="var(--color)"/>
										</svg>
									</a>
								</li>
							</ul>
						</div>
						<!-- Pagination. -->

					</div>
				</div>

				<div class="buy_bottom">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>

<?php get_footer();