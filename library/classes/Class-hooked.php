<?php

namespace Nord;

/**
 * Class Utility_Hooks
 * @package Nord
 */
class Utility_Hooks {

    public function __construct() {

        add_action( 'nord_after_body', [ $this, 'tagmanager' ] );
        add_action( 'pre_get_posts', [ $this, 'loop_alter' ] );
        add_filter( 'get_the_archive_title', [ $this, 'alter_archive_title' ] );

    }

    /**
     * Add TagManager-script (if defined)
     *
     * @hook nord_after_body
     */
    function tagmanager() {

        $options = get_option( 'nord_general_options' );

        if ( ! empty( $options['nord_tagmanager'] ) ) :
            echo $options['nord_tagmanager'];
        endif;

    }

    /**
     * Alter get_the_archive_title -function
     *
     * @param $title
     *
     * @return string|void
     */
    function alter_archive_title( $title ) {
        if ( is_category() ) {
            $title = single_cat_title( '', false );
        } elseif ( is_tag() ) {
            $title = single_tag_title( '', false );
        } elseif ( is_tax( 'post_format' ) ) {
            if ( is_tax( 'post_format', 'post-format-aside' ) ) {
                $title = _x( 'Asides', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
                $title = _x( 'Galleries', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
                $title = _x( 'Images', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
                $title = _x( 'Videos', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
                $title = _x( 'Quotes', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
                $title = _x( 'Links', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
                $title = _x( 'Statuses', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
                $title = _x( 'Audio', 'post format archive title' );
            } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
                $title = _x( 'Chats', 'post format archive title' );
            }
        } elseif ( is_post_type_archive() ) {
            $title = sprintf( __( '%s' ), post_type_archive_title( '', false ) );
        } elseif ( is_tax() ) {
            $tax = get_taxonomy( get_queried_object()->taxonomy );
            /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
            $title = sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );
        } else {
            $title = __( 'Archives' );
        }

        return $title;

    }

    /**
     * Alter WP-loops
     *
     * @hook pre_get_posts
     */
    function loop_alter( $query ) {
    }
}

/**
 * Construct class
 */
new Utility_Hooks();
