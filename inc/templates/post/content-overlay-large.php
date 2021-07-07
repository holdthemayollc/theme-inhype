<?php
/**
 * Post template: Overlay large (with text)
 */

?>
<?php

$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'inhype-blog-thumb');

if(has_post_thumbnail( $post->ID )) {
    $image_bg ='background-image: url('.esc_url($image[0]).');';
    $post_class = ' inhype-post-invert';
}
else {
    $image_bg = '';
    $post_class = ' inhype-post-no-image';
}

$categories_list = inhype_get_the_category_list( $post->ID );

// Show post format
$current_post_format = get_post_format($post->ID) ? get_post_format($post->ID) : 'standard';
$post_format_icon = '';

if (in_array($current_post_format, inhype_get_mediaformats())) {
    $post_format_icon = '<div class="inhype-post-format-icon"></div>';
}

$post_class .= ' format-'.$current_post_format;

echo '<div class="inhype-overlay-post inhype-overlay-large-post inhype-post'.esc_attr($post_class).'"'.inhype_add_aos(false).'>';

echo '<div class="inhype-post-wrapper-inner">';

if(has_post_thumbnail( $post->ID )) {
  echo '<div class="inhype-post-image" data-style="'.esc_attr($image_bg).'">';

  if(get_theme_mod('blog_posts_review', true)) {
    do_action('inhype_post_review_rating'); // this action called from plugin
  }

  echo wp_kses_post($post_format_icon);

  echo '</div>';
}

// Post details
echo '
<div class="inhype-post-details">

<div class="inhype-post-details-inner">
<div class="post-categories">'.wp_kses($categories_list, inhype_esc_data()).'</div>';

echo '<h3 class="post-title entry-title"><a href="'.esc_url(get_permalink($post->ID)).'">'.wp_kses_post($post->post_title).'</a></h3>';
?>
<div class="post-date"><?php echo inhype_get_post_date($post->ID); ?></div>
<?php if(get_theme_mod('blog_posts_read_time', false)): ?>
<div class="post-info-dot"></div>
<div class="post-read-time"><?php echo inhype_get_post_read_time($post->ID); ?></div>
<?php endif; ?>
<?php if (get_theme_mod('blog_posts_excerpt', 'excerpt') !== 'none'): ?>
<?php echo '<div class="post-excerpt">'.wp_kses_post(inhype_get_the_excerpt($post->ID)).'</div>'; ?>
<?php endif; // after post-excerpt?>
</div>

</div>

</div>
</div>
