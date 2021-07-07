<?php
/**
 * Post header template: Post header template with image only
 */

// Header image - uploaded
if(get_theme_mod('blog_post_header_image_type', 'header') == 'header') {
    $header_background_image = get_post_meta( get_the_ID(), '_inhype_header_image', true );
} else {
// Header image - thumb
    $header_background_image_data = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'inhype-blog-thumb');
    $header_background_image = $header_background_image_data[0];
}

$header_parallax = get_post_meta( get_the_ID(), '_inhype_header_parallax', true );

if(isset($header_background_image) && ($header_background_image !== '')) {
    $header_background_image_style = 'background-image: url('.$header_background_image.');';
    $header_background_class = ' with-bg';

    if($header_parallax) {
        $header_background_class .= ' inhype-parallax';
    }

} else {
    $header_background_image_style = '';
    $header_background_class = ' without-bg';
}

// Header width
$post_header_width = get_post_meta( get_the_ID(), '_inhype_post_header_width', true );

if(!empty($post_header_width)) {
    $blog_post_header_width = $post_header_width;
} else {
    $blog_post_header_width = get_theme_mod('blog_post_header_width', 'boxed');
}

// Blog post header width
if($blog_post_header_width == 'fullwidth') {
    $container_class = 'container-fluid';
} else {
    $container_class = 'container';
}
?>
<div class="<?php echo esc_attr($container_class); ?> container-page-item-title container-page-item-title-image-only<?php echo esc_attr($header_background_class); ?>" data-style="<?php echo esc_attr($header_background_image_style); ?>" data-speed="0.1">
    <?php
    if(get_theme_mod('blog_post_review', true)) {
        do_action('inhype_post_review_rating'); // this action called from plugin
    }
    ?>
    <div class="col-overlay">
    </div>
</div>
