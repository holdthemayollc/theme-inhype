<?php
/**
 * Theme CSS cache generation
 */

	add_action( 'wp_enqueue_scripts', 'inhype_enqueue_dynamic_styles', '999' );
    add_action( 'admin_init', 'inhype_enqueue_editor_dynamic_styles', '999' );

    if(!function_exists('inhype_enqueue_editor_dynamic_styles')):
    function inhype_enqueue_editor_dynamic_styles( ) {
        // Fonts configuration for editor
        $headers_font = inhype_get_fonts_settings('headers_font');
        $body_font = inhype_get_fonts_settings('body_font');
        $additional_font = inhype_get_fonts_settings('additional_font');

        require_once(ABSPATH . 'wp-admin/includes/file.php'); // required to use WP_Filesystem();

        WP_Filesystem();

        global $wp_filesystem;

        $editor_cache_file_name = 'style-editor-cache-'.wp_get_theme()->get('TextDomain');

        $wp_upload_dir = wp_upload_dir();

        // Editor CSS cache files
        $css_editor_cache_file = $wp_upload_dir['basedir'].'/'.$editor_cache_file_name.'.css';
        $css_editor_cache_file_url = $wp_upload_dir['baseurl'].'/'.$editor_cache_file_name.'.css';

        $themeoptions_saved_date = get_option( 'themeoptions_saved_date', 1 );
        $editor_cache_saved_date = get_option( 'editor_cache_css_saved_date', 0 );

        // Check if editor CSS cache files exists
        if( file_exists( $css_editor_cache_file ) ) {
            $editor_cache_status = 'exist';

            if($themeoptions_saved_date > $editor_cache_saved_date) {
                $editor_cache_status = 'no-exist';
            }

        } else {
            $editor_cache_status = 'no-exist';
        }

        // FS_CHMOD_FILE required by WordPress guideliness - https://codex.wordpress.org/Filesystem_API#Using_the_WP_Filesystem_Base_Class
        if ( defined( 'FS_CHMOD_FILE' ) ) {
            $chmod_file = FS_CHMOD_FILE;
        } else {
            $chmod_file = ( 0644 & ~ umask() );
        }

        // Editor styles
        if ( $editor_cache_status !== 'exist' ) {

            $out = '/* Editor Cache file created at '.date('Y-m-d H:i:s').' */';

            $out .= '
                body {
                    font-family: "'.esc_attr($body_font['font-family']).'";
                    font-size: "'.esc_attr($body_font['font-size']).'";
                    color: "'.get_theme_mod('color_text', '#333333').'";
                }
                body p {
                    font-size: '.esc_attr($body_font['font-size']).';
                }
                h1,
                h2,
                h3,
                h4,
                h5,
                h6,
                blockquote,
                .wp-block-quote,
                .wp-block-quote:not(.is-large):not(.is-style-large),
                blockquote cite,
                .wp-block-quote .wp-block-quote__citation,
                .editor-post-title__block .editor-post-title__input {
                    font-family: "'.esc_attr($headers_font['font-family']).'";
                }
                .wp-block-button .wp-block-button__link {
                    font-family: "'.esc_attr($additional_font['font-family']).'";
                }
            ';

            // Small post width support
            if(get_theme_mod('blog_post_smallwidth', false)) {
                $out .= '.wp-block {
                    max-width: 880px;
                }
                ';
            }

            // Drop caps support
            if(get_theme_mod('blog_post_dropcaps', false)) {
                $out .= '.editor-block-list__layout.block-editor-block-list__layout > .wp-block.editor-block-list__block[data-type="core/paragraph"]:first-child p.rich-text.wp-block-paragraph:first-child:first-letter {
                    float: left;
                    font-size: 78px;
                    line-height: 60px;
                    padding-top: 10px;
                    padding-right: 10px;
                    padding-left: 0px;
                    font-weight: normal;
                    font-style: normal;
                }
                ';
            }

            $out = str_replace( array( "\t", "
", "\n", "  ", "   ", ), array( "", "", " ", " ", " ", ), $out );

            $wp_filesystem->put_contents( $css_editor_cache_file, $out, $chmod_file );

            // Update save options date
            $option_name = 'editor_cache_css_saved_date';

            $new_value = microtime(true) ;

            update_option( $option_name, $new_value, 'no' );
        }
    }
    endif;

    if(!function_exists('inhype_enqueue_dynamic_styles')):
	function inhype_enqueue_dynamic_styles( ) {

        // Fonts configuration for editor
        $headers_font = inhype_get_fonts_settings('headers_font');
        $body_font = inhype_get_fonts_settings('body_font');
        $additional_font = inhype_get_fonts_settings('additional_font');

        require_once(ABSPATH . 'wp-admin/includes/file.php'); // required to use WP_Filesystem();

        WP_Filesystem();

        global $wp_filesystem;

		if ( function_exists( 'is_multisite' ) && is_multisite() ){
            $cache_file_name = 'style-cache-'.wp_get_theme()->get('TextDomain').'-b' . get_current_blog_id();
        } else {
            $cache_file_name = 'style-cache-'.wp_get_theme()->get('TextDomain');
        }

        // Customizer preview
        if(is_customize_preview()) {
            if ( function_exists( 'is_multisite' ) && is_multisite() ){
                $cache_file_name = 'preview-cache-'.wp_get_theme()->get('TextDomain').'-b' . get_current_blog_id();
            } else {
                $cache_file_name = 'preview-cache-'.wp_get_theme()->get('TextDomain');
            }
        }

        $wp_upload_dir = wp_upload_dir();

        // Frontend CSS cache files
        $css_cache_file = $wp_upload_dir['basedir'].'/'.$cache_file_name.'.css';
        $css_cache_file_url = $wp_upload_dir['baseurl'].'/'.$cache_file_name.'.css';

        $themeoptions_saved_date = get_option( 'themeoptions_saved_date', 1 );
        $cache_saved_date = get_option( 'cache_css_saved_date', 0 );

        // Check if frontend cache files exists
		if( file_exists( $css_cache_file ) ) {
			$cache_status = 'exist';

            if($themeoptions_saved_date > $cache_saved_date) {
                $cache_status = 'no-exist';
            }

		} else {
			$cache_status = 'no-exist';
		}

        if ( defined('DEMO_MODE') ) {
            $cache_status = 'no-exist';
        }

        if(is_customize_preview()) {
            $cache_status = 'no-exist';
        }

        // FS_CHMOD_FILE required by WordPress guideliness - https://codex.wordpress.org/Filesystem_API#Using_the_WP_Filesystem_Base_Class
        if ( defined( 'FS_CHMOD_FILE' ) ) {
            $chmod_file = FS_CHMOD_FILE;
        } else {
            $chmod_file = ( 0644 & ~ umask() );
        }

        // Frontend styles
		if ( $cache_status == 'exist' ) {

			wp_register_style( $cache_file_name, $css_cache_file_url, array(), $cache_saved_date);
			wp_enqueue_style( $cache_file_name );

		} else {

			$out = '/* Cache file created at '.date('Y-m-d H:i:s').' */';

			$generated = microtime(true);

			$out .= inhype_get_css();

			$out = str_replace( array( "\t", "
", "\n", "  ", "   ", ), array( "", "", " ", " ", " ", ), $out );

			$out .= '/* CSS Generator Execution Time: ' . floatval( ( microtime(true) - $generated ) ) . ' seconds */';

			if ( $wp_filesystem->put_contents( $css_cache_file, $out, $chmod_file) ) {

				wp_register_style( $cache_file_name, $css_cache_file_url, array(), $cache_saved_date);
				wp_enqueue_style( $cache_file_name );

                // Update save options date
                update_option( 'cache_css_saved_date', microtime(true), 'no' );
			}

		}
	}
    endif;

    if(!function_exists('inhype_get_css')):
	function inhype_get_css() {

        // Fonts configuration for frontend
        $headers_font = inhype_get_fonts_settings('headers_font');
        $body_font = inhype_get_fonts_settings('body_font');
        $additional_font = inhype_get_fonts_settings('additional_font');

		// ===
		ob_start();
    ?>
    <?php
    // THEME OPTIONS DEFAULTS FOR CSS

    // Header height
    $header_height = get_theme_mod('header_height', 140);

    // Logo width
    $logo_width = get_theme_mod( 'logo_width', 162 );

    // Slider height
    $slider_height = get_theme_mod('slider_height', 420);

    // Main Menu paddings
    $mainmenu_paddings = get_theme_mod('mainmenu_paddings', '10px');

    // Top Menu paddings
    $topmenu_paddings = get_theme_mod('topmenu_paddings', '10px');

    // Thumbs height proportion
    $thumb_height_proportion = get_theme_mod('thumb_height_proportion', 64.8648);

    ?>
    header .col-md-12 {
        height: <?php echo esc_attr($header_height); ?>px;
    }
    .navbar .nav > li {
        padding-top: <?php echo esc_attr($mainmenu_paddings); ?>;
        padding-bottom: <?php echo esc_attr($mainmenu_paddings); ?>;
    }
    .nav > li > .sub-menu {
        margin-top: <?php echo esc_attr($mainmenu_paddings); ?>;
    }
    .header-menu li a,
    .header-menu .menu-top-menu-container-toggle {
        padding-top: <?php echo esc_attr($topmenu_paddings); ?>;
        padding-bottom: <?php echo esc_attr($topmenu_paddings); ?>;
    }
    .header-menu .menu-top-menu-container-toggle + div[class*="-container"] {
        top: calc(<?php echo esc_attr($topmenu_paddings); ?> + <?php echo esc_attr($topmenu_paddings); ?> + 15px);
    }
    <?php
    // Hide post dates
    if(get_theme_mod('blog_posts_date_hide', false)): ?>
    .inhype-post .post-date,
    .inhype-post .post-date + .post-info-dot,
    .sidebar .widget .post-date,
    .sidebar .widget .post-date + .post-info-dot {
        display: none;
    }
    <?php endif; ?>
    <?php
    // Retina logo
    ?>
    header .logo-link img {
        width: <?php echo esc_attr($logo_width); ?>px;
    }
    .inhype-blog-posts-slider .inhype-post {
        height: <?php echo esc_attr($slider_height); ?>px;
    }
    .inhype-blog-posts-slider {
        max-height: <?php echo esc_attr($slider_height); ?>px;
    }
    <?php
    // Transparent header adjustments
    ?>
    @media (min-width: 1024px)  {
        body.single-post.blog-post-header-with-bg.blog-post-transparent-header-enable .container-page-item-title.with-bg .page-item-title-single,
        body.page.blog-post-header-with-bg.blog-post-transparent-header-enable .container-page-item-title.with-bg .page-item-title-single {
            padding-top: <?php echo intval(120 + $header_height); ?>px;
        }
    }
    <?php
    // Thumb height
    ?>
    .inhype-post .inhype-post-image-wrapper {
        padding-bottom: <?php echo esc_attr($thumb_height_proportion); ?>%;
    }
    <?php
    // Header topline
    if(get_theme_mod('header_topline', false)):

    $header_topline_bgcolor_1 = get_theme_mod('header_topline_bgcolor_1', '#22334C');
    $header_topline_bgcolor_2 = get_theme_mod('header_topline_bgcolor_2', '#E58477');

    ?>
    .header-topline-wrapper {
        background-color: <?php echo esc_attr($header_topline_bgcolor_1); ?>;
        background: -moz-linear-gradient(left,  <?php echo esc_attr($header_topline_bgcolor_1); ?> 0%, <?php echo esc_attr($header_topline_bgcolor_2); ?> 100%);
        background: -webkit-linear-gradient(left,  <?php echo esc_attr($header_topline_bgcolor_1); ?> 0%, <?php echo esc_attr($header_topline_bgcolor_2); ?> 100%);
        background: linear-gradient(to right,  <?php echo esc_attr($header_topline_bgcolor_1); ?> 0%, <?php echo esc_attr($header_topline_bgcolor_2); ?> 100%);
    }
    <?php
    // Header topline background image
    $header_topline_background = get_theme_mod( 'header_topline_background', false );

    if(!empty($header_topline_background['background-image'])): ?>
    .header-topline-wrapper {
        <?php
        echo 'background-image: url('.esc_url($header_topline_background['background-image']).');';
        echo 'background-repeat: '.$header_topline_background['background-repeat'].';';
        echo 'background-position: '.$header_topline_background['background-position'].';';
        echo 'background-size: '.$header_topline_background['background-size'].';';
        echo 'background-attachment: '.$header_topline_background['background-attachment'].';';
        ?>
    }
    <?php endif; ?>
    <?php endif; ?>

    <?php
    // Header subscribe block background image
    $subscribe_block_background = get_theme_mod( 'subscribeblock_background', false );

    if(!empty($subscribe_block_background['background-image'])): ?>
    .inhype-subscribe-block {
        <?php
        echo 'background-image: url('.esc_url($subscribe_block_background['background-image']).');';
        echo 'background-repeat: '.$subscribe_block_background['background-repeat'].';';
        echo 'background-position: '.$subscribe_block_background['background-position'].';';
        echo 'background-size: '.$subscribe_block_background['background-size'].';';
        echo 'background-attachment: '.$subscribe_block_background['background-attachment'].';';
        ?>
    }
    <?php endif; ?>

    <?php if(!empty($subscribe_block_background['background-color'])): ?>
    .inhype-subscribe-block {
        <?php
        echo 'background-color: '.esc_attr($subscribe_block_background['background-color']).';';
        ?>
    }
    <?php endif; ?>

    /* Top menu */
    <?php if(get_theme_mod('topmenu_disable_mobile', true)): ?>
    @media (max-width: 991px) {
        .header-menu-bg {
            display: none;
        }
    }
    <?php endif; ?>
    <?php if(get_theme_mod('topmenu_custom_disable_mobile', false)): ?>
    @media (max-width: 991px) {
        .header-menu .topmenu-custom-content {
            display: none;
        }
    }
    <?php endif; ?>

    <?php if(get_theme_mod('header_center_mobile_logo', false)): ?>
    @media (max-width: 991px) {
        header .logo {
            display: inline-block;
            width: 100%;
            text-align: center;
            margin-left: -15px;
        }
    }
    <?php endif; ?>
    /**
    * Theme Google Fonts
    **/
    <?php
    // Logo text font
    if ( get_theme_mod( 'logo_text', true ) == true && get_theme_mod( 'logo_text_title', '' ) !== '' ) {

    $logo_text_font = get_theme_mod( 'logo_text_font', array(
        'font-family'    => 'Cormorant Garamond',
        'font-size'    => '62px',
        'variant'        => 'regular',
        'color'          => '#000000',
    ));

    ?>
        header .logo-link.logo-text {
            font-family: '<?php echo esc_attr($logo_text_font['font-family']); ?>';
            <?php echo esc_attr(inhype_get_font_style_css($logo_text_font['variant'])); ?>
            font-size: <?php echo esc_attr($logo_text_font['font-size']); ?>;
            color: <?php echo esc_attr($logo_text_font['color']); ?>;
        }
        <?php
    }

    ?>
    /* Fonts */
    .headers-font,
    h1, h2, h3, h4, h5, h6,
    .h1, .h2, .h3, .h4, .h5, .h6,
    .blog-post .format-quote .entry-content,
    blockquote,
    .sidebar .widget .post-title,
    .author-bio strong,
    .navigation-post .nav-post-name,
    .sidebar .widgettitle,
    .post-worthreading-post-container .post-worthreading-post-title,
    .post-worthreading-post-wrapper .post-worthreading-post-button,
    .page-item-title-archive .page-description,
    .sidebar .widget.widget_inhype_categories,
    .sidebar .widget.widget_nav_menu li,
    .widget_recent_entries li a,
    .widget_recent_comments li a,
    .widget_archive li a,
    .widget_rss li a {
        font-family: '<?php echo esc_attr($headers_font['font-family']); ?>';
        <?php echo esc_attr(inhype_get_font_style_css($headers_font['variant'])); ?>
    }
    body {
        font-family: '<?php echo esc_attr($body_font['font-family']); ?>';
        <?php echo esc_attr(inhype_get_font_style_css($body_font['variant'])); ?>
        font-size: <?php echo esc_attr($body_font['font-size']); ?>;
    }
    .additional-font,
    .btn,
    input[type="submit"],
    .woocommerce #content input.button,
    .woocommerce #respond input#submit,
    .woocommerce a.button,
    .woocommerce button.button,
    .woocommerce input.button,
    .woocommerce-page #content input.button,
    .woocommerce-page #respond input#submit,
    .woocommerce-page a.button,
    .woocommerce-page button.button,
    .woocommerce-page input.button,
    .woocommerce a.added_to_cart,
    .woocommerce-page a.added_to_cart,
    .woocommerce span.onsale,
    .woocommerce ul.products li.product .onsale,
    .wp-block-button a.wp-block-button__link,
    .header-menu li.menu-item > a,
    .header-menu .topmenu-custom-content,
    .mainmenu li.menu-item > a,
    .footer-menu,
    .inhype-post .post-categories,
    .sidebar .widget .post-categories,
    .blog-post .post-categories,
    .inhype-blog-posts-slider .inhype-post-details .inhype-post-info,
    .post-subtitle-container,
    .sidebar .widget .post-date,
    .sidebar .widget .post-author,
    .inhype-post .post-author,
    .inhype-post .post-date,
    .inhype-post .post-details-bottom,
    .inhype-post .post-read-time,
    .blog-post .tags,
    .navigation-post .nav-post-title,
    .comment-metadata .date,
    header .header-blog-info,
    .inhype-subscribe-block h6,
    .header-topline-wrapper .header-topline,
    .navigation-post .nav-post-button-title,
    .sidebar .widget.widget_inhype_social_icons .social-icons-wrapper {
        font-family: '<?php echo esc_attr($additional_font['font-family']); ?>';
        <?php echo esc_attr(inhype_get_font_style_css($additional_font['variant'])); ?>
    }

    /**
    * Colors and color skins
    */
    <?php

    // Dark theme option
    if(get_theme_mod('color_darktheme', false)) {

        // Dark theme Custom CSS
        ?>
        /* Grey border */
        .inhype-postline-block,
        .inhype-post .post-details-bottom .post-info-wrapper,
        .inhype-post .post-details-bottom,
        .inhype-subscribe-block,
        .sidebar .widgettitle,
        .mainmenu-mobile-toggle i,
        .nav > li .sub-menu,
        .navigation-post:before,
        .comment-list li.comment,
        .navigation-paging .wp-pagenavi,
        .navigation-paging .nav-post-prev a, .navigation-paging .nav-post-next a,
        .comment-list .children li.comment,
        .wp-block-table,
        table,
        table td,
        table th,
        .woocommerce table.shop_attributes th,
        .woocommerce table.shop_attributes td,
        .woocommerce div.product .woocommerce-tabs ul.tabs:before,
        .woocommerce-cart .cart-collaterals .cart_totals table,
        #add_payment_method #payment ul.payment_methods, .woocommerce-cart #payment ul.payment_methods, .woocommerce-checkout #payment ul.payment_methods,
        .wp-block-separator,
        .navbar-center-wrapper,
        .nav .sub-menu li.menu-item > a,
        .inhype-card-post.inhype-post .inhype-post-details-wrapper,
        .sidebar .widget.widget_inhype_categories a,
        body .owl-theme .owl-dots .owl-dot span,
        .inhype-postline-block .inhype-postline-block-right,
        .inhype-postline2-block .inhype-list-post.inhype-list-small-post.inhype-post:after,
        .inhype-featured-categories-wrapper .inhype-featured-category .inhype-featured-category-info,
        blockquote,
        .blog-post-single .format-quote .entry-content,
        .post-review-block,
        .post-review-block .post-review-header,
        .post-review-block .post-review-summary,
        .post-review-block .post-review-criteria-group,
        .post-review-block .post-review-details,
        .single-post .inhype-post.inhype-post-bottom .post-details-bottom.post-details-bottom-single,
        .author-bio,
        .navigation-post,
        .navigation-post .nav-post-prev,
        .inhype-post .post-excerpt .post-readmore,
        .single-post .blog-post-related-wrapper .inhype-post,
        blockquote::before,
        .blog-post-single .format-quote .entry-content::before,
        .inhype-block .inhype-block-title,
        .single-post .blog-post-related-wrapper > h5,
        .comments-title,
        .shopping-cart .shopping-cart-product,
        header[class*="-border"] .mainmenu .navbar,
        .blog-home-block-title-style-border .inhype-block .inhype-block-title,
        .blog-home-block-title-style-border-dark .inhype-block .inhype-block-title,
        header:not(.fixed)[class*="-border"] .mainmenu .navbar,
        .navbar .nav li.mgt-highlight.border a,
        .navbar .nav li.mgt-highlight.border a:hover,
        .navbar .nav li.mgt-highlight.border.alt a,
        .navbar .nav li.mgt-highlight.border.alt a:hover {
            border-color: rgba(255,255,255,0.1);
        }
        /* White border top */
        .navbar-center-wrapper,
        .sidebar .widgettitle,
        blockquote,
        .blog-post-single .format-quote .entry-content,
        .blog-home-block-title-style-doubleborder .inhype-block .inhype-block-title {
            border-top-color: #ffffff;
        }
        /* Dark border */
        .sidebar.sub-menu .widgettitle {
            border-color: #000000;
        }
        /* White text */
        a:hover, a:focus,
        .inhype-post .post-title a,
        .inhype-post .post-title a:hover,
        .inhype-post .post-title,
        .inhype-post .post-author a,
        .inhype-post .post-author a:hover,
        .single-post .page-item-title-single .inhype-post .post-title:hover,
        h1, h2, h3, h4, h5, h6,
        .post-social-wrapper .post-social a,
        .inhype-post .post-details-bottom,
        .inhype-post .post-details-bottom a,
        .sidebar .widgettitle,
        header .social-icons-wrapper a,
        header a.search-toggle-btn,
        .woocommerce-mini-cart:not(.product_list_widget) a.cart-toggle-btn,
        .mainmenu-mobile-toggle,
        .author-bio h3 a:not(.btn),
        .author-bio .author-social-icons li a,
        .navigation-post a.nav-post-title-link,
        .navigation-post .nav-post-name,
        .blog-post-related-wrapper > h5,
        .comments-title,
        .comment-reply-title,
        .page-item-title-single .page-title,
        .sidebar .widget_calendar caption,
        .widget_recent_entries li a,
        .widget_recent_comments li a,
        .widget_categories li a,
        .widget_archive li a,
        .widget_meta li a,
        .widget_pages li a,
        .widget_rss li a,
        .widget_nav_menu li a,
        .sidebar .widget.widget_nav_menu a,
        .navigation-paging .nav-post-prev a,
        .navigation-paging .nav-post-next a,
        .wp-block-latest-posts a,
        .woocommerce ul.cart_list li a, .woocommerce ul.product_list_widget li a,
        .woocommerce ul.products li.product .woocommerce-loop-product__title,
        .inhype-blog-posts-slider .inhype-post .post-title a:hover,
        .inhype-post .post-details-bottom .post-social-wrapper .post-social-title,
        blockquote::before,
        .blog-post-single .format-quote .entry-content::before,
        .inhype-post .post-title a:hover,
        .navigation-post .nav-post-name:hover,
        .single-post .blog-post-related-wrapper > h5,
        .page-item-title-archive .page-description,
        .woocommerce .woocommerce-error,
        .woocommerce .woocommerce-info,
        .woocommerce .woocommerce-message,
        .single-post.blog-enable-dropcaps .blog-post-single .post-content .entry-content > p:first-child:first-letter,
        .single-post .post-worthreading-post-wrapper .post-worthreading-post-button a,
        .navbar .nav li.mgt-highlight a,
        .navbar .nav li.mgt-highlight a:hover,
        .navbar .nav li.mgt-highlight.border a,
        .navbar .nav li.mgt-highlight.border a:hover,
        .navbar .nav li.mgt-highlight.border.alt a,
        .navbar .nav li.mgt-highlight.border.alt a:hover,
        .shopping-cart .shopping-cart-content .shopping-cart-product-title a,
        .single-post .post-worthreading-post-container .btn-close:hover,
        .header-menu .topmenu-custom-content,
        .blog-home-block-subtitle-style-uppercase .inhype-block .inhype-block-title h4,
        .shopping-cart .shopping-cart-content {
            color: #ffffff;
        }
        .shopping-cart-product-remove a.remove:hover,
        .nav > li > a {
            color: #ffffff!important;
        }
        /* Grey text */
        .inhype-postline-block .inhype-block-title h3,
        blockquote cite,
        .author-bio h5,
        .navigation-post .nav-post-title,
        .woocommerce ul.products li.product .price,
        .woocommerce div.product p.price, .woocommerce div.product span.price,
        .social-icons-wrapper a:hover,
        .author-bio .author-social-icons li a:hover,
        .blog-home-block-subtitle-style-regular .inhype-block .inhype-block-title h4 {
            color: #868686;
        }
        /* Black text */
        .inhype-social-share-fixed .post-social-wrapper .post-social a,
        .sidebar .widget_calendar tbody td a:hover,
        .woocommerce-breadcrumb,
        .woocommerce-breadcrumb a {
            color: #000000;
        }
        /* Transparent background */
        .author-bio,
        .panel,
        table th,
        .woocommerce table.shop_table, #add_payment_method #payment, .woocommerce-checkout #payment,
        .woocommerce .order_details,
        .inhype-blog-posts-slider,
        header,
        .navbar .nav > li {
            background: transparent;
        }
        /* Dark background */
        .wp-block-latest-posts a,
        .inhype-postline-block,
        .inhype-overlay-post.inhype-post .inhype-post-wrapper-inner,
        .inhype-postline2-block-wrapper,
        .inhype-block-wrapper-bg,
        body .owl-theme .owl-dots .owl-dot.active span,
        body .owl-theme .owl-dots .owl-dot:hover span,
        .inhype-subscribe-block,
        .inhype-featured-categories-wrapper .inhype-featured-category,
        .post-review-block .post-review-criteria-progress,
        .inhype-post .inhype-post-image-wrapper,
        .woocommerce .woocommerce-error,
        .woocommerce .woocommerce-info,
        .woocommerce .woocommerce-message,
        header a.search-toggle-btn,
        .woocommerce-mini-cart:not(.product_list_widget),
        .navigation-post .nav-post-prev .nav-post-name::after,
        .page-item-title-archive .author-bio,
        .single-post .container-page-item-title-2column {
            background-color: rgba(255,255,255,0.05);
        }
        .sidebar .widget.widget_inhype_social_icons a:hover,
        .single-post .inhype-social-share-fixed .post-social-wrapper .post-social a:hover {
            background-color: rgba(255,255,255,0.05)!important;
        }
        /* Black background */
        .wp-block-table tr:nth-child(2n+1) td,
        .inhype-posthighlight-block-wrapper .inhype-posthighlight-block .inhype-posthighlight-block-right .inhype-card-post.inhype-post {
            background-color: #000000;
        }
        /* Dark grey background */
        header.fixed,
        .inhype-featured-categories-wrapper .inhype-featured-category .inhype-featured-category-info,
        .single-post .post-worthreading-post-container,
        .single-post .post-worthreading-post-wrapper,
        .inhype-fullwidthpostsslider-block-wrapper .inhype-fullwidthpostsslider-block-pagination .inhype-fullwidthpostsslider-page,
        .post-review-block,
        .wp-block-table tr td {
            background-color: #0b0b0b;
        }

        /* Remove menu background */
        .nav .sub-menu li.menu-item > a:hover {
            background: none;
        }
        /* Remove menu shadow */
        header.main-header.fixed {
            box-shadow: none;
        }
        /* Show light logo */
        header .light-logo {
            display: inline-block!important;
        }
        header .regular-logo {
            display: none!important;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .nav .sub-menu li.menu-item > a {
                color: #ffffff;
            }
        }
        <?php
    }

    $color_skin = get_theme_mod('color_skin', 'none');

    // Demo settings
    if ( defined('DEMO_MODE') && isset($_GET['color_skin']) ) {
      $color_skin = $_GET['color_skin'];
    }

    // Use panel settings
    if($color_skin == 'none') {

        $color_text = get_theme_mod('color_text', '#333333');
        $color_main = get_theme_mod('color_main', '#2568ef');
        $color_main_alt = get_theme_mod('color_main_alt', '#FF3366');
        $color_button = get_theme_mod('color_button', '#2568ef');
        $color_button_hover = get_theme_mod('color_button_hover', '#48494b');
        $color_topmenu_bg =  get_theme_mod('color_topmenu_bg', '#FFFFFF');
        $color_topmenu_dark_bg = get_theme_mod('color_topmenu_dark_bg', '#121212');
        $color_mainmenu_dark_bg = get_theme_mod('color_mainmenu_dark_bg', '#121212');
        $color_mainmenu_dark_bg_grad = get_theme_mod('color_mainmenu_dark_bg_grad', '#121212');
        $color_mainmenu_submenu_bg = get_theme_mod('color_mainmenu_submenu_bg', '#FFFFFF');
        $color_mainmenu_link = get_theme_mod('color_mainmenu_link', '#000000');
        $color_mainmenu_link_hover = get_theme_mod('color_mainmenu_link_hover', '#2568ef');
        $color_mainmenu_submenu_link = get_theme_mod('color_mainmenu_submenu_link', '#000000');
        $color_mainmenu_submenu_link_hover = get_theme_mod('color_mainmenu_submenu_link_hover', '#2568ef');
        $color_footer_bg = get_theme_mod('color_footer_bg', '#FFFFFF');
        $color_footer_dark_bg = get_theme_mod('color_footer_dark_bg', '#13181C');
        $color_slider_text = get_theme_mod('color_slider_text', '#000000');
        $color_post_reading_progressbar = get_theme_mod('color_post_reading_progressbar', '#000000');

    } else {

        // Same colors for all skins
        $color_main_alt = '#FF3366';
        $color_text = '#000000';
        $color_button = '#121212';
        $color_button_hover = '#48494b';
        $color_topmenu_bg = '#FFFFFF';
        $color_topmenu_dark_bg = '#121212';
        $color_mainmenu_dark_bg = '#121212';
        $color_mainmenu_dark_bg_grad = '#121212';
        $color_mainmenu_submenu_bg = '#FFFFFF';
        $color_mainmenu_link = '#000000';
        $color_mainmenu_submenu_link = '#000000';
        $color_footer_bg = '#FFFFFF';
        $color_footer_dark_bg = '#13181C';
        $color_slider_text = '#000000';
        $color_post_reading_progressbar = '#000000';
    }

    // Default skin
    if($color_skin == 'default') {

        $color_main = '#2568ef';
        $color_mainmenu_link_hover = $color_main;
        $color_mainmenu_submenu_link_hover = $color_main;

    }
    // Black skin
    if($color_skin == 'dark') {

        $color_text = '#8e8e8e';
        $color_main = '#2568ef';
        $color_main_alt = '#FF3366';
        $color_button_hover = '#0b0b0b';
        $color_topmenu_bg =  '#FFFFFF';
        $color_topmenu_dark_bg = '#0b0b0b';
        $color_mainmenu_submenu_bg = '#0b0b0b';
        $color_mainmenu_link = '#ffffff';
        $color_mainmenu_link_hover = '#868686';
        $color_mainmenu_submenu_link = '#ffffff';
        $color_mainmenu_submenu_link_hover = '#868686';
        $color_footer_bg = '#FFFFFF';
        $color_footer_dark_bg = '#000000';
        $color_slider_text = '#000000';
        $color_post_reading_progressbar = '#2568ef';

    }
    // Black skin
    if($color_skin == 'black') {

        $color_main = '#444444';
        $color_mainmenu_link_hover = $color_main;
        $color_mainmenu_submenu_link_hover = $color_main;

    }
    // Grey skin
    if($color_skin == 'grey') {

        $color_main = '#62aed1';
        $color_mainmenu_link_hover = $color_main;
        $color_mainmenu_submenu_link_hover = $color_main;

    }
    // Light blue skin
    if($color_skin == 'lightblue') {

        $color_main = '#62aed1';
        $color_mainmenu_link_hover = $color_main;
        $color_mainmenu_submenu_link_hover = $color_main;

    }
    // Blue skin
    if($color_skin == 'blue') {

        $color_main = '#6284d1';
        $color_mainmenu_link_hover = $color_main;
        $color_mainmenu_submenu_link_hover = $color_main;

    }
    // Red
    if($color_skin == 'red') {

        $color_main = '#e4393c';
        $color_mainmenu_link_hover = $color_main;
        $color_mainmenu_submenu_link_hover = $color_main;

    }
    // Green
    if($color_skin == 'green') {

        $color_main = '#6cc49a';
        $color_mainmenu_link_hover = $color_main;
        $color_mainmenu_submenu_link_hover = $color_main;

    }
    // Orange
    if($color_skin == 'orange') {

        $color_main = '#fab915';
        $color_mainmenu_link_hover = $color_main;
        $color_mainmenu_submenu_link_hover = $color_main;

    }
    // RedOrange
    if($color_skin == 'redorange') {

        $color_main = '#e4393c';
        $color_mainmenu_link_hover = $color_main;
        $color_mainmenu_submenu_link_hover = $color_main;

    }
    // Brown
    if($color_skin == 'brown') {

        $color_main = '#c6afa5';
        $color_mainmenu_link_hover = $color_main;
        $color_mainmenu_submenu_link_hover = $color_main;

    }
    ?>
    <?php
    // Body background
    $body_background = get_theme_mod( 'body_background', false );

    if(empty($body_background['background-color'])) {
        $body_background['background-color'] = '#ffffff';
    }

    if(!empty($body_background['background-image'])): ?>
    body {
        <?php
        echo 'background-image: url('.esc_url($body_background['background-image']).');';
        echo 'background-repeat: '.$body_background['background-repeat'].';';
        echo 'background-position: '.$body_background['background-position'].';';
        echo 'background-size: '.$body_background['background-size'].';';
        echo 'background-attachment: '.$body_background['background-attachment'].';';
        ?>
    }
    <?php endif; ?>

    :root {
        --color-body-bg: <?php echo esc_html($body_background['background-color']); ?>;
        --color-body-text: <?php echo esc_html($color_text); ?>;
        --color-theme: <?php echo esc_html($color_main); ?>;
        --color-theme-alt: <?php echo esc_html($color_main_alt); ?>;
        --color-button: <?php echo esc_html($color_button); ?>;
        --color-button-hover: <?php echo esc_html($color_button_hover); ?>;
        --color-mainmenu-dark-bg: <?php echo esc_html($color_mainmenu_dark_bg); ?>;
        --color-mainmenu-dark-bg-grad: <?php echo esc_html($color_mainmenu_dark_bg_grad); ?>;
        --color-mainmenu-link: <?php echo esc_html($color_mainmenu_link); ?>;
        --color-mainmenu-link-hover: <?php echo esc_html($color_mainmenu_link_hover); ?>;
        --color-mainmenu-submenu-bg: <?php echo esc_html($color_mainmenu_submenu_bg); ?>;
        --color-mainmenu-submenu-link: <?php echo esc_html($color_mainmenu_submenu_link); ?>;
        --color-mainmenu-submenu-link-hover: <?php echo esc_html($color_mainmenu_submenu_link_hover); ?>;
        --color-bg-topmenu: <?php echo esc_html($color_topmenu_bg); ?>;
        --color-bg-topmenu-dark-bg: <?php echo esc_html($color_topmenu_dark_bg); ?>;
        --color-bg-footer: <?php echo esc_html($color_footer_bg); ?>;
        --color-bg-footer-dark: <?php echo esc_html($color_footer_dark_bg); ?>;
        --color-reading-progress-bar: <?php echo esc_html($color_post_reading_progressbar); ?>;
    }

    <?php

    	$out = ob_get_clean();

		$out .= ' /*' . date("Y-m-d H:i") . '*/';
		/* RETURN */
		return $out;
	}
    endif;
