<?php
/**
 * Suissevault WooCommerce Class
 *
 * @package  suissevault
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Suissevault_WooCommerce' ) ) :

	/**
	 * The Suissevault WooCommerce Integration class
	 */
	class Suissevault_WooCommerce {

		/**
		 * Setup class.
		 *
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ), 20 );

			// Instead of loading Core CSS files, we only register the font families.
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_filter( 'wp_enqueue_scripts', array( $this, 'add_core_fonts' ), 130 );
		}

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @return void
		 */
		public function setup() {
			add_theme_support(
				'woocommerce',
				apply_filters(
					'suissevault_woocommerce_args',
					array(
						'single_image_width'    => 630,
						'thumbnail_image_width' => 324,
						'product_grid'          => array(
							'default_columns' => 3,
							'default_rows'    => 4,
							'min_columns'     => 1,
							'max_columns'     => 6,
							'min_rows'        => 1,
						),
					)
				)
			);

			//add_theme_support( 'wc-product-gallery-zoom' );
			//add_theme_support( 'wc-product-gallery-lightbox' );
			//add_theme_support( 'wc-product-gallery-slider' );

			/**
			 * Add 'suissevault_woocommerce_setup' action.
			 *
			 */
			do_action( 'suissevault_woocommerce_setup' );
		}

		/**
		 * Add CSS in <head> to register WooCommerce Core fonts.
		 *
		 * @return void
		 */
		public function add_core_fonts() {
			$fonts_url = plugins_url( '/woocommerce/assets/fonts/' );
			wp_add_inline_style(
				'suissevault-woocommerce-style',
				'@font-face {
				font-family: star;
				src: url(' . $fonts_url . 'star.eot);
				src:
					url(' . $fonts_url . 'star.eot?#iefix) format("embedded-opentype"),
					url(' . $fonts_url . 'star.woff) format("woff"),
					url(' . $fonts_url . 'star.ttf) format("truetype"),
					url(' . $fonts_url . 'star.svg#star) format("svg");
				font-weight: 400;
				font-style: normal;
			}
			@font-face {
				font-family: WooCommerce;
				src: url(' . $fonts_url . 'WooCommerce.eot);
				src:
					url(' . $fonts_url . 'WooCommerce.eot?#iefix) format("embedded-opentype"),
					url(' . $fonts_url . 'WooCommerce.woff) format("woff"),
					url(' . $fonts_url . 'WooCommerce.ttf) format("truetype"),
					url(' . $fonts_url . 'WooCommerce.svg#WooCommerce) format("svg");
				font-weight: 400;
				font-style: normal;
			}'
			);
		}

		/**
		 * WooCommerce specific scripts & stylesheets
		 *
		 */
		public function woocommerce_scripts() {
			global $suissevault_version;

			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		}
	}

endif;

return new Suissevault_WooCommerce();
