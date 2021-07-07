<?php
/*
*	Posts Author biography template
*/
?>
<div class="author-bio" <?php inhype_add_aos(); ?>>
    <div class="author-image-wrapper">
        <div class="author-image">
            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ))); ?>"><?php echo get_avatar( get_the_author_meta('email'), '90', '90' ); ?></a>
        </div>
        <div class="author-posts"><?php echo esc_html(count_user_posts(get_the_author_meta( 'ID' ),'post')); ?> <?php echo esc_html__('posts', 'inhype'); ?></div>
    </div>
	<div class="author-info">
		<h3><span class="vcard author"><span class="fn"><?php the_author_posts_link();?></span></span></h3>
        <h5><?php esc_html_e( 'About author', 'inhype' ); ?></h5>
		<div class="author-description"><?php the_author_meta('description'); ?></div>
        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ))); ?>" class="author-bio-link"><?php esc_html_e( 'Articles', 'inhype' ); ?></a>
		<?php do_action('inhype_author_social_links_display'); // This action called form plugin ?>
	</div>
</div>
