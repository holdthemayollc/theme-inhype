<?php
/**
 * Post header template: Post header image, without any details and title
 */

?>
<div class="blog-post-thumb">
    <?php
    if(get_theme_mod('blog_post_review', true)) {
        do_action('inhype_post_review_rating'); // this action called from plugin
    }
    ?>
    <?php the_post_thumbnail('inhype-blog-thumb'); ?>
</div>
<?php if(get_theme_mod('blog_post_caption', false) && get_post(get_post_thumbnail_id())->post_excerpt): ?>
<div class="post-image-caption">
    <?php echo wp_kses_post(get_post(get_post_thumbnail_id())->post_excerpt); ?>
</div>
<?php endif; ?>
