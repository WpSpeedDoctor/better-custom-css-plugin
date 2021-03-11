<?php

if ( ! defined( 'WPINC' ) ) {
  die;
}

if ( ! function_exists( 'register_bccss_plugin_settings' )){
	function register_bccss_plugin_settings( $modules ) {
		
		register_setting( 'bccss-settings', 'bccss-disabled' );
	
	}
	
	add_action ('init', 'register_bccss_plugin_settings');
}


if ( ! function_exists( 'custom_menu' )){
	function custom_menu() {
		add_submenu_page('options-general.php', 
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