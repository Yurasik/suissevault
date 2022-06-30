<?php
$product = $args[ 'product' ];
$api_price = $args[ 'api_price' ];
$quantities_discount = get_quantities_discount();
?>

<table id='quantities_discount'>
	<tr>
		<td>Quantity</td>
		<td>Each</td>
	</tr>
	<?php foreach ( $quantities_discount as $quantity => $discount ) {
		$discount_price = get_quantity_discount_price( $product, $quantity, $api_price );
		$plus = ( $quantity == 1 ) ? "" : "+";

		echo "<tr><td>$quantity{$plus}</td><td>" . wc_price( $discount_price * $quantity ) . "</td></tr>";
	} ?>
</table>