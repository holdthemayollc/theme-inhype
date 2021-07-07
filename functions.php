<?php
/**
 * InHype functions
 *
 * @package InHype
 */

/**
 * WordPress content width configuration
 */
if (!isset($content_width))
	$content_width = 1140; /* pixels */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
if(!function_exists('inhype_setup')):
function inhype_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on InHype, use a find and replace
	 * to change 'inhype' to the name of your theme in all the template files
	 */
	load_theme_textdomain('inhype', get_template_directory() . '/languages');

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support('automatic-feed-links');

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support('post-thumbnails');

  /**
   * Enable support Gutenberg features
   */
  add_theme_support( 'align-wide' );
  add_theme_support( 'editor-styles' );

	/**
	 * Enable support for JetPack Infinite Scroll
	 *
	 * @link https://jetpack.me/support/infinite-scroll/
	 */
	add_theme_support( 'infinite-scroll', array(
	    'container' => 'content',
	    'footer' => 'page',
	) );

	/**
	 * Enable support for Title Tag
	 *
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Logo
	 */
	add_theme_support( 'custom-header', array(
	    'default-image' =>  get_template_directory_uri() . '/img/logo.png',
      'width'         => 165,
      'flex-width'    => true,
      'flex-height'   => false,
      'header-text'   => false,
	));

	/**
	 *	Woocommerce support
	 */
	add_theme_support( 'woocommerce' );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

  if (!function_exists('inhype_woocommerce_single_gallery_thumbnail_size')) :
  /**
   * Change the gallery thumbnail image size.
   */
  function inhype_woocommerce_single_gallery_thumbnail_size( $size ) {
      return array(
          'width'  => 300,
          'height' => 300,
          'crop'   => 1,
      );
  }
  endif;
  add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'inhype_woocommerce_single_gallery_thumbnail_size' );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support('post-formats', array('aside', 'image', 'gallery', 'video', 'audio', 'quote', 'link', 'status', 'chat'));

	/**
	 * Theme images sizes
	 */
	add_image_size( 'inhype-blog-thumb', 1140, 694, true);
	add_image_size( 'inhype-blog-thumb-grid', 555, 360, true);
	add_image_size( 'inhype-blog-thumb-widget', 220, 180, true);
  add_image_size( 'inhype-blog-thumb-masonry', 360, 0, false);

	/**
	 * Theme menus locations
	 */
	register_nav_menus( array(
        'main' => esc_html__('Main Menu', 'inhype'),
        'top' => esc_html__('Top Menu', 'inhype'),
        'footer' => esc_html__('Footer Menu', 'inhype'),
	) );

  // Filters the oEmbed process to run the responsive_embed() function
  add_filter('embed_oembed_html', 'inhype_responsive_embed', 10, 3);

  /**
   * Load theme plugins installation.
   */
  require get_template_directory() . '/inc/theme-plugins.php';

  /**
   * Load theme options.
   */
  require get_template_directory() . '/inc/theme-options.php';

  /**
   * Load theme functions.
   */
  require get_template_directory() . '/inc/theme-functions.php';

  /**
   * Load theme homepage blocks.
   */
  require get_template_directory() . '/inc/theme-blocks.php';

  /**
   * Load theme homepage WooCommerce blocks.
   */
  require get_template_directory() . '/inc/theme-wc-blocks.php';

  /**
   * Load theme sidebars
   */
  require get_template_directory() . '/inc/theme-sidebars.php';

  /**
   * Load theme dynamic CSS.
   */
  require get_template_directory() . '/inc/theme-css.php';

  /**
   * Load theme dynamic JS.
   */
  require get_template_directory() . '/inc/theme-js.php';

  /**
   * Theme dashboard.
   */
  require get_template_directory() . '/inc/theme-dashboard/class-theme-dashboard.php';

  /**
   * Load additional theme modules.
   */

  # Module - Category settings
  require get_template_directory() . '/inc/modules/category/category-settings.php';

  # Module - Mega Menu
  if(get_theme_mod('module_mega_menu', true)) {
    require get_template_directory() . '/inc/modules/mega-menu/custom-menu.php';
  }

}
endif;
add_action('after_setup_theme', 'inhype_setup');

/*
* Change posts excerpt length
*/
if(!function_exists('inhype_new_excerpt_length')):
function inhype_new_excerpt_length($length) {
	$post_excerpt_length = get_theme_mod('blog_posts_excerpt_limit', 22);

	return $post_excerpt_length;
}
endif;
add_filter('excerpt_length', 'inhype_new_excerpt_length');

/**
 * Enqueue scripts and styles
 */
if(!function_exists('inhype_scripts')):
function inhype_scripts() {

  // Add default fonts if user not installed required plugins
  if ( !class_exists( 'Kirki' ) ) {
    wp_enqueue_style('inhype-fonts', inhype_editor_fonts_url());
  }

	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
	wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.css');
	wp_enqueue_style('inhype-stylesheet', get_stylesheet_uri(), array(), '1.0.2', 'all');
	wp_enqueue_style('inhype-responsive', get_template_directory_uri() . '/responsive.css', '1.0.2', 'all');

	if ( true == get_theme_mod( 'animations_css3', true ) )  {
		wp_enqueue_style('inhype-animations', get_template_directory_uri() . '/css/animations.css');
	}

	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.css');
	wp_enqueue_style('inhype-select2', get_template_directory_uri() . '/js/select2/select2.css'); // special version, must be prefixed with theme prefix
	wp_enqueue_style('swiper', get_template_directory_uri() . '/css/idangerous.swiper.css');

  // Animation on scroll
  wp_enqueue_style('aos', get_template_directory_uri() . '/js/aos/aos.css');
  wp_register_script('aos', get_template_directory_uri() . '/js/aos/aos.js', array(), '2.3.1', true);
  wp_enqueue_script('aos');

  // Parallax
  wp_register_script('parallax', get_template_directory_uri() . '/js/parallax.min.js', array(), '1.5.0', true);
  wp_enqueue_script('parallax');

	add_thickbox();

	// Registering scripts to include it in correct order later
	wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.1.1', true);
	wp_register_script('easing', get_template_directory_uri() . '/js/easing.js', array(), '1.3', true);
	wp_register_script('inhype-select2', get_template_directory_uri() . '/js/select2/select2.min.js', array(), '3.5.1', true);  // special version, must be prefixed with theme prefix
	wp_register_script('owl-carousel', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.min.js', array(), '2.0.0', true);

	// Enqueue scripts in correct order
	wp_enqueue_script('inhype-script', get_template_directory_uri() . '/js/template.js', array('jquery', 'bootstrap', 'easing', 'inhype-select2', 'owl-carousel'), '1.3', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

}
endif;
add_action('wp_enqueue_scripts', 'inhype_scripts');

/**
 * Enqueue scripts and styles for admin area
 */
if(!function_exists('inhype_admin_scripts')):
function inhype_admin_scripts() {
	wp_register_style( 'inhype-style-admin', get_template_directory_uri() .'/css/admin.css' );
	wp_enqueue_style( 'inhype-style-admin' );
	wp_register_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.css');
	wp_enqueue_style( 'font-awesome' );

	wp_register_script('inhype-template-admin', get_template_directory_uri() . '/js/template-admin.js', array(), '1.0', true);
	wp_enqueue_script('inhype-template-admin');
}
endif;
add_action( 'admin_init', 'inhype_admin_scripts' );

if(!function_exists('inhype_load_wp_media_files')):
function inhype_load_wp_media_files() {
  wp_enqueue_media();
}
endif;
add_action( 'admin_enqueue_scripts', 'inhype_load_wp_media_files' );

/**
 * Disable built-in WordPress plugins
 */
if(!function_exists('inhype_disable_builtin_plugins')):
function inhype_disable_builtin_plugins() {

  // Deactivate Gutenberg to avoid conflicts, since it's already built in to WordPress 5.x
  if(version_compare(get_bloginfo('version'), '5.0', ">=")) {
      deactivate_plugins( '/gutenberg/gutenberg.php' );
  }

}
endif;
add_action( 'admin_init', 'inhype_disable_builtin_plugins' );

/**
 * Display navigation to next/previous pages when applicable
 */
if(!function_exists('inhype_content_nav')):
function inhype_content_nav( $nav_id ) {
  global $wp_query, $post;

  // Loading library to check active plugins
  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

  // Don't print empty markup on single pages if there's nowhere to navigate.
  if ( is_single() ) {
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
      return;
  }

  // Don't print empty markup in archives if there's only one page.
  if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
    return;

  $nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

  ?>
  <nav id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo esc_attr($nav_class); ?>">

  <?php if ( is_single() ) : // navigation links for single posts ?>
  <div class="nav-post-wrapper">
    <?php
    // Previous post nav
    $prev_post = get_previous_post();
    if ( is_a( $prev_post , 'WP_Post' ) ):
    ?>
    <div class="nav-post nav-post-prev inhype-post<?php if(is_a( $prev_post , 'WP_Post' ) && !has_post_thumbnail( $prev_post->ID )) { echo ' no-image'; } ?>">
      <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">

      <?php
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post->ID ), 'inhype-blog-thumb-widget');

      if(has_post_thumbnail( $prev_post->ID )) {
          $image_bg ='background-image: url('.esc_url($image[0]).');';

          $post_image_html = '<div class="inhype-post-image-wrapper"><div class="inhype-post-image" data-style="'.esc_attr($image_bg).'"></div></div>';
      } else {
          $image_bg = '';
          $post_image_html = '';
      }

      $prev_post_title = the_title_attribute(array('echo' => false, 'post' => $prev_post->ID));

      ?>
      <div class="nav-post-button-title"><i class="fa fa-arrow-left" aria-hidden="true"></i><?php esc_html_e( 'Previous', 'inhype' ); ?></div>
      <div class="nav-post-button">

      <div class="nav-post-details">
        <div class="nav-post-name"><?php echo esc_html($prev_post_title); ?></div>
      </div>
      </div>
    </a>
    </div>
    <?php
    endif;
    ?>
    <?php
    // Next post nav
    $next_post = get_next_post();
    if ( is_a( $next_post , 'WP_Post' ) ):
    ?>
    <div class="nav-post nav-post-next inhype-post<?php if(is_a( $next_post , 'WP_Post' ) && !has_post_thumbnail( $next_post->ID )) { echo ' no-image'; } ?>">
    <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
    <?php
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post->ID ), 'inhype-blog-thumb-widget');

      if(has_post_thumbnail( $next_post->ID )) {
          $image_bg ='background-image: url('.esc_url($image[0]).');';

          $post_image_html = '<div class="inhype-post-image-wrapper"><div class="inhype-post-image" data-style="'.esc_attr($image_bg).'"></div></div>';
      } else {
          $image_bg = '';
          $post_image_html = '';
      }

      $next_post_title = the_title_attribute(array('echo' => false, 'post' => $next_post->ID));
      ?>
      <div class="nav-post-button-title"><?php esc_html_e( 'Next', 'inhype' ); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
      <div class="nav-post-button">
      <div class="nav-post-details">
        <div class="nav-post-name"><?php echo esc_html($next_post_title); ?></div>
      </div>
      </div>
    </a>
    </div>
    <?php
    endif;
    ?>
  </div>
  <?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
  <div class="clear"></div>
  <div class="container-fluid">
    <div class="row">
      <?php if ( function_exists( 'wp_pagenavi' ) ): ?>
        <div class="col-md-12 nav-pagenavi">
        <?php wp_pagenavi(); ?>
        </div>
      <?php else: ?>
        <div class="col-md-6 nav-post-prev">
        <?php if ( get_next_posts_link() ) : ?>
        <?php next_posts_link( esc_html__( 'Older posts', 'inhype' ) ); ?>
        <?php endif; ?>
        </div>

        <div class="col-md-6 nav-post-next">
        <?php if ( get_previous_posts_link() ) : ?>
        <?php previous_posts_link( esc_html__( 'Newer posts', 'inhype' ) ); ?>
        <?php endif; ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
  <?php endif; ?>

  </nav>
  <?php
}
endif;

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
if(!function_exists('inhype_comment')):
function inhype_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;

  if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

  <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
    <div class="comment-body">
      <?php esc_html_e( 'Pingback:', 'inhype' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'inhype' ), '<span class="edit-link">', '</span>' ); ?>
    </div>

  <?php else : ?>

  <li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
    <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

      <div class="comment-meta clearfix">
        <div class="reply">
          <?php edit_comment_link( esc_html__( 'Edit', 'inhype' ), '', '' ); ?>
          <?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </div><!-- .reply -->
        <div class="comment-author vcard">

          <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, 100 ); ?>

        </div><!-- .comment-author -->

        <div class="comment-metadata">

          <div class="author">
          <?php printf('%s', sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
          </div>
          <div class="date"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>"><?php printf( _x( '%1$s %2$s %3$s', '1: date, 2: at, 3: time', 'inhype' ), get_comment_date(), esc_html__('at', 'inhype'), get_comment_time() ); ?></time></a></div>

          <?php if ( '0' == $comment->comment_approved ) : ?>
          <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'inhype' ); ?></p>
          <?php endif; ?>
          <div class="comment-content">
            <?php comment_text(); ?>
          </div>
        </div><!-- .comment-metadata -->

      </div><!-- .comment-meta -->

    </article><!-- .comment-body -->

  <?php
  endif;
}
endif;

// Set/Get current post details for global usage in templates (post position in loop, etc)
if(!function_exists('inhype_set_post_details')):
function inhype_set_post_details($details) {
	global $inhype_post_details;

	$inhype_post_details = $details;
}
endif;

if(!function_exists('inhype_get_post_details')):
function inhype_get_post_details() {
	global $inhype_post_details;

	return $inhype_post_details;
}
endif;

/**
 * Registers an editor stylesheet
 */
if(!function_exists('inhype_add_editor_styles')):
function inhype_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
    add_editor_style( inhype_editor_fonts_url() );

    // Load dynamic editor styles with fonts selected by user to match frontend fonts
    $wp_upload_dir = wp_upload_dir();
    $editor_cache_file_name = 'style-editor-cache-'.wp_get_theme()->get('TextDomain');
    $css_editor_cache_file_url = $wp_upload_dir['baseurl'].'/'.$editor_cache_file_name.'.css';
    add_editor_style( $css_editor_cache_file_url );
}
add_action('admin_init', 'inhype_add_editor_styles');
endif;

/**
 * Social services list
 */
if(!function_exists('inhype_social_services_list')):
function inhype_social_services_list() {
  // You can add more social services here, array keys must beequal to Font Awesome icons names, without 'fa-' prefix
  // Available icons list: https://fontawesome.com/v4.7.0/icons/
  $social_services_array = array(
      'facebook' => esc_attr__( 'Facebook', 'inhype' ),
      'vk' => esc_attr__( 'VKontakte', 'inhype' ),
      'google-plus' => esc_attr__( 'Google+', 'inhype' ),
      'twitter' => esc_attr__( 'Twitter', 'inhype' ),
      'linkedin' => esc_attr__( 'LinkedIn', 'inhype' ),
      'dribbble' => esc_attr__( 'Dribbble', 'inhype' ),
      'behance' => esc_attr__( 'Behance', 'inhype' ),
      'instagram' => esc_attr__( 'Instagram', 'inhype' ),
      'tumblr' => esc_attr__( 'Tumblr', 'inhype' ),
      'pinterest' => esc_attr__( 'Pinterest', 'inhype' ),
      'vimeo-square' => esc_attr__( 'Vimeo', 'inhype' ),
      'youtube' => esc_attr__( 'Youtube', 'inhype' ),
      'twitch' => esc_attr__( 'Twitch', 'inhype' ),
      'skype' => esc_attr__( 'Skype', 'inhype' ),
      'flickr' => esc_attr__( 'Flickr', 'inhype' ),
      'deviantart' => esc_attr__( 'Deviantart', 'inhype' ),
      '500px' => esc_attr__( '500px', 'inhype' ),
      'etsy' => esc_attr__( 'Etsy', 'inhype' ),
      'telegram' => esc_attr__( 'Telegram', 'inhype' ),
      'odnoklassniki' => esc_attr__( 'Odnoklassniki', 'inhype' ),
      'houzz' => esc_attr__( 'Houzz', 'inhype' ),
      'slack' => esc_attr__( 'Slack', 'inhype' ),
      'qq' => esc_attr__( 'QQ', 'inhype' ),
      'github' => esc_attr__( 'Github', 'inhype' ),
      'whatsapp' => esc_attr__( 'WhatsApp', 'inhype' ),
      'telegram' => esc_attr__( 'Telegram', 'inhype' ),
      'rss' => esc_attr__( 'RSS', 'inhype' ),
      'envelope-o' => esc_attr__( 'Email', 'inhype' ),
      'medium' => esc_attr__( 'Medium', 'inhype' ),
      'address-card-o' => esc_attr__( 'Other', 'inhype' ),
  );

  return $social_services_array;
}
endif;


/**
 * Theme homepage blocks list
 */
if(!function_exists('inhype_blocks_list')):
function inhype_blocks_list() {

  $inhype_blocks_array = array(
      'postsline' => esc_html__( '[POSTS] Posts Line #1', 'inhype' ),
      'postsline2' => esc_html__( '[POSTS] Posts Line #2', 'inhype' ),
      'largepostsslider' => esc_html__( '[POSTS] Large Posts Slider', 'inhype' ),
      'largefullwidthpostsslider' => esc_html__( '[POSTS] Large Fullwidth Posts Slider', 'inhype' ),
      'fullwidthpostsslider' => esc_html__( '[POSTS] Fullwidth Posts Slider', 'inhype' ),
      'carousel' => esc_html__( '[POSTS] Posts Carousel', 'inhype' ),
      'carousel2' => esc_html__( '[POSTS] Posts Cards Carousel', 'inhype' ),
      'posthighlight' => esc_html__( '[POSTS] Post Highlight #1 Slider', 'inhype' ),
      'posthighlight2' => esc_html__( '[POSTS] Post Highlight #2 Slider', 'inhype' ),
      'postsgrid1' => esc_html__( '[POSTS] Posts Grid #1', 'inhype' ),
      'postsgrid2' => esc_html__( '[POSTS] Posts Grid #2', 'inhype' ),
      'postsgrid3' => esc_html__( '[POSTS] Posts Grid #3', 'inhype' ),
      'postsgrid4' => esc_html__( '[POSTS] Posts Grid #4', 'inhype' ),
      'postsgrid5' => esc_html__( '[POSTS] Posts Grid #5', 'inhype' ),
      'postsgrid6' => esc_html__( '[POSTS] Posts Grid #6', 'inhype' ),
      'postsgrid7' => esc_html__( '[POSTS] Posts Grid #7', 'inhype' ),
      'postsgrid8' => esc_html__( '[POSTS] Posts Grid #8', 'inhype' ),
      'postsgrid9' => esc_html__( '[POSTS] Posts Grid #9', 'inhype' ),
      'postsgrid10' => esc_html__( '[POSTS] Posts Grid #10', 'inhype' ),
      'postsgrid11' => esc_html__( '[POSTS] Posts Grid #11', 'inhype' ),
      'postsmasonry1' => esc_html__( '[POSTS] Posts Masonry #1', 'inhype' ),
      'postsmasonry2' => esc_html__( '[POSTS] Posts Masonry #2', 'inhype' ),
      'postsmasonry3' => esc_html__( '[POSTS] Posts Masonry #3', 'inhype' ),
      'postsmasonry4' => esc_html__( '[POSTS] Posts Masonry #4', 'inhype' ),
      'showcase1' => esc_html__( '[POSTS] Showcase #1', 'inhype' ),
      'showcase2' => esc_html__( '[POSTS] Showcase #2', 'inhype' ),
      'showcase3' => esc_html__( '[POSTS] Showcase #3', 'inhype' ),
      'showcase4' => esc_html__( '[POSTS] Showcase #4', 'inhype' ),
      'showcase5' => esc_html__( '[POSTS] Showcase #5', 'inhype' ),
      'showcase6' => esc_html__( '[POSTS] Showcase #6', 'inhype' ),
      'showcase7' => esc_html__( '[POSTS] Showcase #7', 'inhype' ),
      'showcase8' => esc_html__( '[POSTS] Showcase #8', 'inhype' ),
      'showcase9' => esc_html__( '[POSTS] Showcase #9', 'inhype' ),
      'html' => esc_html__( '[HTML] HTML Block', 'inhype' ),
      'blog' => esc_html__( '[MISC] Blog Listing', 'inhype' ),
      'subscribe' => esc_html__( '[MISC] Subscribe Block', 'inhype' ),
      'categories' => esc_html__( '[MISC] Categories Block', 'inhype' ),
      'instagram' => esc_html__( '[MISC] Instagram Block', 'inhype' )
  );

  if ( class_exists( 'WooCommerce' ) ) {
    $inhype_wc_blocks_array = array(
        'wcgrid1' => esc_html__( '[SHOP] Products Grid #1', 'inhype' ),
        'wccategories' => esc_html__( '[SHOP] Categories Block', 'inhype' ),
    );

    $inhype_blocks_array = array_merge($inhype_blocks_array, $inhype_wc_blocks_array);

  }

  return $inhype_blocks_array;
}
endif;

/**
 * Theme posts types list for homepage blocks
 */
if(!function_exists('inhype_post_types_list')):
function inhype_post_types_list() {

  $inhype_post_types_array = array(
      'latest' => esc_html__( 'Latest', 'inhype' ),
      'featured' => esc_html__( 'Featured', 'inhype' ),
      'editorspicks' => esc_html__( "Editors picks", 'inhype' ),
      'promoted' => esc_html__( 'Promoted', 'inhype' ),
      'popular' => esc_html__( 'Popular', 'inhype' ),
      'liked' => esc_html__( 'Most liked', 'inhype' ),
      'trending' => esc_html__( 'Trending', 'inhype' ),
      'random' => esc_html__( 'Random', 'inhype' ),
  );

  return $inhype_post_types_array;
}
endif;

/**
 * Theme products types list for homepage blocks
 */
if(!function_exists('inhype_product_types_list')):
function inhype_product_types_list() {

  $inhype_product_types_array = array(
      'latest' => esc_html__( 'Latest', 'inhype' ),
      'sale' => esc_html__( 'On sale', 'inhype' )
  );

  return $inhype_product_types_array;
}
endif;

/**
 * Set content width
 */
if(!function_exists('inhype_set_content_width')):
function inhype_set_content_width($width) {
    global $content_width;// Global here used to define new content width for global WordPress system variable

    $content_width = $width;
}
endif;

/**
 * Adds a responsive embed wrapper around oEmbed content
 */
if(!function_exists('inhype_responsive_embed')):
function inhype_responsive_embed($html, $url, $attr) {
    return $html!=='' ? '<div class="embed-container">'.$html.'</div>' : '';
}
endif;

/**
 * Get theme font settings and defaults
 */
if(!function_exists('inhype_get_fonts_settings')):
function inhype_get_fonts_settings($font_type) {

  $headers_font_default = 'Nunito';
  $body_font_default = 'Rubik';
  $additional_font_default = 'Nunito';

  $headers_font = get_theme_mod('headers_font', array(
      'font-family'    => $headers_font_default,
      'variant'        => '800',
  ));

  // Body font
  $body_font = get_theme_mod('body_font', array(
      'font-family'    => $body_font_default,
      'variant'        => 'regular',
      'font-size'      => '15px',
  ));

  // Additional font
  $additional_font = get_theme_mod('additional_font', array(
      'font-family'    => $additional_font_default,
      'variant'        => '600',
  ));

  $fonts_defaults['headers_font'] = $headers_font;
  $fonts_defaults['body_font'] = $body_font;
  $fonts_defaults['additional_font'] = $additional_font;

  return $fonts_defaults[$font_type];
}
endif;

/**
 * Add Custom fonts to editor
 */
if(!function_exists('inhype_editor_fonts_url')):
function inhype_editor_fonts_url() {

  $fonts_url = '';

  // Fonts and default fonts configuration
  $headers_font = inhype_get_fonts_settings('headers_font');

  // Body font
  $body_font = inhype_get_fonts_settings('body_font');

  // Additional font
  $additional_font = inhype_get_fonts_settings('additional_font');

  $font_families[] = $headers_font['font-family'].':'.$headers_font['variant'];
  $font_families[] = $body_font['font-family'].':'.$body_font['variant'];
  $font_families[] = $additional_font['font-family'].':'.$additional_font['variant'];

  $query_args = array(
    'family' => rawurlencode( implode( '|', $font_families ) ),
    'subset' => rawurlencode( 'latin,latin-ext' ),
  );

  $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

  return esc_url_raw( $fonts_url );
}
endif;
