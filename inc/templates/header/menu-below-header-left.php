<?php
/**
 * Header template part: Header with menu below header
 */

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">

      <div class="header-left">
        <?php
        // Show header logo
        inhype_logo_display();
        ?>
      </div>

      <div class="header-center">
      <?php
      // Header search
      if(get_theme_mod('search_position', 'header') !== 'disable' && !(get_theme_mod('header_center_custom', false))):
      ?>
      <div class="search-toggle-wrapper search-<?php echo esc_attr(get_theme_mod('search_position', 'header')); ?>">
        <a class="search-toggle-btn" aria-label="<?php echo esc_attr__('Search toggle', 'inhype'); ?>"><i class="fa fa-search" aria-hidden="true"></i></a>
        <div class="header-center-search-form">
          <?php get_template_part( 'searchform-block' ); ?>
        </div>
      </div>
      <?php endif; ?>
      <?php
      // Custom content
      inhype_header_center_custom_display();
      ?>
      </div>

      <div class="header-right">
        <?php
        // Show social
        if(get_theme_mod('header_socialicons', true)) {
            inhype_social_display(false, 5);
        }
        ?>
        <?php
        // Header search
        if(get_theme_mod('search_position', 'header') !== 'disable' && (get_theme_mod('header_center_custom', false))):
        ?>
        <div class="search-toggle-wrapper search-<?php echo esc_attr(get_theme_mod('search_position', 'header')); ?>">
          <a class="search-toggle-btn" aria-label="<?php echo esc_attr__('Search toggle', 'inhype'); ?>"><i class="fa fa-search" aria-hidden="true"></i></a>
          <div class="header-center-search-form">
            <?php get_template_part( 'searchform-block' ); ?>
          </div>
        </div>
        <?php endif; ?>
        <?php if (get_theme_mod('header_cart', false) && class_exists('Woocommerce')): ?>
        <div class="woocommerce-mini-cart">
        <?php
        // Show cart dropdown
        $cart_display = inhype_woocommerce_header_add_to_cart_fragment();

        echo wp_kses_post($cart_display['#shopping-cart']);
        ?>
        </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
  <?php
  // Show mainmenu below header
  inhype_mainmenu_display();
  ?>
</div>
