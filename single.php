<?php
/**
 * The Template for displaying all single posts.
 *
 * @package InHype
 */

get_header();

do_action("inhype_set_post_views"); // called from plugin

?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'content', 'single' ); ?>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
