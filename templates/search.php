<?php

/**
 * The main search-wrapper
 *
 * @package Digia WP-Base
 */

get_header();

?>

<?php do_action( 'digia_before_page' ); ?>

<?php if ( have_posts() ) : ?>
	<?php printf( __( 'Search Results for: %s', TEXT_DOMAIN ), '<span>' . get_search_query() . '</span>' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'partials/content', 'search' ); ?>
	<?php endwhile; ?>

<?php else : ?>
	<?php get_template_part( 'partials/no-results', 'search' ); ?>
<?php endif; ?>

<?php get_footer(); ?>