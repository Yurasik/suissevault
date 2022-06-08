<?php
/**
 * Template Name: Checkout
 *
 * @package suissevault
 */

get_header();
?>

	<div class="page checkout">
		<div class="bone">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<h1><?php the_title(); ?></h1>

			<div class="checkout_time">Time to confirm your order: <b>11m 17s</b></div>

			<!--<div class="checkout_net grid grid__twoo">
				<div class="checkout_form">
					<div class="checkout_form_tabs flex__align">
						<div class="checkout_form_tab active" data-tab="register">Register for an account here</div>
						<div class="checkout_form_tab" data-tab="login">Already a user? Log in here</div>
					</div>
					<div class="checkout_form_steps">
						<div class="checkout_form_step form step-register">
							<form action="">
								<h2>Contact details</h2>
								<div class="grid grid__twoo">
									<div class="form_wrapper">
										<div class="form_label">first name*</div>
										<div class="input error">
											<input type="text">
											<span class="error_text">Error text</span>
										</div>
									</div>
									<div class="form_wrapper">
										<div class="form_label">last name*</div>
										<div class="input">
											<input type="text">
											<span class="error_text">Error text</span>
										</div>
									</div>
								</div>
								<div class="grid grid__three">
									<div class="form_wrapper">
										<div class="form_label">Date of Birthd (DD)*</div>
										<div class="input">
											<input type="text">
											<span class="error_text">Error text</span>
										</div>
									</div>
									<div class="form_wrapper">
										<div class="form_label">Month (MM)*</div>
										<div class="input">
											<input type="text">
											<span class="error_text">Error text</span>
										</div>
									</div>
									<div class="form_wrapper">
										<div class="form_label">Year (YYYY)*</div>
										<div class="input">
											<input type="text">
											<span class="error_text">Error text</span>
										</div>
									</div>
								</div>
								<div class="form_wrapper">
									<div class="form_label">company name</div>
									<div class="input">
										<input type="text">
										<span class="error_text">Error text</span>
									</div>
								</div>
								<div class="form_wrapper">
									<div class="form_label">country</div>
									<div class="select">
										<select name="country">
											<option value="1">United Kingdom</option>
										</select>
									</div>
								</div>
								<div class="form_wrapper">
									<div class="form_label">Street address*</div>
									<div class="input">
										<input type="text" placeholder="House number and street name">
										<span class="error_text">Error text</span>
									</div>
									<div class="input">
										<input type="text" placeholder="Apartment, suite, unit etc. (optional)">
										<span class="error_text">Error text</span>
									</div>
								</div>
								<div class="form_wrapper">
									<div class="form_label">town/city*</div>
									<div class="input">
										<input type="text">
										<span class="error_text">Error text</span>
									</div>
								</div>
								<div class="form_wrapper">
									<div class="form_label">county</div>
									<div class="input">
										<input type="text">
										<span class="error_text">Error text</span>
									</div>
								</div>
								<div class="form_wrapper">
									<div class="form_label">post code*</div>
									<div class="input">
										<input type="text">
										<span class="error_text">Error text</span>
									</div>
								</div>
								<div class="grid grid__twoo">
									<div class="form_wrapper">
										<div class="form_label">Phone*</div>
										<div class="input">
											<input type="text">
											<span class="error_text">Error text</span>
										</div>
									</div>
									<div class="form_wrapper">
										<div class="form_label">email address*</div>
										<div class="input">
											<input type="text">
											<span class="error_text">Error text</span>
										</div>
									</div>
								</div>
								<h2>Additional information</h2>
								<div class="form_wrapper">
									<div class="form_label">order notes</div>
									<div class="input">
										<textarea placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
										<span class="error_text">Error text</span>
									</div>
								</div>
								<h2>Payment Details</h2>
								<div class="form_wrapper">
									<div class="form_label">Card Type *</div>
									<div class="grid grid__twoo">
										<label>
											<input type="radio" checked name="n1" class="input__hidden">
											<span>Visa</span>
										</label>
										<label>
											<input type="radio" name="n1" class="input__hidden">
											<span>Mastercard</span>
										</label>
										<label>
											<input type="radio" name="n1" class="input__hidden">
											<span>Maestro UK</span>
										</label>
										<label>
											<input type="radio" disabled name="n1" class="input__hidden">
											<span>Maestro Int.</span>
										</label>
									</div>
								</div>
								<div class="form_wrapper">
									<div class="form_label">Card Number *</div>
									<div class="input">
										<input type="text">
										<span class="error_text">Error text</span>
									</div>
								</div>
								<div class="grid grid__twoo">
									<div class="form_wrapper">
										<div class="form_label">Expiry Month *</div>
										<div class="select">
											<select name="Mounth">
												<option value="hidden">Mounth</option>
												<option value="0">January</option>
												<option value="1">February</option>
												<option value="2">March</option>
												<option value="3">April</option>
											</select>
										</div>
									</div>
									<div class="form_wrapper">
										<div class="form_label">Expiry Year *</div>
										<div class="select">
											<select name="Mounth">
												<option value="hidden">Year</option>
												<option value="0">2020</option>
												<option value="1">2021</option>
												<option value="2">2022</option>
												<option value="3">2023</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form_wrapper">
									<div class="form_label">Security Code *</div>
									<p>This code is a three or four digit number printed on the back or front of credit cards.</p>
									<div class="input">
										<input type="text">
										<span class="error_text">Error text</span>
									</div>
								</div>
							</form>
						</div>
						<div class="checkout_form_step form step-login" style="display: none;">
							<form action="">
								<p>If you are a registered client, enter your username / email and password, if you are not yet our client, then go to the "New customer" section and fill in the information.</p>
								<div class="form_wrapper">
									<div class="form_label">Your Email</div>
									<div class="input">
										<input type="text">
										<span class="error_text">Error text</span>
									</div>
								</div>
								<div class="form_wrapper">
									<div class="form_label">Password</div>
									<div class="input">
										<input type="text">
										<span class="error_text">Error text</span>
									</div>
								</div>
								<a href="#" class="checkout_forgout hover__line">Forgot password?</a>
								<div class="checkout_btn">
									<div class="btn">Log in</div>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="checkout_info">
					<h2>Cart totals</h2>
					<div class="checkout_totals">
						<ul>
							<li>
								<div class="checkout_totals_item flex">
									<div class="checkout_totals_item_img">
										<picture><source srcset="/develop/suisse/images/i2.webp" type="image/webp"><img src="/develop/suisse/images/i2.jpg" alt srcset="/develop/suisse/images/i2.jpg 1x, /develop/suisse/images/i2@2x.jpg 2x"></picture>
									</div>
									<div class="checkout_totals_item_info">
										<div class="checkout_totals_item_name">2021 Gold Sovereign</div>
										<div class="checkout_totals_item_right">
											<p><span>Qty</span>1</p>
											<p><span>Each</span>£27.96</p>
											<p><span>Total</span>£27.96</p>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="checkout_totals_item flex">
									<div class="checkout_totals_item_img">
										<picture><source srcset="/develop/suisse/images/i3.webp" type="image/webp"><img src="/develop/suisse/images/i3.jpg" alt srcset="/develop/suisse/images/i3.jpg 1x, /develop/suisse/images/i3@2x.jpg 2x"></picture>
									</div>
									<div class="checkout_totals_item_info">
										<div class="checkout_totals_item_name">1oz Silver Coins Best Value</div>
										<div class="checkout_totals_item_right">
											<p><span>Qty</span>1</p>
											<p><span>Each</span>£27.96</p>
											<p><span>Total</span>£27.96</p>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="checkout_totals_item flex">
									<div class="checkout_totals_item_img">
										<picture><source srcset="/develop/suisse/images/i4.webp" type="image/webp"><img src="/develop/suisse/images/i4.jpg" alt srcset="/develop/suisse/images/i4.jpg 1x, /develop/suisse/images/i4@2x.jpg 2x"></picture>
									</div>
									<div class="checkout_totals_item_info">
										<div class="checkout_totals_item_name">Metalor 100 Gram Gold Bar (Minted)</div>
										<div class="checkout_totals_item_right">
											<p><span>Qty</span>1</p>
											<p><span>Each</span>£27.96</p>
											<p><span>Total</span>£27.96</p>
										</div>
									</div>
								</div>
							</li>
							<li>
								<p class="flex__center"><span>Subtotal</span>£4,796.46</p>
							</li>
							<li>
								<p class="flex__center"><span>VAT</span>£0.00</p>
							</li>
							<li>
								<p class="flex__center"><span>Delivery (Free Insured UK Delivery)</span>Free</p>
							</li>
							<li>
								<div class="checkout_total flex__center">
									<div class="checkout_total_left">Total (inc. VAT)</div>
									<div class="checkout_total_price">£5,796.46</div>
								</div>
							</li>
						</ul>
					</div>
					<div class="checkout_info_edit">
						<a href="#" class="more-line">Edit Basket</a>
					</div>
					<h2>Check payments</h2>
					<div class="checkout_payment">
						<p>Please note the following;</p>
						<ul>
							<li>All order by bank transfer require a 10% deposit by debit card (if below £10,000) or by same day/ CHAPS payment. Payment must be set up immediately to honor the price, full name or order number must be used as reference. Any payments not received within 24 hours of order being placed may be cancelled/ refunded/ redealt and subject to an administration as per our Terms.</li>
							<li>For our customers' security we can only accept card payments with cards registered with Verified by Visa or Mastercard SecureCode.</li>
							<li>For security reasons we can only dispatch debit & credit card orders to the card holder’s registered address. Please ensure the name on the card and address it is registered to matches the delivery details on your order.</li>
						</ul>
					</div>
					<div class="checkout_info_btn">
						<div class="btn">Pay</div>
					</div>
				</div>
			</div>-->

			<?php the_content(); ?>
		</div>
	</div>

<?php get_footer();