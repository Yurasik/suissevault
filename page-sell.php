<?php
/**
 * Template Name: Sell
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page sell">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<!-- <div class="sell_net grid">
				<div class="sell_top">
					<ul class="breadcrumbs flex__align">
						<li>
							<a class="hover__line" href="/">Home</a>
						</li>
						<li>sell</li>
					</ul>
					<h1>Precious Metals Price List</h1>
				</div>
				<div class="filter">
					<div class="filter_clear">Clear filters <span class="close"></span></div>
					<div class="filter_block">
						<div class="filter_label icon icon-arrow">Mint/Refiner</div>
						<ul class="filter_choice">
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Argor Heraeus (65)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Royal Canadian Mint (14)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>The Royal Mint (6)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Valcambi (20)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Rand Refinery (17)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Munze Osterreich (34)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>United States Mint (11)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>The Perth Mint (15)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>The Holy Land Mint (24)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Mexico City Mint (54)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Chinese Mint (19)</span>
								</label>
							</li>
							<li class="more_items icon icon-arrow">Show more</li>
						</ul>
					</div>
					<div class="filter_block">
						<div class="filter_label icon icon-arrow">Weight</div>
						<ul class="filter_choice">
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>2.5g (65)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>5g (14)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>10g (6)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>20g (20)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>1oz (17)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>50g (34)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>100g (11)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>100g cast (15)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>250g cast (24)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>500g cast(54)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>1kg (19)</span>
								</label>
							</li>
							<li class="more_items icon icon-arrow">Show more</li>
						</ul>
					</div>
					<div class="filter_block">
						<div class="filter_label icon icon-arrow">Type</div>
						<ul class="filter_choice">
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Gold Bar (65)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Gold Coins (14)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Gifts (6)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Siver Coin (20)</span>
								</label>
							</li>
							<li>
								<label>
									<input type="checkbox" class="input__hidden">
									<span>Silver Bar (17)</span>
								</label>
							</li>
						</ul>
					</div>
				</div>
				<div class="sell_content">
					<div class="sell_content_top flex__center">
						<div class="sell_content_tabs flex__align">
							<div class="sell_content_tab active">Gold</div>
							<div class="sell_content_tab">Silver</div>
							<div class="sell_content_tab">All</div>
						</div>
						<a class="more-line" href="#">Print list</a>
					</div>
					<div class="sell_content_name flex__align">
						<h2>Gold Bar</h2>
						<div class="sell_content_search">
							<div class="search flex__align">
								<button>
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M19.6959 18.2168L14.7656 13.2662C16.0332 11.8113 16.7278 9.98069 16.7278 8.07499C16.7278 3.62251 12.9757 0 8.36391 0C3.75212 0 0 3.62251 0 8.07499C0 12.5275 3.75212 16.15 8.36391 16.15C10.0952 16.15 11.7451 15.6458 13.1557 14.6888L18.1235 19.677C18.3311 19.8852 18.6104 20 18.9097 20C19.193 20 19.4617 19.8957 19.6657 19.7061C20.0992 19.3034 20.113 18.6357 19.6959 18.2168ZM8.36391 2.10652C11.7727 2.10652 14.5459 4.78391 14.5459 8.07499C14.5459 11.3661 11.7727 14.0435 8.36391 14.0435C4.95507 14.0435 2.18189 11.3661 2.18189 8.07499C2.18189 4.78391 4.95507 2.10652 8.36391 2.10652Z" fill="var(--color)"/>
									</svg>
								</button>
								<input class="input__search" type="text" placeholder="Search list">
							</div>
						</div>
					</div>
					<table class="sell_content_table">
						<tr>
							<th class="icon icon-arrows">Description</th>
							<th class="icon icon-arrows">Weight (grams)</th>
							<th class="icon icon-arrows">We buy</th>
							<th class="icon icon-arrows">We sell</th>
						</tr>
						<tr>
							<td class="_img">
								<picture><source srcset="/develop/suisse/images/i1.webp" type="image/webp"><img src="/develop/suisse/images/i1.jpg" alt=""></picture>
							</td>
							<td class="_name">100g Cast Gold Bar - Sharps Pixley</td>
							<td class="_grams">100.00</td>
							<td class="_buy">£4,171.14</td>
							<td class="_sell">£4,397.00</td>
							<td class="_btn">
								<div class="btn btn-line">Buy now</div>
							</td>
						</tr>
						<tr>
							<td class="_img">
								<picture><source srcset="/develop/suisse/images/i2.webp" type="image/webp"><img src="/develop/suisse/images/i2.jpg" alt=""></picture>
							</td>
							<td class="_name">100g Cast Gold Bar - Sharps Pixley</td>
							<td class="_grams">100.00</td>
							<td class="_buy">£4,171.14</td>
							<td class="_sell">£4,397.00</td>
							<td class="_btn">
								<div class="btn btn-line">Buy now</div>
							</td>
						</tr>
						<tr>
							<td class="_img">
								<picture><source srcset="/develop/suisse/images/i3.webp" type="image/webp"><img src="/develop/suisse/images/i3.jpg" alt=""></picture>
							</td>
							<td class="_name">100g Cast Gold Bar - Sharps Pixley</td>
							<td class="_grams">100.00</td>
							<td class="_buy">£4,171.14</td>
							<td class="_sell">£4,397.00</td>
							<td class="_btn">
								<div class="btn btn-line">Buy now</div>
							</td>
						</tr>
					</table>
					<div class="sell_content_name flex__align">
						<h2>Gold Coins</h2>
					</div>
					<table class="sell_content_table">
						<tr>
							<th class="icon icon-arrows">Description</th>
							<th class="icon icon-arrows">Weight (grams)</th>
							<th class="icon icon-arrows">We buy</th>
							<th class="icon icon-arrows">We sell</th>
						</tr>
						<tr>
							<td class="_img">
								<picture><source srcset="/develop/suisse/images/i1.webp" type="image/webp"><img src="/develop/suisse/images/i1.jpg" alt=""></picture>
							</td>
							<td class="_name">100g Cast Gold Bar - Sharps Pixley</td>
							<td class="_grams">100.00</td>
							<td class="_buy">£4,171.14</td>
							<td class="_sell">£4,397.00</td>
							<td class="_btn">
								<div class="btn btn-line">Buy now</div>
							</td>
						</tr>
						<tr>
							<td class="_img">
								<picture><source srcset="/develop/suisse/images/i2.webp" type="image/webp"><img src="/develop/suisse/images/i2.jpg" alt=""></picture>
							</td>
							<td class="_name">100g Cast Gold Bar - Sharps Pixley</td>
							<td class="_grams">100.00</td>
							<td class="_buy">£4,171.14</td>
							<td class="_sell">£4,397.00</td>
							<td class="_btn">
								<div class="btn btn-line">Buy now</div>
							</td>
						</tr>
						<tr>
							<td class="_img">
								<picture><source srcset="/develop/suisse/images/i3.webp" type="image/webp"><img src="/develop/suisse/images/i3.jpg" alt=""></picture>
							</td>
							<td class="_name">100g Cast Gold Bar - Sharps Pixley</td>
							<td class="_grams">100.00</td>
							<td class="_buy">£4,171.14</td>
							<td class="_sell">£4,397.00</td>
							<td class="_btn">
								<div class="btn btn-line">Buy now</div>
							</td>
						</tr>
					</table>
				</div>
			</div> -->

			<?php the_content(); ?>
		</div>

		<?php $sell_steps = get_field( 'sell_steps' ); ?>
		<?php if ( $sell_steps[ 'display_sell_steps' ] ): ?>
			<div class="sell_three">
				<div class="sell_three_bg">
					<?php if ( $sell_steps[ 'background' ] ) {
						echo suissevault_get_picture_html( $sell_steps[ 'background' ] );
					} ?>
				</div>
				<div class="bone">
					<div class="sell_three_title"><?php echo "$sell_steps[title]"; ?></div>
					<?php if ( $sell_steps[ 'steps' ] ): ?>
						<div class="sell_three_items grid">
							<?php foreach ( $sell_steps[ 'steps' ] as $step ) : ?>
								<div class="sell_three_item">
									<h3><?php echo $step[ 'title' ]; ?></h3>
									<p><?php echo $step[ 'text' ]; ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php $sell_bottom = get_field( 'sell_bottom' ); ?>
		<?php if ( $sell_bottom[ 'display_sell_bottom' ] ): ?>
			<div class="sell_bottom">
				<div class="bone">
					<div class="subtitle"><?php echo "$sell_bottom[title]"; ?></div>
					<?php echo "$sell_bottom[text]"; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>

<?php get_footer();