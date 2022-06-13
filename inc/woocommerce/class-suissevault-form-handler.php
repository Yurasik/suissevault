<?php

defined( 'ABSPATH' ) || exit;

/**
 * Suissevault_Form_Handler class.
 */
class Suissevault_Form_Handler
{

	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_action( 'template_redirect', array( __CLASS__, 'save_my_account' ) );
	}

	public static function save_my_account() {
		$nonce_value = wc_get_var( $_REQUEST[ 'save-my-account-nonce' ], wc_get_var( $_REQUEST[ '_wpnonce' ], '' ) ); // @codingStandardsIgnoreLine.

		if ( !wp_verify_nonce( $nonce_value, 'save_my_account' ) ) {
			return;
		}

		if ( empty( $_POST[ 'action' ] ) || 'save_my_account' !== $_POST[ 'action' ] ) {
			return;
		}

		wc_nocache_headers();

		$user_id = get_current_user_id();

		if ( $user_id <= 0 ) {
			return;
		}

		$account_first_name    = !empty( $_POST[ 'account_first_name' ] )
			? wc_clean( wp_unslash( $_POST[ 'account_first_name' ] ) )
			: '';
		$account_last_name     = !empty( $_POST[ 'account_last_name' ] )
			? wc_clean( wp_unslash( $_POST[ 'account_last_name' ] ) )
			: '';
		$account_email         = !empty( $_POST[ 'account_email' ] )
			? wc_clean( wp_unslash( $_POST[ 'account_email' ] ) )
			: '';
		$account_billing_phone = !empty( $_POST[ 'account_billing_phone' ] )
			? wc_clean( wp_unslash( $_POST[ 'account_billing_phone' ] ) )
			: '';

		// Current user data.
		$current_user          = get_user_by( 'id', $user_id );
		$current_first_name    = $current_user->first_name;
		$current_last_name     = $current_user->last_name;
		$current_email         = $current_user->user_email;
		$current_billing_phone = $current_user->billing_phone;

		// New user data.
		$user             = new stdClass();
		$user->ID         = $user_id;
		$user->first_name = $account_first_name;
		$user->last_name  = $account_last_name;

		// Handle required fields.
		$required_fields = apply_filters( 'woocommerce_save_my_account_required_fields', array(
			'account_first_name'    => __( 'First name', 'woocommerce' ),
			'account_last_name'     => __( 'Last name', 'woocommerce' ),
			'account_email'         => __( 'Email address', 'woocommerce' ),
			'account_billing_phone' => __( 'Phone', 'woocommerce' ),
		) );

		foreach ( $required_fields as $field_key => $field_name ) {
			if ( empty( $_POST[ $field_key ] ) ) {
				/* translators: %s: Field name. */
				wc_add_notice( sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . esc_html( $field_name ) . '</strong>' ), 'error', array( 'id' => $field_key ) );
			}
		}

		if ( $account_email ) {
			$account_email = sanitize_email( $account_email );
			if ( !is_email( $account_email ) ) {
				wc_add_notice( __( 'Please provide a valid email address.', 'woocommerce' ), 'error' );
			}
			elseif ( email_exists( $account_email ) && $account_email !== $current_user->user_email ) {
				wc_add_notice( __( 'This email address is already registered.', 'woocommerce' ), 'error' );
			}
			$user->user_email = $account_email;
		}

		if ( $account_billing_phone ) {
			$account_billing_phone = wc_sanitize_phone_number( $account_billing_phone );
			if ( !WC_Validation::is_phone( $account_billing_phone ) || empty( $account_billing_phone ) ) {
				wc_add_notice( __( 'Please provide a valid phone number.', 'woocommerce' ), 'error' );
			}
			$user->billing_phone = $account_billing_phone;
		}

		// Allow plugins to return their own errors.
		$errors = new WP_Error();
		do_action_ref_array( 'woocommerce_save_my_account_errors', array( &$errors, &$user ) );

		if ( $errors->get_error_messages() ) {
			foreach ( $errors->get_error_messages() as $error ) {
				wc_add_notice( $error, 'error' );
			}
		}

		if ( wc_notice_count( 'error' ) === 0 ) {
			wp_update_user( $user );

			// Update customer object to keep data in sync.
			$customer = new WC_Customer( $user->ID );

			if ( $customer ) {
				// Keep billing data in sync if data changed.
				if ( is_email( $user->user_email ) && $current_email !== $user->user_email ) {
					$customer->set_billing_email( $user->user_email );
				}

				if ( WC_Validation::is_phone( $current_billing_phone ) && $current_billing_phone !== $user->billing_phone ) {
					$customer->set_billing_phone( $user->billing_phone );
				}

				if ( $current_first_name !== $user->first_name ) {
					$customer->set_billing_first_name( $user->first_name );
				}

				if ( $current_last_name !== $user->last_name ) {
					$customer->set_billing_last_name( $user->last_name );
				}

				$customer->save();
			}

			wc_add_notice( __( 'Account details changed successfully.', 'woocommerce' ) );

			do_action( 'woocommerce_save_my_account', $user->ID );

			wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
			exit;
		}
	}
}

Suissevault_Form_Handler::init();