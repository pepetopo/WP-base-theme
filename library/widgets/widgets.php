<?php

/**
 * Widgetized areas
 *
 * @package NordStarter
 *
 */

/**
 * Register widgetized areas
 */
function nord_widgets_init() {
	register_sidebar( [
		'name'          => __( 'Sidebar', TEXT_DOMAIN ),
		'id'            => 'sidebar_main',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget__title">',
		'after_title'   => '</h3>',
	] );
}

add_action( 'widgets_init', 'nord_widgets_init' );
