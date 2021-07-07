<?php
/**
 * Product template: Grid
 */

?>
<?php

$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'inhype-blog-thumb');

if (has_post_thumbnail($post->ID)) {
    $image_bg ='background-image: url('.esc_url($image[0]).');';
    $post_class = '';
} else {
    $image_bg = '';
    $post_class = ' inhype-post-no-image';
}

$categories_list = inhype_get_the_wc_category_list($post->ID);

// Show post format
$current_post_format = get_post_format($post->ID) ? get_post_format($post->ID) : 'standard';
$post_format_icon = '';

if (in_array($current_post_format, inhype_get_mediaformats())) {
    $post_format_icon = '<div class="inhype-post-format-icon"></div>';
}

$post_class .= ' format-'.$current_post_format;

echo '<div class="inhype-grid-post inhype-post'.esc_attr($post_class).'"'.inhype_add_aos(false).'>';

if (has_post_thumbnail($post->ID)) {
    echo '<div class="inhype-post-image-wrapper">';

    if(get_theme_mod('blog_posts_review', true)) {
        do_action('inhype_post_review_rating'); // this action called from plugin
    }

    echo '<a href="'.esc_url(get_permalink($post->ID)).'"><div class="inhype-post-image" data-style="'.esc_attr($image_bg).'">'.wp_kses_post($post_format_icon).'</div></a></div>';
}

// Post details
echo '<div class="inhype-post-details">
    <div class="post-categories">'.wp_kses($categories_list, inhype_esc_data()).'</div>
    <h3 class="post-title entry-title"><a href="'.esc_url(get_permalink($post->ID)).'">'.wp_kses_post($post->post_title).'</a></h3>';

echo do_shortcode('[add_to_cart id="'.$post->ID.'"]');
    //echo $post->get_price_html();
?>
<?php
echo '</div>';
// END - Post details
?>

</div>
