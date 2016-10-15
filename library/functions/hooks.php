<?php

/**
 * After user is registered, display the full toolbar on rich edit
 *
 * @hook user_register
 */
add_action( 'user_register', function ( $user_id ) {
    update_user_meta( $user_id, 'wp_user-settings', 'hidetb=1' );
}, 10, 1 );

/**
 * Filter video oembeds and wrap with Foundations flex-video
 *
 * @param $html
 * @param $url
 * @param $attr
 * @param $post_id
 *
 * @return string
 */
add_filter( 'embed_oembed_html', function ( $html, $url, $attr, $post_id ) {
    $matches = [
        'youtube.com',
        'vimeo.com',
        'youtu.be'
    ];

    foreach ( $matches as $match ) {
        if ( false !== stripos( $url, $match ) ) {
            return '<div class="framecontainer">' . $html . '</div>';
        }
    }

    return $html;
}, 99, 4 );

/**
 * The Modified Gallery shortcode.
 *
 * Adds some helper-classes to the gallery
 *
 * @param array $attr Attributes of the shortcode.
 *
 * @return string HTML content to display gallery.
 */
add_filter( 'post_gallery', function ( $defaults = '', $attr ) {
    global $post;

    static $instance = 0;
    $instance ++;

    // Allow plugins/themes to override the default gallery template.
    $output = apply_filters( 'nord_post_gallery', '', $attr );
    if ( $output != '' ) {
        return $output;
    }

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( ! $attr['orderby'] ) {
            unset( $attr['orderby'] );
        }
    }

    extract( shortcode_atts( [
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'li',
        'icontag'    => '',
        'captiontag' => 'div',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ], $attr ) );

    $id = intval( $id );
    if ( 'RAND' == $order ) {
        $orderby = 'none';
    }

    if ( ! empty( $include ) ) {
        $include      = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( [
            'include'        => $include,
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => $order,
            'orderby'        => $orderby
        ] );

        $attachments = [];
        foreach ( $_attachments as $key => $val ) {
            $attachments[ $val->ID ] = $_attachments[ $key ];
        }
    } elseif ( ! empty( $exclude ) ) {
        $exclude     = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( [
            'post_parent'    => $id,
            'exclude'        => $exclude,
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => $order,
            'orderby'        => $orderby
        ] );
    } else {
        $attachments = get_children( [
            'post_parent'    => $id,
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => $order,
            'orderby'        => $orderby
        ] );
    }

    if ( empty( $attachments ) ) {
        return '';
    }

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment ) {
            $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
        }

        return $output;
    }

    $itemtag    = tag_escape( $itemtag );
    $captiontag = tag_escape( $captiontag );
    $columns    = intval( $columns );
    $itemwidth  = $columns > 0 ? floor( 100 / $columns ) : 100;
    $float      = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $size_class = sanitize_html_class( $size );

    $small_columns  = $columns > 2 ? 2 : $columns;
    $medium_columns = $columns > 4 ? 4 : $columns;

    $gallery_div = "<div class=\"gallery-wrap\"><ul id='$selector' class='small-block-grid__{$small_columns} medium-block-grid__{$medium_columns} large-block-grid__{$columns} gallery galleryid-{$id} gallery-size__{$size_class}'>";
    $output      = "\n\t\t" . $gallery_div;

    foreach ( $attachments as $id => $attachment ) {
        $thumb_src = wp_get_attachment_thumb_url( $id );
        $link_url  = wp_get_attachment_url( $id );

        $has_caption = $captiontag && trim( $attachment->post_excerpt ) ? true : false;

        $link = "<a href='$link_url' class='gallery-item__link'><img src='$thumb_src' class='gallery-item__thumbnail' ";

        if ( $has_caption ) {
            $link .= " data-caption='" . wptexturize( strip_tags( $attachment->post_excerpt ) ) . "' ";
        }
        $link .= " /></a>";

        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "$link";
        if ( $has_caption ) {
            $output .= "
                <{$captiontag} class='gallery-item__caption' id='img-caption-{$attachment->ID}'>
                " . wptexturize( $attachment->post_excerpt ) . "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
    }

    $output .= "</ul></div>\n";

    return $output;
}, 10, 2 );

/**
 * Remove h1-tag from tinyMCE
 */
add_filter( 'tiny_mce_before_init', function ( $init ) {
    $init['block_formats'] = "Paragraph=p;Address=address;Pre=pre;Heading 2=h2;Heading 3=h3;Heading 4=h4";

    return $init;
} );

/**
 * Add TagManager-script (if defined)
 *
 * @hook nord_after_body
 */
add_action( 'nord_after_body', function () {
    $options = get_option( 'nord_general_options' );

    if ( ! empty( $options['nord_tagmanager'] ) ) :
        echo $options['nord_tagmanager'];
    endif;
} );

/**
 * Add favicons to head
 *
 * @hook wp_head
 */
add_action( 'wp_head', function () {
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
}, 999 );
