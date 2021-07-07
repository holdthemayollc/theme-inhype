<?php
/**
 * Theme Sidebars
 */

if(!function_exists('inhype_sidebars_init')):
function inhype_sidebars_init() {

    register_sidebar(
      array(
        'name' => esc_html__( 'Default Blog sidebar', 'inhype' ),
        'id' => 'main-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in the left or right site column on: Main Blog page, Archives, Search.', 'inhype' )
      )
    );

    register_sidebar(
      array(
        'name' => esc_html__( 'Single Blog Post sidebar', 'inhype' ),
        'id' => 'post-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in the left or right site column on: Single Blog Post.', 'inhype' )
      )
    );

    register_sidebar(
      array(
        'name' => esc_html__( 'Page sidebar', 'inhype' ),
        'id' => 'page-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in the left or right site column on: Page.', 'inhype' )
      )
    );

    register_sidebar(
      array(
        'name' => esc_html__( 'WooCommerce sidebar', 'inhype' ),
        'id' => 'woocommerce-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in the left or right site column for woocommerce pages.', 'inhype' )
      )
    );

    register_sidebar(
      array(
        'name' => esc_html__( 'WooCommerce product sidebar', 'inhype' ),
        'id' => 'woocommerce-product-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in the left or right site column for woocommerce single product pages.', 'inhype' )
      )
    );

    register_sidebar(
      array(
        'name' => esc_html__( 'Footer sidebar #1', 'inhype' ),
        'id' => 'footer-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in site footer in 4 columns.', 'inhype' )
      )
    );

    register_sidebar(
      array(
        'name' => esc_html__( 'Footer sidebar #2', 'inhype' ),
        'id' => 'footer-sidebar-2',
        'description' => esc_html__( 'Widgets in this area will be shown in site footer in 4 column after Footer sidebar #1.', 'inhype' )
      )
    );

    // Mega Menu sidebars
    if(get_theme_mod('module_megamenu_sidebars', 1) > 0) {
        for ($i = 1; $i <= get_theme_mod('module_megamenu_sidebars', 1); $i++) {
            register_sidebar(
              array(
                'name' => esc_html__( 'Mega Menu sidebar #', 'inhype' ).$i,
                'id' => 'megamenu_sidebar_'.$i,
                'description' => esc_html__( 'You can use this sidebar to display widgets inside megamenu items in menus.', 'inhype' )
              )
            );
        }
    }

}
endif;
add_action( 'widgets_init', 'inhype_sidebars_init' );
