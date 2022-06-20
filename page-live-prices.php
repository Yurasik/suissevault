<?php
/**
 * Template Name: Live Prices
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page live">
		<div class="bone">
			<div class="live_net grid">
				<div class="live_top">
					<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
					<h1><?php the_title(); ?></h1>
				</div>
				<form class="filter">
					<?php
					$filters = [
						[
							'name'   => 'weight',
							'title'  => 'Weight',
							'fields' => [
								'ounces'    => 'Ounces',
								'grams'     => 'Grams',
								'kilograms' => 'Kilograms',
							]
						],
						[
							'name'   => 'currency',
							'title'  => 'Currency',
							'fields' => [
								'GBP' => 'GBP',
								'USD' => 'USD',
								'EUR' => 'EUR',
								'JPY' => 'JPY',
							]
						],
						[
							'name'   => 'period',
							'title'  => 'Period',
							'fields' => [
								'1D'   => 'Today',
								'5D'   => 'Week',
								'1M'   => 'Month',
								'3M'   => '3 Month',
								'6M'   => '6 Month',
								'12M'  => 'Year',
								'60M'  => '5 Year',
								'ALL'  => 'All Time',
							]
						],
					];
					?>
					<div class="filter_clear">Clear filters <span class="close"></span></div>
					<?php foreach ( $filters as $filter ):
						$fields = $filter [ 'fields' ];
						$show_more = ( count( $fields ) > 8 ) ? '<li class="more_items icon icon-arrow">Show more</li>' : ''; ?>
						<div class="filter_block">
							<div class="filter_label icon icon-arrow"><?php echo $filter[ 'title' ]; ?></div>
							<ul class="filter_choice">
								<?php foreach ( $fields as $field_value => $field_name ):
									$array = array_values( $fields );
									$checked = ( array_shift( $array ) == $field_name ) ? "checked" : ""; ?>
									<li>
										<label>
											<input type="radio" name="<?php echo $filter[ 'name' ]; ?>" value="<?php echo $field_value; ?>" class="input__hidden filter_input" <?php echo $checked; ?>>
											<span><?php echo $field_name; ?></span> </label>
									</li>
								<?php endforeach; ?>
								<?php echo $show_more; ?>
							</ul>
						</div>
					<?php endforeach; ?>
				</form>

				<div class="live_content">
					<div class="live_content_tabs flex__align">
						<div class="live_content_tab active">Gold</div>
						<div class="live_content_tab">Silver</div>
						<div class="live_content_tab">All</div>
					</div>
					<div class="live_content_tables grid grid__twoo">
						<table>
							<tr>
								<th colspan="4">Live Gold Price</th>
							</tr>
							<tr>
								<td>Current</td>
								<td>High</td>
								<td>Low</td>
								<td>Change</td>
							</tr>
							<tr>
								<td>£ 1,373.95</td>
								<td>£ 1,375.54</td>
								<td>£ 1,373.23</td>
								<td class="_red">£ -0.3500 (-0.03%)</td>
							</tr>
						</table>
						<table>
							<tr>
								<th colspan="4">Intrinsic Values (£)</th>
							</tr>
							<tr>
								<td>Sovereign</td>
								<td>Half Sovereign</td>
								<td>1oz Gold</td>
								<td>1oz Silver</td>
							</tr>
							<tr>
								<td>£ 323.43</td>
								<td>£ 161.71</td>
								<td>£ 1,373.95</td>
								<td>£18.33</td>
							</tr>
						</table>
					</div>
					<div class="live_content_information flex__align">
						<h4>Gold: <i>Silver Ratio</i></h4>
						<p>74.967</p>
					</div>
					<div class="live_content_information flex__align">
						<h4>Gold: <i>Silver Ratio</i></h4>
						<p>USD: 1.3446</p>
						<p>EUR: 1.1909</p>
					</div>
					<div class="live_content_more">
						<div class="more-line"> View Metal Ratio Graphs</div>
					</div>

					<div class="live_content_tabs flex__align">
						<div class="live_content_tab active">Advanced Real-Time Chart Widget</div>
						<div class="live_content_tab">Market Data Widget</div>
						<div class="live_content_tab">Symbol Overview Widget</div>
					</div>
					<div class="live_content_chart">
						<h2>Advanced Real-Time Chart Widget</h2>
						<!-- TradingView Widget BEGIN -->
						<div class="tradingview-widget-container">
							<div id="tradingview_33cdd"></div>
							<div class="live_content_subtitle">
								<a href="https://www.tradingview.com/symbols/NASDAQ-AAPL/" rel="noopener" target="_blank"><span>AAPL Chart</span></a> by TradingView
							</div>
						</div>
						<!-- TradingView Widget END -->
						<div class="live_content_txt">Symbol Overview Widget shows latest quotes, a simple chart and key fundamental fields for a single stock. It’s in-depth, yet detailed, and it’s a great solution for web and mobile. You can add multiple tabs to cover several stocks and use a “Chart Only” mode for a simpler look.</div>
					</div>

				</div>
			</div>
		</div>

		<?php get_template_part( 'template-parts/section/popular-gold-products' ); ?>

		<div class="live_text">
			<div class="bone">
				<?php the_content(); ?>
			</div>
		</div>
	</div>

<?php get_footer();