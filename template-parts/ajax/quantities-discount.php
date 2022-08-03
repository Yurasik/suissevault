<?php
$product = $args[ 'product' ];
$api_price = $args[ 'api_price' ];
$quantities_discount = get_field( 'quantities_discount', $product->id );
?>

<table id='quantities_discount'>
	<tr>
		<td>Quantity</td>
		<td>Each</td>
	</tr>
	<tr>
		<td>1</td>
		<td><?php echo wc_price( get_quantity_discount_price( $product, 1, $api_price ) ); ?></td>
	</tr>
	<?php if ( $quantities_discount ): ?>
		<?php foreach ( $quantities_discount as $values ) {
			$discount_price = get_quantity_discount_price( $product, $values[ 'quantity' ], $api_price );
			$plus = "+";

			echo "<tr><td>$values[quantity]{$plus}</td><td>" . wc_price( $discount_price * $values[ 'quantity' ] ) . "</td></tr>";
		} ?>
	<?php endif; ?>
</table>