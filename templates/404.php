<?php

/**
 * The main 404-wrapper
 *
 * @package NordStarter
 */

get_header();

?>

<?php do_action( 'nord_before_page' ); ?>
<?php get_template_part( 'partials/no-results', '404' ); ?>
<?php get_footer(); ?>
