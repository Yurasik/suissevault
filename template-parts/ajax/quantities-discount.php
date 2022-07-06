<?php
$product = $args[ 'product' ];
$api_price = $args[ 'api_price' ];
$quantities_discount = get_field( 'quantities_discount', 'options' );
?>

<table id='quantities_discount'>
	<tr>
		<td>Quantity</td>
		<td>Each</td>
	</tr>
	<?php foreach ( $quantities_discount as $values ) {
		$discount_price = get_quantity_discount_price( $product, $values['quantity'], $api_price );
		$plus = ( $values['quantity'] == 1 ) ? "" : "+";

		echo "<tr><td>$values[quantity]{$plus}</td><td>" . wc_price( $discount_price * $values['quantity'] ) . "</td></tr>";
	} ?>
</table>