<?php

/**
 * Main functions and definitions
 *
 * @package NordStarter
 */

/**
 * Require helpers
 */
require dirname( __FILE__ ) . '/library/functions/helpers.php';

/**
 * Set theme name which will be referenced from style & script registrations
 */
$nord_theme = wp_get_theme();

/**
 * If defined, the feed will be shown on admin dashboard
 */
define( 'FEED_URI', 'http://omnipartners.fi/feed' );

/**
 * Define Translation domain which will be used on WP __() & _e() -functions
 *
 * note: change also the one on package.json themeHeader-section
 */
define( 'TEXT_DOMAIN', 'nord' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/**
 * Set up theme defaults and register support for various WordPress features.
 */
if ( ! function_exists( 'nord_setup' ) ) :

	function nord_setup() {

		global $cap, $content_width;

		/**
		 * Set custom imagesizes
		 *
		 * @example:[$name(:str), $width(:int), $height(:int), $crop(:bool|arr([x_crop_pos,y_crop_pos]))]
		 */
		$imagesizes = [
			//[ 'article_lift', 360, 200, true ]
		];

		/**
		 * Load textdomain
		 */
		load_theme_textdomain( TEXT_DOMAIN, get_template_directory() . '/library/lang' );

		/**
		 * Add editor styling
		 */
		add_editor_style();

		/**
		 * Require some classes
		 */
		require_files( dirname( __FILE__ ) . '/library/classes' );

		/**
		 * Require custom post types
		 */
		require_files( dirname( __FILE__ ) . '/library/custom-posts' );

		/**
		 * Require metaboxes
		 */
		require_files( dirname( __FILE__ ) . '/library/metaboxes' );

		/**
		 * Widgets (nav-menus & widgetized areas)
		 */
		require_files( dirname( __FILE__ ) . '/library/widgets' );

		/**
		 * Functions and helpers
		 */
		require_files( dirname( __FILE__ ) . '/library/functions' );

		/**
		 * WP-BEM
		 */
		require dirname( __FILE__ ) . '/library/classes/wordpress-bem/wordpress-bem.php';

		/**
		 * Theme supports
		 */
		if ( function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'html5', [ 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ] );
			//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
		}

		/**
		 * Register custom imagesizes
		 */
		foreach ( $imagesizes as $size ) {
			add_image_size( $size[0], $size[1], $size[2], $size[3] );
		}

	}

endif; // nord_setup

add_action( 'after_setup_theme', 'nord_setup' );

/**
 * Add feed (if defined) to dashboard
 */
function nord_dashbord_setup() {
	if ( defined( 'FEED_URI' ) ) {
		add_meta_box( 'dashboard_custom_feed', 'Feed', 'nord_feed', 'dashboard', 'side', 'low' );
	}

	function nord_feed() {
		echo '<div class="rss-widget">';
		wp_widget_rss_output( [
			'url'          => FEED_URI,
			'title'        => __( 'Title', TEXT_DOMAIN ),
			'items'        => 2,
			'show_title'   => 0,
			'show_summary' => 1,
			'show_author'  => 0,
			'show_date'    => 1
		] );
		echo "</div>";
	}
}

add_action( 'wp_dashboard_setup', 'nord_dashbord_setup' );

/**
 * Add admin scripts & styles
 */
function nord_admin_style() {
	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/assets/build/styles/backend.css" type="text/css" media="all" />';
}

add_action( 'login_head', 'nord_admin_style' );
add_action( 'admin_head', 'nord_admin_style' );

function nord_admin_scripts() {
	global $nord_theme;

	wp_enqueue_script(
		'nord-admin',
		get_template_directory_uri() . '/assets/build/js/backend.min.js',
		[ ],
		$nord_theme->get( 'Version' )
	);
}

add_action( 'admin_enqueue_scripts', 'nord_admin_scripts' );

/**
 * Add text to theme footer
 */
function nord_footer_text( $default_text ) {
	global $nord_theme;

	return '<span id="footer-thankyou">' . $nord_theme->Name . ' by: <a href="' . $nord_theme->AuthorURI . '" target="_blank">' . $nord_theme->Author . '</a><span>';
}

add_filter( 'admin_footer_text', 'nord_footer_text' );

/**
 * Enqueue scripts and styles
 */
function nord_scripts() {

	global $nord_theme;

	/**
	 * Vendor scripts
	 */
	wp_enqueue_script(
		'nord-vendor',
		get_template_directory_uri() . '/assets/build/js/vendor.min.js',
		[ 'jquery' ],
		$nord_theme->get( 'Version' ),
		true
	);

	/**
	 * Main script file
	 */
	wp_enqueue_script(
		'nord-theme',
		get_template_directory_uri() . '/assets/build/js/main.min.js',
		[ 'nord-vendor' ],
		$nord_theme->get( 'Version' ),
		true
	);

	/**
	 * Main style
	 */
	wp_enqueue_style(
		'nord-style',
		get_stylesheet_directory_uri() . '/assets/build/styles/main.min.css',
		[ ],
		$nord_theme->get( 'Version' )
	);
}

add_action( 'wp_enqueue_scripts', 'nord_scripts' );

/**
 * Allow svg-uploads
 *
 * @param $mimes
 *
 * @return mixed
 */
function nord_svg_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'nord_svg_mime_types' );


/**
 * Change default WP-API endpoints
 *
 * @return mixed|void
 */

add_filter( 'rest_url_prefix', function ( $prefix ) {
	return 'api';
} );

add_filter( 'json_url_prefix', function ( $prefix ) {
	return 'api';
} );