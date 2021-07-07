<?php
/**
 * Post header template: Post header template (without image)
 */

?>
<div class="container-page-item-title container-page-item-title-inside without-bg">
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
