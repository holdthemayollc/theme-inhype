<?php
/**
 * Single blog post page
 *
 * @package InHype
 */

$current_post_format = get_post_format($post->ID) ? get_post_format($post->ID) : 'standard';

$post_formats_media = array('audio', 'video', 'gallery');

$post_id = get_the_ID();

// Post settings
$post_sidebarposition = get_post_meta( get_the_ID(), '_inhype_post_sidebar_position', true );
$post_image_disable = get_post_meta( get_the_ID(), '_inhype_post_image_disable', true );

// Header image - uploaded
if(get_theme_mod('blog_post_header_image_type', 'header') == 'header') {
    $has_post_header_image = get_post_meta( get_the_ID(), '_inhype_header_image', true );
} else {
// Header image - thumb
    $header_background_image_data = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'inhype-blog-thumb');
    $has_post_header_image = $header_background_image_data[0];
}

$post_review_enabled = get_post_meta( get_the_ID(), '_inhype_post_review_enabled', true );
$post_header_layout = get_post_meta( get_the_ID(), '_inhype_post_header_layout', true );
$post_summary = get_post_meta( get_the_ID(), '_inhype_post_summary', true );
$post_summary = array_filter(explode("\n", str_replace("\r", "", $post_summary)));
$post_smallwidth = get_post_meta( get_the_ID(), '_inhype_post_smallwidth', true );

// Post header layout
if(empty($post_header_layout)) {
	$blog_post_header_layout = get_theme_mod('blog_post_header_layout', 'incontent2');
} else {
	$blog_post_header_layout = $post_header_layout;
}

// Post sidebar position
if(empty($post_sidebarposition)) {
	$post_sidebarposition = 0;
}

if($post_sidebarposition == "0") {
	$post_sidebarposition = get_theme_mod('sidebar_post', 'disable');
}

// Demo settings
if ( defined('DEMO_MODE') && isset($_GET['sidebar_post']) ) {
  $post_sidebarposition = $_GET['sidebar_post'];
}

if(is_active_sidebar( 'post-sidebar' ) && ($post_sidebarposition !== 'disable') ) {
	$span_class = 'col-md-8';

	inhype_set_content_width(750);
}
else {
	$span_class = 'col-md-12 post-single-content';

	if((get_theme_mod('blog_post_smallwidth', false) && $post_smallwidth != 0) || $post_smallwidth == 1) {
	    inhype_set_content_width(850);
	}
}

// Post media
$post_embed_video = get_post_meta( $post_id, '_inhype_video_embed', true );

if($post_embed_video !== '') {

	$post_embed_video_output = wp_oembed_get($post_embed_video);
} else {
	$post_embed_video_output = '';
}

$post_embed_audio = get_post_meta( $post_id, '_inhype_audio_embed', true );

if($post_embed_audio !== '') {

	$post_embed_audio_output = wp_oembed_get($post_embed_audio);

} else {
	$post_embed_audio_output = '';
}

// Gallery post type
$post_embed_gallery_output = '';

if($current_post_format == 'gallery') {

	$gallery_images_data = inhype_cmb2_get_images_src( $post_id, '_inhype_gallery_file_list', 'inhype-blog-thumb' );

	if(count($gallery_images_data) > 0) {

		$post_gallery_id = 'blog-post-gallery-'.$post_id;
		$post_embed_gallery_output = '<div class="blog-post-gallery-wrapper owl-carousel" id="'.$post_gallery_id.'" style="display: none;">';

		$post_title = the_title_attribute(array('echo' => false));

		foreach ($gallery_images_data as $gallery_image) {
			$post_embed_gallery_output .= '<div class="blog-post-gallery-image"><a href="'.esc_url($gallery_image).'" rel="lightbox" title="'.esc_attr($post_title).'"><img src="'.esc_url($gallery_image).'" alt="'.esc_attr($post_title).'"/></a></div>';
		}

		$post_embed_gallery_output .= '</div>';

		wp_add_inline_script( 'inhype-script', '(function($){
	            $(document).ready(function() {

	            	"use strict";

	                $("#'.esc_js($post_gallery_id).'").owlCarousel({
	                    items: 1,
	                    autoplay: true,
	                    autowidth: false,
	                    autoplayTimeout:2000,
	                    autoplaySpeed: 1000,
	                    navSpeed: 1000,
	                    nav: true,
	                    dots: false,
	                    loop: true,
	                    navText: false,
	                    responsive: {
	                        1199:{
	                            items:1
	                        },
	                        979:{
	                            items:1
	                        },
	                        768:{
	                            items:1
	                        },
	                        479:{
	                            items:1
	                        },
	                        0:{
	                            items:1
	                        }
	                    }
	                });

	            });})(jQuery);');

	}
}
?>

<div class="content-block post-header-<?php echo esc_attr($blog_post_header_layout); ?> post-sidebar-<?php echo esc_attr($post_sidebarposition); ?>">
<?php
// Blog post header layout "In header" - Style 1 - Show post header with image and title
if($has_post_header_image && $blog_post_header_layout == 'inheader') {
	get_template_part( 'inc/templates/post-header/post-header', 'image-details' );
}

// Blog post header layout "In header" - Style 2 - Show post header with image only
if($has_post_header_image && $blog_post_header_layout == 'inheader2') {
	get_template_part( 'inc/templates/post-header/post-header', 'image' );
}

// Blog post header layout "In header" - Style 3 - Show post header with image and title 2 columns
if(has_post_thumbnail() && $blog_post_header_layout == 'inheader3') {
	get_template_part( 'inc/templates/post-header/post-header', 'image-2column' );
}
?>
	<div class="post-container container <?php echo esc_attr('span-'.$span_class); ?>">
		<div class="row">
			<?php if ( is_active_sidebar( 'post-sidebar' ) && ( $post_sidebarposition == 'left')) : ?>
			<div class="col-md-4 post-sidebar sidebar sidebar-left" role="complementary">
			<ul id="post-sidebar">
			<?php dynamic_sidebar( 'post-sidebar' ); ?>
			</ul>
			</div>
			<?php endif; ?>
			<div class="<?php echo esc_attr($span_class); ?>">
				<div class="blog-post blog-post-single hentry clearfix">
					<?php
					// Blog post header layout "In header" - Style 1 - Show post header without image
					if(!$has_post_header_image && $blog_post_header_layout == 'inheader') {
						get_template_part( 'inc/templates/post-header/post-header', 'text' );
					}

					// Blog post header layout "In header" - Style 2 - Show post header without image
					if(!$has_post_header_image && $blog_post_header_layout == 'inheader2') {
						get_template_part( 'inc/templates/post-header/post-header', 'text' );
					}

					// Blog post header layout "In header" - Style 3 - Show post header without image
					if(!has_post_thumbnail() && $blog_post_header_layout == 'inheader3') {
						get_template_part( 'inc/templates/post-header/post-header', 'text' );
					}

					// Blog post header layouts "In content" - Show post header without image
					if(!has_post_thumbnail() && $blog_post_header_layout !== 'inheader' && $blog_post_header_layout !== 'inheader2' && $blog_post_header_layout !== 'inheader3' && $blog_post_header_layout !== 'incontent2') {
						get_template_part( 'inc/templates/post-header/post-header', 'text' );
					}

					// Blog post header layouts "In content" - Show post header with image
					if ( has_post_thumbnail() && !in_array($current_post_format, $post_formats_media)&&(!$post_image_disable ) && (get_theme_mod('blog_post_featured_image', true) ) ):

						// Blog post header layout "Image in content - Style 1" Show post header with image
						if($blog_post_header_layout == 'incontent') {
							get_template_part( 'inc/templates/post-header/post-header', 'image-details-incontent' );
						}

						// Blog post header layout "Image in content - Style 2" Show post header with image
						if($blog_post_header_layout == 'incontent2') {
							get_template_part( 'inc/templates/post-header/post-header', 'text' );
							get_template_part( 'inc/templates/post-header/post-header', 'image-incontent' );
						}

						// Blog post header layout "Image in content - Style 3" Show post header with image
						if($blog_post_header_layout == 'incontent3') {
							get_template_part( 'inc/templates/post-header/post-header', 'image-incontent' );
							get_template_part( 'inc/templates/post-header/post-header', 'text' );
						}

					endif;

					// If we don't have image or it's disabled show only text title
					if ( !has_post_thumbnail() || $post_image_disable || get_theme_mod('blog_post_featured_image', true) == false ):

						if(!in_array($current_post_format, $post_formats_media)) {

							if(in_array($blog_post_header_layout, array('incontent', 'incontent2', 'incontent3'))) {
								get_template_part( 'inc/templates/post-header/post-header', 'text' );
							}
						}

					endif;

					// Show post title for media posts - Blog post header layout "Image in content - Style 1 & 2", title above media
					if(in_array($current_post_format, $post_formats_media)) {
						if($blog_post_header_layout == 'incontent2' || $blog_post_header_layout == 'incontent') {
							get_template_part( 'inc/templates/post-header/post-header', 'text' );
						}
					}

					// Blog post header layout "In header" - Style 2 - Show post header with image only - Show title
					if($has_post_header_image && $blog_post_header_layout == 'inheader2') {
						get_template_part( 'inc/templates/post-header/post-header', 'text' );
					}

					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="main">
						<div class="post-content-wrapper">
							<div class="post-content clearfix">
								<?php
								// Show featured image only for post header layout "In header"
								if ( has_post_thumbnail() && !in_array($current_post_format, $post_formats_media)&&(!$post_image_disable ) && (get_theme_mod('blog_post_featured_image', true) ) ):
								if ( $blog_post_header_layout == 'inheader' || $blog_post_header_layout == 'inheader2' ):
								?>
								<div class="blog-post-thumb">

									<?php the_post_thumbnail('inhype-blog-thumb'); ?>

								</div>
								<?php if(get_theme_mod('blog_post_caption', false) && get_post(get_post_thumbnail_id())->post_excerpt): ?>
								<div class="post-image-caption">
								    <?php echo wp_kses_post(get_post(get_post_thumbnail_id())->post_excerpt); ?>
								</div>
								<?php endif; ?>

								<?php
								endif;
								endif;
								?>
								<?php

								if(in_array($current_post_format, $post_formats_media) && (wp_kses($post_embed_video_output, inhype_esc_data()) !== '' || wp_kses($post_embed_audio_output, inhype_esc_data()) !== '' || wp_kses_post($post_embed_gallery_output) !== '')) {
									echo '<div class="blog-post-thumb blog-post-thumb-media">';

								// Post media
								if($current_post_format == 'video') {
									echo '<div class="blog-post-media blog-post-media-video">';
									echo wp_kses($post_embed_video_output, inhype_esc_data());
									echo '</div>';
								}
								elseif($current_post_format == 'audio') {
									echo '<div class="blog-post-media blog-post-media-audio">';
									echo wp_kses($post_embed_audio_output, inhype_esc_data());
									echo '</div>';
								}
								elseif($current_post_format == 'gallery') {
									echo '<div class="blog-post-media blog-post-media-gallery">';
									echo wp_kses_post($post_embed_gallery_output);
									echo '</div>';
								}
									echo '</div>';
								}

								// Show post title for media posts - Blog post header layout "Image in content - Style 3" Show post header with image, title below media
								if(in_array($current_post_format, $post_formats_media)&&(!$post_image_disable ) && $blog_post_header_layout == 'incontent3') {
									get_template_part( 'inc/templates/post-header/post-header', 'text' );
								}

								// Single Blog Post page Top banner
								inhype_banner_display('single_post_top');
								?>
								<?php if(count($post_summary) > 0): ?>
								<div class="post-summary">
					            <ul>
					                <?php
					                foreach ($post_summary as $post_summary_entry) {
					                    echo '<li><i class="fa fa-long-arrow-right" aria-hidden="true"></i>'.wp_kses_post($post_summary_entry).'</li>';
					                }
					                ?>
					            </ul>
					            </div>
					            <?php endif; ?>
								<?php if ( is_search() ) : // Only display Excerpts for Search ?>
								<div class="entry-summary">
									<?php the_excerpt(); ?>
								</div><!-- .entry-summary -->
								<?php else : ?>
								<div class="entry-content">

								<?php the_content('<div class="more-link">'.esc_html__( 'View more', 'inhype' ).'</div>' ); ?>

								<?php

									wp_link_pages( array(
										'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'inhype' ),
										'after'  => '</div>',
									) );
								?>
								</div><!-- .entry-content -->

								<?php if(get_theme_mod('blog_post_share_fixed', false)): ?>
								<div class="inhype-social-share-fixed sidebar-position-<?php echo esc_attr($post_sidebarposition); ?>">
									<?php do_action('inhype_social_share'); // this action called from plugin ?>
								</div>
								<?php endif; ?>

								<?php
								// Single Blog Post page Bottom banner
								inhype_banner_display('single_post_bottom');
								?>

								<?php endif; ?>
								</div>

						</div>

					</article>
					<?php
					if($post_review_enabled) {
						get_template_part( 'inc/templates/part/post-review-block' );
					}
					?>
					<?php if(get_theme_mod('blog_post_tags', true)): ?>
					<?php
						/* translators: used between list items, there is a space after the comma */
						$tags_list = get_the_tag_list( '', ' ' );
						if ( $tags_list ) :
					?>
					<div class="post-tags-wrapper">
						<div class="tags clearfix">
							<?php echo wp_kses_post($tags_list); ?>
						</div>
					</div>
					<?php endif; // End if $tags_list ?>
					<?php endif; ?>

					<?php if(get_theme_mod('blog_post_info_bottom', true) == true): ?>
					<div class="inhype-post inhype-post-bottom">
					<?php
	                // Post details bottom
	            	get_template_part( 'inc/templates/part/post-details-single-bottom' );
	                ?>
					</div>
					<?php endif; ?>
				</div>

			</div>
			<?php if ( is_active_sidebar( 'post-sidebar' ) && ( $post_sidebarposition == 'right')) : ?>
			<div class="col-md-4 post-sidebar sidebar sidebar-right" role="complementary">
			<ul id="post-sidebar">
			  <?php dynamic_sidebar( 'post-sidebar' ); ?>
			</ul>
			</div>
			<?php endif; ?>

		</div><?php // .row ?>
	</div><?php // .container.post-container ?>

	<div class="post-container-bottom container <?php echo esc_attr('span-'.$span_class); ?>">
		<div class="row">
			<div class="<?php echo esc_attr($span_class); ?>">
				<?php if(get_theme_mod('blog_post_author', true) == true): ?>
					<?php if ( is_single() && get_the_author_meta( 'description' ) ) : ?>
						<?php get_template_part( 'author-bio' ); ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php
				if(get_theme_mod('blog_post_nav', true) == true) {
					inhype_content_nav( 'nav-below' );
				}
				?>

				<?php if(get_theme_mod('blog_post_related', false) == true): ?>
				<?php get_template_part( 'related-posts-loop' ); ?>
				<?php endif; ?>

				<?php
				if(get_theme_mod('blog_post_subscribe', false)) {
					inhype_block_subscribe_display();
				}
				?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )

						comments_template();
				?>
			</div>
		</div><?php // .row ?>
	</div><?php // .container.post-container-bottom ?>
</div><?php // .content-block ?>
<?php
// Worth reading posts
if(get_theme_mod('blog_post_worthreading', false)) {

	// Get worth reading posts
	$post_worthreading_posts = get_post_meta( $post_id, '_inhype_worthreading_posts', true );

	if(!empty($post_worthreading_posts)) {

		$post_worthreading_post_count = count($post_worthreading_posts);

		$post_worthreading_post_arr_id = rand(0, $post_worthreading_post_count-1);

		$post_worthreading_post_id = $post_worthreading_posts[$post_worthreading_post_arr_id];

		$post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_worthreading_post_id ), 'inhype-blog-thumb-grid');

		if(has_post_thumbnail( $post_worthreading_post_id )) {
	        $image_bg ='background-image: url('.$post_image[0].');';
	        $post_image_html ='<div class="inhype-post-image-wrapper"><a href="'.esc_url(get_permalink($post_worthreading_post_id)).'"><div class="inhype-post-image" data-style="'.esc_attr($image_bg).'"></div></a></div>';
	    }
	    else {
	        $image_bg = '';
	        $post_image_html ='';
	    }

	    $args = array(
			'post__in' => array($post_worthreading_post_id),
			'posts_per_page' => 1,
			'post_type'        => 'post',
			'post_status'      => 'publish',
			'ignore_sticky_posts' => true,
			'suppress_filters' => 0
		);

		$posts_query = new WP_Query($args);

		if( $posts_query->have_posts() ) {

			while ($posts_query->have_posts()) {
				$posts_query->the_post();

				echo '<div class="post-worthreading-post-wrapper">';

				echo '<div class="post-worthreading-post-container">';

				echo '<div class="btn-close">×</div>';

				get_template_part( 'inc/templates/post/content', 'list-small' );

				echo '</div>';

				echo '</div>';

			}

		}

		wp_reset_postdata();

	}

}
?>
