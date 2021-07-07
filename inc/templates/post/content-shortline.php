<?php
/**
 * Post template: Shortline
 */

?>
<?php

$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'inhype-blog-thumb-widget');

if(has_post_thumbnail( $post->ID )) {
    $image_bg ='background-image: url('.esc_url($image[0]).');';
    $post_class = '';
}
else {
    $image_bg = '';
    $post_class = ' inhype-post-no-image';
}

$categories_list = inhype_get_the_category_list( $post->ID );

echo '<div class="inhype-shortline-post inhype-post'.esc_attr($post_class).'"'.inhype_add_aos(false).'>';

if(has_post_thumbnail( $post->ID )) {
  echo '<div class="inhype-post-image-wrapper"><a href="'.esc_url(get_permalink($post->ID)).'"><div class="inhype-post-image" data-style="'.esc_attr($image_bg).'"></div></a></div>';
}

// Post details
echo '<div class="inhype-post-details">
    <h3 class="post-title entry-title"><a href="'.esc_url(get_permalink($post->ID)).'">'.wp_kses_post($post->post_title).'</a></h3>
    <div class="post-date">'.inhype_get_post_date($post->ID).'</div>';

echo '</div>';
// END - Post details


echo '</div>';
