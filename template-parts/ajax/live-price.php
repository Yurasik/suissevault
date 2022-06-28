<?php
$api_price = $args[ 'api_price' ];
$weight = isset( $args[ 'weight' ] ) ? $args[ 'weight' ] : 'oz';

$currency_symbol = get_woocommerce_currency_symbol( $api_price->curr );

if ( $weight == 'g' || $weight == 'kg' ) {
	foreach ( $api_price as $key => $val ) {
		if ( $key == "curr" )
			continue;
		elseif ( $weight == 'g' )
			$api_price->$key = $val / 28.3495231;
		elseif ( $weight == 'kg' )
			$api_price->$key = $val * 35.2739619;
	}
}

$intrinsic_values_display = false;
$ratio_display = false;
$low_display = false;
?>
<div class="top_live_content_steps live_content_steps">
	<div class="live_content_step" data-id="live" id="live-gold">
		<div class="live_content_tables grid grid__twoo">
			<table>
				<tr>
					<th colspan="4">Live Gold Price</th>
				</tr>
				<tr>
					<td>Current</td>
					<td>High</td>
					<?php if ( $low_display ): ?>
						<td>Low</td>
					<?php endif; ?>
					<td>Change</td>
				</tr>
				<tr>
					<td><?php echo "$currency_symbol " . number_format( $api_price->xauPrice, 2 ); ?></td>
					<td><?php echo "$currency_symbol " . number_format( $api_price->xauClose, 2 ); ?></td>
					<?php if ( $low_display ): ?>
						<td>£ (!)</td>
					<?php endif; ?>
					<?php $td_class = ( $api_price->chgXau < 0 ) ? "_red" : ""; ?>
					<td class="<?php echo $td_class; ?>"><?php echo "$currency_symbol " . number_format( $api_price->chgXau, 2 ); ?> (<?php echo number_format( $api_price->pcXau, 2 ); ?>%)</td>
				</tr>
			</table>
			<?php if ( $intrinsic_values_display ): ?>
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
			<?php endif; ?>
		</div>

		<?php if ( $ratio_display ): ?>
			<div class="live_content_information flex__align">
				<h4>Gold: <i>Silver Ratio</i></h4>
				<p>74.967</p>
			</div>
			<div class="live_content_information flex__align">
				<h4>Gold: <i>Silver Ratio</i></h4>
				<p>USD: 1.3446</p>
				<p>EUR: 1.1909</p>
			</div>
		<?php endif; ?>
	</div>
	<div class="live_content_step" data-id="live" id="live-silver" style="display: none;">
		<div class="live_content_tables grid grid__twoo">
			<table>
				<tr>
					<th colspan="4">Live Silver Price</th>
				</tr>
				<tr>
					<td>Current</td>
					<td>High</td>
					<?php if ( $low_display ): ?>
						<td>Low</td>
					<?php endif; ?>
					<td>Change</td>
				</tr>
				<tr>
					<td><?php echo "$currency_symbol " . number_format( $api_price->xagPrice, 2 ); ?></td>
					<td><?php echo "$currency_symbol " . number_format( $api_price->xagClose, 2 ); ?></td>
					<?php if ( $low_display ): ?>
						<td>£ (!)</td>
					<?php endif; ?>
					<?php $td_class = ( $api_price->chgXag < 0 ) ? "_red" : ""; ?>
					<td class="<?php echo $td_class; ?>"><?php echo "$currency_symbol " . number_format( $api_price->chgXag, 2 ); ?> (<?php echo number_format( $api_price->pcXag, 2 ); ?>%)</td>
				</tr>
			</table>

			<?php if ( $intrinsic_values_display ): ?>
				<table>
					<tr>
						<th colspan="4">Intrinsic Values (£)</th>
					</tr>
					<tr>
						<td>Sovereign</td>
						<td>Half Sovereign</td>
						<td>1oz Silver</td>
						<td>1oz Silver</td>
					</tr>
					<tr>
						<td>£ 323.43</td>
						<td>£ 161.71</td>
						<td>£ 1,373.95</td>
						<td>£18.33</td>
					</tr>
				</table>
			<?php endif; ?>
		</div>

		<?php if ( $ratio_display ): ?>
			<div class="live_content_information flex__align">
				<h4>Silver: <i>Silver Ratio</i></h4>
				<p>74.967</p>
			</div>
			<div class="live_content_information flex__align">
				<h4>Silver: <i>Silver Ratio</i></h4>
				<p>USD: 1.3446</p>
				<p>EUR: 1.1909</p>
			</div>
		<?php endif; ?>
	</div>
</div>