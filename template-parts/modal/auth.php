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
												$selected = ( $country_code == "GB" ) ? "selected" : ""; ?>
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

							<?php do_action( 'mailchimp_subscribe_checkbox_output', '' ); ?>

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