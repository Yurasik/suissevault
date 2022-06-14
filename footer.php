<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after
 *
 * @package suissevault
 */

$contacts = get_field( 'contacts', 'options' );
$footer   = get_field( 'footer', 'options' );
?>

<style>
    .modals {
        --bone_w: 600px;
    }

    .modals > h1 {
        margin-top: 132px;
    }

    .modals > .btn {
        --btn_w: 100%;

        margin-top: 40px;
    }
</style>

<?php if ( !is_user_logged_in() ) : ?>
	<!-- Modal-login. -->
	<div class="modal modal-login">
		<div class="modal_wrapper">
			<div class="modal_top">
				<span class="close"></span>Login
			</div>
			<div class="modal_scroll">
				<form class="form" id="login">
					<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>

					<div class="form_wrapper">
						<div class="form_label">Your Email</div>
						<div class="input">
							<input type="text" id="username" name="username">
						</div>
					</div>

					<div class="form_wrapper">
						<div class="form_label">Password</div>
						<div class="input">
							<input type="password" id="password" name="password">
						</div>
					</div>

					<a href="<?php echo wp_lostpassword_url(); ?>" class="modal_forgout hover__line">Forgot password?</a>

					<div class="modal_btn">
						<input type="submit" name="wp-submit" value="Log In" class="btn">
					</div>

					<div class="modal_under">
						<div class="hover__line modal-link" data-modal-name="register">sign in</div>
					</div>
				</form>
			</div>
		</div>
		<div class="modal_viel"></div>
	</div>
	<!-- Modal-login. -->

	<!-- Modal-register. -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<div class="modal modal-register">
		<div class="modal_wrapper">
			<div class="modal_top">
				<span class="close"></span> Register
			</div>
			<div class="modal_scroll">
				<form id="register" class="form">
					<?php wp_nonce_field( 'ajax-register-nonce', 'signonsecurity' ); ?>
					<div class="grid grid__twoo">
						<div>
							<div class="form_wrapper">
								<div class="form_label">Title*</div>
								<div class="select">
									<select name="title" id="title" required>
										<option value="Mr">Mr</option>
										<option value="Mrs">Mrs</option>
										<option value="Ms">Ms</option>
										<option value="Mx">Mx</option>
										<option value="Miss">Miss</option>
										<option value="Master">Master</option>
										<option value="Dr">Dr</option>
										<option value="Prof">Prof</option>
										<option value="Lord">Lord</option>
										<option value="Lady">Lady</option>
										<option value="Dame">Dame</option>
										<option value="Company">Company</option>
									</select>
								</div>
							</div>

							<div class="form_wrapper">
								<div class="form_label">Middle Name or initial</div>
								<div class="input">
									<input type="text" name="initial" id="initial">
								</div>
							</div>

							<div class="form_wrapper">
								<div class="form_label">Phone number*</div>
								<div class="input">
									<input type="text" name="billing_phone" id="billing_phone" required>
								</div>
							</div>

							<div class="form_wrapper">
								<div class="form_label">Where Did you hear About Us?</div>
								<div class="select">
									<select name="where" id="where">
										<option value="Referral">Referral</option>
										<option value="Social media">Social media</option>
										<option value="Ad">Ad</option>
										<option value="Search engine">Search engine</option>
										<option value="Other">Other</option>
									</select>
								</div>
							</div>

							<div class="form_wrapper">
								<div class="form_label">Password*</div>
								<div class="input">
									<input type="password" name="password" id="password" required>
								</div>
							</div>

							<?php $countries = WC()->countries->get_allowed_countries(); ?>
							<?php if ( $countries ): ?>
								<div class="form_wrapper">
									<div class="form_label">Country</div>
									<div class="select">
										<select name="billing_country" id="billing_country">
											<?php foreach ( $countries as $country_code => $country_name ):
												$selected = ( $country_code == "GB" )
													? "selected"
													: ""; ?>
												<option value="<?php echo $country_code; ?>" <?php echo "$selected"; ?>><?php echo $country_name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?php endif; ?>

							<div class="form_wrapper">
								<div class="form_label">Complete the captcha below to submit your registration*</div>
								<div class="input">
									<div id="g-recaptcha" class="g-recaptcha" data-sitekey="6Lepwx4gAAAAADqZv9lQA7QRRTA2ikiRQviNI_qE"></div>
								</div>
							</div>
						</div>

						<div>
							<div class="form_wrapper">
								<div class="form_label">First name*</div>
								<div class="input">
									<input type="text" name="first_name" id="first_name" required>
								</div>
							</div>

							<div class="form_wrapper">
								<div class="form_label">Last name*</div>
								<div class="input">
									<input type="text" name="last_name" id="last_name" required>
								</div>
							</div>

							<div class="grid grid__three">
								<div class="form_wrapper">
									<div class="form_label">Date of Birthd (DD)*</div>
									<div class="input">
										<input type="number" min="1" max="31" step="1" name="birth_day" id="birth_day" required>
									</div>
								</div>

								<div class="form_wrapper">
									<div class="form_label">Month (MM)*</div>
									<div class="input">
										<input type="number" min="1" max="12" step="1" name="birth_month" id="birth_month" required>
									</div>
								</div>

								<div class="form_wrapper">
									<div class="form_label">Year (YYYY)*</div>
									<div class="input">
										<input type="number" min="1900" max="<?php echo date( 'Y' ); ?>" step="1" name="birth_year" id="birth_year" required>
									</div>
								</div>
							</div>

							<div class="form_wrapper">
								<div class="form_label">Email*</div>
								<div class="input">
									<input type="email" name="email" id="email" required>
								</div>
							</div>

							<div class="form_wrapper">
								<div class="form_label">Confirm Password*</div>
								<div class="input">
									<input type="password" name="confirm_password" id="confirm_password" required>
								</div>
							</div>

							<div class="form_wrapper">
								<div class="form_label">address*</div>
								<div class="input">
									<input type="text" name="billing_address_1" id="billing_address_1" required>
								</div>
							</div>

							<div class="form_wrapper">
								<div class="input">
									<label> <input type="checkbox" name="newsletter" id="newsletter" checked class="input__hidden">
										<span>Sign Up for Newsletter</span> </label>
								</div>
							</div>

							<div class="modal_btn">
								<!--<div class="btn">sign in</div>-->
								<input type="submit" name="wp-submit" class="btn" value="sign in">
							</div>

							<div class="modal_under">
								<div class="hover__line modal-link" data-modal-name="login">Log in</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="modal_viel"></div>
	</div>
	<!-- Modal-register. -->
<?php endif; ?>

<?php if ( is_checkout() ): ?>
	<!-- Modal-identification. -->
	<div class="modal modal-identification">
		<div class="modal_wrapper">
			<div class="modal_top">
				<span class="close"></span> Identification
			</div>
			<div class="modal_scroll">
				<table class="black">
					<tr>
						<th>Identification</th>
						<th>Validation of address</th>
					</tr>
					<tr>
						<td>Current signed passport</td>
						<td>Utility bill (gas, electric, satellite television, landline phone bill) issued within the last three months</td>
					</tr>
					<tr>
						<td>Original birth certificate</td>
						<td>Local authority council tax bill for the current council tax year</td>
					</tr>
					<tr>
						<td>EEA member state identity card</td>
						<td>Current UK driving license (if not used to evi-dence identification)</td>
					</tr>
					<tr>
						<td>Current UK or EEA photocard driving license</td>
						<td>Bank, Building Society or Credit Union statement dated within the last three months</td>
					</tr>
					<tr>
						<td>Full UK driving license (old-style)</td>
						<td>Original mortgage statement from a recognised lender issued for the last full year</td>
					</tr>
					<tr>
						<td>Original notification letter from Benefits Agency</td>
						<td>Solicitors letter within the last three months con-firming recent house purchase or land registry confirmation of address</td>
					</tr>
					<tr>
						<td>Firearms or shotgun certificate</td>
						<td>Council or housing association rent card <br>Tenancy agreement for the current year</td>
					</tr>
					<tr>
						<td>Residence permit issued by the Home Office to EEA nationals</td>
						<td>Original notification letter from Benefits Agency (if not used to evidence identification)</td>
					</tr>
					<tr>
						<td>National identity card bearing a photograph of the applicant</td>
						<td>HMRC self-assessment letters <br>Tax demands dated within the current financial year</td>
					</tr>
					<tr>
						<td></td>
						<td>Electoral Register entry</td>
					</tr>
					<tr>
						<td></td>
						<td>NHS Medical card <br>Letter of confirmation from GP’s practice con-firming registration with the surgery</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="modal_viel"></div>
	</div>
	<!-- Modal-identification. -->
<?php endif; ?>

<?php if ( is_cart() ): ?>
	<!-- Modal-allocated. -->
	<div class="modal modal-allocated">
		<div class="modal_wrapper">
			<div class="modal_top">
				<span class="close"></span> Allocated Storage Information
			</div>
			<div class="modal_scroll">
				<p>BullionByPost are now offering customers a high security, insured, allocated storage solution from only £10.00 per month. Our storage service includes free delivery to the vault, individually segregated and fully allocated storage with Brinks, insurance and independent audits by Azets.</p>
				<ul>
					<li>No minimum holding or term</li>
					<li>Minimum charge equivalent to £10.00 per month</li>
					<li>Sell to us or request physical delivery</li>
				</ul>
				<h4>Storage rates</h4>
				<table>
					<tr>
						<th>Metal</th>
						<th>Rate</th>
						<th>From</th>
						<th>To</th>
					</tr>
					<tr>
						<td>Gold</td>
						<td>0.65% per annum + VAT</td>
						<td>29 Mar 2022</td>
						<td>Ongoing</td>
					</tr>
				</table>
				<a class="modal_more hover__line" href="<?php echo home_url( '/storage-information/' ); ?>">View more storage information</a>
				<div class="flex__center">
					<picture>
						<source srcset="<?php echo get_template_directory_uri() . "/assets"; ?>/images/brinks.webp" type="image/webp">
						<img src="<?php echo get_template_directory_uri() . "/assets"; ?>/images/brinks.png" alt srcset="<?php echo get_template_directory_uri() . "/assets"; ?>/images/brinks.png 1x, <?php echo get_template_directory_uri() . "/assets"; ?>/images/brinks@2x.png 2x">
					</picture>
					<div class="btn close-btn">Ok</div>
				</div>
			</div>
		</div>
		<div class="modal_viel"></div>
	</div>
	<!-- Modal-allocated. -->
<?php endif; ?>

<!-- Modal-payment. -->
<div class="modal modal-payment">
	<div class="modal_wrapper">
		<div class="modal_top">
			<span class="close"></span> Add payment method
		</div>
		<div class="modal_scroll">
			<fomm class="form">
				<div class="form_wrapper">
					<div class="form_label">Card number</div>
					<div class="input">
						<input type="text"> <span class="error_text">Error text</span>
					</div>
				</div>
				<div class="grid grid__twoo">
					<div class="form_wrapper">
						<div class="form_label">Expiration</div>
						<div class="input error">
							<input type="text"> <span class="error_text">Error text</span>
						</div>
					</div>
					<div class="form_wrapper">
						<div class="form_label">Cvv</div>
						<div class="input">
							<input type="text"> <span class="error_text">Error text</span>
						</div>
					</div>
				</div>
				<p>If you add a payment method, all future renewals will be charged on that new payment method</p>
				<div class="modal_btn">
					<div class="btn">Add new credit card</div>
				</div>
				<div class="modal_under">
					<div class="hover__line">Add new pay pal account</div>
				</div>
			</fomm>
		</div>
	</div>
	<div class="modal_viel"></div>
</div>
<!-- Modal-payment. -->

<!-- Modal-billing. -->
<div class="modal modal-billing">
	<div class="modal_wrapper">
		<div class="modal_top">
			<span class="close"></span> Edit Billing Address
		</div>
		<div class="modal_scroll">
			<fomm class="form">
				<div class="grid grid__twoo">
					<div class="form_wrapper">
						<div class="form_label">First name</div>
						<div class="input">
							<input type="text"> <span class="error_text">Error text</span>
						</div>
					</div>
					<div class="form_wrapper">
						<div class="form_label">Last name</div>
						<div class="input">
							<input type="text"> <span class="error_text">Error text</span>
						</div>
					</div>
					<div class="form_wrapper">
						<div class="form_label">Address Line 1</div>
						<div class="input">
							<input type="text"> <span class="error_text">Error text</span>
						</div>
					</div>
					<div class="form_wrapper">
						<div class="form_label">Address Line 2</div>
						<div class="input">
							<input type="text"> <span class="error_text">Error text</span>
						</div>
					</div>
					<div class="form_wrapper">
						<div class="form_label">City</div>
						<div class="input">
							<input type="text"> <span class="error_text">Error text</span>
						</div>
					</div>
					<div class="form_wrapper">
						<div class="form_label">State</div>
						<div class="select">
							<select name="where">
								<option value="hidden"></option>
								<option value="1">State 1</option>
								<option value="2">State 2</option>
								<option value="3">State 3</option>
								<option value="4">State 4</option>
							</select>
						</div>
					</div>
					<div class="form_wrapper">
						<div class="form_label">ZIP Code</div>
						<div class="input">
							<input type="text"> <span class="error_text">Error text</span>
						</div>
					</div>
					<div class="form_wrapper">
						<div class="form_label">Phone Number</div>
						<div class="input">
							<input type="text"> <span class="error_text">Error text</span>
						</div>
					</div>
				</div>
				<div class="modal_btn">
					<div class="btn">Save</div>
				</div>
			</fomm>
		</div>
	</div>
	<div class="modal_viel"></div>
</div>
<!-- Modal-billing. -->

<!-- Footer. -->
<div class="footer">
	<div class="bone">
		<div class="footer_net flex__start">
			<?php if ( $footer[ 'logo' ] || $footer[ 'text' ] ) :
				$picture = suissevault_get_picture_html( $footer[ 'logo' ] ); ?>
				<div class="footer_column">
					<?php if ( $footer[ 'logo' ] ): ?>
						<div class="footer_logo">
							<?php echo $picture; ?>
						</div>
					<?php endif; ?>
					<p><?php echo "$footer[text]"; ?></p>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-1' ) ): ?>
				<?php dynamic_sidebar( 'footer-1' ); ?>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-2' ) ): ?>
				<?php dynamic_sidebar( 'footer-2' ); ?>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-3' ) ): ?>
				<?php dynamic_sidebar( 'footer-3' ); ?>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-4' ) ): ?>
				<?php dynamic_sidebar( 'footer-4' ); ?>
			<?php endif; ?>

			<div class="footer_column">
				<?php get_template_part( 'template-parts/social', 'links' ); ?>
				<ul class="footer_hrefs">
					<li class="icon icon-tel">
						<a href="tel:<?php echo "$contacts[phone]"; ?>" class="hover__line"><?php echo "$contacts[phone]"; ?></a>
					</li>
					<li class="icon icon-time"><?php echo abbreviated_days_of_the_week( $contacts[ 'working_days' ] ) . ": $contacts[working_hours]"; ?></li>
					<li class="icon icon-mail">
						<a href="mailto:<?php echo "$contacts[email]"; ?>" class="hover__line"><?php echo "$contacts[email]"; ?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer_bottom">
		<div class="bone">
			<div class="footer_net flex__center">
				<div class="footer_cop">
					<?php echo "$footer[copyright]"; ?>
				</div>

				<?php if ( $footer[ 'payments' ] ): ?>
					<ul class="footer_pay flex__align">
						<?php foreach ( $footer[ 'payments' ] as $payment ) {
							echo suissevault_get_picture_html( $payment[ 'payment' ] );
						} ?>
					</ul>
				<?php endif; ?>

				<div>
					<?php echo get_acf_link_html( $footer[ 'privacy_link' ], "footer_policy hover__line" ); ?>
					<?php echo get_acf_link_html( $footer[ 'terms_link' ], "footer_policy hover__line" ); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Footer. -->

<?php wp_footer(); ?>

</body>
</html>