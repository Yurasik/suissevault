<?php
$api_price = $args[ 'api_price' ];
$metal = $args[ 'metal' ];
$currency = $api_price->curr;

$oz_to_g = 31.1034767726; 
$price_current = ( $metal == 'gold' ) ? $api_price->xauPrice : $api_price->xagPrice;
$price_changed = ( $metal == 'gold' ) ? $api_price->xauPrice/$oz_to_g : ($api_price->xagPrice/$oz_to_g)*1000;
//$price_changed = ( $metal == 'gold' ) ? $api_price->chgXau : $api_price->chgXag;
$price_changed_percentage = ( $metal == 'gold' ) ? $api_price->pcXau : $api_price->pcXag;
?>
<div class="header_price_bottom icon icon-<?php echo $currency; ?> flex__center">
	<span class="price_current"><?php echo number_format( $price_current, 2 ); ?></span>
	<span class="price_changed"><?php echo number_format( $price_changed, 2 ); ?></span>
	<span class="price_changed_percentage"><?php echo number_format( $price_changed_percentage, 2 ); ?>%</span>
</div>
