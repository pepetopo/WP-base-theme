<?php

namespace Nord;

class Hooks {

	public function __construct() {

		add_action( 'nord_after_body', [ $this, 'tagmanager' ] );
		add_action( 'pre_get_posts', [ $this, 'loop_alter' ] );
		add_action( 'wp_head', [ $this, 'favicons' ], 999 );

	}

	/**
	 * Add TagManager-script (if defined)
	 *
	 * @hook nord_after_body
	 */
	public function tagmanager() {

		$options = get_option( 'nord_general_options' );

		if ( ! empty( $options['nord_tagmanager'] ) ) :
			echo $options['nord_tagmanager'];
		endif;

	}

	/**
	 * Add favicons to head
	 *
	 * @return string
	 */
	public function favicons() {

		$image_uri = UTILS()->get_image_uri();

		echo <<<EOT
	\n
	<link rel="apple-touch-icon" sizes="57x57" href="{$image_uri}/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="{$image_uri}/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="{$image_uri}/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="{$image_uri}/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="{$image_uri}/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="{$image_uri}/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="{$image_uri}/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="{$image_uri}/favicons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="{$image_uri}/favicons/apple-touch-icon-180x180.png">

	<link rel="icon" type="image/png" href="{$image_uri}/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="{$image_uri}/favicons/favicon-194x194.png" sizes="194x194">
	<link rel="icon" type="image/png" href="{$image_uri}/favicons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="{$image_uri}/favicons/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="{$image_uri}/favicons/favicon-16x16.png" sizes="16x16">

	<link rel="manifest" href="{$image_uri}/favicons/manifest.json">

	<meta name="msapplication-config" content="{$image_uri}/favicons/browserconfig.xml" />
	<meta name="theme-color" content="#ffffff">
	\n
EOT;
	}

	/**
	 * Alter WP-loops
	 *
	 * @hook pre_get_posts
	 */
	public function loop_alter( $query ) {
	}
}

/**
 * Construct class
 */
new Hooks;
