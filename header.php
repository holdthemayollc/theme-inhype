<?php
/**
 * WP Theme Header
 *
 * Displays all of the <head> section
 *
 * @package InHype
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open ();?>

<?php inhype_topline_display(); ?>

<?php
// Blog Posts Slider
$show_slider = true;

if(get_theme_mod('slider_homepage', true) && is_front_page()) {
  $show_slider = true;
}
if(get_theme_mod('slider_homepage', true) && !is_front_page()) {
  $show_slider = false;
}

if($show_slider) {
  inhype_blog_slider_display();
}
?>

<?php inhype_top_display(); ?>

<?php
// Site Header Banner
inhype_banner_display('below_top_menu');
?>

<?php
// Disable header
if(get_theme_mod('header_disable', false) == false):
?>
<?php
// Header Banner
inhype_banner_display('header');

// Fixed menu
$header_add_class = '';

if(get_theme_mod('header_sticky', true)) {
  $header_add_class = ' sticky-header';
}

$header_add_class .= ' mainmenu-'.esc_html(get_theme_mod('mainmenu_style', 'light'));

// Header layout
$header_layout = get_theme_mod('header_layout', 'menu-in-header');
?>
<header class="main-header clearfix header-layout-<?php echo esc_attr($header_layout); ?><?php echo esc_attr($header_add_class); ?>">
<?php if(get_theme_mod('blog_post_reading_progress', false)): ?>
<div class="blog-post-reading-progress"></div>
<?php endif; ?>
<?php
// Header layout template
switch ($header_layout) {
  case 'menu-in-header':
    $header_layout_template = 'menu-in-header';
    break;
  case 'menu-below-header-left':
  case 'menu-below-header-left-border':
    $header_layout_template = 'menu-below-header-left';
    break;
  case 'menu-below-header-center':
  case 'menu-below-header-center-border':
    $header_layout_template = 'menu-below-header-center';
    break;
  case 'menu-below-header-left-border-fullwidth':
    $header_layout_template = 'menu-below-header-left-fullwidth';
    break;
  case 'menu-below-header-center-border-fullwidth':
    $header_layout_template = 'menu-below-header-center-fullwidth';
    break;
}

get_template_part( 'inc/templates/header/'.esc_attr($header_layout_template) );

?>
</header>
<?php endif; ?>
<?php
// Site Header Banner
inhype_banner_display('below_header');
?>
