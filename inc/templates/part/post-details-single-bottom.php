<?php
/**
 * Post template part: Post details bottom on single post page
 */

?>
<div class="post-details-bottom post-details-bottom-single">

    <div class="post-info-wrapper">
    <?php if(get_theme_mod('blog_post_comments', false)):?>
    <?php if ( ! post_password_required() && ( comments_open() ) ) : ?>
    <div class="post-info-comments"><i class="fa fa-comments-o" aria-hidden="true"></i><a href="<?php echo esc_url(get_comments_link( $post->ID )); ?>"><?php echo wp_kses(get_comments_number_text( esc_html__('0', 'inhype'), esc_html__('1', 'inhype'), esc_html__('%', 'inhype') ), inhype_esc_data()); ?></a></div>
    <?php endif; ?>
    <?php endif; ?>

    <?php if(get_theme_mod('blog_post_views', true) && function_exists('inhype_post_views_display')): ?>
    <div class="post-info-views"><?php do_action('inhype_post_views'); // this action called from plugin ?></div>
    <?php endif; ?>
    <?php if(get_theme_mod('blog_post_likes', false) && function_exists('inhype_post_likes_display')): ?>
    <div class="post-info-likes"><?php do_action('inhype_post_likes'); // this action called from plugin ?></div>
    <?php endif; ?>
    </div>

    <?php if(get_theme_mod('blog_post_share', true)): ?>
    <div class="post-info-share">
      <?php do_action('inhype_social_share'); // this action called from plugin ?>
    </div>
    <?php endif; ?>

</div>
