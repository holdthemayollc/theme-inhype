<?php
/**
 * Theme JS cache generation
 */

	add_action( 'wp_enqueue_scripts', 'inhype_enqueue_dynamic_js', '999' );

	if(!function_exists('inhype_enqueue_dynamic_js')):
	function inhype_enqueue_dynamic_js( ) {

		require_once(ABSPATH . 'wp-admin/includes/file.php'); // required to use WP_Filesystem();

		WP_Filesystem();

		global $wp_filesystem;

		if ( function_exists( 'is_multisite' ) && is_multisite() ){
			$cache_file_name = 'js-cache-'.wp_get_theme()->get('TextDomain').'-b' . get_current_blog_id();
		} else {
			$cache_file_name = 'js-cache-'.wp_get_theme()->get('TextDomain');
		}

		// Customizer preview
        if(is_customize_preview()) {
            if ( function_exists( 'is_multisite' ) && is_multisite() ){
                $cache_file_name = 'preview-js-cache-'.wp_get_theme()->get('TextDomain').'-b' . get_current_blog_id();
            } else {
                $cache_file_name = 'preview-js-cache-'.wp_get_theme()->get('TextDomain');
            }
        }

		$wp_upload_dir = wp_upload_dir();

		$js_cache_file = $wp_upload_dir['basedir'].'/'.$cache_file_name.'.js';

		$js_cache_file_url = $wp_upload_dir['baseurl'].'/'.$cache_file_name.'.js';

        $themeoptions_saved_date = get_option( 'themeoptions_saved_date', 1 );
        $cache_saved_date = get_option( 'cache_js_saved_date', 0 );

		if( file_exists( $js_cache_file ) ) {
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

		if ( $cache_status == 'exist' ) {

			wp_register_script( $cache_file_name, $js_cache_file_url, array(), $cache_saved_date);
			wp_enqueue_script( $cache_file_name );

		} else {

			$out = '/* Cache file created at '.date('Y-m-d H:i:s').' */';

			$js_generated = microtime(true);

			$out .= inhype_get_js();

			$out .= '/* JS Generator Execution Time: ' . floatval( ( microtime(true) - $js_generated ) ) . ' seconds */';

			// FS_CHMOD_FILE required by WordPress guideliness - https://codex.wordpress.org/Filesystem_API#Using_the_WP_Filesystem_Base_Class
            if ( defined( 'FS_CHMOD_FILE' ) ) {
                $chmod_file = FS_CHMOD_FILE;
            } else {
                $chmod_file = ( 0644 & ~ umask() );
            }

			if ( $wp_filesystem->put_contents( $js_cache_file, $out, $chmod_file) ) {

				wp_register_script( $cache_file_name, $js_cache_file_url, array(), $cache_saved_date);
				wp_enqueue_script( $cache_file_name );

                // Update save options date
                $option_name = 'cache_js_saved_date';

                $new_value = microtime(true) ;

                if ( get_option( $option_name ) !== false ) {

                    // The option already exists, so we just update it.
                    update_option( $option_name, $new_value );

                } else {

                    // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
                    $deprecated = null;
                    $autoload = 'no';
                    add_option( $option_name, $new_value, $deprecated, $autoload );
                }
			}

		}
	}
	endif;

	if(!function_exists('inhype_get_js')):
	function inhype_get_js () {
		// ===
		ob_start();
    ?>
    (function($){
    $(document).ready(function() {


        <?php if(get_theme_mod('custom_js_code', '') !== '') {

        	echo get_theme_mod('custom_js_code', '');  // This variable contains user Custom JS code and can't be escaped with WordPress functions

        } ?>

    });
    })(jQuery);
    <?php

    	$out = ob_get_clean();

		$out .= ' /*' . date("Y-m-d H:i") . '*/';
		/* RETURN */
		return $out;
	}
	endif;
