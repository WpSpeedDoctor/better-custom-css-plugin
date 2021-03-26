<?php

if ( ! defined( 'WPINC' ) ) {
  die;
}

if ( ! function_exists( 'is_inside_the_theme' ) ){
	function is_inside_the_theme() {

	return is_int( strpos(__DIR__, basename( get_theme_file_path() ) ));
	}
}

if ( ! function_exists( 'register_bccss_plugin_settings' )){
	function register_bccss_plugin_settings( $modules ) {
		
		register_setting( 'bccss-settings', 'bccss-disabled' );
	
	}
	
	add_action ('init', 'register_bccss_plugin_settings');
}


if ( ! function_exists( 'custom_menu' )){
	function custom_menu() {

		$admin_submenu_location = ( is_inside_the_theme()  ? 'themes.php': 'options-general.php' );

		add_submenu_page( 

			$admin_submenu_location, 
			'Better Custom CSS', 
			'Better Custom CSS', 
			'administrator', 
			'better_custom_css', 
			'bc_css_admin_page', 
			'dashicons-layout' 

		);
	}
	add_action('admin_menu', 'custom_menu');
}

if ( ! function_exists( 'bc_css_admin_page' )){
	function bc_css_admin_page() {
		
		$setting_value = get_option('bccss-disabled');

		$setting_status = ( $setting_value == '1' ? 'checked' : '');

		bccss_disable_autoload( $setting_value )

		?>
		<div id="wpbody-content">
			<div class="wrap">
				<h1>Better custom CSS</h1>
				<form class="form-table" method="post" action="options.php" >
					<?php
					
					settings_fields( 'bccss-settings' ); 

					do_settings_sections( 'bccss-settings' ); 
								
					?>
					<label for="disabled-top-bar">Disable menu on the admin bar
						<input id="disabled-top-bar" type="checkbox" name="bccss-disabled" value="1" <?php echo $setting_status ?> >
					</label>
					<br>
					<?php submit_button('Save settings'); ?>
				</form>

				<?php
				if (!is_inside_the_theme()) {
					
					echo '<p style="max-width:600px">'._('You\'re running Better Custom CSS as a plugin. To avoid accidental deactivation, you can run Better Custom CSS code directly from the child theme. Just move plugin folder to the child theme folder and add to functions.php in the child theme:') . '</p>';
					
					echo '<p style="max-width: 600px;background-color: #ddd;width: fit-content;padding: 0 10px 3px;font-weight: 500;">require_once ( trailingslashit( get_theme_file_path() ) . \''.basename(__DIR__).'/better-custom-css.php\'); </p>';
					
					echo '<p style="max-width:600px">'._('After you do that, this plugin\'s settings menu will be automatically moved to theme menu "Appearance".') . '</p>';
					
					
					
				}
				?>
				
			</div>
		</div>
		<?php

	}
}

if ( ! function_exists( 'bccss_disable_autoload' )){
	function bccss_disable_autoload( $setting_value ) {
	
		$setting_status_string = ( $setting_value == '1' ? '1' : '0');

		if ( isset( $_REQUEST["settings-updated"] ) ) update_option( 'bccss-disabled', $setting_status_string , 'no' );
	
	}
}
