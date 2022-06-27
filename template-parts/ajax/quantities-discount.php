<?php
$product = $args[ 'product' ];
$api_price = $args[ 'api_price' ];
$dynamic_price = get_dynamic_price( $api_price, $product );
$quantities = [
	1  => 0,
	2  => 1,
	5  => 2,
	10 => 3,
	20 => 5
];
?>

<table id='quantities_discount'>
	<tr>
		<td>Quantity</td>
		<td>Each</td>
	</tr>
	<?php foreach ( $quantities as $quantity => $discount ) {
		$quantity_price = $dynamic_price[ 'price_inc_vat' ] * $quantity;
		$discount_for_price = ( $quantity == 1 ) ? 0 : $quantity_price / 100 * $discount;
		$discount_price = wc_price( $quantity_price - $discount_for_price );
		$plus = ( $quantity == 1 ) ? "" : "+";

		echo "<tr><td>$quantity{$plus}</td><td data-quantity-count='$quantity'>$discount_price</td></tr>";
	} ?>
</table>