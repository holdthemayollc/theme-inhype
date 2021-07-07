<?php
/**
 * Theme dashboard system information section
 *
 * @package InHype
 */

?>
<?php

if( ! class_exists( 'InHype_System' ) ) {
	class InHype_System {
		public function __construct() {

			if( ! is_admin() ){
				return;
			}

			$this->main();
		}

		public function main(){

			add_action('admin_menu', array($this, 'add_menu_link'), 15);

		}

		function add_menu_link(){

			$page_title = esc_html__('System & Tools', 'inhype');
			add_theme_page( $page_title, $page_title, 'manage_options', 'inhype_system_information', array( $this, 'dashboard_system' ), null, 3 );
		}

		public function let_to_num( $size ) {
		  $l   = substr( $size, -1 );
		  $ret = substr( $size, 0, -1 );
		  switch ( strtoupper( $l ) ) {
		    case 'P':
		      $ret *= 1024;
		    case 'T':
		      $ret *= 1024;
		    case 'G':
		      $ret *= 1024;
		    case 'M':
		      $ret *= 1024;
		    case 'K':
		      $ret *= 1024;
		  }
		  return $ret;
		}

		public function dashboard_system(){

			function get_plugin_version_number($plugin_name) {
			    // If get_plugins() isn't available, require it
			    if ( ! function_exists( 'get_plugins' ) )
			        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			        // Create the plugins folder and file variables
			    $plugin_folder = get_plugins( '/' . $plugin_name );
			    $plugin_file = $plugin_name.'.php';

			    // If the plugin version number is set, return it
			    if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {
			        return $plugin_folder[$plugin_file]['Version'];

			    } else {
			    // Otherwise return null
			        return esc_html__('Plugin not installed', 'inhype');
			    }
			}

			?>
			<div class="wrap about-wrap theme-dashboard-wrapper system-wrapper">
				<?php include get_template_directory() . '/inc/theme-dashboard/inc/header.php'; ?>
				<h2 class="nav-tab-wrapper">
					<a href="<?php echo esc_url(admin_url( 'themes.php?page=inhype_dashboard' )); ?>" class="nav-tab"><?php esc_html_e( 'Getting started', 'inhype' ); ?></a>
					<a href="<?php echo admin_url( 'customize.php?autofocus[panel]=theme_settings_panel' ) ?>" class="nav-tab"><?php esc_html_e( 'Theme options', 'inhype' ); ?></a>
					<?php if(get_option( 'inhype_license_key_status', false ) !== 'activated'):?>
					<a href="<?php echo esc_url(admin_url( 'themes.php?page=inhype_activate_theme' )); ?>" class="nav-tab"><?php esc_html_e( 'Theme activation', 'inhype' ); ?></a>
					<?php endif; ?>
					<a href="<?php echo esc_url(admin_url( 'themes.php?page=inhype_system_information' )); ?>" class="nav-tab nav-tab-active"><?php esc_html_e( 'System & tools', 'inhype' ); ?></a>

				</h2>
				<h3>System information</h3>
				<div class="theme-system-wrapper">
				<?php

			 	echo '<ul>';

			 	echo '<li><strong>PHP version:</strong> '.phpversion().'</li>';

			 	echo '<li><strong>WordPress version:</strong> '.get_bloginfo( 'version' ).'</li>';

			    echo '<li><strong>Theme version:</strong> '.wp_get_theme()->get( 'Version' ).'</li>';

			    echo '<li><strong>Theme Addons version:</strong> '.get_plugin_version_number('inhype-theme-addons').'</li>';

			    echo '<li><strong>WooCommerce version:</strong> '.get_plugin_version_number('woocommerce').'</li>';

				$memory_limit = $this->let_to_num(ini_get('memory_limit'));

				if ( $memory_limit < 128000000 ) {
					$memory_limit_message_html = ' <span class="configuration-error">WARNING: <strong>128MB</strong> value required.</span>';
					$hosting_passed = false;
				} else {
					$memory_limit_message_html = '';
				}

				echo '<li><strong>Server Memory Limit:</strong> '.size_format(esc_html($memory_limit)).wp_kses_post($memory_limit_message_html).'</li>';

				$memory_limit = $this->let_to_num( WP_MEMORY_LIMIT );

				if ( $memory_limit < 128000000 ) {
					$memory_limit_message_html = ' <span class="configuration-info">INFO: <strong>128MB</strong> value recommended. <a href="https://wordpress.org/support/article/editing-wp-config-php/#increasing-memory-allocated-to-php" target="_blank">How to set?</a></span>';
				} else {
					$memory_limit_message_html = '';
				}

				echo '<li><strong>WordPress Memory Limit:</strong> '.size_format(esc_html($memory_limit)).'.'.wp_kses_post($memory_limit_message_html).'</li>';

				$time_limit = ini_get('max_execution_time');

				if ( $time_limit < 60 && $time_limit != 0 ) {
					$time_limit_message_html = ' <span class="configuration-error">WARNING: <strong>60</strong> value required</span>';
					$hosting_passed = false;
				} else {
					$time_limit_message_html = '';
				}

				echo '<li><strong>Max Execution Time:</strong> '.esc_html($time_limit).' seconds '.wp_kses_post($time_limit_message_html).'</li>';

				$max_input_vars = ini_get('max_input_vars');

				if ( $max_input_vars < 1000 && $max_input_vars != 0 || $max_input_vars == '' ) {
					$max_input_vars_limit_message_html = ' <span class="configuration-info">INFO: <strong>1000</strong> value recommended.</span>';
				} else {
					$max_input_vars_limit_message_html = '';
				}

				if($max_input_vars == '') {
					$max_input_vars = 'Not set';
				}

				echo '<li><strong>Max Input Vars:</strong> '.esc_html($max_input_vars).' '.wp_kses_post($max_input_vars_limit_message_html).'</li>';

				$s_max_input_vars = ini_get( 'suhosin.post.max_vars' );

				if(!empty($s_max_input_vars)) {

					if ( $s_max_input_vars < 1000 && $s_max_input_vars != 0 ) {
						$max_input_vars_limit_message_html = ' <span class="configuration-info">INFO: <strong>1000</strong> value recommended.</span>';
					} else {
						$max_input_vars_limit_message_html = '';
					}

					echo '<li><strong>Suhosin Post Max Vars:</strong> '.esc_html($s_max_input_vars).'.'.wp_kses_post($max_input_vars_limit_message_html).'</li>';

			    }

				echo '</ul>';

				?>
				<h3>System tools</h3>
				<?php
				// Tools

				// Flush theme cache
				if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'flushcache') {
					inhype_update_options_cache();

					echo '<div class="theme-admin-message">Theme cache files was regenerated.</div>';
				}

				// Reset activation
				if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'resetactivation') {
					delete_option('inhype_license_key_status');

					echo '<div class="theme-admin-message">Theme activation was reseted.</div>';
				}

				// Disable TOTD
				if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'disabletotd') {
					add_option('totd_disable', 1);

					echo '<div class="theme-admin-message">Daily tip feature disabled.</div>';
				}

				// Disable TOTD
				if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'enabletotd') {
					delete_option('totd_disable');

					echo '<div class="theme-admin-message">Daily tip feature enabled.</div>';
				}
				?>

				<table class="tools widefat" cellspacing="0">
					<tbody>
					<tr>
						<td>
							<strong>Flush theme options cache</strong>
							<p class="description">Perform if you does not see changes that you made in theme files that generate dynamic CSS styles (for ex. theme-css.php or theme-js.php files).</p>
						</td>
						<td>
							<a href="<?php echo esc_url(admin_url( 'themes.php?page=inhype_system_information&act=flushcache' )); ?>" class="button button-large">Flush cache</a>
						</td>
					</tr>
					<tr>
						<td>
							<strong>Reset theme activation</strong>
							<p class="description">You can reset theme activation if you want to register theme again for some reason.</p>
						</td>
						<td>
							<a href="<?php echo esc_url(admin_url( 'themes.php?page=inhype_system_information&act=resetactivation' )); ?>" class="button button-large">Reset activation</a>
						</td>
					</tr>
					<tr>
						<td>
							<strong>Daily tip messages</strong>
							<p class="description">You can disable/enable "Daily tip" messages in Dashboard.</p>
						</td>
						<td>
							<?php if(!get_option('totd_disable')): ?>
							<a class="button button-large" href="<?php echo esc_url(admin_url( 'themes.php?page=inhype_system_information&act=disabletotd' )); ?>">Disable daily tip</a>
							<?php else: ?>
							<a class="button button-large" href="<?php echo esc_url(admin_url( 'themes.php?page=inhype_system_information&act=enabletotd' )); ?>">Enable daily tip</a>
							<?php endif; ?>
						</td>
					</tr>

					</tbody>
				</table>
				</div>
			</div>
			<?php
		}


	}
}

new InHype_System;
