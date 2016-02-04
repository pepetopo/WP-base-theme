<?php

/**
 * WP-nav-menus & Widgetized areas
 *
 * @package nord_
 *
 */

/**
 * Main menu
 */
function nord_main_menu() {
	wp_nav_menu( [
		'theme_location'  => 'top_nav',
		'container'       => false,
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => '',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '%3$s',
		'depth'           => 4,
		'walker'          => new Nord\WP_navwalker
	] );
}

register_nav_menu( 'top_nav', __( 'Main menu', TEXT_DOMAIN ) );

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
