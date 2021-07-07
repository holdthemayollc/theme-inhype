<?php
/**
 * Theme homepage WooCommerce blocks
 **/

/**
 * Homepage WooCommerce categories block display
 */
if(!function_exists('inhype_block_wccategories_display')):
function inhype_block_wccategories_display($settings = array()) {

    $categories = get_theme_mod('wc_featured_categories', array());
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

            $wc_category = get_term_by('id', $category, 'product_cat' );

            if(!empty($wc_category)) {

              $category_title = $wc_category->name;
              $category_link = get_term_link( (int) $category, 'product_cat' );
              $category_counter = $wc_category->count;

              $category_thumbnail_id = get_woocommerce_term_meta( $category, 'thumbnail_id', true );
              $category_image = wp_get_attachment_url( $category_thumbnail_id );

              if(!empty($category_image)) {
                  $category_style = 'background-image: url('.$category_image.');';
                  $add_class = ' with-bg';
              } else {
                  $category_style = '';
                  $add_class = ' without-bg';
              }

              echo '<div class="'.esc_attr($col_class).'">';
              echo '<div class="inhype-post">';

              echo '<div class="inhype-featured-category'.esc_attr($add_class).' inhype-image-wrapper" '.inhype_add_aos(false).' data-style="'.esc_attr($category_style).'">';

              echo '<div class="inhype-featured-category-overlay">';

              echo '<div class="inhype-featured-category-bg"></div>';

              echo '<div class="inhype-featured-category-counter">'.esc_html($category_counter).' '.esc_html__('Products', 'inhype').'</div>';

              echo '<div class="post-categories"><a href="'.esc_url($category_link).'" class="inhype-featured-category-link"><span class="cat-dot"></span><span class="cat-title">'.esc_html($category_title).'</span></a></div>';

              echo '<a class="btn btn-small btn-white" href="'.esc_url($category_link).'">'.esc_html__('View products', 'inhype').'</a>';

              echo '</div>';

              echo '</div>';

              echo '</div>';
              echo '</div>';


            }


        }

        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

}
endif;


/**
 * Helper function to render products blocks output
 */
if(!function_exists('inhype_wc_block_renderer')):
function inhype_wc_block_renderer($block_id = '', $settings = array()) {

        // Blocks with custom title position, disable regular title
        $custom_title = array();

        $args = inhype_get_wcquery_args($settings);

        $posts_query = new WP_Query;
        $posts = $posts_query->query($args);

        // Disable load more if specified offset
        if(!empty($settings['block_wc_offset'])) {
          $settings['block_wc_loadmore'] = 'no';
        }

        if($posts_query->have_posts()) {

              $unique_block_id = rand(10000, 900000);

              echo '<div class="inhype-wc-block-wrapper inhype-'.esc_attr($block_id).'-block-wrapper inhype-'.esc_attr($block_id).'-block-wrapper-'.esc_html($unique_block_id).' inhype-block">';

              if(!empty($settings['block_title']) && !in_array($block_id, $custom_title)) {
                echo '<div class="container container-title">';
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

              echo '<div class="container container-content">';
              echo '<div class="row">';

              $i = 0;
              $post_template = $block_id;

              while ($posts_query->have_posts()){
                  $posts_query->the_post();

                  $i++;

                  // Grid templates
                  if($block_id == 'wcgrid1') {

                    echo '<div class="'.esc_attr(inhype_get_wcgrid_col($block_id)).'">';

                    $post_template = 'grid';

                    get_template_part( 'inc/templates/product/content', $post_template );

                    echo '</div>';

                  }
              }
            }

            if (  $posts_query->max_num_pages > 1 && $settings['block_wc_loadmore'] == 'yes' ) {
              echo '<div class="col-md-12 inhype-block-button"'.inhype_add_aos(false).'><a href="#" class="btn btn-load-more">'.esc_html__('Load more', 'inhype').'</a></div>';
            }

            wp_reset_postdata();

            echo '</div>';
            echo '</div>';

            echo '</div>';

            // Load more JS script
            if (  $posts_query->max_num_pages > 1 && $settings['block_wc_loadmore'] == 'yes' ) {
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
                                $('.inhype-".esc_js($block_id)."-block-wrapper-".esc_js($unique_block_id)." .inhype-post .post-categories a').each(function( index ) {
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
 * WC Grid 1 block display
 */
if(!function_exists('inhype_block_wcgrid1_display')):
function inhype_block_wcgrid1_display($settings = array()) {

  inhype_wc_block_renderer('wcgrid1', $settings);

}
endif;

