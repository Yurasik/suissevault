<?php
$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
$gateway = isset( $available_gateways['bacs'] ) ? $available_gateways['bacs'] : false;

if($gateway){
    bacs_thankyou_page($gateway,$order_id);
}

function bacs_thankyou_page($gateway,$order_id){
    if($gateway->instructions ) {
    	echo wp_kses_post( wpautop( wptexturize( wp_kses_post( $gateway->instructions ) ) ) );
    }   
        
    if ( empty( $gateway->account_details ) ) {
    	return;
    }
    
    $order = wc_get_order( $order_id );
    $country = $order->get_billing_country();
    $locale  = $gateway->get_country_locale();
    
    $sortcode = isset( $locale[ $country ]['sortcode']['label'] ) ? $locale[ $country ]['sortcode']['label'] : __( 'Sort code', 'woocommerce' );
    $bacs_accounts = apply_filters( 'woocommerce_bacs_accounts', $gateway->account_details, $order_id );

    $account_html = '';    
    $has_details  = false;

	foreach ( $bacs_accounts as $bacs_account ) {
		$bacs_account = (object) $bacs_account;

		if($bacs_account->account_name ) {				    
            $account_names = explode(',',wp_kses_post( wp_unslash( $bacs_account->account_name ) ));
            $account_html .= '<ul class="wc-bacs-bank-details order_details bacs_details">' . PHP_EOL;
            foreach ( $account_names as $value ) {
				$account_html .= '<li>' . wp_kses_post( wptexturize( $value ) ) . '</li>' . PHP_EOL;
			}    
			$account_html .= '</ul><br>';
		}

		$account_html .= '<ul class="wc-bacs-bank-details order_details bacs_details">' . PHP_EOL;

		// BACS account fields shown on the thanks page and in emails.
		$account_fields = apply_filters(
			'woocommerce_bacs_account_fields',
			array(
				'bank_name'      => array(
					'label' => __( 'Bank', 'woocommerce' ),
					'value' => $bacs_account->bank_name,
				),
				'account_number' => array(
					'label' => __( 'Account number', 'woocommerce' ),
					'value' => $bacs_account->account_number,
				),
				'sort_code'      => array(
					'label' => $sortcode,
					'value' => $bacs_account->sort_code,
				),
				'iban'           => array(
					'label' => __( 'IBAN', 'woocommerce' ),
					'value' => $bacs_account->iban,
				),
				'bic'            => array(
					'label' => __( 'BIC', 'woocommerce' ),
					'value' => $bacs_account->bic,
				),
			),
			$order_id
		);

		foreach ( $account_fields as $field_key => $field ) {
			if ( ! empty( $field['value'] ) ) {
				$account_html .= '<li class="' . esc_attr( $field_key ) . '">' . wp_kses_post( $field['label'] ) . ': <strong>' . wp_kses_post( wptexturize( $field['value'] ) ) . '</strong></li>' . PHP_EOL;
				$has_details   = true;
			}
		}

		$account_html .= '</ul>';
	}

	if ( $has_details ) {
		echo '<section class="woocommerce-bacs-bank-details"><h2 class="wc-bacs-bank-details-heading">' . esc_html__( 'Our bank details', 'woocommerce' ) . '</h2><br>' . wp_kses_post( PHP_EOL . $account_html ) . '</section>';
	}
    
}
