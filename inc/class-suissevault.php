<?php
/**
 * Suissevault Class
 *
 * @since    1.0.0
 * @package  suissevault
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Suissevault' ) ) :

	/**
	 * The main Suissevault class
	 */
	class Suissevault
	{
		private $widget_regions;

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'init', array( $this, 'cpt_init' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'widget_nav_menu_args', array( $this, 'add_widget_nav_menu_class' ), 10, 4 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'child_enqueue' ), 30 ); // After WooCommerce.
			add_filter( 'body_class', array( $this, 'body_classes' ) );
			//add_action( 'enqueue_embed_scripts', array( $this, 'print_embed_styles' ) );
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 */
		public function setup() {
			/*
			 * Load Localisation files.
			 *
			 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
			 */

			// Loads wp-content/languages/themes/suissevault-it_IT.mo.
			load_theme_textdomain( 'suissevault', trailingslashit( WP_LANG_DIR ) . 'themes' );

			// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
			load_theme_textdomain( 'suissevault', get_stylesheet_directory() . '/languages' );

			// Loads wp-content/themes/suissevault/languages/it_IT.mo.
			load_theme_textdomain( 'suissevault', get_template_directory() . '/languages' );

			/**
			 * Add default posts and comments RSS feed links to head.
			 */
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );

			/**
			 * Register menu locations.
			 */
			register_nav_menus( apply_filters( 'suissevault_register_nav_menus', array(
				'primary' => __( 'Primary Menu', 'suissevault' )
			) ) );

			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5', apply_filters( 'suissevault_html5_args', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'widgets',
				'style',
				'script',
			) ) );

			/**
			 * Declare support for title theme feature.
			 */
			add_theme_support( 'title-tag' );

			/**
			 * Declare support for selective refreshing of widgets.
			 */
			add_theme_support( 'customize-selective-refresh-widgets' );

			/**
			 * Add support for Block Styles.
			 */
			add_theme_support( 'wp-block-styles' );

			/**
			 * Add support for editor styles.
			 */
			add_theme_support( 'editor-styles' );

			/**
			 * Add support for editor font sizes.
			 */
			add_theme_support( 'editor-font-sizes', array(
				array(
					'name' => __( 'Small', 'suissevault' ),
					'size' => 14,
					'slug' => 'small',
				),
				array(
					'name' => __( 'Normal', 'suissevault' ),
					'size' => 16,
					'slug' => 'normal',
				),
				array(
					'name' => __( 'Medium', 'suissevault' ),
					'size' => 23,
					'slug' => 'medium',
				),
				array(
					'name' => __( 'Large', 'suissevault' ),
					'size' => 26,
					'slug' => 'large',
				),
				array(
					'name' => __( 'Huge', 'suissevault' ),
					'size' => 37,
					'slug' => 'huge',
				),
			) );
		}

		public function cpt_init() {
			//Banners
			register_post_type( 'banner', array(
				'labels'              => array(
					'name'               => __( 'Banners', 'suissevault' ),
					'singular_name'      => __( 'Banner', 'suissevault' ),
					'add_new'            => __( 'Add New', 'suissevault' ),
					'add_new_item'       => __( 'Add New Banner', 'suissevault' ),
					'edit_item'          => __( 'Edit Banner', 'suissevault' ),
					'new_item'           => __( 'New Banner', 'suissevault' ),
					'view_item'          => __( 'View Banner', 'suissevault' ),
					'search_items'       => __( 'Search Banners', 'suissevault' ),
					'not_found'          => __( 'No Banners found', 'suissevault' ),
					'not_found_in_trash' => __( 'No Banners found in Trash', 'suissevault' ),
				),
				'public'              => true,
				'exclude_from_search' => true,
				'menu_icon'           => 'dashicons-slides',
				'supports'            => array( 'title', 'thumbnail' ),
			) );

			// Feedbacks
			register_post_type( 'feedback', array(
				'labels'              => array(
					'name'               => __( 'Feedbacks', 'suissevault' ),
					'singular_name'      => __( 'Feedback', 'suissevault' ),
					'add_new'            => __( 'Add New', 'suissevault' ),
					'add_new_item'       => __( 'Add New Feedback', 'suissevault' ),
					'edit_item'          => __( 'Edit Feedback', 'suissevault' ),
					'new_item'           => __( 'New Feedback', 'suissevault' ),
					'view_item'          => __( 'View Feedback', 'suissevault' ),
					'search_items'       => __( 'Search Feedback', 'suissevault' ),
					'not_found'          => __( 'No Feedbacks found', 'suissevault' ),
					'not_found_in_trash' => __( 'No Feedbacks found in Trash', 'suissevault' ),
				),
				'public'              => true,
				'exclude_from_search' => true,
				'menu_icon'           => 'dashicons-feedback',
				'supports'            => array( 'title', 'editor' ),
			) );

			// FAQ
			register_post_type( 'faq', array(
				'labels'              => array(
					'name'               => __( 'FAQ', 'suissevault' ),
					'singular_name'      => __( 'FAQ', 'suissevault' ),
					'add_new'            => __( 'Add New', 'suissevault' ),
					'add_new_item'       => __( 'Add New FAQ', 'suissevault' ),
					'edit_item'          => __( 'Edit FAQ', 'suissevault' ),
					'new_item'           => __( 'New FAQ', 'suissevault' ),
					'view_item'          => __( 'View FAQ', 'suissevault' ),
					'search_items'       => __( 'Search FAQ', 'suissevault' ),
					'not_found'          => __( 'No FAQ found', 'suissevault' ),
					'not_found_in_trash' => __( 'No FAQ found in Trash', 'suissevault' ),
				),
				'public'              => true,
				'exclude_from_search' => true,
				'menu_icon'           => 'dashicons-editor-help',
				'supports'            => array( 'title', 'editor' ),
			) );

			// Suppliers
			register_post_type( 'supplier', array(
				'labels'              => array(
					'name'               => __( 'Suppliers', 'suissevault' ),
					'singular_name'      => __( 'Supplier', 'suissevault' ),
					'add_new'            => __( 'Add New', 'suissevault' ),
					'add_new_item'       => __( 'Add New Supplier', 'suissevault' ),
					'edit_item'          => __( 'Edit Supplier', 'suissevault' ),
					'new_item'           => __( 'New Supplier', 'suissevault' ),
					'view_item'          => __( 'View Supplier', 'suissevault' ),
					'search_items'       => __( 'Search Suppliers', 'suissevault' ),
					'not_found'          => __( 'No Suppliers found', 'suissevault' ),
					'not_found_in_trash' => __( 'No Suppliers found in Trash', 'suissevault' ),
				),
				'public'              => true,
				'exclude_from_search' => true,
				'menu_icon'           => 'dashicons-store',
				'supports'            => array( 'title', 'thumbnail' ),
			) );
		}

		/**
		 * Register widget area.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
		 */
		public function widgets_init() {
			$sidebar_args[ 'sidebar' ] = array(
				'name'        => __( 'Sidebar', 'suissevault' ),
				'id'          => 'sidebar-1',
				'description' => '',
			);

			$rows = intval( apply_filters( 'suissevault_footer_widget_rows', 1 ) );
			$this->widget_regions = intval( apply_filters( 'suissevault_footer_widget_columns', 4 ) );

			for ( $row = 1; $row <= $rows; $row++ ) {
				for ( $region = 1; $region <= $this->widget_regions; $region++ ) {
					$footer_n = $region + $this->widget_regions * ( $row - 1 ); // Defines footer sidebar ID.
					$footer = sprintf( 'footer_%d', $footer_n );

					if ( 1 === $rows ) {
						/* translators: 1: column number */
						$footer_region_name = sprintf( __( 'Footer Column %1$d', 'suissevault' ), $region );

						/* translators: 1: column number */
						$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of the footer.', 'suissevault' ), $region );
					}
					else {
						/* translators: 1: row number, 2: column number */
						$footer_region_name = sprintf( __( 'Footer Row %1$d - Column %2$d', 'suissevault' ), $row, $region );

						/* translators: 1: column number, 2: row number */
						$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'suissevault' ), $region, $row );
					}

					$sidebar_args[ $footer ] = array(
						'name'        => $footer_region_name,
						'id'          => sprintf( 'footer-%d', $footer_n ),
						'description' => $footer_region_description,
					);
				}
			}

			$sidebar_args = apply_filters( 'suissevault_sidebar_args', $sidebar_args );

			foreach ( $sidebar_args as $sidebar => $args ) {
				$widget_tags = array(
					'before_widget' => '<div id="%1$s" class="footer_column widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="subtitle">',
					'after_title'   => '</div>',
				);

				/**
				 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
				 * 'suissevault_header_widget_tags'
				 * 'suissevault_sidebar_widget_tags'
				 * 'suissevault_footer_1_widget_tags'
				 * 'suissevault_footer_2_widget_tags'
				 * 'suissevault_footer_3_widget_tags'
				 * 'suissevault_footer_4_widget_tags'
				 */
				$filter_hook = sprintf( 'suissevault_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );

				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			}
		}

		/**
		 * @param $nav_menu_args
		 * @param $nav_menu
		 * @param $args
		 * @param $instance
		 *
		 * @return mixed
		 */
		public function add_widget_nav_menu_class( $nav_menu_args, $nav_menu, $args, $instance ) {

			$widget_regions = array();
			for ( $i = 1; $i <= $this->widget_regions; $i++ ) {
				$widget_regions[ $i ] = "footer-$i";
			}

			if ( in_array( $args[ 'id' ], $widget_regions ) ) {
				$nav_menu_args[ 'menu_class' ] = 'nav';
			}

			return $nav_menu_args;
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @since  1.0.0
		 */
		public function enqueue() {
			global $suissevault_version;

			$current_url = ( isset( $_SERVER[ 'HTTPS' ] ) ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			/**
			 * Styles
			 */
			wp_enqueue_style( "suissevault-main", get_template_directory_uri() . "/assets/css/main.css", array(), $suissevault_version );
			wp_enqueue_style( 'suissevault-style', get_stylesheet_uri(), array(), $suissevault_version );

			/**
			 * Scripts
			 */
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			if ( wc_get_endpoint_url( 'payment-methods' ) == $current_url || wc_get_endpoint_url( 'payment-methods', 'billing' ) == $current_url ) {
				wp_dequeue_style( 'select2' );
				wp_dequeue_script( 'select2' );
				wp_dequeue_script( 'selectWoo' );
			}

			wp_dequeue_script( 'jquery' );
			wp_dequeue_script( 'jquery-core' );
			wp_dequeue_script( 'jquery-migrate' );

			//wp_register_script( "jquery", get_template_directory_uri() . "/assets/js/libraries/jquery.min.js", [], false, true );
			wp_register_script( 'jquery', false, array(), false, true );
			wp_register_script( 'jquery-core', false, array(), false, true );
			wp_register_script( 'jquery-migrate', false, array(), false, true );
			wp_register_script( "jquery-ui-range", get_template_directory_uri() . "/assets/js/libraries/jquery-ui__range.min.js", [], false, true );
			wp_register_script( 'suissevault-navigation', get_template_directory_uri() . '/assets/js/navigation' . $suffix . '.js', array(), $suissevault_version, true );
			wp_register_script( "select", get_template_directory_uri() . "/assets/js/libraries/select.min.js", [], false, true );
			wp_register_script( "slick", get_template_directory_uri() . "/assets/js/libraries/slick.min.js", [], false, true );
			wp_register_script( "main", get_template_directory_uri() . "/assets/js/main.js", [ 'jquery', 'select' ], false, true );

			wp_enqueue_script( "jquery" );
			wp_enqueue_script( "jquery-core" );
			wp_enqueue_script( "jquery-migrate" );
			wp_enqueue_script( "jquery-ui-range" );
			wp_enqueue_script( "'suissevault-navigation" );
			wp_enqueue_script( "select" );
			wp_enqueue_script( "slick" );
			if ( is_page( 'live-prices' ) ) {
				wp_register_script( "advanced-real-time-chart-widget", "https://s3.tradingview.com/tv.js", [ 'jquery' ], false, true );
				wp_register_script( "widgets", get_template_directory_uri() . "/assets/js/widgets.js", [
					'jquery',
					'advanced-real-time-chart-widget'
				], false, true );

				wp_enqueue_script( "advanced-real-time-chart-widget" );
				wp_enqueue_script( "widgets" );

				wp_localize_script( 'widgets', 'ajax_object', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' )
				) );
			}
			wp_enqueue_script( "main" );

			wp_localize_script( 'main', 'ajax_object', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			) );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
		 * primary css and the separate WooCommerce css.
		 *
		 * @since  1.5.3
		 */
		public function child_enqueue() {
			if ( is_child_theme() ) {
				$child_theme = wp_get_theme( get_stylesheet() );
				wp_enqueue_style( 'suissevault-child-style', get_stylesheet_uri(), array(), $child_theme->get( 'Version' ) );
			}
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 *
		 * @return array
		 */
		public function body_classes( $classes ) {

			// If our main sidebar doesn't contain widgets, adjust the layout to be full-width.
			if ( !is_active_sidebar( 'sidebar-1' ) ) {
				$classes[] = 'suissevault-full-width-content';
			}

			// Add class when using homepage template + featured image.
			if ( is_page_template( 'template-homepage.php' ) && has_post_thumbnail() ) {
				$classes[] = 'has-post-thumbnail';
			}

			return $classes;
		}

		/**
		 * Add styles for embeds
		 */
		public function print_embed_styles() {
			global $suissevault_version;

			?>
			<style type="text/css"></style>
			<?php
		}

	}
endif;

return new Suissevault();
