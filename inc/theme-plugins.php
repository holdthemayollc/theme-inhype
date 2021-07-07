<?php
/**
 * Theme Plugins installation
 */

/**
 * Plugin recomendations
 **/
require_once(get_template_directory().'/inc/tgmpa/class-tgm-plugin-activation.php');

if(!function_exists('inhype_register_required_plugins')):
function inhype_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     */
    $plugins = array(
        array(
            'name'                  => esc_html__('InHype Custom Metaboxes', 'inhype'),
            'slug'                  => 'cmb2',
            'source'                => get_template_directory() . '/inc/plugins/cmb2.zip',
            'required'              => true,
            'version'               => '2.7.0',
        ),
        array(
            'name'                  => esc_html__('InHype Theme Settings (Kirki Customizer Framework)', 'inhype'),
            'slug'                  => 'kirki',
            'source'                => get_template_directory() . '/inc/plugins/kirki.3.1.6.zip',
            'required'              => true,
            'version'               => '3.1.6',
        ),
        array(
            'name'                  => esc_html__('InHype Theme Addons', 'inhype'),
            'slug'                  => 'inhype-theme-addons',
            'source'                => get_template_directory() . '/inc/plugins/inhype-theme-addons.zip',
            'required'              => true,
            'version'               => '1.2.3',
        ),
        array(
            'name'                  => esc_html__('InHype AMP - Accelerated Mobile Pages support', 'inhype'),
            'slug'                  => 'amp',
            'required'              => false,
        ),
        array(
            'name'                  => esc_html__('Envato Market - Automatic theme updates', 'inhype'),
            'slug'                  => 'envato-market',
            'source'                => get_template_directory() . '/inc/plugins/envato-market.zip',
            'required'              => false,
            'version'               => '2.0.6',
        ),
        array(
            'name'                  => esc_html__('InHype Page Navigation', 'inhype'),
            'slug'                  => 'wp-pagenavi',
            'required'              => false,
        ),
        array(
            'name'                  => esc_html__('InHype Login and Registration Popup', 'inhype'),
            'slug'                  => 'ajax-login-and-registration-modal-popup',
            'source'                => get_template_directory() . '/inc/plugins/ajax-login-and-registration-modal-popup.zip',
            'required'              => false,
        ),
        array(
            'name'                  => esc_html__('InHype Translation Manager', 'inhype'),
            'slug'                  => 'loco-translate',
            'required'              => false,
        ),
        array(
            'name'                  => esc_html__('Instagram Feed', 'inhype'),
            'slug'                  => 'instagram-feed',
            'required'              => false,
        ),
        array(
            'name'                  => esc_html__('MailChimp for WordPress', 'inhype'),
            'slug'                  => 'mailchimp-for-wp',
            'required'              => false,
        ),
        array(
            'name'                  => esc_html__('WordPress LightBox', 'inhype'),
            'slug'                  => 'responsive-lightbox',
            'required'              => false
        ),
        array(
            'name'                  => esc_html__('Contact Form 7', 'inhype'),
            'slug'                  => 'contact-form-7',
            'required'              => false,
        ),
        array(
            'name'                  => esc_html__('Regenerate Thumbnails', 'inhype'),
            'slug'                  => 'regenerate-thumbnails',
            'required'              => false,
        )

    );

    // Add Gutenberg for old WordPress versions
    if(version_compare(get_bloginfo('version'), '5.0', "<")) {
        $plugins[] = array(
            'name'                  => esc_html__('Gutenberg - Advanced WordPress Content Editor', 'inhype'),
            'slug'                  => 'gutenberg',
            'required'              => false,
        );
    }

    /**
     * Array of configuration settings.
     */
    $config = array(
        'domain'            => 'inhype',
        'default_path'      => '',
        'menu'              => 'install-required-plugins',
        'has_notices'       => true,
        'dismissable'  => true,
        'is_automatic'      => false,
        'message'           => ''
    );

    tgmpa( $plugins, $config );

}
endif;
add_action('tgmpa_register', 'inhype_register_required_plugins');
