<?php
/**
 * suissevault engine room
 *
 * @package suissevault
 */

/**
 * Assign the suissevault version to a var
 */
$theme               = wp_get_theme( 'suissevault' );
$suissevault_version = $theme[ 'Version' ];

$suissevault = (object)array(
	'version' => $suissevault_version,

	/**
	 * Initialize all the things.
	 */
	'main'    => require 'inc/class-suissevault.php'
);

require 'inc/suissevault-functions.php';
require 'inc/suissevault-template-hooks.php';
require 'inc/suissevault-template-functions.php';
require 'inc/suissevault-shortcodes.php';
require 'inc/class-suissevault-form-handler.php';

if ( suissevault_is_woocommerce_activated() ) {
	$suissevault->woocommerce = require 'inc/woocommerce/class-suissevault-woocommerce.php';

	require 'inc/woocommerce/suissevault-woocommerce-template-hooks.php';
	require 'inc/woocommerce/suissevault-woocommerce-template-functions.php';
	require 'inc/woocommerce/suissevault-woocommerce-functions.php';
}

if ( is_admin() ) {
	$suissevault->admin = require 'inc/admin/class-suissevault-admin.php';
}

require 'inc/lib/suissevault-ajax-auth.php';