<?php
/**
 * Suissevault Admin Class
 *
 * @package  suissevault
 * @since    1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Suissevault_Admin' ) ) :
	/**
	 * The Suissevault admin class
	 */
	class Suissevault_Admin
	{

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			$this->suissevault_acf();

		}

		private function suissevault_acf() {

			// Options Page
			if ( function_exists( 'acf_add_options_page' ) ) {
				acf_add_options_page( array(
					'page_title' => 'Theme General Settings',
					'menu_title' => 'Theme Settings',
					'menu_slug'  => 'theme-general-settings',
					'capability' => 'edit_posts',
					'redirect'   => false
				) );

				// Header
				acf_add_options_sub_page( array(
					'page_title'  => 'Header',
					'menu_title'  => 'Header',
					'parent_slug' => 'theme-general-settings',
				) );

				// Footer
				acf_add_options_sub_page( array(
					'page_title'  => 'Footer',
					'menu_title'  => 'Footer',
					'parent_slug' => 'theme-general-settings',
				) );

				// Contacts
				acf_add_options_sub_page( array(
					'page_title'  => 'Contacts',
					'menu_title'  => 'Contacts',
					'parent_slug' => 'theme-general-settings',
				) );

				// 404
				acf_add_options_sub_page( array(
					'page_title'  => 'Page 404',
					'menu_title'  => 'Page 404',
					'parent_slug' => 'theme-general-settings',
				) );

				// Products
				acf_add_options_sub_page( array(
					'page_title'  => 'Products',
					'menu_title'  => 'Products',
					'parent_slug' => 'theme-general-settings',
				) );

				// Modals
				acf_add_options_sub_page( array(
					'page_title'  => 'Modals',
					'menu_title'  => 'Modals',
					'parent_slug' => 'theme-general-settings',
				) );
			}

		}

	}

endif;

return new Suissevault_Admin();
