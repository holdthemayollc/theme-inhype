<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package InHype
 */
?>
<?php
// Get page options
$page_sidebarposition = get_post_meta( get_the_ID(), '_inhype_page_sidebar_position', true );
$page_disable_title =  get_post_meta( get_the_ID(), '_inhype_page_disable_title', true );
$page_class = get_post_meta( get_the_ID(), '_inhype_page_css_class', true );
$page_header_width = get_post_meta( get_the_ID(), '_inhype_page_header_width', true );
$post_smallwidth = get_post_meta( get_the_ID(), '_inhype_post_smallwidth', true );

// Sidebar position
if(empty($page_sidebarposition)) {
  $page_sidebarposition = 0;
}

if($page_sidebarposition == "0") {
  $page_sidebarposition = get_theme_mod('sidebar_page', 'disable');
}

if(is_active_sidebar( 'page-sidebar' ) && ($page_sidebarposition !== 'disable')) {
  $span_class = 'col-md-8';

  inhype_set_content_width(750);
}
else {
  $span_class = 'col-md-12';

  if((get_theme_mod('blog_page_smallwidth', false) && $post_smallwidth != 0) || $post_smallwidth == 1) {
    inhype_set_content_width(850);
  }
}

// Header image
$header_background_image = get_post_meta( get_the_ID(), '_inhype_header_image', true );
$header_parallax = get_post_meta( get_the_ID(), '_inhype_header_parallax', true );

if(isset($header_background_image) && $header_background_image) {
  $header_background_image_style = 'background-image: url('.$header_background_image.');';
  $header_background_class = ' with-bg';

  if($header_parallax) {
    $header_background_class .= ' inhype-parallax';
  }

} else {
  $header_background_image_style = '';
  $header_background_class = '';
}

// Header width
if(!empty($page_header_width)) {
    $blog_page_header_width = $page_header_width;
} else {
    $blog_page_header_width = get_theme_mod('page_header_width', 'boxed');
}

if($blog_page_header_width == 'fullwidth') {
  $container_class = 'container-fluid';
} else {
  $container_class = 'container';
}
?>
<div class="content-block <?php echo esc_attr($page_class); ?>">
  <?php if(!$page_disable_title): ?>
  <div class="<?php echo esc_attr($container_class); ?> container-page-item-title<?php echo esc_attr($header_background_class); ?>" data-style="<?php echo esc_attr($header_background_image_style); ?>" data-speed="0.1">
    <div class="row">
      <div class="col-md-12 col-overlay">
        <div class="container">
          <div class="page-item-title-single page-item-title-page">
              <h1 class="page-title"><?php the_title(); ?></h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
  <div class="page-container container <?php echo esc_attr('span-'.$span_class); ?>">
    <div class="row">
      <?php if ( is_active_sidebar( 'page-sidebar' ) && ( $page_sidebarposition == 'left')) : ?>
      <div class="col-md-4 page-sidebar sidebar sidebar-left" role="complementary">
        <ul id="page-sidebar">
          <?php dynamic_sidebar( 'page-sidebar' ); ?>
        </ul>
      </div>
      <?php endif; ?>
			<div class="<?php echo esc_attr($span_class);?>">
      <div class="entry-content clearfix" role="main">
      <article>
				<?php the_content(); ?>
      <?php
        wp_link_pages( array(
          'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'inhype' ),
          'after'  => '</div>',
        ) );
      ?>
      </article>
      </div>
        <?php
        // If comments are open or we have at least one comment, load up the comment template
        if ( comments_open() || '0' != get_comments_number() )
            comments_template();
        ?>

			</div>
      <?php if ( is_active_sidebar( 'page-sidebar' ) && ( $page_sidebarposition == 'right')) : ?>
      <div class="col-md-4 page-sidebar sidebar sidebar-right" role="complementary">
        <ul id="page-sidebar">
          <?php dynamic_sidebar( 'page-sidebar' ); ?>
        </ul>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
