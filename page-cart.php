<?php
/**
 * Template Name: Cart
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page lock">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<h1><?php the_title(); ?></h1>

			<!--<div class="lock_cart">
				<table>
					<tr>
						<th colspan="2"></th>
						<th>Product</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>VAT</th>
						<th>Total</th>
					</tr>
					<tr>
						<td>
							<div class="close"></div>
						</td>
						<td>
							<picture><source srcset="/develop/suisse/images/i1.webp" type="image/webp"><img src="/develop/suisse/images/i1.jpg" alt srcset="/develop/suisse/images/i1.jpg 1x, /develop/suisse/images/i1@2x.jpg 2x"></picture>
						</td>
						<td class="product-name">2021 Gold Sovereign</td>
						<td class="product-quantity">
							<div class="amount flex__align">
								<div class="amount_btn amount__subtract"></div>
								<input type="number" value="1">
								<div class="amount_btn amount__add"></div>
							</div>
						</td>
						<td>£329.40</td>
						<td>£0.00</td>
						<td>£329.30</td>
					</tr>
				</table>
			</div>

			<div class="lock_radio lock_radio-small flex__align">
				<label>
					<input type="radio" data-checked="checked1" name="n1" class="input__hidden">
					<span>
						<picture><source srcset="<?php /*echo get_template_directory_uri(); */?>/assets/images/svg/car.svg" type="image/webp"><img src="<?php /*echo get_template_directory_uri(); */?>/assets/images/svg/car.svg" alt></picture>
						Delivery
					</span>
				</label>
				<label>
					<input type="radio" data-checked="checked2" checked name="n1" class="input__hidden">
					<span>
						<picture><source srcset="<?php /*echo get_template_directory_uri(); */?>/assets/images/svg/safe.svg" type="image/webp"><img src="<?php /*echo get_template_directory_uri(); */?>/assets/images/svg/safe.svg" alt></picture>
						Storage
					</span>
				</label>
			</div>

			<ul class="lock_radio_checked">
				<li id="checked1">
					<p class="lock_radio_label">Delivery option:</p>
					<div class="select">
						<select name="delivery">
							<option value="1">Free Insured Special Delivery (£0.00)</option>
							<option value="2">Fast Delivery (£10.00)</option>
						</select>
					</div>
				</li>
				<li id="checked2">
					<p>Minimum £10.00 per month inc VAT <span class="icon icon-i">more info</span></p>
					<p class="color">Please note your order will not be delivered, it will be sent to secure storage.</p>
				</li>
			</ul>

			<p class="lock_label">To order for collection call us on 0207 889 (GOLD) 4653</p>

			<table class="lock_order">
				<tr>
					<td>Order total</td>
					<td>£4,791.80</td>
					<td>£4.66</td>
					<td>£4,796.46</td>
				</tr>
			</table>

			<div class="lock_payment">
				<div class="lock_payment_title">Payment Method</div>
				<p>Please select a payment method from below to pay for your metal. You will need to set-up a Direct Debit in order to pay for your storage on the final page.</p>
				<div class="lock_radio grid grid__three">
					<label>
						<input type="radio" data-checked="checked3" checked name="n2" class="input__hidden">
						<span>
							<picture><source srcset="<?php /*echo get_template_directory_uri(); */?>/assets/images/svg/card.svg" type="image/webp"><img src="<?php /*echo get_template_directory_uri(); */?>/assets/images/svg/card.svg" alt></picture>
							Debit Card <br>(Payment limit £10,000)
						</span>
					</label>
					<label>
						<input type="radio" data-checked="checked3" name="n2" class="input__hidden">
						<span>
							<picture><source srcset="<?php /*echo get_template_directory_uri(); */?>/assets/images/svg/card.svg" type="image/webp"><img src="<?php /*echo get_template_directory_uri(); */?>/assets/images/svg/card.svg" alt></picture>
							Credit Card <br>(Payment limit £10,000)
						</span>
					</label>
					<label>
						<input type="radio" data-checked="checked4" name="n2" class="input__hidden">
						<span>
							<picture><source srcset="<?php /*echo get_template_directory_uri(); */?>/assets/images/svg/bank.svg" type="image/webp"><img src="<?php /*echo get_template_directory_uri(); */?>/assets/images/svg/bank.svg" alt></picture>
							Bank Transfer <br>Deposit Required of 10%
						</span>
					</label>
				</div>
				<div class="lock_payment_label">For large orders please call us on 0207 889 (GOLD) 4653 <br>between 9am - 6pm Monday to Friday.</div>
				<ul class="lock_radio_checked">
					<li id="checked3">
						<p>Pay online using a Debit card up to the value of £10,000. Debit card payments must be completed immediately for the full balance. Once the payment has been completed you may not cancel your order. This does NOT include Pre-Pay Cards. For security purposes we can only dispatch orders paid by debit and credit card to the card holder’s registered address. Please ensure the name on the card and the address it is registered to matches the name and delivery address on your order.</p>
					</li>
					<li id="checked4">
						<p>Take deposit (10%) by debit/ credit card. <br>You must initiate a Bank Transfer by the end of the next working day or your order may be cancelled. You will receive your Order Number and our Bank Details at the end of the checkout process and within your order confirmation email. As soon as we receive cleared funds we will release your order for dispatch. Bank Transfers clear between 2 hours and 4 working days depending on who you bank with</p>
					</li>
				</ul>
			</div>

			<div class="lock_gold">
				<div class="lock_gold_title">Please review and accept to continue with your order</div>
				<p>By ticking the checkbox below and placing your order you are committing to purchase the products at the price displayed. Please review the points made below and the terms and conditions of sale before continuing with your order.</p>
				<p><b>Cancellations</b> - As the goods supplied are dependent on fluctuations in financial markets, under the Financial Services (Distance Marketing) Regulations 2004 there is no statutory right to cancel. Any cancellations will incur a £25 termination fee plus any adverse movement in the underlying metal prices.</p>
				<p>By ticking the checkbox below you are confirming that you understand the above and agree to the <span class="hover__line-active">terms and conditions</span> of sale.</p>
				<label>
					<input type="checkbox" class="input__hidden">
					<span>Yes, I understand the above and agree to the terms and conditions.</span>
				</label>
			</div>

			<div class="lock_btn">
				<div class="btn btn-line">Buy now</div>
			</div>-->

			<?php the_content(); ?>
		</div>
	</div>

<?php get_footer();