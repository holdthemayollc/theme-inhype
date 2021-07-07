<?php
/**
 * Theme Functions
 */

/**
 * Header logo display
 */
if(!function_exists('inhype_logo_display')):
function inhype_logo_display() {

    $menu = wp_nav_menu(
        array (
            'theme_location'  => 'main',
            'echo' => false,
            'fallback_cb'    => true,
        )
    );

    if (!empty($menu)):
    ?>
    <div class="mainmenu-mobile-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    <?php endif; ?>
    <?php
    // Header tagline style
    $tag_line_style = get_theme_mod('header_tagline_style', 'regular');

    // Text logo
    if ( get_theme_mod( 'logo_text', false ) && (get_theme_mod( 'logo_text_title', '' ) !== '') ) {
        ?>
        <div class="logo"><a class="logo-link logo-text" href="<?php echo esc_url(home_url()); ?>"><?php echo html_entity_decode(wp_kses_post(get_theme_mod( 'logo_text_title', true )));?></a>
        <?php
          if(get_bloginfo('description')!=='' && get_theme_mod( 'header_tagline', false ) ) {
            echo '<div class="header-blog-info header-blog-info-'.esc_attr($tag_line_style).'">';
            bloginfo('description');
            echo '</div>';
          }
        ?>
        </div>
        <?php
    // Image logo
    } else {
        ?>
        <div class="logo">
        <a class="logo-link" href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url(get_header_image()); ?>" alt="<?php bloginfo('name'); ?>" class="regular-logo"><img src="<?php if ( get_theme_mod( 'inhype_header_transparent_logo' ) ) { echo esc_url( get_theme_mod( 'inhype_header_transparent_logo' )); } else { echo esc_url(get_header_image()); }  ?>" alt="<?php bloginfo('name'); ?>" class="light-logo"></a>
        <?php
          if(get_bloginfo('description') !== '' && get_theme_mod( 'header_tagline', false ) ) {
            echo '<div class="header-blog-info header-blog-info-'.esc_attr($tag_line_style).'">';
            bloginfo('description');
            echo '</div>';
          }
        ?>
        </div>
        <?php
    }

    ?>

    <?php
}
endif;

/**
 * Main Menu display
 */
if(!function_exists('inhype_mainmenu_display')):
function inhype_mainmenu_display() {

    // MainMenu styles
    $menu_add_class = '';

    $menu_add_class .= ' mainmenu-'.esc_html(get_theme_mod('mainmenu_style', 'light'));

    $menu_add_class .= ' mainmenu-'.esc_html(get_theme_mod('mainmenu_align', 'left'));

    $menu_add_class .= ' mainmenu-'.esc_html(get_theme_mod('mainmenu_font_decoration', 'none'));

    $menu_add_class .= ' mainmenu-'.esc_html(get_theme_mod('mainmenu_font_weight', 'regularfont'));

    $menu_add_class .= ' mainmenu-'.esc_html(get_theme_mod('mainmenu_arrow_style', 'noarrow'));

    ?>

    <?php
    // Main Menu

    $menu = wp_nav_menu(
        array (
            'theme_location'  => 'main',
            'echo' => false,
            'fallback_cb'    => true,
        )
    );

    if(get_theme_mod('module_mega_menu', true)) {
         $add_class = ' mgt-mega-menu';
         $menu_walker = new InHype_Megamenu_Walker;
    } else {
         $add_class = '';
         $menu_walker = new InHype_Mainmenu_Walker;
    }

    if (!empty($menu)):

    ?>
    <div class="mainmenu<?php echo esc_attr($menu_add_class); ?> clearfix" role="navigation">

        <div id="navbar" class="navbar navbar-default clearfix<?php echo esc_attr($add_class);?>">

          <div class="navbar-inner">
              <div class="container">

                  <div class="navbar-toggle btn" data-toggle="collapse" data-target=".collapse">
                    <?php esc_html_e( 'Menu', 'inhype' ); ?>
                  </div>

                  <div class="navbar-center-wrapper">
                  <?php

                     wp_nav_menu(array(
                      'theme_location'  => 'main',
                      'container_class' => 'navbar-collapse collapse',
                      'menu_class'      => 'nav',
                      'fallback_cb'    => true,
                      'walker'          => $menu_walker
                      ));

                  ?>
                  </div>

              </div>
          </div>

        </div>

    </div>
    <?php endif; ?>

    <?php
    // Site Footer Banner
    inhype_banner_display('inside_header');
    ?>

    <?php
    // MainMenu Below header position END
}
endif;

/**
 * Social icons display
 */
if(!function_exists('inhype_social_display')):
function inhype_social_display($background = true, $limit = 0, $showtitles = false, $showdescription = false) {

    $social_services_html = '';
    $add_class = '';

    $social_services_list = inhype_social_services_list();

    $social_icons = get_theme_mod('social_icons', array());

    $i = 0;

    foreach( $social_icons as $social_icon ) {

        $i++;

        $social_type = $social_icon['social_type'];
        $social_url = !empty($social_icon['social_url']) ? $social_icon['social_url'] : '';
        $social_description = !empty($social_icon['social_description']) ? $social_icon['social_description'] : '';

        if($showtitles) {
            $social_title = '<span class="social-title">'.$social_services_list[$social_type].'</span>';
        } else {
            $social_title = '';
        }

        $add_class = ' no-description';

        if($showdescription && !empty($social_description)) {
            $social_description_html = '<span class="social-description">'.$social_description.'</span>';
            $add_class = ' have-description';
        } else {
            $social_description_html = '';
        }

        $social_services_html .= '<a href="'.esc_url($social_url).'" target="_blank" class="a-'.esc_attr($social_type).esc_attr($add_class).'"><i class="fa fa-'.esc_attr($social_type).'"></i>'.wp_kses_post($social_title).wp_kses_post($social_description_html).'</a>';

        if($limit > 0 && $limit == $i) {
          break;
        }

    }

    if($background) {
      $add_class = ' social-icons-with-bg';
    }

    if($social_services_html !== '') {
      echo wp_kses_post('<div class="social-icons-wrapper'.esc_attr($add_class).'">'.$social_services_html.'</div>');
    }
}
endif;

/**
 * Top menu display
 */
if(!function_exists('inhype_top_display')):
function inhype_top_display() {
    ?>
    <?php if(get_theme_mod('topmenu_disable', false) == false): ?>
    <?php
    $header_add_class = '';

    $header_top_menu_style = get_theme_mod('topmenu_style', 'menu_white');
    $header_top_menu_style .= ' '.get_theme_mod('topmenu_border_style', 'menu_border_boxed');

    $header_add_class .= ' '.esc_attr($header_top_menu_style);

    $header_top_menu_uppercase = get_theme_mod('topmenu_uppercase', 'none');
    $header_add_class .= ' header-menu-'.esc_attr($header_top_menu_uppercase);

    $header_add_class .= ' header-menu-social-icons-'.esc_attr(get_theme_mod('topmenu_socialicons_position', 'left'));

    $topmenu = wp_nav_menu(
        array (
            'theme_location'  => 'top',
            'echo' => false,
            'fallback_cb'    => false,
        )
    );

    if (!empty($topmenu)):

    ?>
    <div class="header-menu-bg<?php echo esc_attr($header_add_class); ?>" role="navigation">
      <div class="header-menu">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <?php
              // Show social
              if(get_theme_mod('topmenu_socialicons', false)) {
                  inhype_social_display(false, 5);
              }
              ?>
              <div class="menu-top-menu-container-toggle">
                <?php if(get_theme_mod('topmenu_icon', 'regular') == 'user'): ?>
                <i class="fa fa-user" aria-hidden="true"></i>
                <?php else: ?>
                <i class="fa fa-bars" aria-hidden="true"></i>
                <?php endif; ?>
              </div>
              <?php
              wp_nav_menu(array(
                'theme_location'  => 'top',
                'menu_class'      => 'links',
                'fallback_cb'    => false,
                ));
              ?>
              <?php
              // Show custom content
              if(get_theme_mod('topmenu_custom', false)) {
                  inhype_topmenu_custom_display();
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <?php endif;
}
endif;

/**
 * Top line display
 */
if(!function_exists('inhype_topline_display')):
function inhype_topline_display() {

  if(get_theme_mod('header_topline', false)) {

    $header_topline_content = get_theme_mod('header_topline_content', '');

    ?>
    <div class="header-topline-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="header-topline">
              <div class="header-topline-content">
                <?php echo do_shortcode(wp_kses_post($header_topline_content)); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php
  }

}
endif;

/**
 * Header center custom content display
 */
if(!function_exists('inhype_header_center_custom_display')):
function inhype_header_center_custom_display() {

  if(get_theme_mod('header_center_custom', false)) {

    $header_center_custom_content = get_theme_mod('header_center_custom_content', '');

    ?>
    <div class="header-center-custom-content">
      <?php echo do_shortcode(wp_kses_post($header_center_custom_content)); ?>
    </div>
  <?php
  }

}
endif;

/**
 * Top menu custom content display
 */
if(!function_exists('inhype_topmenu_custom_display')):
function inhype_topmenu_custom_display() {

    $topmenu_custom_content = get_theme_mod('topmenu_custom_content', '');

    ?>
    <div class="topmenu-custom-content">
      <div class="topmenu-custom-content-inner">
        <?php echo do_shortcode(wp_kses_post($topmenu_custom_content)); ?>
      </div>
    </div>
  <?php
}
endif;

/**
 * Homepage featured posts slider display
 */
if(!function_exists('inhype_blog_slider_display')):
function inhype_blog_slider_display() {

    if(get_theme_mod('slider_enable', false) == true): ?>

    <div class="inhype-blog-posts-slider">
    <?php

    // Custom slider
    if(get_theme_mod('slider_custom', false) == true) {
        echo '<div class="inhype-custom-slider">'.do_shortcode(get_theme_mod('slider_custom_shortcode', '')).'</div>';
    } else {
    // Theme slider

        $settings['block_posts_limit'] = get_theme_mod('slider_limit', 30);
        $settings['block_posts_type'] = get_theme_mod('slider_posts_type', 'featured');
        $settings['block_categories'] = get_theme_mod('slider_categories', '');

        $args = inhype_get_wpquery_args($settings);

        $posts_query = new WP_Query;
        $posts = $posts_query->query($args);

        if($posts_query->have_posts()) {

          $slider_autoplay = get_theme_mod('slider_autoplay', '0');

          if($slider_autoplay > 0) {
              $slider_autoplay_bool = 'true';
          } else {
              $slider_autoplay_bool = 'false';
          }

          $slider_arrows = get_theme_mod('slider_arrows', false);

          if($slider_arrows == true) {
              $slider_arrows = 'true';
          } else {
              $slider_arrows = 'false';
          }

          echo '<div class="owl-carousel">';

          $i = 0;

          while ($posts_query->have_posts()){

              //setup_postdata($post);
              $posts_query->the_post();

              get_template_part( 'inc/templates/post/content', 'overlay-short' );

              $i++;

          }

          wp_reset_postdata();

          if($i > 1) {

              wp_add_inline_script( 'inhype-script', '(function($){
              $(document).ready(function() {
                  "use strict";

                  var owlpostslider = $(".inhype-blog-posts-slider .owl-carousel").owlCarousel({
                      loop: true,
                      items: 1,
                      autoplay:'.esc_js($slider_autoplay_bool).',
                      autowidth: false,
                      autoplayTimeout:'.esc_js($slider_autoplay).',
                      autoplaySpeed: 1000,
                      navSpeed: 1000,
                      nav: '.esc_js($slider_arrows).',
                      dots: false,
                      navText: false,
                      responsive: {
                          1199:{
                              items:5
                          },
                          979:{
                              items:4
                          },
                          768:{
                              items:2
                          },
                          479:{
                              items:1
                          },
                          0:{
                              items:1
                          }
                      }
                  });

                  AOS.refresh();

              });})(jQuery);');

            } else {
                wp_add_inline_script( 'inhype-script', '(function($){
                  $(document).ready(function() {
                     "use strict";

                     $(".inhype-blog-posts-slider .owl-carousel").show();

                     AOS.refresh();

                  });})(jQuery);');
            }
        }
    }

    ?>

        </div>
    </div>
    <?php endif;

}
endif;

/**
 * Ads banner display
 */
if(!function_exists('inhype_banner_display')):
function inhype_banner_display($banner_id) {

    $banner_option_name = 'banner_'.$banner_id;
    $banner_content_name = 'banner_'.$banner_id.'_content';

    if(get_theme_mod($banner_option_name, false) == true) {

        echo '<div class="inhype-bb-block inhype-bb-block-'.$banner_id.' clearfix">';
        echo do_shortcode(get_theme_mod($banner_content_name, '')); // This is safe place and we can't use wp_kses_post or other esc_ functions here because this is ads area where user may use Google Adsense and other Java Script banners code with <script> inside.
        echo '</div>';
    }

}
endif;

/**
 * Footer shortcode block display
 */
if(!function_exists('inhype_footer_shortcode_display')):
function inhype_footer_shortcode_display() {

  if(get_theme_mod('footer_shortcodeblock', false) == true):
  ?>
  <div class="container">
    <div class="footer-shortcode-block">
    <?php echo do_shortcode(get_theme_mod('footer_shortcodeblock_html', '')); ?>
    </div>
  </div>
  <?php
  endif;
}
endif;

/**
 * Footer HTML block display
 */
if(!function_exists('inhype_footer_htmlblock_display')):
function inhype_footer_htmlblock_display() {

  if(get_theme_mod('footer_htmlblock', false) == true) {

    $footer_htmlblock_background = get_theme_mod('footer_htmlblock_background', false);

    $style = 'background-color: '.esc_html($footer_htmlblock_background['background-color']).';';
    $style .= 'color: '.esc_html(get_theme_mod('footer_htmlblock_color_text', '#ffffff')).';';

    if($footer_htmlblock_background['background-image'] !== '') {
      $style .= 'background-image: url('.esc_url($footer_htmlblock_background['background-image']).');';
      $style .= 'background-repeat: '.esc_html($footer_htmlblock_background['background-repeat']).';';
      $style .= 'background-position: '.esc_html($footer_htmlblock_background['background-position']).';';
      $style .= 'background-size: '.esc_html($footer_htmlblock_background['background-size']).';';
      $style .= 'background-attachement: '.esc_html($footer_htmlblock_background['background-size']).';';
    }

    ?>
    <div class="footer-html-block" data-style="<?php echo esc_attr($style); ?>">
    <?php echo do_shortcode(get_theme_mod('footer_htmlblock_html', '')); ?>
    </div>
    <?php

  }
}
endif;

/**
 *  Blog post excerpt display override
 */
if(!function_exists('inhype_excerpt_more')):
function inhype_excerpt_more( $more ) {
    return '...';
}
endif;
add_filter('excerpt_more', 'inhype_excerpt_more');

/**
 *  Blog post read more display override
 */
if(!function_exists('inhype_modify_read_more_link')):
function inhype_modify_read_more_link() {
    return '<a class="more-link btn" href="' . esc_url(get_permalink()) . '">'.esc_html__('Read more', 'inhype').'</a>';
}
endif;
add_filter( 'the_content_more_link', 'inhype_modify_read_more_link' );

/**
 * Custom SINGLE POST CSS classes
 */
if(!function_exists('inhype_remove_from_posts_class')):
function inhype_remove_from_posts_class( $classes ) {
    // Remove 'hentry' class, to add it manually in other element
    $classes = array_diff( $classes, array( "hentry" ) );
    return $classes;
}
add_filter( 'post_class', 'inhype_remove_from_posts_class' );
endif;

/**
 *  Custom BODY CSS classes
 */
if(!function_exists('inhype_body_classes')):
function inhype_body_classes($classes) {

  // Single Post page related classes
  $blog_transparent_header = false;

  // Transparent header for post
  if(is_single()) {

    $blog_transparent_header = get_theme_mod('blog_post_transparent_header', false);

    // Demo settings
    if ( defined('DEMO_MODE') && isset($_GET['blog_post_transparent_header']) ) {
        if($_GET['blog_post_transparent_header'] == 0) {
          $blog_transparent_header = false;
        }
        if($_GET['blog_post_transparent_header'] == 1) {
          $blog_transparent_header = true;
        }
    }

    // Blog post header layout
    $post_header_layout = get_post_meta( get_the_ID(), '_inhype_post_header_layout', true );

    // Post header layout
    if(empty($post_header_layout)) {
        $blog_post_header_layout = get_theme_mod('blog_post_header_layout', 'incontent2');
    } else {
        $blog_post_header_layout = $post_header_layout;
    }

    // Demo settings
    if ( defined('DEMO_MODE') && isset($_GET['blog_post_header_layout']) ) {
      $blog_post_header_layout = $_GET['blog_post_header_layout'];
    }

    // Allow transparent header only for 'inheader' layout
    if($blog_post_header_layout !== 'inheader') {
      $blog_transparent_header = false;
    }

  }

  // Transparent header for page
  if(is_page()) {
    $blog_transparent_header = get_theme_mod('blog_page_transparent_header', false);

    if(get_theme_mod('page_header_width', 'boxed') == 'boxed') {
      $blog_transparent_header = false;
    }

    // Demo settings
    if ( defined('DEMO_MODE') && isset($_GET['blog_page_transparent_header']) ) {
      if($_GET['blog_page_transparent_header'] == 0) {
        $blog_transparent_header = false;
      }
      if($_GET['blog_page_transparent_header'] == 1) {
        $blog_transparent_header = true;
      }
    }
  }

  if($blog_transparent_header) {
    $classes[] = 'blog-post-transparent-header-enable';
  } else {
    $classes[] = 'blog-post-transparent-header-disable';
  }

  $blog_post_smallwidth = is_single() ? get_theme_mod('blog_post_smallwidth', false) : get_theme_mod('blog_page_smallwidth', false);

  if(is_page() || is_single()) {
    $post_smallwidth = get_post_meta( get_the_ID(), '_inhype_post_smallwidth', true );

    if(($blog_post_smallwidth && $post_smallwidth != 0) || $post_smallwidth == 1) {
      $blog_post_smallwidth = true;
    } elseif($post_smallwidth !== '' && $post_smallwidth == 0) {
      $blog_post_smallwidth = false;
    }
  }

  // Demo settings
  if ( defined('DEMO_MODE') && isset($_GET['blog_post_smallwidth']) ) {
    if($_GET['blog_post_smallwidth'] == 0) {
      $blog_post_smallwidth = false;
    }
    if($_GET['blog_post_smallwidth'] == 1) {
      $blog_post_smallwidth = true;
    }
  }

  if($blog_post_smallwidth) {
    $classes[] = 'blog-small-page-width';
  }

  // Slider related classes
  $blog_enable_homepage_slider = get_theme_mod('slider_enable', true);

  if($blog_enable_homepage_slider) {

    $classes[] = 'blog-slider-enable';

  } else {
    $classes[] = 'blog-slider-disable';
  }

  if(get_theme_mod('blog_post_dropcaps', false)) {
    $classes[] = 'blog-enable-dropcaps';
  }

  if(get_theme_mod('animations_images', true)) {
    $classes[] = 'blog-enable-images-animations';
  }

  if(get_theme_mod('sidebar_sticky', false)) {
    $classes[] = 'blog-enable-sticky-sidebar';
  }

  if(get_theme_mod('header_sticky', true)) {
    $classes[] = 'blog-enable-sticky-header';
  }

  $style_corners = get_theme_mod('style_corners', 'rounded');

  if($style_corners !== '') {
    $classes[] = 'blog-style-corners-'.esc_attr($style_corners);
  }

  // Homepage blocks title align
  $classes[] = 'blog-home-block-title-'.esc_attr(get_theme_mod('home_block_title_align', 'left'));

  // Homepage blocks title style
  $classes[] = 'blog-home-block-title-style-'.esc_attr(get_theme_mod('home_block_title_style', 'regular'));

  // Homepage blocks subtitle style
  $classes[] = 'blog-home-block-subtitle-style-'.esc_attr(get_theme_mod('home_block_subtitle_style', 'uppercase'));

  return $classes;
}
endif;
add_filter('body_class', 'inhype_body_classes');

/**
 * CMB2 images file list display
 *
 * @param  string  $file_list_meta_key The field meta key. ('wiki_test_file_list')
 * @param  string  $img_size           Size of image to show
 */
if(!function_exists('inhype_cmb2_get_images_src')):
function inhype_cmb2_get_images_src( $post_id, $file_list_meta_key, $img_size = 'medium' ) {

    // Get the list of files
    $files = get_post_meta( $post_id, $file_list_meta_key, 1 );

    $attachments_image_urls_array = Array();

    foreach ( (array) $files as $attachment_id => $attachment_url ) {

        $current_attach = wp_get_attachment_image_src( $attachment_id, $img_size );

        $attachments_image_urls_array[] = $current_attach[0];

    }

    if($attachments_image_urls_array[0] == '') {
        $attachments_image_urls_array = array();
    }

    return $attachments_image_urls_array;

}
endif;


/**
 * Add on scroll animations to elements
 */
if(!function_exists('inhype_add_aos')):
function inhype_add_aos($echo = true) {

    $aos_animation = get_theme_mod('aos_animation', '');

    if($aos_animation !== '') {

        $blog_layout = get_theme_mod('blog_layout', 'standard');

        if ( defined('DEMO_MODE') && isset($_GET['blog_layout']) ) {
            $blog_layout = $_GET['blog_layout'];
        }

        // Masonry layout does not supported
        if($blog_layout == 'masonry') {
            $data_params = '';
        } else {
            $data_params = ' data-aos="'.esc_attr($aos_animation).'"';
        }

        if($echo) {
            echo wp_kses_post($data_params);
        } else {
            return wp_kses_post($data_params);
        }

    }
}
endif;

/**
 *  Get correct CSS styles for Google fonts variant
 */
if(!function_exists('inhype_get_font_style_css')):
function inhype_get_font_style_css($variant) {
    $font_style_css = '';

    if(strpos($variant, 'italic')) {
        $font_style_css .= 'font-style: italic;';
        $variant = str_replace('italic', '', $variant);
    }

    if($variant !== 'regular' && $variant !== '') {
        $font_style_css .= 'font-weight: '.$variant.';';
    }

    return $font_style_css;
}
endif;

/**
 * Menu Links Customization
 */
if ( !class_exists( 'InHype_Mainmenu_Walker' ) ):
class InHype_Mainmenu_Walker extends Walker_Nav_Menu{
      function start_el(&$output, $item, $depth = 0, $args = Array(), $current_object_id = 0 ){
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
           $class_names = $value = '';
           $classes = empty( $item->classes ) ? array() : (array) $item->classes;
           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );

           $add_class = '';

           $post = get_post($item->object_id);

               $class_names = ' class="'.$add_class.' '. esc_attr( $class_names ) . '"';
               $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
               $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
               $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
               $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

                    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

                if (is_object($args)) {
                    $item_output = $args->before;
                    $item_output .= '<a'. $attributes .'>';
                    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
                    $item_output .= $args->link_after;
                    if($item->description !== '') {
                        $item_output .= '<span>'.$item->description.'</span>';
                    }

                    $item_output .= '</a>';
                    $item_output .= $args->after;
                    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

                }
     }
}
endif;

/**
 * Get categories list with colors
 */
if(!function_exists('inhype_get_the_category_list')):
function inhype_get_the_category_list($post_id = false) {

  $thelist = '';

  $categories = apply_filters( 'the_category_list', get_the_category( $post_id ), $post_id );

  if ( empty( $categories ) && get_post_type( $post_id ) == 'post' ) {
    return '<a><span class="cat-dot"></span><span class="cat-title">'.esc_html__( 'Uncategorized', 'inhype' ).'</span></a>';
  }

  foreach ( $categories as $category ) {

    $category_color = get_term_meta ( $category->cat_ID, '_inhype_category_color', true );

    if(!empty($category_color)) {
        $data_style = 'background-color: '.$category_color.';';
        $thelist .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '"><span class="cat-dot" data-style="'.esc_attr($data_style).'"></span><span class="cat-title">' . esc_html($category->name).'</span></a>';
    } else {
        $thelist .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '"><span class="cat-dot"></span><span class="cat-title">' . esc_html($category->name).'</span></a>';
    }

  }

  return $thelist;

}
endif;

/**
 * Get product category list
 */
if(!function_exists('inhype_get_the_wc_category_list')):
function inhype_get_the_wc_category_list($post_id = false) {

  $thelist = '';

  $categories = wp_get_post_terms($post_id, 'product_cat', array('fields' => 'ids'));

  if ( empty( $categories ) && get_post_type( $post_id ) == 'product' ) {
    return '<a><span class="cat-dot"></span><span class="cat-title">'.esc_html__( 'Uncategorized', 'inhype' ).'</span></a>';
  }

  foreach ( $categories as $categoryid ) {

    $category = get_term_by('id', $categoryid, 'product_cat' );
    $category_title = $category->name;
    $category_link = get_term_link( (int) $categoryid, 'product_cat' );

    $thelist .= '<a href="' . esc_url( $category_link ) . '"><span class="cat-dot"></span><span class="cat-title">' . esc_html($category_title).'</span></a>';

  }

  return $thelist;

}
endif;

/**
 * Display post date
 */
if(!function_exists('inhype_get_post_date')):
function inhype_get_post_date($postid = '') {

  if($postid == '') {
    $post_date = get_the_time( get_option( 'date_format' ) );
    $postid = get_the_ID();
  } else {
    $post_date = get_the_time( get_option( 'date_format' ), $postid );
  }

  $post_sponsored = get_post_meta( $postid, '_inhype_post_sponsored', true );

  if($post_sponsored) {
    $date_html = '<div class="post-sponsored-badge">'.esc_html__('Sponsored', 'inhype').'</div>';
  } else {
    $date_html = '<time class="entry-date published updated" datetime="'.get_the_date(DATE_W3C, $postid).'">'.esc_html($post_date).'</time>';
  }

  return $date_html;

}
endif;

/**
 * Display post read type
 */
if(!function_exists('inhype_get_post_read_time')):
function inhype_get_post_read_time($postid = '') {

  if($postid == '') {
    $postid = get_the_ID();
  }

  $content = get_post_field( 'post_content', $postid );
  $post_words_count = str_word_count( strip_tags( $content ) );
  $readtime = round($post_words_count / 265);

  if($readtime < 1) {
    $readtime = 1;
  }

  $readtime_html = $readtime.' '.esc_html__('Mins read', 'inhype');

  return $readtime_html;

}
endif;

/**
 * Build WP_Query args based on post type
 */
if(!function_exists('inhype_get_wpquery_args')):
function inhype_get_wpquery_args($settings = array()) {

  $posts_type = $settings['block_posts_type'];

  $args = array();

  if($posts_type == 'featured') {
      $args = array(
        'orderby'          => 'date',
        'order'            => 'DESC',
        'meta_key'         => '_inhype_post_featured',
        'meta_value'       => 'on',
      );
  }

  if($posts_type == 'latest') {
      $args = array(
        'orderby'          => 'date',
        'order'            => 'DESC',
      );
  }

  if($posts_type == 'editorspicks') {
      $args = array(
        'orderby'          => 'date',
        'order'            => 'DESC',
        'meta_key'         => '_inhype_post_editorspicks',
        'meta_value'       => 'on',
      );
  }

  if($posts_type == 'promoted') {
      $args = array(
        'orderby'          => 'date',
        'order'            => 'DESC',
        'meta_key'         => '_inhype_post_promoted',
        'meta_value'       => 'on',
      );
  }

  if($posts_type == 'popular') {
      $args = array(
        'order'            => 'DESC',
        'orderby'          => 'meta_value_num',
        'meta_key'         => '_inhype_post_views_count',
    );
  }

  if($posts_type == 'liked') {
      $args = array(
        'order'            => 'DESC',
        'orderby'          => 'meta_value_num',
        'meta_key'         => '_inhype_post_likes_count',
    );
  }

  if($posts_type == 'trending') {
      $args = array(
          'meta_query' => array(
              'relation' => 'AND',
              'views_clause' => array(
                  'key'   => '_inhype_post_views_count',
                    'type'  => 'NUMERIC'
              ),
              'likes_clause' => array(
                  'key'   => '_inhype_post_likes_count',
                    'type'  => 'NUMERIC'
              ),
          ),
          'orderby' => array(
              'views_clause' => 'DESC',
              'likes_clause' => 'DESC',
          ),
      );
  }

  if($posts_type == 'random') {
      $args = array(
        'order'            => 'DESC',
        'orderby'          => 'rand',
    );
  }

  if(!empty($settings['block_posts_offset'])) {
    $args['offset'] = $settings['block_posts_offset'];
  }

  if(!empty($settings['block_categories']) && !empty($settings['block_categories'][0])) {
    $args['cat'] = $settings['block_categories'];
  }

  if(!empty($settings['block_tags']) && !empty($settings['block_tags'][0]) ) {
    $args['tag__in'] = $settings['block_tags'];
  }

  if(!empty($settings['post__not_in'])) {
    $args['post__not_in'] = $settings['post__not_in'];
  }

  $args['posts_per_page'] = $settings['block_posts_limit'];
  $args['post_type'] = 'post';
  $args['post_status'] = 'publish';
  $args['ignore_sticky_posts'] = true;
  $args['suppress_filters'] = 0;

  return $args;

}
endif;

/**
 * Build WP_Query args for WooCommerce
 */
if(!function_exists('inhype_get_wcquery_args')):
function inhype_get_wcquery_args($settings = array()) {

  $posts_per_page = $settings['block_wc_limit'];
  $posts_type = $settings['block_wc_type'];

  if(!isset($settings['block_wc_offset']) || $settings['block_wc_offset'] == 0) {
    $offset = '';
  } else {
    $offset = $settings['block_wc_offset'];
  }

  if(!isset($settings['block_wc_categories']) || $settings['block_wc_categories'] == 0) {
    $category = '';
  } else {
    $category = $settings['block_wc_categories'];
  }

  $args = array();

  if($posts_type == 'latest') {
      $args = array(
        'posts_per_page'   => $posts_per_page,
        'offset'           => $offset,
        'orderby'          => 'date',
        'order'            => 'DESC',
        'post_type'        => 'product',
        'post_status'      => 'publish',
        'ignore_sticky_posts' => true,
        'suppress_filters' => 0,
        'tax_query'             => array(
            array(
                'taxonomy'      => 'product_visibility',
                'field'         => 'slug',
                'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                'operator'      => 'NOT IN'
            )
        )
      );
  }

  if($posts_type == 'sale') {
      $args = array(
        'posts_per_page'   => $posts_per_page,
        'offset'           => $offset,
        'orderby'          => 'date',
        'order'            => 'DESC',
        'cat'              => $category,
        'post_type'        => 'product',
        'post_status'      => 'publish',
        'ignore_sticky_posts' => true,
        'suppress_filters' => 0,
        'tax_query'             => array(
            array(
                'taxonomy'      => 'product_visibility',
                'field'         => 'slug',
                'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                'operator'      => 'NOT IN'
            )
        ),
        'meta_query'     => array(
            'relation' => 'OR',
            array( // Simple products type
                'key'           => '_sale_price',
                'value'         => 0,
                'compare'       => '>',
                'type'          => 'numeric'
            ),
            array( // Variable products type
                'key'           => '_min_variation_sale_price',
                'value'         => 0,
                'compare'       => '>',
                'type'          => 'numeric'
            )
        )
      );
  }

  // Filter by category
  if($category !== '') {

    $args['tax_query'][] = array(
        'taxonomy'      => 'product_cat',
        'field' => 'term_id',
        'terms'         => $category,
        'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
    );
  }

  return $args;

}
endif;

/*
 * Get exrcept by chars without breaked words
 */
if(!function_exists('inhype_get_the_excerpt')):
function inhype_get_the_excerpt($postid = '') {

  $excerpt = '';

  if(get_theme_mod('blog_posts_excerpt', 'excerpt') == 'content') {

      ob_start();
      the_content('');
      $excerpt = ob_get_contents();
      ob_end_clean();

  } elseif(get_theme_mod('blog_posts_excerpt', 'excerpt') == 'excerpt') {

      ob_start();
      the_excerpt('');
      $excerpt = strip_tags(ob_get_contents());
      ob_end_clean();

  }

  if($excerpt == '…') {
    $excerpt = '';
  }

  return $excerpt;

}
endif;

/*
* Check if we edit post
*/
function is_edit_page($new_edit = null){
    global $pagenow;
    //make sure we are on the backend
    if (!is_admin()) return false;

    if($new_edit == "edit")
        return in_array( $pagenow, array( 'post.php',  ) );
    elseif($new_edit == "new") //check for new post page
        return in_array( $pagenow, array( 'post-new.php' ) );
    else //check for either new or edit
        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}

/*
* Modify main blog listing query
*/
if(!function_exists('inhype_modify_main_query')):
function inhype_modify_main_query( $query ) {
  if ( $query->is_home() && $query->is_main_query() ) { // Run only on the homepage

    $cat_array = get_theme_mod('blog_exclude_categories','');

    if($cat_array !== '') {
      $exclude_cats = '-'.implode(',-', get_theme_mod('blog_exclude_categories',''));

      $query->query_vars['cat'] = $exclude_cats;
    }

  }
}
endif;
add_action( 'pre_get_posts', 'inhype_modify_main_query' );

/*
 * Get columns layout class based on blog layout
 */
if(!function_exists('inhype_get_blog_col_class')):
function inhype_get_blog_col_class($blog_layout = '', $is_sidebar = true) {

  /*
  * Columns layout structure based on blog layout:
  * " inhype-blog-col-2" - 2 cols
  * " inhype-blog-col-3" - 3 cols
  * " inhype-blog-col-1-2" - first 1 then 2 cols
  * " inhype-blog-col-1-3" - first 1 then 3 cols
  * " inhype-blog-col-mixed-1" - first 1 then 2 cols with repeat after 4 elements
  * " inhype-blog-col-mixed-2" - first 1 then 2 cols with repeat after 2 elements
  */

  switch ($blog_layout) {

    // Layout: First large then grid
    case 'large-grid':
      $column_layout = $is_sidebar ? ' inhype-blog-col-1-2' : ' inhype-blog-col-1-3';
      break;

    // Layout: First overlay then grid
    case 'overlay-grid':
      $column_layout = $is_sidebar ? ' inhype-blog-col-1-2' : ' inhype-blog-col-1-3';
      break;

    // Layout: Grid
    case 'grid':
      $column_layout = $is_sidebar ? ' inhype-blog-col-2' : ' inhype-blog-col-3';
      break;

    // Layout: Overlay full
    case 'overlayfull':
      $column_layout = $is_sidebar ? ' inhype-blog-col-2' : ' inhype-blog-col-3';
      break;

    // Layout: Mixed overlays
    case 'mixed-overlays':
      $column_layout = ' inhype-blog-col-mixed-1';
      break;

    // Layout: Mixed large then grid
    case 'mixed-large-grid':
      $column_layout = ' inhype-blog-col-mixed-2';
      break;

    default:
      $column_layout = '';
      break;
  }

  return $column_layout;
}
endif;

/*
* Get posts media formats that support format icons
*/
if(!function_exists('inhype_get_mediaformats')):
function inhype_get_mediaformats() {

  $media_formats[] = 'video';
  $media_formats[] = 'image';
  $media_formats[] = 'gallery';
  $media_formats[] = 'audio';
  $media_formats[] = 'quote';
  $media_formats[] = 'link';

  return $media_formats;
}
endif;

/*
* Get wp_kses allowed tags and attributes list for data-style support
*/
if(!function_exists('inhype_esc_data')):
function inhype_esc_data() {
  $allowed_tags =
      array(
        'a' => array(
          'href' => array(),
          'title' => array(),
          'class' => array(),
          'data' => array(),
          'data-style' => array(),
          'rel'   => array()
        ),
        'div' => array(
          'class' => array(),
          'data' => array(),
          'data-style' => array()
        ),
        'span' => array(
          'class' => array(),
          'data' => array(),
          'data-style' => array()
        ),
        'iframe' => array(
          'src' => array(),
          'class' => array(),
          'data' => array(),
          'data-style' => array(),
          'allow' => array(),
          'allowfullscreen' => array(),
          'width' => array(),
          'height' => array(),
          'frameborder' => array()
        )
  );

  return $allowed_tags;
}
endif;

/*
* Sanitize function for theme options with HTML
*/
if(!function_exists('inhype_sanitize')):
function inhype_sanitize($data) {
  return $data;
}
endif;

/*
 *  Get COL-MD CSS class for 'postsgrid' homepage block
 */
if(!function_exists('inhype_get_postsgrid_col')):
function inhype_get_postsgrid_col($blockid){

  switch ($blockid) {
    case 'postsgrid1':
      $col = 'col-md-4';
      break;

    case 'postsgrid2':
      $col = 'col-md-6';
      break;

    case 'postsgrid3':
      $col = 'col-md-4';
      break;

    case 'postsgrid4':
      $col = 'col-md-4';
      break;

    case 'postsgrid5':
      $col = 'col-md-3';
      break;

    case 'postsgrid6':
      $col = 'col-md-3';
      break;

    case 'postsgrid7':
      $col = 'col-md-6';
      break;

    case 'postsgrid8':
      $col = 'col-md-6';
      break;

    case 'postsgrid9':
      $col = 'col-md-3';
      break;

    case 'postsgrid10':
      $col = 'col-md-3';
      break;

    case 'postsgrid11':
      $col = 'col-md-4';
      break;

    default:
      $col = 'col-md-12';
      break;
  }

  return $col;

}
endif;


/*
 *  Get COL-MD CSS class for 'wcgrid' homepage block
 */
if(!function_exists('inhype_get_wcgrid_col')):
function inhype_get_wcgrid_col($blockid){

  switch ($blockid) {
    case 'wcgrid1':
      $col = 'col-md-3';
      break;

    default:
      $col = 'col-md-12';
      break;
  }

  return $col;

}
endif;

/*
 *  Load more posts ajax handler
 */
if(!function_exists('inhype_loadmore_ajax_handler')):
function inhype_loadmore_ajax_handler(){

  global $wp_query;

  // prepare our arguments for the query
  $args = $_POST['query'];

  $q_args['paged'] = $_POST['page'] + 1;
  $q_args['posts_per_page'] = $args['posts_per_page'];
  $q_args['orderby'] = $args['orderby'];
  $q_args['order'] = $args['order'];
  $q_args['cat'] = $args['cat'];
  $q_args['post_type'] = $args['post_type'];
  $q_args['post_status'] = $args['post_status'];
  $q_args['category_name'] = $args['category_name'];
  $q_args['tax_query'] = $args['tax_query'];
  $q_args['meta_query'] = $args['meta_query'];
  $q_args['meta_key'] = $args['meta_key'];
  $q_args['meta_value'] = $args['meta_value'];
  $q_args['suppress_filters'] = $args['suppress_filters'];

  $block_id = esc_html($_POST['block']);
  $post_template = esc_html($_POST['post_template']);

  query_posts( $q_args );

  if( have_posts() ) :

    // run the loop
    while( have_posts() ): the_post();

      // Posts grid layouts
      $col_class = inhype_get_postsgrid_col($block_id);

      if($block_id == 'blog') {

        // Set correct post loop id for ajax requests
        if(is_paged()) {

          $post_loop_id = get_query_var('paged') * get_option( 'posts_per_page' ) - get_option( 'posts_per_page' ) + $wp_query->current_post + 1;

          $post_loop_details['post_loop_id'] = $post_loop_id;
          inhype_set_post_details($post_loop_details);

        }

        get_template_part( 'content', get_post_format() );

      } elseif (strpos($block_id, 'wc') !== false) {
        // WooCommerce block
        $col_class = inhype_get_wcgrid_col($block_id);

        echo '<div class="'.esc_attr($col_class).'">';
        get_template_part( 'inc/templates/product/content', $post_template );
        echo '</div>';

      } else {

        echo '<div class="'.esc_attr($col_class).'">';
        get_template_part( 'inc/templates/post/content', $post_template );
        echo '</div>';

      }

    endwhile;

  endif;
  die; // here we exit the script and even no wp_reset_query() required!
}
endif;
add_action('wp_ajax_inhype_loadmore', 'inhype_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_inhype_loadmore', 'inhype_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}

/*
* WooCommerce ajax add to cart
*/
// Ensure cart contents update when products are added to the cart via AJAX
if (!function_exists('inhype_woocommerce_header_add_to_cart_fragment')) :
function inhype_woocommerce_header_add_to_cart_fragment( $fragments = array() ) {

  global $woocommerce;

  $add_class = '';

  ob_start();
  ?>
  <div class="shopping-cart" id="shopping-cart">

      <a class="cart-toggle-btn" href="<?php echo esc_url(wc_get_cart_url()); ?>"><i class="fa fa-shopping-cart"></i>
      <?php if($woocommerce->cart->cart_contents_count > 0): ?>
      <div class="shopping-cart-count"><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></div>
      <?php endif; ?>
      <span class="<?php echo esc_attr($add_class); ?>"><?php esc_html_e('Shopping cart', 'inhype'); ?></span>
      </a>

      <div class="shopping-cart-content">
      <?php
      $cart_products_i = 0;
      $cart_products_more = 0;
      $cart_products_count = count($woocommerce->cart->get_cart());

      if ( $woocommerce->cart->cart_contents_count > 0 ) : ?>
      <div class="shopping-cart-products">
      <?php foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) : $_product = $cart_item['data'];
      if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 ) continue;

      $cart_products_i++;

      if(isset($cryptibit_theme_options['woocommerce_mini_cart_limit'])) {
        $cart_products_more_limit = $cryptibit_theme_options['woocommerce_mini_cart_limit'];
      } else {
        $cart_products_more_limit = 3;
      }

      if($cart_products_i == $cart_products_more_limit + 1) {
        $cart_products_more = $cart_products_count - $cart_products_more_limit;
        break;
      }

      $product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? wc_get_price_excluding_tax($_product) : wc_get_price_including_tax($_product);
      $product_price = apply_filters( 'woocommerce_cart_item_price_html', wc_price( $product_price ), $cart_item, $cart_item_key );
      ?>
      <div class="shopping-cart-product clearfix">
        <div class="shopping-cart-product-image">
        <a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>"><?php echo wp_kses_post($_product->get_image()); ?></a>
        </div>
        <div class="shopping-cart-product-remove">
            <?php
                echo wp_kses_post(apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">×</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'inhype' ) ), $cart_item_key ));
            ?>
        </div>
        <div class="shopping-cart-product-title">
        <a href="<?php echo esc_url(get_permalink( $cart_item['product_id'] )); ?>"><?php echo wp_kses_post(apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product )); ?></a>
        </div>
        <div class="shopping-cart-product-price">
        <?php echo wp_kses_post(wc_get_formatted_cart_item_data( $cart_item )); ?><span class="quantity"><?php wp_kses_post(printf( '%s &times; %s', $cart_item['quantity'], $product_price )); ?></span>
        </div>
      </div>
      <?php endforeach; ?>
      <?php if($cart_products_more > 0): ?>
      <div class="shopping-cart-product-more"><?php esc_html_e('And', 'inhype'); ?> <?php echo wp_kses_post($cart_products_more); ?> <?php esc_html_e('more product(s) in cart.', 'inhype'); ?></div>
      <?php endif; ?>
      </div>

      <div class="shopping-cart-subtotal clearfix"><div class="shopping-cart-subtotal-text"><?php esc_html_e('Subtotal', 'inhype'); ?></div><div class="shopping-cart-subtotal-value"><?php echo wp_kses_post(wc_cart_totals_subtotal_html()); ?></div></div>
      <a class="btn btn-cart btn-bordered" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'inhype'); ?>"><?php esc_html_e('View cart', 'inhype'); ?></a> <a class="btn btn-checkout" href="<?php echo esc_url(wc_get_checkout_url()); ?>" title="<?php esc_attr_e('Proceed to checkout', 'inhype'); ?>"><?php esc_html_e('Proceed to checkout', 'inhype'); ?></a>
      <?php else : ?>
        <div class="empty-cart-icon-mini">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        </div>
        <div class="empty"><?php esc_html_e('No products in the cart.', 'inhype'); ?></div>
      <?php endif; ?>

      </div>
    </div>
  <?php
  $fragments['#shopping-cart'] = ob_get_clean();
  return $fragments;
}
endif;

if(class_exists('Woocommerce')) {
    add_filter('woocommerce_add_to_cart_fragments', 'inhype_woocommerce_header_add_to_cart_fragment');
}
