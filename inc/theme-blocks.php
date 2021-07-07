<?php
/**
 * Theme homepage blocks
 **/

/**
 * Subscribe block display
 */
if(!function_exists('inhype_block_subscribe_display')):
function inhype_block_subscribe_display($settings = array()) {
  ?>
  <div class="container inhype-subscribe-block-container inhype-block"<?php inhype_add_aos(); ?>>
    <?php if(!empty($settings['block_title'])): ?>
    <div class="row">
    <?php
      echo '<div class="inhype-block-title">';
      echo '<h3>'.esc_html($settings['block_title']).'</h3>';
      if(!empty($settings['block_subtitle'])) {
        echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
      }
      echo '</div>';
    ?>
    </div>
    <?php endif; ?>
    <div class="inhype-subscribe-block">
    <?php echo do_shortcode(get_theme_mod('subscribeblock_html', '')); ?>
    </div>
  </div>
  <?php
}
endif;

/**
 * Homepage featured categories block display
 */
if(!function_exists('inhype_block_categories_display')):
function inhype_block_categories_display($settings = array()) {

    $categories = get_theme_mod('featured_categories', array());
    $categories_count = !empty($categories) ? count($categories) : 0;

    if(!empty($categories) && $categories_count > 0) {

        echo '<div class="inhype-featured-categories-wrapper inhype-block"'.inhype_add_aos(false).'>';
        echo '<div class="container">';
        echo '<div class="row">';

        if(!empty($settings['block_title'])) {
          echo '<div class="inhype-block-title">';
          echo '<h3>'.esc_html($settings['block_title']).'</h3>';
          if(!empty($settings['block_subtitle'])) {
            echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
          }
          echo '</div>';
        }

        if($categories_count % 3 == 0) {
            $col_class = 'col-md-4';
        } else {
            $col_class = 'col-md-3';
        }

        foreach ($categories as $category) {

            $category_title = get_the_category_by_ID( $category );

            if(!empty($category_title)) {

              $category_link = get_category_link( $category );

              $category_image = get_term_meta ( $category, '_inhype_category_image', true );

              $add_class = '';

              if(isset($category_image) && ($category_image !== '')) {
                  $category_style = 'background-image: url('.$category_image.');';
                  $add_class = ' with-bg';
              } else {
                  $category_style = '';
                  $add_class = ' without-bg';
              }

              $category_color = get_term_meta ( $category, '_inhype_category_color', true );

              if(isset($category_color) && ($category_color !== '')) {
                  $category_badge_style = 'background-color: '.$category_color.';';
              } else {
                  $category_badge_style = '';
              }

              $category_obj = get_category($category);

              if(!empty($category_obj)) {
                $category_counter = $category_obj->category_count;

                echo '<div class="'.esc_attr($col_class).'">';
                echo '<div class="inhype-post">';

                echo '<div class="inhype-featured-category'.esc_attr($add_class).' inhype-image-wrapper" '.inhype_add_aos(false).' data-style="'.esc_attr($category_style ? $category_style : $category_badge_style).'">';

                echo '<div class="inhype-featured-category-overlay">';

                echo '<div class="inhype-featured-category-bg" data-style="'.esc_attr($category_badge_style).'"></div>';

                echo '<div class="inhype-featured-category-counter" data-style="'.esc_attr($category_badge_style).'">'.esc_html($category_counter).' '.esc_html__('Posts', 'inhype').'</div>';

                echo '<div class="post-categories"><a href="'.esc_url($category_link).'" class="inhype-featured-category-link"><span class="cat-dot" data-style="'.esc_attr($category_badge_style).'"></span><span class="cat-title">'.esc_html($category_title).'</span></a></div>';

                echo '<a class="btn btn-small btn-white" href="'.esc_url($category_link).'">'.esc_html__('View posts', 'inhype').'</a>';

                echo '</div>';

                echo '</div>';

                echo '</div>';
                echo '</div>';
              }

            }


        }

        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

}
endif;

/**
 * Footer Instagram block display
 */
if(!function_exists('inhype_block_instagram_display')):
function inhype_block_instagram_display($settings = array()) {

    // Instagram feed
    echo '<div class="inhype-instagram-block-wrapper inhype-block"'.inhype_add_aos(false).'>';
    if(!empty($settings['block_title'])) {
      echo '<div class="container">';
      echo '<div class="row">';
      echo '<div class="inhype-block-title">';
      echo '<h3>'.esc_html($settings['block_title']).'</h3>';
      if(!empty($settings['block_subtitle'])) {
        echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
      }
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }

    echo '<div class="container">';

    echo do_shortcode('[instagram-feed]');
    echo '</div>';

    echo '</div>';

}
endif;

/**
 * Postsline #1 block display
 */
if(!function_exists('inhype_block_postsline_display')):
function inhype_block_postsline_display($settings = array()) {

  $args = inhype_get_wpquery_args($settings);

  $posts_query = new WP_Query;
  $posts = $posts_query->query($args);

  $total_posts = count($posts);

  if($posts_query->have_posts()) {

    $unique_block_id = rand(10000, 900000);
    ?>
    <div class="inhype-postline-block-wrapper"<?php inhype_add_aos(true);?>>
      <div class="container">
        <div class="row">
          <div class="inhype-postline-block inhype-postline-block-<?php echo esc_attr($unique_block_id); ?> inhype-block clearfix">
            <div class="owl-carousel">
            <?php
            while ($posts_query->have_posts()) {
                  $posts_query->the_post();

                  $post = get_post();

                  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'inhype-blog-thumb-grid');

                  if(has_post_thumbnail( $post->ID )) {
                      $image_bg ='background-image: url('.esc_url($image[0]).');';
                      $post_class = '';
                  }
                  else {
                      $image_bg = '';
                      $post_class = ' inhype-post-no-image';
                  }

                  $categories_list = inhype_get_the_category_list( $post->ID );
                  ?>

                  <div class="inhype-post<?php echo esc_attr($post_class); ?>">
                    <div class="inhype-postline-block-content">

                      <div class="inhype-postline-details">
                        <div class="post-categories"><?php echo wp_kses($categories_list, inhype_esc_data()); ?></div>
                        <h3 class="post-title"><a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php echo esc_html($post->post_title); ?></a></h3>
                        <?php if (get_theme_mod('blog_posts_author', false)): ?>
                        <div class="post-author">
                            <span class="vcard">
                                <?php echo esc_html__('By', 'inhype'); ?> <span class="fn"><?php echo get_the_author_posts_link(); ?></span>
                            </span>
                        </div>
                        <div class="post-info-dot"></div>
                        <?php endif; ?>
                        <div class="post-date"><?php echo inhype_get_post_date($post->ID); ?></div>
                        <?php if(get_theme_mod('blog_posts_read_time', false)): ?>
                        <div class="post-info-dot"></div>
                        <div class="post-read-time"><?php echo inhype_get_post_read_time($post->ID); ?></div>
                        <?php endif; ?>
                      </div>

                      <?php if(has_post_thumbnail( $post->ID )): ?>
                      <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="inhype-post-image-link">
                        <div class="inhype-post-image" data-style="<?php echo esc_attr($image_bg); ?>"></div>
                      </a>
                      <?php endif; ?>
                    </div>
                  </div>
            <?php
            }
            ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      if($total_posts > 1) {
        wp_add_inline_script( 'inhype-script', '(function($){
        $(document).ready(function() {

            "use strict";

            var owlpostslider = $(".inhype-postline-block.inhype-postline-block-'.esc_js($unique_block_id).' .owl-carousel").owlCarousel({
                loop: true,
                items: 1,
                autoplay: true,
                autowidth: false,
                autoplaySpeed: 1000,
                navSpeed: 5000,
                nav: false,
                dots: false,
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

            AOS.refresh();

        });})(jQuery);');
      } else {
        wp_add_inline_script( 'inhype-script', '(function($){
            $(document).ready(function() {

               "use strict";

               $(".inhype-postline-block.inhype-postline-block-'.esc_js($unique_block_id).' .owl-carousel").show();

               AOS.refresh();

            });})(jQuery);');
      }

    } // have_posts

    wp_reset_postdata();

}
endif;

/**
 * Postsline #2 block display
 */
if(!function_exists('inhype_block_postsline2_display')):
function inhype_block_postsline2_display($settings = array()) {

  $args = inhype_get_wpquery_args($settings);

  $posts_query = new WP_Query;
  $posts = $posts_query->query($args);

  $total_posts = count($posts);

  if($posts_query->have_posts()) {

    $unique_block_id = rand(10000, 900000);
    ?>
    <div class="inhype-postline2-block-wrapper"<?php inhype_add_aos(true);?>>
      <div class="container-fluid">
        <div class="row">
          <div class="inhype-postline2-block inhype-postline-block-<?php echo esc_attr($unique_block_id); ?> inhype-block clearfix">
            <?php if(!empty($settings['block_title'])) {
              echo '<div class="container">';
              echo '<div class="row">';
              echo '<div class="inhype-block-title">';
              echo '<h3>'.esc_html($settings['block_title']).'</h3>';
              if(!empty($settings['block_subtitle'])) {
                echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
              }
              echo '</div>';
              if(!empty($settings['block_description'])) {
                echo '<div class="inhype-block-description">'.do_shortcode($settings['block_description']).'</div>';
              }
              echo '</div>';
              echo '</div>';
            }
            ?>
            <div class="owl-carousel">
            <?php
            while ($posts_query->have_posts()) {
                  $posts_query->the_post();

                  $post = get_post();

                  echo '<div class="col-md-12">';

                  get_template_part( 'inc/templates/post/content', 'grid-short' );

                  echo '</div>';

                  ?>
            <?php
            }
            ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      if($total_posts > 1) {
        wp_add_inline_script( 'inhype-script', '(function($){
        $(document).ready(function() {

            "use strict";

            var owlpostslider = $(".inhype-postline2-block.inhype-postline-block-'.esc_js($unique_block_id).' .owl-carousel").owlCarousel({
                loop: true,
                items: 5,
                autoplay: true,
                autowidth: false,
                autoplaySpeed: 1000,
                navSpeed: 5000,
                nav: false,
                dots: false,
                navText: false,
                responsive: {
                    1199:{
                        items:5
                    },
                    979:{
                        items:3
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

               $(".inhype-postline-block.inhype2-postline-block-'.esc_js($unique_block_id).' .owl-carousel").show();

               AOS.refresh();

            });})(jQuery);');
      }

    } // have_posts

    wp_reset_postdata();

}
endif;

/**
 * Helper function to render posts blocks output
 */
if(!function_exists('inhype_posts_block_renderer')):
function inhype_posts_block_renderer($block_id = '', $settings = array(), $fullwidth = false) {

        // Blocks with custom title position, disable regular title
        $custom_title = array('showcase3');

        $args = inhype_get_wpquery_args($settings);

        $posts_query = new WP_Query;
        $posts = $posts_query->query($args);

        // Disable load more if specified offset
        if(!empty($settings['block_posts_offset'])) {
          $settings['block_posts_loadmore'] = 'no';
        }

        if($posts_query->have_posts()) {

              $unique_block_id = rand(10000, 900000);

              echo '<div class="inhype-'.esc_attr($block_id).'-block-wrapper inhype-'.esc_attr($block_id).'-block-wrapper-'.esc_html($unique_block_id).' inhype-block">';

              if(!empty($settings['block_fullwidth']) && $settings['block_fullwidth']) {
                echo '<div class="inhype-block-wrapper-bg">';
              }

              if(!empty($settings['block_title']) && !in_array($block_id, $custom_title)) {
                echo '<div class="container container-title">';
                echo '<div class="row">';
                echo '<div class="inhype-block-title">';
                echo '<h3>'.esc_html($settings['block_title']).'</h3>';
                if(!empty($settings['block_subtitle'])) {
                  echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
                }
                echo '</div>';
                if(!empty($settings['block_description'])) {
                  echo '<div class="inhype-block-description">'.do_shortcode($settings['block_description']).'</div>';
                }
                echo '</div>';
                echo '</div>';
              }

              echo '<div class="container container-content">';
              echo '<div class="row">';

              $i = 0;
              $post_template = $block_id;

              while ($posts_query->have_posts()){
                  $posts_query->the_post();

                  $i++;

                  // Mixed templates

                  // Posts Masonry 1
                  if($block_id == 'postsmasonry1') {

                    if($posts_query->post_count < $settings['block_posts_limit']) {
                      break;
                    }

                    if($i < 4) {

                      if($i == 1) {

                        echo '<div class="col-md-7">';

                      }

                      get_template_part( 'inc/templates/post/content', 'list-medium' );

                      if($i == 3) {

                        echo '</div>';

                      }

                    } else {

                      if($i == 4) {
                        echo '<div class="col-md-5">';
                      }

                      get_template_part( 'inc/templates/post/content', 'overlay' );

                      if($i == $posts_query->post_count) {

                        echo '</div>';

                      }

                    }

                  } elseif($block_id == 'postsmasonry2') {

                    // Posts Masonry 2
                    if($posts_query->post_count < $settings['block_posts_limit']) {
                      break;
                    }


                    if($i == 1) {

                      echo '<div class="col-md-4">';

                      get_template_part( 'inc/templates/post/content', 'text-large' );

                    } elseif($i == 2) {

                      echo '<div class="row">';

                      echo '<div class="col-md-6">';

                      get_template_part( 'inc/templates/post/content', 'grid-short' );

                      echo '</div>';

                    } elseif($i == 3) {

                      echo '<div class="col-md-6">';

                      get_template_part( 'inc/templates/post/content', 'grid-short' );

                      echo '</div>';

                      echo '</div>'; // row close

                      echo '</div>'; // col-md-4 close

                    } elseif($i < 8) {

                      if($i == 4) {
                        echo '<div class="col-md-4">';
                      }

                      get_template_part( 'inc/templates/post/content', 'text' );

                      if($i == 7) {
                        echo '</div>';
                      }

                    } elseif($i == 8) {

                      echo '<div class="col-md-4">';

                      get_template_part( 'inc/templates/post/content', 'grid-short' );

                      echo '</div>';

                    }

                  } elseif($block_id == 'postsmasonry3') {

                    // Posts Masonry 3
                    if($i == 1) {

                      echo '<div class="col-md-9">';

                      get_template_part( 'inc/templates/post/content', 'grid' );

                      echo '</div>';

                    } else {

                      echo '<div class="col-md-3">';

                      get_template_part( 'inc/templates/post/content', 'grid-short' );

                      echo '</div>';
                    }

                  } elseif($block_id == 'postsmasonry4') {

                    // Posts Masonry 4
                    if($i == 1) {

                      echo '<div class="col-md-6">';

                      get_template_part( 'inc/templates/post/content', 'grid' );

                      echo '</div>';

                    } else {

                      echo '<div class="col-md-6">';

                      get_template_part( 'inc/templates/post/content', 'list-small' );

                      echo '</div>';
                    }

                  } elseif($block_id == 'showcase1') {

                    // Showcase 1
                    if($posts_query->post_count < $settings['block_posts_limit']) {
                      break;
                    }

                    if($i == 1) {

                      echo '<div class="col-md-3">';

                      get_template_part( 'inc/templates/post/content', 'overlay-short' );

                    } elseif($i == 2) {

                      get_template_part( 'inc/templates/post/content', 'overlay-short' );

                      echo '</div>';

                    } elseif($i == 3) {

                      echo '<div class="col-md-6">';

                      get_template_part( 'inc/templates/post/content', 'overlay' );

                      echo '</div>';

                    } elseif($i == 4) {

                      echo '<div class="col-md-3">';

                      get_template_part( 'inc/templates/post/content', 'overlay-short' );

                    } else {

                      get_template_part( 'inc/templates/post/content', 'overlay-short' );

                      echo '</div>';

                    }

                  } elseif($block_id == 'showcase2') {

                    // Showcase 2
                    if($i == 1) {

                      echo '<div class="col-md-12">';

                      get_template_part( 'inc/templates/post/content', 'overlay-short' );

                      echo '</div>';

                    } else {

                      echo '<div class="col-md-4">';

                      get_template_part( 'inc/templates/post/content', 'overlay-short' );

                      echo '</div>';

                    }

                  } elseif($block_id == 'showcase3') {

                    // Showcase 3
                    if($i == 1) {

                      echo '<div class="col-md-7">';

                      get_template_part( 'inc/templates/post/content', 'overlay-large' );

                      echo '</div>';

                      if(!empty($settings['block_title'])) {
                        echo '<div class="col-md-5">';

                        echo '<div class="container-title">';
                        echo '<div class="row">';
                        echo '<div class="inhype-block-title">';
                        echo '<h3>'.esc_html($settings['block_title']).'</h3>';
                        if(!empty($settings['block_subtitle'])) {
                          echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        echo '</div>';
                      }

                    } else {

                      if($i == 2) {
                        echo '<div class="col-md-5">';
                      }

                      get_template_part( 'inc/templates/post/content', 'text' );

                      if($i == $posts_query->post_count) {
                        echo '</div>';
                      }

                    }
                  } elseif($block_id == 'showcase4') {

                    // Showcase 4
                    if($posts_query->post_count < $settings['block_posts_limit']) {
                      break;
                    }

                    if($i == 1) {

                      echo '<div class="col-md-6">';

                      get_template_part( 'inc/templates/post/content', 'overlay' );

                      echo '</div>';

                    } elseif($i == 2) {

                      echo '<div class="col-md-6">';

                      get_template_part( 'inc/templates/post/content', 'overlay-short' );

                    } else {

                      get_template_part( 'inc/templates/post/content', 'overlay-short' );

                      if($i == $settings['block_posts_limit']) {
                        echo '</div>';
                      }
                    }

                  } elseif($block_id == 'showcase5') {

                    // Showcase 5
                    if($posts_query->post_count < $settings['block_posts_limit']) {
                      break;
                    }

                    if($i == 1) {

                      echo '<div class="col-md-3">';

                      get_template_part( 'inc/templates/post/content', 'grid-short' );

                      $div_opened = true;

                    } elseif($i == 2) {

                      get_template_part( 'inc/templates/post/content', 'grid-short' );

                      echo '</div>';

                      $div_opened = false;

                    } elseif($i == 3) {

                      echo '<div class="col-md-6">';

                      get_template_part( 'inc/templates/post/content', 'grid-large' );

                      echo '</div>';

                    } elseif($i == 4) {

                      echo '<div class="col-md-3">';

                      get_template_part( 'inc/templates/post/content', 'grid-short' );

                      $div_opened = true;

                    } else {

                      get_template_part( 'inc/templates/post/content', 'grid-short' );

                      echo '</div>';

                      $div_opened = false;

                    }

                    if(($posts_query->post_count < $settings['block_posts_limit']) && $div_opened && ($i == $posts_query->post_count)) {
                      echo '</div>';
                    }

                  } elseif($block_id == 'showcase6') {

                    // Showcase 6
                    if($posts_query->post_count < $settings['block_posts_limit']) {
                      break;
                    }

                    if($i == 1) {

                      echo '<div class="col-md-4">';

                      get_template_part( 'inc/templates/post/content', 'grid' );

                      echo '</div>';

                    } else {

                      echo '<div class="col-md-4">';

                      get_template_part( 'inc/templates/post/content', 'text' );

                      echo '</div>';

                    }


                  } elseif($block_id == 'showcase7') {

                    // Showcase 7
                    if($posts_query->post_count < $settings['block_posts_limit']) {
                      break;
                    }

                    if($i == 1) {

                      echo '<div class="col-md-8">';

                      get_template_part( 'inc/templates/post/content', 'grid' );

                      echo '</div>';

                    } elseif($i == 2) {

                      echo '<div class="col-md-4">';

                      get_template_part( 'inc/templates/post/content', 'grid-short' );

                    } else {

                      get_template_part( 'inc/templates/post/content', 'grid-short' );

                      if($i == $settings['block_posts_limit']) {
                        echo '</div>';
                      }
                    }

                  } elseif($block_id == 'showcase8') {

                    // Showcase 8
                    if($posts_query->post_count < $settings['block_posts_limit']) {
                      break;
                    }

                    if($i == 1) {

                      echo '<div class="col-md-8">';

                      get_template_part( 'inc/templates/post/content', 'overlay' );

                      echo '</div>';

                    } else {

                      echo '<div class="col-md-4">';

                      get_template_part( 'inc/templates/post/content', 'overlay' );

                      echo '</div>';

                    }

                  } elseif($block_id == 'showcase9') {

                    // Showcase 9
                    if($posts_query->post_count < $settings['block_posts_limit']) {
                      break;
                    }

                    if($i == 1) {

                      echo '<div class="col-md-4">';

                      get_template_part( 'inc/templates/post/content', 'overlay' );

                      echo '</div>';

                    } elseif($i == 2) {

                      echo '<div class="col-md-4">';

                      get_template_part( 'inc/templates/post/content', 'overlay' );

                      echo '</div>';

                    } elseif($i == 3) {

                      echo '<div class="col-md-4">';

                      get_template_part( 'inc/templates/post/content', 'overlay-short' );

                    } else {

                      get_template_part( 'inc/templates/post/content', 'overlay-short' );

                      if($i == $settings['block_posts_limit']) {
                        echo '</div>';
                      }
                    }

                  }

                  // Posts Grid templates
                  elseif($block_id == 'postsgrid1') {

                    echo '<div class="'.esc_attr(inhype_get_postsgrid_col($block_id)).'">';

                    $post_template = 'grid';

                    get_template_part( 'inc/templates/post/content', $post_template );

                    echo '</div>';

                  } elseif($block_id == 'postsgrid2') {

                    echo '<div class="'.esc_attr(inhype_get_postsgrid_col($block_id)).'">';

                    $post_template = 'overlay';

                    get_template_part( 'inc/templates/post/content', $post_template );

                    echo '</div>';

                  } elseif($block_id == 'postsgrid3') {

                    echo '<div class="'.esc_attr(inhype_get_postsgrid_col($block_id)).'">';

                    $post_template = 'overlay-short';

                    get_template_part( 'inc/templates/post/content', $post_template );

                    echo '</div>';

                  } elseif($block_id == 'postsgrid4') {

                    echo '<div class="'.esc_attr(inhype_get_postsgrid_col($block_id)).'">';

                    $post_template = 'grid-short';

                    get_template_part( 'inc/templates/post/content', $post_template );

                    echo '</div>';

                  } elseif($block_id == 'postsgrid5') {

                    echo '<div class="'.esc_attr(inhype_get_postsgrid_col($block_id)).'">';

                    $post_template = 'text';

                    get_template_part( 'inc/templates/post/content', $post_template );

                    echo '</div>';

                  } elseif($block_id == 'postsgrid6') {

                    echo '<div class="'.esc_attr(inhype_get_postsgrid_col($block_id)).'">';

                    $post_template = 'overlay-short';

                    get_template_part( 'inc/templates/post/content', $post_template );

                    echo '</div>';

                  } elseif($block_id == 'postsgrid7') {

                    echo '<div class="'.esc_attr(inhype_get_postsgrid_col($block_id)).'">';

                    $post_template = 'list-small';

                    get_template_part( 'inc/templates/post/content', $post_template );

                    echo '</div>';

                  } elseif($block_id == 'postsgrid8') {

                    echo '<div class="'.esc_attr(inhype_get_postsgrid_col($block_id)).'">';

                    $post_template = 'grid';

                    get_template_part( 'inc/templates/post/content', $post_template );

                    echo '</div>';

                  } elseif($block_id == 'postsgrid9') {

                    echo '<div class="'.esc_attr(inhype_get_postsgrid_col($block_id)).'">';

                    $post_template = 'grid-short';

                    get_template_part( 'inc/templates/post/content', $post_template );

                    echo '</div>';

                  } elseif($block_id == 'postsgrid10') {

                    echo '<div class="'.esc_attr(inhype_get_postsgrid_col($block_id)).'">';

                    $post_template = 'grid-short';

                    get_template_part( 'inc/templates/post/content', $post_template );

                    echo '</div>';

                  } elseif($block_id == 'postsgrid11') {

                    echo '<div class="'.esc_attr(inhype_get_postsgrid_col($block_id)).'">';

                    $post_template = 'overlay-short';

                    get_template_part( 'inc/templates/post/content', $post_template );

                    echo '</div>';

                  }
              }

              wp_reset_postdata();
            }

            if (  $posts_query->max_num_pages > 1 && $settings['block_posts_loadmore'] == 'yes' ) {
              echo '<div class="col-md-12 inhype-block-button"'.inhype_add_aos(false).'><a href="#" class="btn btn-load-more">'.esc_html__('Load more', 'inhype').'</a></div>';
            }

            echo '</div>';
            echo '</div>';

            if(!empty($settings['block_fullwidth']) && $settings['block_fullwidth']) {
              echo '</div>'; // .inhype-block-wrapper-bg
            }

            echo '</div>';

            // Load more JS script
            if (  $posts_query->max_num_pages > 1 && $settings['block_posts_loadmore'] == 'yes' ) {
              wp_add_inline_script( 'inhype-script', "(function($){
              $(document).ready(function() {
                  'use strict';

                  var current_page_".esc_js($unique_block_id)." = 1;

                  $('.inhype-".esc_js($block_id)."-block-wrapper-".esc_js($unique_block_id)." .btn-load-more').on('click', function(e){

                    e.preventDefault();
                    e.stopPropagation();

                    var button = $(this),
                        data = {
                        'action': 'inhype_loadmore',
                        'query': ".json_encode( $posts_query->query_vars , true).",
                        'page' : current_page_".esc_js($unique_block_id).",
                        'block' : '".esc_js($block_id)."',
                        'post_template' : '".esc_js($post_template)."'
                    };

                    var button_default_text = button.text();

                    $.ajax({
                        url : '".esc_url(site_url())."/wp-admin/admin-ajax.php', // AJAX handler
                        data : data,
                        type : 'POST',
                        beforeSend : function ( xhr ) {
                            button.text('".esc_html__('Loading...', 'inhype')."');
                            button.addClass('btn-loading');
                        },
                        success : function( data ){
                            if( data ) {
                                button.text( button_default_text );
                                button.removeClass('btn-loading');

                                // Insert new posts
                                $('.inhype-".esc_js($block_id)."-block-wrapper-".esc_js($unique_block_id)." .inhype-block-button').before(data);

                                // Show images
                                $('.inhype-".esc_js($block_id)."-block-wrapper-".esc_js($unique_block_id)." .inhype-post-image').each(function( index ) {
                                  $(this).attr('style', ($(this).attr('data-style')));
                                });

                                // Show categories colors
                                $('.inhype-".esc_js($block_id)."-block-wrapper-".esc_js($unique_block_id)." .inhype-post .post-categories .cat-dot').each(function( index ) {
                                  $(this).attr('style', ($(this).attr('data-style')));
                                });

                                // Show rating badges
                                $('.inhype-".esc_js($block_id)."-block-wrapper-".esc_js($unique_block_id)." .inhype-post .post-review-rating-badge').each(function( index ) {
                                  $(this).attr('style', ($(this).attr('data-style')));
                                });

                                current_page_".esc_js($unique_block_id)."++;

                                if ( current_page_".esc_js($unique_block_id)." == ".esc_js($posts_query->max_num_pages)." )
                                    button.remove(); // if last page, remove the button

                            } else {
                                button.remove(); // if no data, remove the button
                            }
                        }
                    });
                  });

              });})(jQuery);");

          }
}
endif;

/**
 * Posts Grid 1 block display
 */
if(!function_exists('inhype_block_postsgrid1_display')):
function inhype_block_postsgrid1_display($settings = array()) {

  inhype_posts_block_renderer('postsgrid1', $settings);

}
endif;

/**
 * Posts Grid 2 block display
 */
if(!function_exists('inhype_block_postsgrid2_display')):
function inhype_block_postsgrid2_display($settings = array()) {

  inhype_posts_block_renderer('postsgrid2', $settings);

}
endif;

/**
 * Posts Grid 3 block display
 */
if(!function_exists('inhype_block_postsgrid3_display')):
function inhype_block_postsgrid3_display($settings = array()) {

  inhype_posts_block_renderer('postsgrid3', $settings);

}
endif;

/**
 * Posts Grid 4 block display
 */
if(!function_exists('inhype_block_postsgrid4_display')):
function inhype_block_postsgrid4_display($settings = array()) {

  inhype_posts_block_renderer('postsgrid4', $settings);

}
endif;

/**
 * Posts Grid 5 block display
 */
if(!function_exists('inhype_block_postsgrid5_display')):
function inhype_block_postsgrid5_display($settings = array()) {

  inhype_posts_block_renderer('postsgrid5', $settings);

}
endif;

/**
 * Posts Grid 6 block display
 */
if(!function_exists('inhype_block_postsgrid6_display')):
function inhype_block_postsgrid6_display($settings = array()) {

  $settings['block_fullwidth'] = false;

  inhype_posts_block_renderer('postsgrid6', $settings);

}
endif;

/**
 * Posts Grid 7 block display
 */
if(!function_exists('inhype_block_postsgrid7_display')):
function inhype_block_postsgrid7_display($settings = array()) {

  inhype_posts_block_renderer('postsgrid7', $settings);

}
endif;

/**
 * Posts Grid 8 block display
 */
if(!function_exists('inhype_block_postsgrid8_display')):
function inhype_block_postsgrid8_display($settings = array()) {

  inhype_posts_block_renderer('postsgrid8', $settings);

}
endif;

/**
 * Posts Grid 9 block display
 */
if(!function_exists('inhype_block_postsgrid9_display')):
function inhype_block_postsgrid9_display($settings = array()) {

  inhype_posts_block_renderer('postsgrid9', $settings);

}
endif;

/**
 * Posts Grid 10 block display
 */
if(!function_exists('inhype_block_postsgrid10_display')):
function inhype_block_postsgrid10_display($settings = array()) {

  inhype_posts_block_renderer('postsgrid10', $settings);

}
endif;

/**
 * Posts Grid 11 block display
 */
if(!function_exists('inhype_block_postsgrid11_display')):
function inhype_block_postsgrid11_display($settings = array()) {

  inhype_posts_block_renderer('postsgrid11', $settings);

}
endif;

/**
 * Posts Masonry 1 block display
 */
if(!function_exists('inhype_block_postsmasonry1_display')):
function inhype_block_postsmasonry1_display($settings = array()) {

  $settings['block_posts_limit'] = 5;
  $settings['block_posts_loadmore'] = false;

  inhype_posts_block_renderer('postsmasonry1', $settings);

}
endif;

/**
 * Posts Masonry 2 block display
 */
if(!function_exists('inhype_block_postsmasonry2_display')):
function inhype_block_postsmasonry2_display($settings = array()) {

  $settings['block_posts_limit'] = 8;
  $settings['block_posts_loadmore'] = false;

  inhype_posts_block_renderer('postsmasonry2', $settings);

}
endif;

/**
 * Posts Masonry 3 block display
 */
if(!function_exists('inhype_block_postsmasonry3_display')):
function inhype_block_postsmasonry3_display($settings = array()) {

  $settings['block_posts_limit'] = 4;
  $settings['block_posts_loadmore'] = false;

  inhype_posts_block_renderer('postsmasonry3', $settings);

}
endif;

/**
 * Posts Masonry 4 block display
 */
if(!function_exists('inhype_block_postsmasonry4_display')):
function inhype_block_postsmasonry4_display($settings = array()) {

  $settings['block_posts_limit'] = 5;
  $settings['block_posts_loadmore'] = false;

  inhype_posts_block_renderer('postsmasonry4', $settings);

}
endif;

/**
 * Showcase 1 block display
 */
if(!function_exists('inhype_block_showcase1_display')):
function inhype_block_showcase1_display($settings = array()) {

  $settings['block_posts_limit'] = 5;
  $settings['block_posts_loadmore'] = false;
  $settings['block_fullwidth'] = false;

  inhype_posts_block_renderer('showcase1', $settings);

}
endif;

/**
 * Showcase 2 block display
 */
if(!function_exists('inhype_block_showcase2_display')):
function inhype_block_showcase2_display($settings = array()) {

  $settings['block_posts_limit'] = 5;
  $settings['block_posts_loadmore'] = false;
  $settings['block_fullwidth'] = false;

  inhype_posts_block_renderer('showcase2', $settings);

}
endif;

/**
 * Showcase 3 block display
 */
if(!function_exists('inhype_block_showcase3_display')):
function inhype_block_showcase3_display($settings = array()) {

  $settings['block_posts_limit'] = 6;
  $settings['block_posts_loadmore'] = false;

  inhype_posts_block_renderer('showcase3', $settings);

}
endif;

/**
 * Showcase 4 block display
 */
if(!function_exists('inhype_block_showcase4_display')):
function inhype_block_showcase4_display($settings = array()) {

  $settings['block_posts_limit'] = 3;
  $settings['block_posts_loadmore'] = false;
  $settings['block_fullwidth'] = false;

  inhype_posts_block_renderer('showcase4', $settings);

}
endif;

/**
 * Showcase 5 block display
 */
if(!function_exists('inhype_block_showcase5_display')):
function inhype_block_showcase5_display($settings = array()) {

  $settings['block_posts_limit'] = 5;
  $settings['block_posts_loadmore'] = false;

  inhype_posts_block_renderer('showcase5', $settings);

}
endif;

/**
 * Showcase 6 block display
 */
if(!function_exists('inhype_block_showcase6_display')):
function inhype_block_showcase6_display($settings = array()) {

  $settings['block_posts_limit'] = 9;
  $settings['block_posts_loadmore'] = false;

  inhype_posts_block_renderer('showcase6', $settings);

}
endif;

/**
 * Showcase 7 block display
 */
if(!function_exists('inhype_block_showcase7_display')):
function inhype_block_showcase7_display($settings = array()) {

  $settings['block_posts_limit'] = 3;
  $settings['block_posts_loadmore'] = false;

  inhype_posts_block_renderer('showcase7', $settings);

}
endif;

/**
 * Showcase 8 block display
 */
if(!function_exists('inhype_block_showcase8_display')):
function inhype_block_showcase8_display($settings = array()) {

  $settings['block_posts_limit'] = 2;
  $settings['block_posts_loadmore'] = false;

  inhype_posts_block_renderer('showcase8', $settings);

}
endif;

/**
 * Showcase 9 block display
 */
if(!function_exists('inhype_block_showcase9_display')):
function inhype_block_showcase9_display($settings = array()) {

  $settings['block_posts_limit'] = 4;
  $settings['block_posts_loadmore'] = false;

  inhype_posts_block_renderer('showcase9', $settings);

}
endif;

/**
 * Large Posts Slider block display
 */
if(!function_exists('inhype_block_largepostsslider_display')):
function inhype_block_largepostsslider_display($settings = array()) {

  $args = inhype_get_wpquery_args($settings);

  $posts_query = new WP_Query;
  $posts = $posts_query->query($args);

  $total_posts = count($posts);

  if($posts_query->have_posts()) {

    $unique_block_id = rand(10000, 900000);
    ?>
    <div class="inhype-largepostsslider-block-wrapper">
      <div class="container">
        <div class="row">
          <div class="inhype-largepostsslider-block inhype-largepostsslider-block-<?php echo esc_attr($unique_block_id); ?> inhype-block">
            <div class="owl-carousel">
            <?php
            while ($posts_query->have_posts()) {
              $posts_query->the_post();

              echo '<div class="col-md-12">';

              get_template_part( 'inc/templates/post/content', 'overlay-short' );

              echo '</div>';
            }
            wp_reset_postdata();
            ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      if($total_posts > 1) {
        wp_add_inline_script( 'inhype-script', '(function($){
        $(document).ready(function() {

            var owlpostslider = $(".inhype-largepostsslider-block.inhype-largepostsslider-block-'.esc_js($unique_block_id).' .owl-carousel").owlCarousel({
                loop: true,
                items: 1,
                autoplay: true,
                autowidth: false,
                autoplaySpeed: 1000,
                navSpeed: 5000,
                nav: false,
                dots: false,
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

            AOS.refresh();

        });})(jQuery);');
      } else {
        wp_add_inline_script( 'inhype-script', '(function($){
            $(document).ready(function() {

              "use strict";

               $(".inhype-largepostsslider-block.inhype-largepostsslider-block-'.esc_js($unique_block_id).' .owl-carousel").show();

               AOS.refresh();

            });})(jQuery);');
      }

    } // have_posts

    wp_reset_postdata();

}
endif;

/**
 * Large Fullwidth Posts Slider block display
 */
if(!function_exists('inhype_block_largefullwidthpostsslider_display')):
function inhype_block_largefullwidthpostsslider_display($settings = array()) {

  $args = inhype_get_wpquery_args($settings);

  $posts_query = new WP_Query;
  $posts = $posts_query->query($args);

  $total_posts = count($posts);

  if($posts_query->have_posts()) {

    $unique_block_id = rand(10000, 900000);
    ?>
    <div class="inhype-largepostsslider-block-wrapper inhype-largefullwidthpostsslider-block-wrapper">
      <div class="container-fullwidth">
        <div class="row">
          <div class="inhype-largepostsslider-block inhype-largepostsslider-block-<?php echo esc_attr($unique_block_id); ?> inhype-block">
            <div class="owl-carousel">
            <?php
            while ($posts_query->have_posts()) {
              $posts_query->the_post();

              echo '<div class="col-md-12">';

              get_template_part( 'inc/templates/post/content', 'overlay-short' );

              echo '</div>';
            }
            wp_reset_postdata();
            ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      if($total_posts > 1) {
        wp_add_inline_script( 'inhype-script', '(function($){
        $(document).ready(function() {

            var owlpostslider = $(".inhype-largepostsslider-block.inhype-largepostsslider-block-'.esc_js($unique_block_id).' .owl-carousel").owlCarousel({
                loop: true,
                items: 1,
                autoplay: true,
                autowidth: false,
                autoplaySpeed: 1000,
                navSpeed: 5000,
                nav: false,
                dots: false,
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

            AOS.refresh();

        });})(jQuery);');
      } else {
        wp_add_inline_script( 'inhype-script', '(function($){
            $(document).ready(function() {

              "use strict";

               $(".inhype-largepostsslider-block.inhype-largepostsslider-block-'.esc_js($unique_block_id).' .owl-carousel").show();

               AOS.refresh();

            });})(jQuery);');
      }

    } // have_posts

    wp_reset_postdata();

}
endif;

/**
 * Posts Carousel block display
 */
if(!function_exists('inhype_block_carousel_display')):
function inhype_block_carousel_display($settings = array()) {

  $args = inhype_get_wpquery_args($settings);

  $posts_query = new WP_Query;
  $posts = $posts_query->query($args);

  $total_posts = count($posts);

  if($posts_query->have_posts()) {

    $unique_block_id = rand(10000, 900000);
    ?>
    <div class="inhype-carousel-block-wrapper inhype-block">
      <?php
      if(!empty($settings['block_title'])) {
        echo '<div class="container container-title">';
        echo '<div class="row">';
        echo '<div class="inhype-block-title">';
        echo '<h3>'.esc_html($settings['block_title']).'</h3>';
        if(!empty($settings['block_subtitle'])) {
          echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
        }
        echo '</div>';
        if(!empty($settings['block_description'])) {
          echo '<div class="inhype-block-description">'.do_shortcode($settings['block_description']).'</div>';
        }
        echo '</div>';
        echo '</div>';
      }
      ?>
      <div class="container container-content">
        <div class="row">
          <div class="inhype-carousel-block inhype-carousel-block-<?php echo esc_attr($unique_block_id); ?> inhype-block">
            <div class="inhype-carousel-block-inside">
              <div class="owl-carousel">
              <?php
              while ($posts_query->have_posts()) {
                $posts_query->the_post();

                get_template_part( 'inc/templates/post/content', 'grid-short' );

              }
              wp_reset_postdata();
              ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      if($total_posts > 1) {
        wp_add_inline_script( 'inhype-script', '(function($){
        $(document).ready(function() {

            var owlpostslider = $(".inhype-carousel-block.inhype-carousel-block-'.esc_js($unique_block_id).' .owl-carousel").owlCarousel({
                loop: true,
                items: 4,
                autoplay: true,
                autowidth: false,
                autoplaySpeed: 500,
                navSpeed: 500,
                margin: 30,
                nav: false,
                dots: false,
                navText: false,
                slideBy: 4,
                responsive: {
                    1199:{
                        items:4,
                        slideBy: 4
                    },
                    979:{
                        items:4,
                        slideBy: 4
                    },
                    768:{
                        items:2,
                        slideBy: 1
                    },
                    479:{
                        items:1,
                        slideBy: 1
                    },
                    0:{
                        items:1,
                        slideBy: 1
                    }
                }
            });

            AOS.refresh();

        });})(jQuery);');
      } else {
        wp_add_inline_script( 'inhype-script', '(function($){
            $(document).ready(function() {

              "use strict";

               $(".inhype-carousel-block.inhype-carousel-block-'.esc_js($unique_block_id).' .owl-carousel").show();

               AOS.refresh();

            });})(jQuery);');
      }

    } // have_posts

    wp_reset_postdata();

}
endif;

/**
 * Posts Carousel 2 block display
 */
if(!function_exists('inhype_block_carousel2_display')):
function inhype_block_carousel2_display($settings = array()) {

  $args = inhype_get_wpquery_args($settings);

  $posts_query = new WP_Query;
  $posts = $posts_query->query($args);

  $total_posts = count($posts);

  if($posts_query->have_posts()) {

    $unique_block_id = rand(10000, 900000);
    ?>
    <div class="inhype-carousel2-block-wrapper inhype-block">
      <?php
      if(!empty($settings['block_title'])) {
        echo '<div class="container container-title">';
        echo '<div class="row">';
        echo '<div class="inhype-block-title">';
        echo '<h3>'.esc_html($settings['block_title']).'</h3>';
        if(!empty($settings['block_subtitle'])) {
          echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
        }
        echo '</div>';
        if(!empty($settings['block_description'])) {
          echo '<div class="inhype-block-description">'.do_shortcode($settings['block_description']).'</div>';
        }
        echo '</div>';
        echo '</div>';
      }
      ?>
      <div class="container container-content">
        <div class="row">
          <div class="inhype-carousel-block inhype-carousel-block-<?php echo esc_attr($unique_block_id); ?> inhype-block">
            <div class="inhype-carousel-block-inside">
              <div class="owl-carousel">
              <?php
              while ($posts_query->have_posts()) {
                $posts_query->the_post();

                get_template_part( 'inc/templates/post/content', 'overlay-short' );

              }
              wp_reset_postdata();
              ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      if($total_posts > 1) {
        wp_add_inline_script( 'inhype-script', '(function($){
        $(document).ready(function() {

            var owlpostslider = $(".inhype-carousel-block.inhype-carousel-block-'.esc_js($unique_block_id).' .owl-carousel").owlCarousel({
                loop: true,
                items: 5,
                autoplay: true,
                autowidth: false,
                autoplaySpeed: 500,
                navSpeed: 500,
                margin: 0,
                nav: false,
                dots: false,
                navText: false,
                slideBy: 1,
                responsive: {
                    1199:{
                        items: 5,
                        slideBy: 1
                    },
                    979:{
                        items: 3,
                        slideBy: 1
                    },
                    768:{
                        items:2,
                        slideBy: 1
                    },
                    479:{
                        items:1,
                        slideBy: 1
                    },
                    0:{
                        items:1,
                        slideBy: 1
                    }
                }
            });

            AOS.refresh();

        });})(jQuery);');
      } else {
        wp_add_inline_script( 'inhype-script', '(function($){
            $(document).ready(function() {

              "use strict";

               $(".inhype-carousel-block.inhype-carousel-block-'.esc_js($unique_block_id).' .owl-carousel").show();

               AOS.refresh();

            });})(jQuery);');
      }

    } // have_posts

    wp_reset_postdata();

}
endif;

/**
 * Fullwidth Posts Slider block display
 */
if(!function_exists('inhype_block_fullwidthpostsslider_display')):
function inhype_block_fullwidthpostsslider_display($settings = array()) {

  $settings['block_posts_limit'] = 3;
  $args = inhype_get_wpquery_args($settings);

  $posts_query = new WP_Query;
  $posts = $posts_query->query($args);

  $total_posts = count($posts);

  if($posts_query->have_posts()) {

    $unique_block_id = rand(10000, 900000);
    ?>
    <div class="inhype-fullwidthpostsslider-block-wrapper inhype-fullwidthpostsslider-block-wrapper-<?php echo esc_attr($unique_block_id); ?> inhype-block">
      <?php
      if(!empty($settings['block_title'])) {
        echo '<div class="container container-title">';
        echo '<div class="row">';
        echo '<div class="inhype-block-title">';
        echo '<h3>'.esc_html($settings['block_title']).'</h3>';
        if(!empty($settings['block_subtitle'])) {
          echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
        }
        echo '</div>';
        if(!empty($settings['block_description'])) {
          echo '<div class="inhype-block-description">'.do_shortcode($settings['block_description']).'</div>';
        }
        echo '</div>';
        echo '</div>';
      }
      ?>
      <div class="container-fluid">
        <div class="row">
          <div class="inhype-fullwidthpostsslider-block inhype-fullwidthpostsslider-block-<?php echo esc_attr($unique_block_id); ?> inhype-block">
            <div class="owl-carousel">
            <?php
            while ($posts_query->have_posts()) {
              $posts_query->the_post();

              echo '<div class="col-md-12">';

              get_template_part( 'inc/templates/post/content', 'overlay-fullwidth-slider' );

              echo '</div>';
            }
            wp_reset_postdata();
            ?>
            </div>
          </div>
        </div>
      </div>
      <div class="inhype-fullwidthpostsslider-block-pagination">
          <?php
          $i = 0;
          while ($posts_query->have_posts()) {
            $i++;
            $posts_query->the_post();

            $is_active = ($i == 1) ? ' active' : '';

            echo '<div class="inhype-fullwidthpostsslider-page inhype-fullwidthpostsslider-page-'.esc_attr($i).$is_active.'" data-id="'.esc_attr($i).'">';

            echo '<div class="inhype-fullwidthpostsslider-page-id">0'.esc_html($i).'</div>';
            echo '<h4 class="post-title">'.wp_kses_post(get_the_title()).'</h4>';

            echo '</div>';
          }
          wp_reset_postdata();
          ?>
      </div>
    </div>
    <?php
      if($total_posts > 1) {
        wp_add_inline_script( 'inhype-script', '(function($){
        $(document).ready(function() {

            "use strict";

            var owlpostslider = $(".inhype-fullwidthpostsslider-block.inhype-fullwidthpostsslider-block-'.esc_js($unique_block_id).' .owl-carousel").owlCarousel({
                loop: true,
                items: 1,
                autoplay: true,
                autowidth: false,
                autoplaySpeed: 1000,
                navSpeed: 1000,
                nav: true,
                slideBy: "page",
                dots: false,
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

            owlpostslider.on("changed.owl.carousel", function(event) {

              var current_slide = event.item.index-1;
              if(current_slide == 4) {
                current_slide = 1;
              }

              $(".inhype-fullwidthpostsslider-block-wrapper.inhype-fullwidthpostsslider-block-wrapper-'.esc_js($unique_block_id).' .inhype-fullwidthpostsslider-block-pagination .inhype-fullwidthpostsslider-page").removeClass("active");

              $(".inhype-fullwidthpostsslider-block-wrapper.inhype-fullwidthpostsslider-block-wrapper-'.esc_js($unique_block_id).' .inhype-fullwidthpostsslider-block-pagination .inhype-fullwidthpostsslider-page.inhype-fullwidthpostsslider-page-"+current_slide).addClass("active");

            });

            $(".inhype-fullwidthpostsslider-block-wrapper.inhype-fullwidthpostsslider-block-wrapper-'.esc_js($unique_block_id).' .inhype-fullwidthpostsslider-block-pagination .inhype-fullwidthpostsslider-page").on("click", function(e){

                owlpostslider.trigger("to.owl.carousel", $(this).data("id") - 1);

            });

            $(".inhype-fullwidthpostsslider-block-wrapper.inhype-fullwidthpostsslider-block-wrapper-'.esc_js($unique_block_id).' .inhype-fullwidthpostsslider-block-pagination").addClass("show-flex");

            AOS.refresh();

        });})(jQuery);');
      } else {
        wp_add_inline_script( 'inhype-script', '(function($){
            $(document).ready(function() {

               "use strict";

               $(".inhype-fullwidthpostsslider-block.inhype-fullwidthpostsslider-block-'.esc_js($unique_block_id).' .owl-carousel").show();

               AOS.refresh();

            });})(jQuery);');
      }

    } // have_posts

}
endif;

/**
 * Post Highlight block display
 */
if(!function_exists('inhype_block_posthighlight_display')):
function inhype_block_posthighlight_display($settings = array()) {

  $args = inhype_get_wpquery_args($settings);

  $posts_query = new WP_Query;
  $posts = $posts_query->query($args);

  $total_posts = $posts_query->post_count;

  if($posts_query->have_posts()) {

    $unique_block_id = rand(10000, 900000);
    ?>
    <div class="inhype-posthighlight-block-wrapper inhype-block">
      <div class="container">
        <div class="row">
          <div class="inhype-posthighlight-block inhype-posthighlight-block-<?php echo esc_attr($unique_block_id); ?> inhype-block owl-carousel">
            <?php
            while ($posts_query->have_posts()) {

              $posts_query->the_post();

              $post = get_post();

              if (has_post_thumbnail($post->ID)) {
                  $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'inhype-blog-thumb-grid');
                  $image_bg ='background-image: url('.esc_url($image[0]).');';
                  $block_class = 'with-image';
              } else {
                  $image_bg = '';
                  $block_class = 'no-image';
              }

              $current_post_format = get_post_format($post->ID) ? get_post_format($post->ID) : 'standard';
              $post_format_icon = '';

              if (in_array($current_post_format, inhype_get_mediaformats())) {
                  $post_format_icon = '<div class="inhype-post-format-icon"></div>';
              }

              echo '<div class="inhype-posthighlight-slide '.esc_attr($block_class).'">';

              echo '<div class="col-md-6 inhype-posthighlight-block-left">';

              if(!empty($settings['block_title'])) {
                echo '<div class="inhype-block-title">';
                echo '<h3>'.esc_html($settings['block_title']).'</h3>';
                if(!empty($settings['block_subtitle'])) {
                  echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
                }
                echo '</div>';
              }

              get_template_part( 'inc/templates/post/content', 'text-large' );

              echo '</div>';

              echo '<div class="col-md-6 inhype-posthighlight-block-right">';

              get_template_part( 'inc/templates/post/content', 'image' );

              echo '</div>';

              echo '</div>';
            }
            wp_reset_postdata();

            if($total_posts > 1) {
              wp_add_inline_script( 'inhype-script', '(function($){
              $(document).ready(function() {

                  "use strict";

                  var owlpostslider = $(".inhype-posthighlight-block.inhype-posthighlight-block-'.esc_js($unique_block_id).'.owl-carousel").owlCarousel({
                      loop: true,
                      items: 1,
                      autoplay: true,
                      autowidth: false,
                      autoplaySpeed: 1000,
                      navSpeed: 1000,
                      nav: true,
                      dots: false,
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

                  AOS.refresh();

              });})(jQuery);');
            } else {
              wp_add_inline_script( 'inhype-script', '(function($){
                  $(document).ready(function() {

                     "use strict";

                     $(".inhype-posthighlight-block.inhype-posthighlight-block-'.esc_js($unique_block_id).'.owl-carousel").show();

                     AOS.refresh();

                  });})(jQuery);');
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <?php

    } // have_posts

}
endif;

/**
 * Post Highlight 2 block display
 */
if(!function_exists('inhype_block_posthighlight2_display')):
function inhype_block_posthighlight2_display($settings = array()) {

  $args = inhype_get_wpquery_args($settings);

  $posts_query = new WP_Query;
  $posts = $posts_query->query($args);

  $total_posts = $posts_query->post_count;

  if($posts_query->have_posts()) {

    $unique_block_id = rand(10000, 900000);
    ?>
    <div class="inhype-posthighlight2-block-wrapper inhype-posthighlight-block-wrapper inhype-block">
      <div class="container">
        <div class="row">
          <div class="inhype-posthighlight-block inhype-posthighlight-block-<?php echo esc_attr($unique_block_id); ?> inhype-block owl-carousel">
            <?php
            while ($posts_query->have_posts()) {

              $posts_query->the_post();

              $post = get_post();

              if (has_post_thumbnail($post->ID)) {
                  $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'inhype-blog-thumb-grid');
                  $image_bg ='background-image: url('.esc_url($image[0]).');';
                  $block_class = 'with-image';
              } else {
                  $image_bg = '';
                  $block_class = 'no-image';
              }

              $current_post_format = get_post_format($post->ID) ? get_post_format($post->ID) : 'standard';
              $post_format_icon = '';

              if (in_array($current_post_format, inhype_get_mediaformats())) {
                  $post_format_icon = '<div class="inhype-post-format-icon"></div>';
              }

              echo '<div class="inhype-posthighlight-slide '.esc_attr($block_class).'">';

              echo '<div class="col-md-6 inhype-posthighlight-block-left">';

              if(!empty($settings['block_title'])) {
                echo '<div class="inhype-block-title">';
                echo '<h3>'.esc_html($settings['block_title']).'</h3>';
                if(!empty($settings['block_subtitle'])) {
                  echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
                }
                echo '</div>';
              }

              get_template_part( 'inc/templates/post/content', 'text' );

              echo '</div>';

              echo '<div class="col-md-6 inhype-posthighlight-block-right">';

              get_template_part( 'inc/templates/post/content', 'image' );

              echo '</div>';

              echo '</div>';
            }
            wp_reset_postdata();

            if($total_posts > 1) {
              wp_add_inline_script( 'inhype-script', '(function($){
              $(document).ready(function() {

                  "use strict";

                  var owlpostslider = $(".inhype-posthighlight-block.inhype-posthighlight-block-'.esc_js($unique_block_id).'.owl-carousel").owlCarousel({
                      loop: true,
                      items: 1,
                      autoplay: true,
                      autowidth: false,
                      autoplaySpeed: 1000,
                      navSpeed: 1000,
                      nav: true,
                      dots: false,
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

                  AOS.refresh();

              });})(jQuery);');
            } else {
              wp_add_inline_script( 'inhype-script', '(function($){
                  $(document).ready(function() {

                     "use strict";

                     $(".inhype-posthighlight-block.inhype-posthighlight-block-'.esc_js($unique_block_id).'.owl-carousel").show();

                     AOS.refresh();

                  });})(jQuery);');
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <?php

    } // have_posts

}
endif;

/**
 * Content block display
 */
if(!function_exists('inhype_block_html_display')):
function inhype_block_html_display($settings = array()) {
  ?>
  <div class="container html-block-container inhype-block"<?php inhype_add_aos(); ?>>
    <div class="row">
      <?php
      if(!empty($settings['block_title'])) {
        echo '<div class="inhype-block-title">';
        echo '<h3>'.esc_html($settings['block_title']).'</h3>';
        if(!empty($settings['block_subtitle'])) {
          echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
        }
        echo '</div>';
      }
      ?>
      <div class="col-md-12 html-block"><?php echo do_shortcode($settings['block_html']); ?></div>
    </div>
  </div>
  <?php
}
endif;

/**
 * Blog listing display
 */
if(!function_exists('inhype_block_blog_display')):
function inhype_block_blog_display($settings = array()) {

  $blog_sidebarposition = get_theme_mod('sidebar_blog', 'right');

  // Demo settings
  if ( defined('DEMO_MODE') && isset($_GET['blog_sidebar_position']) ) {
    $blog_sidebarposition = $_GET['blog_sidebar_position'];
  }

  if(is_active_sidebar( 'main-sidebar' ) && ($blog_sidebarposition !== 'disable') ) {
    $span_class = 'col-md-8';
    $is_sidebar = true;
  }
  else {
    $span_class = 'col-md-12';
    $is_sidebar = false;
  }

  // Blog layout
  $blog_layout = get_theme_mod('blog_layout', 'standard');

  if ( defined('DEMO_MODE') && isset($_GET['blog_layout']) ) {
      $blog_layout = $_GET['blog_layout'];
  }

  // Load masonry layout script
  if($blog_layout == 'masonry') {

    wp_enqueue_script('masonry');
    wp_add_inline_script( 'masonry', '(function($){
  $(document).ready(function() {
    "use strict";
    $(window).load(function()
    {
      var $container = $(".blog-layout-masonry");

      $container.imagesLoaded(function(){
        $container.masonry({
          itemSelector : ".blog-layout-masonry .blog-post"
        });

      });

      AOS.refresh();
    });

  });})(jQuery);');

  }

  ?>
  <div class="inhype-blog-block-wrapper page-container container">
    <div class="row">
      <?php if ( is_active_sidebar( 'main-sidebar' ) && ( $blog_sidebarposition == 'left')) : ?>
      <div class="col-md-4 main-sidebar sidebar sidebar-left"<?php inhype_add_aos(true);?> role="complementary">
      <ul id="main-sidebar">
        <?php dynamic_sidebar( 'main-sidebar' ); ?>
      </ul>
      </div>
      <?php endif; ?>

      <div class="<?php echo esc_attr($span_class);?>">
      <?php
      if(!empty($settings['block_title'])) {
        echo '<div class="inhype-blog-block-title-wrapper inhype-block">';
        echo '<div class="inhype-block-title">';
        echo '<h3>'.esc_html($settings['block_title']).'</h3>';
        if(!empty($settings['block_subtitle'])) {
          echo '<h4>'.esc_html($settings['block_subtitle']).'</h4>';
        }
        echo '</div>';
        if(!empty($settings['block_description'])) {
          echo '<div class="inhype-block-description">'.do_shortcode($settings['block_description']).'</div>';
        }
        echo '</div>';
      }
      ?>
      <div class="blog-posts-list blog-layout-<?php echo esc_attr($blog_layout);?><?php echo esc_attr(inhype_get_blog_col_class($blog_layout, $is_sidebar));?>" id="content">
      <?php

      // Blog listing settings
      $settings['block_posts_limit'] = get_option( 'posts_per_page' );
      $settings['block_posts_type'] = 'latest';

      $args = inhype_get_wpquery_args($settings);

      $posts_query = new WP_Query;
      $posts = $posts_query->query($args);

      $wp_query = $posts_query;

      ?>
      <?php if ( have_posts() ) : ?>

        <?php /* Start the Loop */
        $post_loop_id = 1;
        ?>
        <?php while ( have_posts() ) : the_post(); ?>

        <?php
          $post_loop_details['post_loop_id'] = $post_loop_id;
          $post_loop_details['span_class'] = $span_class;

          inhype_set_post_details($post_loop_details);

          get_template_part( 'content', get_post_format() );

          $post_loop_id++;
        ?>

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>

      <?php else : ?>

        <?php get_template_part( 'no-results', 'index' ); ?>

      <?php endif; ?>
      </div>

      <?php
      // Load more
      if ( $wp_query->max_num_pages > 1 && isset($settings['block_posts_loadmore']) && $settings['block_posts_loadmore'] == 'yes' && $blog_layout !== 'masonry' && !is_paged() ) {
        echo '<div class="col-md-12 inhype-block-button"'.inhype_add_aos(false).'><a href="#" class="btn btn-load-more">'.esc_html__('Load more', 'inhype').'</a></div>';
      } else {
        inhype_content_nav( 'nav-below' );
      }
      ?>

      <?php
      // Post Loops Bottom Banner
      inhype_banner_display('posts_loop_bottom');
      ?>

      </div>

      <?php if ( is_active_sidebar( 'main-sidebar' ) && ( $blog_sidebarposition == 'right')) : ?>
      <div class="col-md-4 main-sidebar sidebar sidebar-right"<?php inhype_add_aos(true);?> role="complementary">
      <ul id="main-sidebar">
        <?php dynamic_sidebar( 'main-sidebar' ); ?>
      </ul>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php

  // Load more JS script
  if ( $wp_query->max_num_pages > 1 && isset($settings['block_posts_loadmore']) && $settings['block_posts_loadmore'] == 'yes' ) {

    $post_template = 'blog';

    wp_add_inline_script( 'inhype-script', "(function($){
    $(document).ready(function() {
        'use strict';

        var current_page = 1;

        $('.blog-posts-list + .inhype-block-button .btn-load-more').on('click', function(e){

          e.preventDefault();
          e.stopPropagation();

          var button = $(this),
              data = {
              'action': 'inhype_loadmore',
              'query': ".json_encode( $wp_query->query_vars , true).",
              'page' : current_page,
              'block' : 'blog',
              'post_template' : '".esc_js($post_template)."'
          };

          var button_default_text = button.text();

          $.ajax({
              url : '".esc_url(site_url())."/wp-admin/admin-ajax.php', // AJAX handler
              data : data,
              type : 'POST',
              beforeSend : function ( xhr ) {
                  button.text('".esc_html__('Loading...', 'inhype')."');
                  button.addClass('btn-loading');
              },
              success : function( data ){
                  if( data ) {
                      button.text( button_default_text );
                      button.removeClass('btn-loading');

                      // Insert new posts
                      $('.blog-posts-list').append(data);

                      // Show images
                      $('.blog-posts-list .inhype-post-image').each(function( index ) {
                        $(this).attr('style', ($(this).attr('data-style')));
                      });

                      // Show categories colors
                      $('.blog-posts-list .inhype-post .post-categories .cat-dot').each(function( index ) {
                        $(this).attr('style', ($(this).attr('data-style')));
                      });

                      // Show rating badges
                      $('.blog-posts-list .inhype-post .post-review-rating-badge').each(function( index ) {
                        $(this).attr('style', ($(this).attr('data-style')));
                      });

                      current_page++;

                      if ( current_page == ".esc_js($wp_query->max_num_pages)." )
                          button.parent().remove(); // if last page, remove the button

                  } else {
                      button.parent().remove(); // if no data, remove the button
                  }
              }
          });
        });

    });})(jQuery);");

}
}
endif;
