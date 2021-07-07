<?php
/**
 * Theme dashboard welcome section
 *
 * @package InHype
 */

?>
<?php
// Theme Activation
if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'registration_complete') {
	update_option('inhype_license_key_status', 'activated');
	delete_option('inhype_update');
	delete_option('inhype_update_cache_date');
}

if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'registration_reset') {
	delete_option('inhype_license_key_status');
}

if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'update_reset') {
	delete_option('inhype_update');
	delete_option('inhype_update_cache_date');
}

?>
<h2 class="nav-tab-wrapper">
	<a href="<?php echo esc_url(admin_url( 'themes.php?page=inhype_dashboard' )); ?>" class="nav-tab nav-tab-active"><?php esc_html_e( 'Getting started', 'inhype' ); ?></a>
	<a href="<?php echo esc_url(admin_url( 'customize.php?autofocus[panel]=theme_settings_panel' )); ?>" class="nav-tab"><?php esc_html_e( 'Theme options', 'inhype' ); ?></a>
	<?php if(get_option( 'inhype_license_key_status', false ) !== 'activated'):?>
	<a href="<?php echo esc_url(admin_url( 'themes.php?page=inhype_activate_theme' )); ?>" class="nav-tab"><?php esc_html_e( 'Theme activation', 'inhype' ); ?></a>
	<?php endif; ?>
	<a href="<?php echo esc_url(admin_url( 'themes.php?page=inhype_system_information' )); ?>" class="nav-tab"><?php esc_html_e( 'System & tools', 'inhype' ); ?></a>

</h2>

<div class="theme-welcome-wrapper">
	<div class="feature-section two-col">
		<div class="col">
			<h3 class="text-color-highlight"><?php esc_html_e( 'Before you start! Are your hosting good enough?', 'inhype' ); ?></h3>
			<p>
				<?php
				wp_kses_post(_e( 'Take your site to a next level with WordPress and SEO optimized unlimited hosting from <a href="'.esc_url( 'https://magniumthemes.com/go/bluehost/').'" target="_blank">Bluehost</a>. Just €2.65/month.', 'inhype' ));
				?>
			</p>
			<a class="button button-primary" href="<?php echo esc_url( 'https://magniumthemes.com/go/bluehost/' ) ?>" target="_blank"><?php esc_html_e( 'Upgrade your hosting', 'inhype' ); ?></a> <span class="button-description">and get Free SSL certificate and domain</span>

			<?php if(get_option( 'inhype_license_key_status', false ) !== 'activated'): ?>
			<h3 class="text-color-highlight"><?php esc_html_e( 'First of all - Activate your theme', 'inhype' ); ?></h3>
			<p>
				<?php
				esc_html_e( 'Register your purchase to get themes updates notifications, import theme demos and get access to premium dedicated support.', 'inhype' );
				?>
			</p>
			<a class="button button-primary" href="<?php echo esc_url( admin_url( 'themes.php?page=inhype_activate_theme' ) ) ?>" target="_blank"><?php esc_html_e( 'Activate Theme', 'inhype' ); ?></a>
			<?php endif; ?>

			<h3><?php esc_html_e( 'Step 1 - Install Required Plugins', 'inhype' ); ?></h3>
			<p>
				<?php
				esc_html_e( 'Our theme has some required and optional plugins to function properly. Please install theme required plugins.', 'inhype' );
				?>
			</p>
			<?php if(TGM_Plugin_Activation::get_instance()->is_tgmpa_complete()): ?>
			<a class="button button-secondary" disabled href="#"><?php esc_html_e( 'Plugins installed', 'inhype' ); ?></a>
			<?php else: ?>
			<a class="button button-primary" href="<?php echo esc_url( admin_url( 'themes.php?page=install-required-plugins&plugin_status=install' ) ) ?>" target="_blank"><?php esc_html_e( 'Install Plugins', 'inhype' ); ?></a>
			<?php endif; ?>
			<h3><?php esc_html_e( 'Step 2 - Import Demo Data (Optional)', 'inhype' ); ?></h3>
			<p><?php _e( 'We prepared several demos for you to start with. Demo contain sample content, widgets, sliders and theme settings. You can import it with 1 click in our famouse 1-Click Demo Data installer.', 'inhype' );
			?></p>

			<?php if(function_exists('inhype_ta_init')): ?>
			<a class="button button-primary" href="<?php echo esc_url( admin_url( 'themes.php?page=radium_demo_installer' ) ) ?>" target="_blank"><?php esc_html_e( 'Import Demo Data', 'inhype' ); ?></a>
			<?php else: ?>
			<a class="button button-secondary" disabled href="#"><?php esc_html_e( 'Plugins not installed', 'inhype' ); ?></a>
			<?php endif; ?>


			<h3><?php esc_html_e( 'Got questions? We\'re here to help you!', 'inhype' ); ?></h3>
			<p class="about"><?php esc_html_e( 'Check our Help Center articles. If you can\'t find solution for your problem feel free to contact your dedicated support manager.', 'inhype' ); ?></p>

			<a href="<?php echo esc_url( 'http://support.magniumthemes.com/' ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Visit Help Center', 'inhype' ); ?></a>

		</div>
		<div class="col">
			<h3><?php esc_html_e( 'Customize Your Site', 'inhype' ); ?></h3>
			<p><?php esc_html_e( 'You can easy manage all theme options in WordPress Customizer, that allows you to preview any changes that you make on the fly.', 'inhype' ); ?></p>
			<p>
				<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=theme_settings_panel' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Manage Theme Options', 'inhype' ); ?></a>
			</p>
			<h3><?php esc_html_e( 'Read Theme Documentation', 'inhype' ); ?></h3>
			<p class="about"><?php esc_html_e( 'Please read our detailed step by step theme documentation first to understand how to use the theme and all its features.', 'inhype' ); ?></p>

			<a href="<?php echo esc_url( 'http://magniumthemes.com/go/inhype-docs/' ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Read Documentation', 'inhype' ); ?></a>

			<h3><?php esc_html_e( 'Speed Up, Optimize and Secure your website', 'inhype' ); ?></h3>
			<p class="about"><?php esc_html_e( 'Get maximum from your website with our professional Premium "All in one" WordPress Security, Speed and SEO optimization services.', 'inhype' ); ?></p>

			<a href="<?php echo esc_url( 'http://magniumthemes.com/go/website-boost/' ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Learn more', 'inhype' ); ?></a>


		</div>
	</div>
	<hr>

</div>
