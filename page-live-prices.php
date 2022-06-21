<?php
/**
 * Template Name: Live Prices
 *
 * @package suissevault
 */

get_header();

$api_price = get_api_price();
?>

	<div class="page live">
		<div class="bone">
			<div class="live_net grid">
				<div class="live_top">
					<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
					<h1><?php the_title(); ?></h1>
				</div>
				<form class="filter">
					<?php $filters = [
						[
							'name'   => 'weight',
							'title'  => 'Weight',
							'fields' => [
								'oz' => 'Ounces',
								'g'  => 'Grams',
								'kg' => 'Kilograms',
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
								'1D'  => 'Today',
								'5D'  => 'Week',
								'1M'  => 'Month',
								'3M'  => '3 Month',
								'6M'  => '6 Month',
								'12M' => 'Year',
								'60M' => '5 Year',
								'ALL' => 'All Time',
							]
						],
					]; ?>
					<div class="filter_clear hidden">Clear filters <span class="close"></span></div>
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
						<div class="live_content_tab active" data-tabs="live" data-tab="gold">Gold</div>
						<div class="live_content_tab" data-tabs="live" data-tab="silver">Silver</div>
						<div class="live_content_tab" data-tabs="live" data-tab="all">All</div>
					</div>
					<?php get_template_part( 'template-parts/ajax/live_content_steps', '', [ 'api_price' => $api_price ] ); ?>
					<div class="live_content_more">
						<div class="more-line"> View Metal Ratio Graphs</div>
					</div>
					<div class="live_content_tabs flex__align">
						<div class="live_content_tab active" data-tabs="widget" data-tab="1">Advanced Real-Time Chart Widget</div>
						<div class="live_content_tab" data-tabs="widget" data-tab="2">Market Data Widget</div>
						<div class="live_content_tab" data-tabs="widget" data-tab="3">Symbol Overview Widget</div>
					</div>
					<div class="live_content_steps">
						<div class="live_content_step" data-id="widget" id="widget-1">
							<h2>Advanced Real-Time Chart Widget</h2>
							<div class="live_content_chart">
								<div class="tradingview-widget-container">
									<div id="tradingview_real_time_chart"></div>
								</div>
							</div>
							<div class="live_content_subtitle">
								<a href="https://www.tradingview.com/symbols/NASDAQ-AAPL/" rel="noopener" target="_blank"><span>AAPL Chart</span></a> by TradingView
							</div>
						</div>
						<div class="live_content_step" data-id="widget" id="widget-2" style="display: none;">
							<h2>Market Data Widget</h2>
							<div id="market-widget" class="live_content_chart">
								<div class="tradingview-widget-container">
									<div class="tradingview-widget-container__widget"></div>
									<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-quotes.js" async>
                                        {
                                            "width"
                                        :
                                            "100%",
                                                "height"
                                        :
                                            "100%",
                                                "symbolsGroups"
                                        :
                                            [
                                                {
                                                    "name": "Indices",
                                                    "originalName": "Indices",
                                                    "symbols": [
                                                        {
                                                            "name": "FOREXCOM:SPXUSD",
                                                            "displayName": "S&P 500"
                                                        },
                                                        {
                                                            "name": "FOREXCOM:NSXUSD",
                                                            "displayName": "US 100"
                                                        },
                                                        {
                                                            "name": "FOREXCOM:DJI",
                                                            "displayName": "Dow 30"
                                                        },
                                                        {
                                                            "name": "INDEX:NKY",
                                                            "displayName": "Nikkei 225"
                                                        },
                                                        {
                                                            "name": "INDEX:DEU40",
                                                            "displayName": "DAX Index"
                                                        },
                                                        {
                                                            "name": "FOREXCOM:UKXGBP",
                                                            "displayName": "UK 100"
                                                        }
                                                    ]
                                                },
                                                {
                                                    "name": "Futures",
                                                    "originalName": "Futures",
                                                    "symbols": [
                                                        {
                                                            "name": "CME_MINI:ES1!",
                                                            "displayName": "S&P 500"
                                                        },
                                                        {
                                                            "name": "CME:6E1!",
                                                            "displayName": "Euro"
                                                        },
                                                        {
                                                            "name": "COMEX:GC1!",
                                                            "displayName": "Gold"
                                                        },
                                                        {
                                                            "name": "NYMEX:CL1!",
                                                            "displayName": "Crude Oil"
                                                        },
                                                        {
                                                            "name": "NYMEX:NG1!",
                                                            "displayName": "Natural Gas"
                                                        },
                                                        {
                                                            "name": "CBOT:ZC1!",
                                                            "displayName": "Corn"
                                                        }
                                                    ]
                                                },
                                                {
                                                    "name": "Bonds",
                                                    "originalName": "Bonds",
                                                    "symbols": [
                                                        {
                                                            "name": "CME:GE1!",
                                                            "displayName": "Eurodollar"
                                                        },
                                                        {
                                                            "name": "CBOT:ZB1!",
                                                            "displayName": "T-Bond"
                                                        },
                                                        {
                                                            "name": "CBOT:UB1!",
                                                            "displayName": "Ultra T-Bond"
                                                        },
                                                        {
                                                            "name": "EUREX:FGBL1!",
                                                            "displayName": "Euro Bund"
                                                        },
                                                        {
                                                            "name": "EUREX:FBTP1!",
                                                            "displayName": "Euro BTP"
                                                        },
                                                        {
                                                            "name": "EUREX:FGBM1!",
                                                            "displayName": "Euro BOBL"
                                                        }
                                                    ]
                                                },
                                                {
                                                    "name": "Forex",
                                                    "originalName": "Forex",
                                                    "symbols": [
                                                        {
                                                            "name": "FX:EURUSD",
                                                            "displayName": "EUR/USD"
                                                        },
                                                        {
                                                            "name": "FX:GBPUSD",
                                                            "displayName": "GBP/USD"
                                                        },
                                                        {
                                                            "name": "FX:USDJPY",
                                                            "displayName": "USD/JPY"
                                                        },
                                                        {
                                                            "name": "FX:USDCHF",
                                                            "displayName": "USD/CHF"
                                                        },
                                                        {
                                                            "name": "FX:AUDUSD",
                                                            "displayName": "AUD/USD"
                                                        },
                                                        {
                                                            "name": "FX:USDCAD",
                                                            "displayName": "USD/CAD"
                                                        }
                                                    ]
                                                }
                                            ],
                                                "showSymbolLogo"
                                        :
                                            true,
                                                "colorTheme"
                                        :
                                            "light",
                                                "isTransparent"
                                        :
                                            false,
                                                "locale"
                                        :
                                            "en"
                                        }
									</script>
								</div>
							</div>
							<div class="live_content_subtitle">
								<a href="https://www.tradingview.com/markets/" rel="noopener" target="_blank"><span>Financial Markets</span></a> by TradingView
							</div>
						</div>
						<div class="live_content_step" data-id="widget" id="widget-3" style="display: none;">
							<h2>Symbol Overview Widget</h2>
							<div class="live_content_chart">
								<div class="tradingview-widget-container">
									<div id="tradingview_symbol_overview"></div>
								</div>
							</div>
							<div class="live_content_subtitle">
								<a href="https://www.tradingview.com/symbols/AAPL/" rel="noopener" target="_blank"><span>Apple</span></a> by TradingView
							</div>
						</div>
					</div>
					<div class="live_content_txt">Symbol Overview Widget shows latest quotes, a simple chart and key fundamental fields for a single stock. It’s in-depth, yet detailed, and it’s a great solution for web and mobile. You can add multiple tabs to cover several stocks and use a “Chart Only” mode for a simpler look.</div>
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