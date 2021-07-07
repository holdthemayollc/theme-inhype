<?php
/*
 * Template Name: Homepage
 *
 * @package InHype
 */

get_header();

?>

<div class="content-block clearfix" role="main">
    <?php
    // Load homepage layout
    $homepage_blocks = get_theme_mod('homepage_blocks', array());

    foreach( $homepage_blocks as $block ) {

        $block_function_name = 'inhype_block_'.esc_attr($block['block_type']).'_display';

        // Don't show blog page on static page
        if($block['block_type'] !== 'blog') {
            $block_function_name($block);
        }

    }

    ?>
</div>

<?php get_footer(); ?>
