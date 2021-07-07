<?php
/**
 * Post header template: Post header template with image and details displayed in post content
 */

// Header image
$header_background_image_data = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'inhype-blog-thumb');
$header_background_image = $header_background_image_data[0];

if(isset($header_background_image) && ($header_background_image !== '')) {
    $header_background_image_style = 'background-image: url('.$header_background_image.');';
    $header_background_class = ' with-bg';

} else {
    $header_background_image_style = '';
    $header_background_class = ' without-bg';
}

?>
<div class="container-page-item-title container-page-item-title-inside<?php echo esc_attr($header_background_class); ?>" data-style="<?php echo esc_attr($header_background_image_style); ?>">
    <?php
    if(get_theme_mod('blog_post_review', true)) {
        do_action('inhype_post_review_rating'); // this action called from plugin
    }
    ?>
    <div class="col-overlay">
        <div class="page-item-title-single page-item-title-single-inside">
            <?php
            $categories_list = inhype_get_the_category_list();
            ?>
            <div class="inhype-post-single inhype-post">
                <div class="post-categories"><?php echo wp_kses($categories_list, inhype_esc_data()); ?></div>
                <div class="inhype-post-details">
                    <h1 class="post-title entry-title"><?php the_title(); ?></h1>
                    <?php
                    if(get_theme_mod('blog_posts_author', false)):
                    ?>
                    <div class="post-author">
                        <span class="vcard">
                            <?php echo esc_html__('By', 'inhype'); ?> <span class="fn"><?php echo get_the_author_posts_link(); ?></span>
                        </span>
                    </div>
                    <div class="post-info-dot"></div>
                    <?php endif; ?>
                    <div class="post-date"><?php echo inhype_get_post_date(); ?></div>
                    <?php if(get_theme_mod('blog_post_read_time', false)): ?>
                    <div class="post-info-dot"></div>
                    <div class="post-read-time"><?php echo inhype_get_post_read_time($post->ID); ?></div>
                    <?php endif; ?>
                    <?php
                    // Post details bottom
                    get_template_part( 'inc/templates/part/post-details-single-bottom-inline' );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(get_theme_mod('blog_post_caption', false) && get_post(get_post_thumbnail_id())->post_excerpt): ?>
<div class="post-image-caption">
    <?php echo wp_kses_post(get_post(get_post_thumbnail_id())->post_excerpt); ?>
</div>
<?php endif; ?>
