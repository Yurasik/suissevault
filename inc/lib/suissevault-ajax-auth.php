<?php
add_action( 'wp_logout', 'auto_redirect_after_logout' );
function auto_redirect_after_logout() {
	wp_safe_redirect( home_url() );
	exit;
}

function ajax_auth_init() {
	wp_register_script( 'ajax-auth-script', get_template_directory_uri() . '/assets/js/ajax-auth-script.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'ajax-auth-script' );

	wp_localize_script( 'ajax-auth-script', 'ajax_auth_object', array(
		'ajaxurl'     => admin_url( 'admin-ajax.php' ),
		'redirecturl' => home_url(),
	) );

	// Enable the user with no privileges to run ajax_login() in AJAX
	add_action( 'wp_ajax_nopriv_ajax_login', 'ajax_login' );
	// Enable the user with no privileges to run ajax_register() in AJAX
	add_action( 'wp_ajax_nopriv_ajax_register', 'ajax_register' );
}

// Execute the action only if the user isn't logged in
if ( !is_user_logged_in() ) {
	add_action( 'init', 'ajax_auth_init' );
}

function ajax_login() {

	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'ajax-login-nonce', 'security' );

	// Nonce is checked, get the POST data and sign user on
	// Call auth_user_login
	auth_user_login( $_POST[ 'username' ], $_POST[ 'password' ] );

	die();
}

function ajax_register() {

	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'ajax-register-nonce', 'security' );

	register_validation();

	// Nonce is checked, get the POST data and sign user on
	$info                    = array();
	$info[ 'user_email' ]    = sanitize_email( $_POST[ 'email' ] );
	$info[ 'user_login' ]    = explode( "@", $info[ 'user_email' ] )[ 0 ];
	$info[ 'user_nicename' ] = $info[ 'nickname' ] = $info[ 'display_name' ] = $info[ 'first_name' ] = sanitize_user( $_POST[ 'first_name' ] );
	$info[ 'last_name' ]     = sanitize_text_field( $_POST[ 'last_name' ] );
	$info[ 'user_pass' ]     = sanitize_text_field( $_POST[ 'password' ] );
	$info[ 'role' ]          = 'customer';

	// Get User meta data
	$meta                    = array();
	$meta[ 'title' ]         = sanitize_text_field( $_POST[ 'title' ] );
	$meta[ 'initial' ]       = sanitize_text_field( $_POST[ 'initial' ] );
	$meta[ 'where' ]         = sanitize_text_field( $_POST[ 'where' ] );
	$meta[ 'birth_day' ]     = sanitize_text_field( $_POST[ 'birth_day' ] );
	$meta[ 'birth_month' ]   = sanitize_text_field( $_POST[ 'birth_month' ] );
	$meta[ 'birth_year' ]    = sanitize_text_field( $_POST[ 'birth_year' ] );
	$meta[ 'birthday_date' ] = date( 'd-m-Y', strtotime( "$_POST[birth_day]-$_POST[birth_month]-$_POST[birth_year]" ) );
	$meta[ 'newsletter' ]    = sanitize_text_field( $_POST[ 'newsletter' ] );

	// Get User billing meta data
	$meta[ 'billing_first_name' ] = sanitize_user( $_POST[ 'first_name' ] );
	$meta[ 'billing_last_name' ]  = sanitize_text_field( $_POST[ 'last_name' ] );
	$meta[ 'billing_phone' ]      = sanitize_text_field( $_POST[ 'billing_phone' ] );
	$meta[ 'billing_country' ]    = sanitize_text_field( $_POST[ 'billing_country' ] );
	$meta[ 'billing_address_1' ]  = sanitize_text_field( $_POST[ 'billing_address_1' ] );

	// Register the user
	$user_id = user_register( $info );
	if ( $user_id ) {

		// Update User meta
		foreach ( $meta as $meta_key => $meta_value ) {
			update_user_meta( $user_id, $meta_key, $meta_value );
		}

		auth_user_login( $info[ 'user_email' ], $info[ 'user_pass' ] );
	}

	die();
}

function register_validation() {

	$response               = array();
	$response[ 'loggedin' ] = false;
	$response[ 'errors' ]   = [];

	// Checking required fields
	$required_fields = [
		'first_name',
		'last_name',
		'birth_day',
		'birth_month',
		'birth_year',
		'email',
		'billing_phone',
		'billing_address_1',
		'password',
		'confirm_password',
	];

	foreach ( $required_fields as $required_field ) {
		$response = check_required_field( sanitize_text_field( $_POST[ $required_field ] ), $required_field, $response );
	}

	// Check password match
	$password         = sanitize_text_field( $_POST[ 'password' ] );
	$confirm_password = sanitize_text_field( $_POST[ 'confirm_password' ] );
	if ( $password != $confirm_password ) {
		$error_counter                                        = count( $response[ 'errors' ] );
		$response[ 'errors' ][ $error_counter ][ 'input_id' ] = 'password';
		$response[ 'errors' ][ $error_counter ][ 'message' ]  = "Passwords do not match";

		$error_counter                                        = +1;
		$response[ 'errors' ][ $error_counter ][ 'input_id' ] = 'confirm_password';
		$response[ 'errors' ][ $error_counter ][ 'message' ]  = "Passwords do not match";
	}

	// Check g-recaptcha
	$g_recaptcha_response = sanitize_text_field( $_POST[ 'g_recaptcha_response' ] );
	if ( $g_recaptcha_response == "" ) {
		$error_counter                                        = count( $response[ 'errors' ] );
		$response[ 'errors' ][ $error_counter ][ 'input_id' ] = 'g-recaptcha';
		$response[ 'errors' ][ $error_counter ][ 'message' ]  = "Confirm that you are not a robot";
	}
	else {
		require_once "recaptchalib.php";

		$secret            = "6Lepwx4gAAAAAJBsDc910PBHEWzmEGjm4yxU5suG";
		$reCaptcha         = new ReCaptcha( $secret );
		$recaptchaResponse = $reCaptcha->verifyResponse( $_SERVER[ "REMOTE_ADDR" ], $g_recaptcha_response );

		if ( !$recaptchaResponse->success ) {
			$error_counter                                        = count( $response[ 'errors' ] );
			$response[ 'errors' ][ $error_counter ][ 'input_id' ] = 'g-recaptcha';
			$response[ 'errors' ][ $error_counter ][ 'message' ]  = $recaptchaResponse->errorCodes;
		}
	}

	// If there are errors, show them in the form
	if ( !empty( $response[ 'errors' ] ) ) {
		wp_send_json( $response );
		die();
	}

}

function check_required_field( $field, $field_id, $result ) {

	if ( $field == "" ) {
		$error_counter = count( $result[ 'errors' ] );

		$result[ 'errors' ][ $error_counter ][ 'input_id' ] = $field_id;
		$result[ 'errors' ][ $error_counter ][ 'message' ]  = "Field is required";
	}

	return $result;
}

function user_register( $info ) {

	$user_id = wp_insert_user( $info );

	if ( is_wp_error( $user_id ) ) {
		$response               = array();
		$response[ 'loggedin' ] = false;
		$response[ 'errors' ]   = [];
		$errors                 = $user_id->errors;

		if ( array_key_exists( 'existing_user_login', $errors ) ) {
			$info[ 'user_login' ] = fixing_user_login( $info[ 'user_login' ] );
			user_register( $info );
		}

		foreach ( $errors as $error_key => $error_value ) {
			$error_counter = count( $response[ 'errors' ] );
			if ( $error_key == 'existing_user_email' ) {
				$response[ 'errors' ][ $error_counter ][ 'input_id' ] = 'email';
				$response[ 'errors' ][ $error_counter ][ 'message' ]  = $errors[ $error_key ][ 0 ];
			}
		}

		// If there are errors, show them in the form
		if ( !empty( $response[ 'errors' ] ) ) {
			wp_send_json( $response );
			die();
		}
	}

	return $user_id;
}

function fixing_user_login( $user_login ) {

	$user_login_parts                  = explode( '_', $user_login );
	$user_login_parts_count            = count( $user_login_parts );
	$user_login_parts_last_part_number = $user_login_parts_count - 1;
	$user_login_parts_last_part        = $user_login_parts[ $user_login_parts_last_part_number ];

	if ( is_numeric( $user_login_parts_last_part ) ) {
		$user_login_parts[ $user_login_parts_last_part_number ] = $user_login_parts_last_part + 1;
		$user_login                                             = implode( "_", $user_login_parts );
	}
	else {
		$user_login .= "_1";
	}

	return $user_login;
}

function auth_user_login( $user_login, $password ) {

	$response               = array();
	$response[ 'loggedin' ] = true;

	$info                    = array();
	$info[ 'user_login' ]    = $user_login;
	$info[ 'user_password' ] = $password;
	$info[ 'remember' ]      = true;

	$user_signon = wp_signon( $info );
	if ( !is_wp_error( $user_signon ) ) {
		wp_set_current_user( $user_signon->ID );
	}
	else {
		$response[ 'loggedin' ] = false;
		$response[ 'errors' ]   = [];
		$errors                 = $user_signon->errors;

		foreach ( $errors as $error_key => $error_value ) {
			$error_counter = count( $response[ 'errors' ] );
			if ( $error_key == 'empty_username' || $error_key == 'invalid_username' || $error_key == 'invalid_email' ) {
				$response[ 'errors' ][ $error_counter ][ 'input_id' ] = 'username';
				$response[ 'errors' ][ $error_counter ][ 'message' ]  = $errors[ $error_key ][ 0 ];
			}
			elseif ( $error_key == 'empty_password' || $error_key == 'incorrect_password' ) {
				$response[ 'errors' ][ $error_counter ][ 'input_id' ] = 'password';
				$response[ 'errors' ][ $error_counter ][ 'message' ]  = $errors[ $error_key ][ 0 ];
			}
		}
	}

	wp_send_json( $response );
	die();
}