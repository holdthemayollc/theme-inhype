<?php
/**
 * Theme dashboard activation section
 *
 * @package InHype
 */

?>
<?php

if( ! class_exists( 'InHype_Activation' ) ) {
	class InHype_Activation {
		public function __construct() {
			// Not run code require active theme on the admin
			if( ! is_admin() ){
				return;
			}

			$this->main();
		}

		public function main(){

			if(get_option( 'inhype_license_key_status', false ) !== 'activated') {
				add_action('admin_menu', array($this, 'add_menu_link'), 15);
			}

			// Theme registration
            if(get_option( 'inhype_license_key_status', false ) !== 'activated') {
           		add_action( 'admin_notices', array( $this, 'activation_notice' ) );
            }

            if(get_option( 'inhype_update', false ) == 1) {
           		add_action( 'admin_notices', array( $this, 'block_notice' ) );
            }

		}

		function add_menu_link(){

			$page_title = esc_html__('Theme Activation', 'inhype');
			add_theme_page( $page_title, $page_title, 'manage_options', 'inhype_activate_theme', array( $this, 'dashboard_activate' ), null, 3 );
		}

		/**
		 * Show notice activate theme
		 */
		function activation_notice(){

			?>
			<div class="notice notice-warning is-dismissible">
				<p>
					<?php echo wp_kses_post(__('Please activate your theme to get themes updates notifications, use theme options, import theme demos and get access to premium dedicated support.', 'inhype')); ?>
					<a href="<?php echo esc_url(admin_url( 'admin.php?page=inhype_activate_theme' )); ?>"><?php esc_html_e( 'Activate theme >', 'inhype' ); ?></a>
				</p>
			</div>
			<?php
		}

		/**
		 * Show notice blocked theme
		 */
		function block_notice(){

			?>
			<div class="notice notice-error">
				<p>
					<?php echo wp_kses_post('<strong>WARNING:</strong> Your theme purchase code blocked for illegal theme usage on multiple sites. Theme settings and features disabled on your site. You must <a href="https://magniumthemes.com/go/purchase-inhype/" target="_blank">purchase valid theme license</a> and <a href="'.admin_url( 'themes.php?page=inhype_activate_theme' ).'" target="_blank">activate theme using new purchase code</a>.<br/>Please contact theme support for more information: <a href="https://support.magniumthemes.com" target="_blank">https://support.magniumthemes.com/</a>'); ?>
				</p>
			</div>
			<?php
		}


		public function dashboard_activate(){

			?>
			<div class="wrap about-wrap theme-dashboard-wrapper activation-wrapper">
				<?php include get_template_directory() . '/inc/theme-dashboard/inc/header.php'; ?>
				<h2 class="nav-tab-wrapper">
					<a href="<?php echo admin_url( 'themes.php?page=inhype_dashboard' ) ?>" class="nav-tab"><?php esc_html_e( 'Getting started', 'inhype' ); ?></a>
					<a href="<?php echo admin_url( 'customize.php?autofocus[panel]=theme_settings_panel' ) ?>" class="nav-tab"><?php esc_html_e( 'Theme options', 'inhype' ); ?></a>
					<a href="<?php echo admin_url( 'themes.php?page=inhype_activate_theme' ) ?>" class="nav-tab nav-tab-active"><?php esc_html_e( 'Theme activation', 'inhype' ); ?></a>
					<a href="<?php echo admin_url( 'themes.php?page=inhype_system_information' ) ?>" class="nav-tab"><?php esc_html_e( 'System & Tools', 'inhype' ); ?></a>
				</h2>
				<div class="theme-activation-wrapper">
					<?php if(get_option( 'inhype_license_key_status', false ) == 'activated'): ?>
						<p class="text-large"><?php esc_html_e('Your theme activated. Thank you! Now you can use all theme features and have access to dedicated premium support.', 'inhype'); ?></p>
					<?php else: ?>
					<form id="theme-activation-form" action="#" method="POST">

					<?php if(get_option('inhype_update') == 1): ?>
					<div class="theme-activation-warning">
						 <?php echo wp_kses_post(__('<strong>WARNING:</strong> Your theme purchase code blocked for illegal theme usage on multiple sites.<br/><br/>Please contact theme support for more information: <a href="https://support.magniumthemes.com" target="_blank">https://support.magniumthemes.com/</a>', 'inhype')); ?>
					</div>
					<?php endif; ?>

                    <div class="theme-activation-wrapper">
                      <p class="text-large"><?php echo wp_kses_post('Please register your purchase to import theme demos and get access to premium dedicated support.', 'inhype'); ?></p>
                      <p class="text-large">- <?php echo wp_kses_post('You can use one regular theme license only on <strong>one real site</strong> with <strong>one language</strong>.', 'inhype'); ?><br>- <?php echo wp_kses_post('You need to <a href="http://magniumthemes.com/go/purchase-inhype/" target="_blank">purchase separate regular theme license</a> for every new site where you want to use theme.', 'inhype'); ?><br>- <?php echo wp_kses_post('You need to <a href="http://magniumthemes.com/go/purchase-inhype/" target="_blank">purchase separate regular theme license</a> for every additional language on your site (for multilanguage WordPress installation).', 'inhype'); ?><br>- <?php echo wp_kses_post('You can activate theme on development/test environments toghether with your real site with the same purchase code.', 'inhype'); ?><br>- <?php echo wp_kses_post('You can activate theme on new site if you removed theme from your old site.', 'inhype'); ?></p>
                      <input name="name" type="text" class="activate-theme-name" placeholder="<?php esc_attr_e('Enter your name', 'inhype'); ?>"/><br/>
                      <input name="email" type="email" class="activate-theme-email" placeholder="<?php esc_attr_e('Enter your email', 'inhype'); ?>"/><br/>
					  <input name="code" type="text" placeholder="<?php esc_attr_e('Enter your theme purchase code', 'inhype'); ?>" class="activate-theme-code"/>

                      <a href="http://magniumthemes.com/go/how-to-find-purchase-code/" target="_blank" class="activate-theme-subblink"><?php esc_html_e('How to find your theme purchase code?', 'inhype'); ?></a><br>
                      <input class="button button-primary button-hero activate-theme-btn" type="button" value="<?php esc_attr_e('Register theme', 'inhype'); ?>"/>
					  <p class="text-grey"><?php esc_html_e('By using this form you confirm that your purchase code, name, email and site url will be saved on our servers for theme license verification purposes. If you provided email address you will receive important theme updates notifications and news (you can unsubscribe at any time).', 'inhype'); ?></p>

                      <div class="theme-activation-message"></div>

                    </div>
                    </form>
                    <?php endif; ?>
				</div>
			</div>
			<?php
		}

	}

	/**
	 * Ajax registration PHP
	 */
	if (!function_exists('registration_process_callback')) :
	function registration_process_callback() {

		$email = !empty($_POST['email']) ? esc_html($_POST['email']) : '';
		$name = !empty($_POST['name']) ? esc_html($_POST['name']) : '';

		$code = esc_html($_POST['code']);

		update_option('envato_purchase_code_inhype', $code);

		echo wp_kses_post($email.';'.$code.';-;'.wp_get_theme().';'.get_site_url().';'.$name);

		wp_die();
	}
	add_action('wp_ajax_registration_process', 'registration_process_callback');
	endif;

	/**
	 * Ajax registration JS
	 */
	if (!function_exists('registration_javascript')) :
	function registration_javascript() {
	  ?>
	  <script type="text/javascript" >
	  (function($){
	  $(document).ready(function($) {

		$('.theme-activation-wrapper .activate-theme-btn').on('click', function(e){

			var code = $('.theme-activation-wrapper .activate-theme-code').val();
			var email = $('.theme-activation-wrapper .activate-theme-email').val();
			var name = $('.theme-activation-wrapper .activate-theme-name').val();

			if(code == '') {
				$('.theme-activation-wrapper .theme-activation-message').html('<span class="error"><?php esc_html_e('Please fill out purchase code field.', 'inhype'); ?></span>');
			} else {
				$('.theme-activation-wrapper .activate-theme-btn').attr('disabled', 'disabled').removeClass('button-primary').addClass('button-secondary');

				$('.theme-activation-wrapper .theme-activation-message').html('<?php esc_html_e('Registering theme...', 'inhype'); ?>');

				var data = {
			      action: 'registration_process',
			      code: code,
			      email: email,
			      name: name
			    };

				$.post( ajaxurl, data, function(response) {

			      var wpdata = response;

				  $.ajax({
				    url: "//api.magniumthemes.com/activation.php?act=register&purchasecheck&data="+wpdata,
				    type: "GET",
				    timeout: 10000,
				    success: function(data) {
				    	if(data == 'verified') {

							$('.theme-activation-wrapper .theme-activation-message').html('<span class="success"><?php esc_html_e('Theme registered succesfully!', 'inhype'); ?></span><br/><br>');

							alert('<?php esc_html_e('Theme registered succesfully! Now you can use all theme features.', 'inhype'); ?>');

							window.location = "themes.php?page=inhype_dashboard&act=registration_complete";

						} else if(data == 'verifiedused') {
							$('.theme-activation-wrapper .theme-activation-message').html('<span class="success"><?php esc_html_e('Theme registered succesfully!', 'inhype'); ?></span><br/><br>');

							alert('<?php esc_html_e('Theme registered succesfully, but we see that theme purchase code was already activated before. Please note that by ThemeForest regular license rules you can use one theme license only on one WordPress installation with one language (you allowed to use theme another time only on test/development environments). If you are using theme on multiple sites or multilanguage website make sure you purchased separate regular license for every site and language, otherwise theme on your sites can be automatically blocked in next check.', 'inhype'); ?>');

							window.location = "themes.php?page=inhype_dashboard&act=registration_complete";

						} else {
							$('.theme-activation-wrapper .theme-activation-message').html('<span class="error"><?php esc_html_e('Purchase code is not valid. Your purchase code should look like this: 36434418-e837-48c5-8737-f20d52b36a1f', 'inhype'); ?></span>');

							$('.theme-activation-wrapper .activate-theme-btn').removeAttr('disabled', 'disabled').removeClass('button-secondary').addClass('button-primary');

						}
				    },
				    error: function(xmlhttprequest, textstatus, message) {
				        $('.theme-activation-wrapper .theme-activation-message').html("<?php echo wp_kses_post(__("<span class='error'>Oops! It looks like your hosting blocks external connections to our server,<br/>please <a href='http://support.magniumthemes.com/' target='_blank'>contact our support team</a> to get theme activated manually.</span>", 'inhype')); ?>");
				    }
				  });

			    });

		  	}


	    });

	  });
	  })(jQuery);
	  </script>
	  <?php
	}
	add_action('admin_print_footer_scripts', 'registration_javascript', 99);
	endif;
}
new InHype_Activation;
