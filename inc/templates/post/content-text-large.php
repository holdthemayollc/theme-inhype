<?php
/**
 * Post template: Text large
 */

?>
<?php

$categories_list = inhype_get_the_category_list( $post->ID );

echo '<div class="inhype-text-post inhype-text-large-post inhype-post"'.inhype_add_aos(false).'>';

echo '<div class="post-categories">'.wp_kses($categories_list, inhype_esc_data()).'</div>';

// Post details
echo '<div class="inhype-post-details">

     <h3 class="post-title entry-title"><a href="'.esc_url(get_permalink($post->ID)).'">'.wp_kses_post($post->post_title).'</a></h3>';

if (get_theme_mod('blog_posts_author', false)):
?>
<div class="post-author">
    <span class="vcard">
        <?php echo esc_html__('By', 'inhype'); ?> <span class="fn"><?php echo get_the_author_posts_link(); ?></span>
    </span>
</div>
<div class="post-info-dot"></div>
<?php
endif;

echo '<div class="post-date">'.inhype_get_post_date($post->ID).'</div>';

if(get_theme_mod('blog_posts_read_time', false)): ?>
<div class="post-info-dot"></div>
<div class="post-read-time"><?php echo inhype_get_post_read_time($post->ID); ?></div>
<?php endif;

echo '</div>';
// END - Post details
if(get_theme_mod('blog_posts_excerpt', 'excerpt') !== 'none'): ?>
<?php echo '<div class="post-excerpt">';

echo wp_kses_post( inhype_get_the_excerpt($post->ID) );

?>
</div>
<?php endif; // after post-excerpt


echo '</div>';
