<?php

if ( ! defined( 'WPINC' ) ) {
  die;
}

if ( BCCSS_IS_PLUGIN && ! function_exists( 'add_action_links' ) && basename($_SERVER['REQUEST_URI']) == 'plugins.php' ){
    
    function add_action_links ( $actions ) {

    	$admin_submenu_location = get_admin_submenu_location();

       $mylinks = array(
          '<a href="' . admin_url( $admin_submenu_location.'?page=better_custom_css' ) . '">Settings</a>',
       );

       $actions = array_merge( $mylinks, $actions );

       return $actions;
    }

add_filter( 'plugin_action_links_' .'better-custom-css/better-custom-css.php', 'add_action_links' );

}

if ( ! function_exists( 'register_plugin_settings_bccss' )){
	function register_plugin_settings_bccss( $modules ) {
		
		register_setting( 'bccss-settings', 'bccss-disabled' );
	
	}
	
	add_action ('init', 'register_plugin_settings_bccss');
}


if ( ! function_exists( 'custom_menu_bccss' )){
	function custom_menu_bccss() {

		$admin_submenu_location = get_admin_submenu_location();

		add_submenu_page( 

			$admin_submenu_location, 
			'Better Custom CSS', 
			'Better Custom CSS', 
			'administrator', 
			'better_custom_css', 
			'admin_page_bccss', 
			'dashicons-layout' 

		);
	}
	add_action('admin_menu', 'custom_menu_bccss');
}

if ( ! function_exists( 'get_admin_submenu_location' )){
	function get_admin_submenu_location() {
	
	return BCCSS_IS_PLUGIN  ? 'options-general.php' : 'themes.php';
	
	}
}


if ( ! function_exists( 'admin_page_bccss' )){
	function admin_page_bccss() {
		
		$setting_value = get_option('bccss-disabled');

		$setting_status = ( $setting_value == '1' ? 'checked' : '');

		disable_autoload_in_options_table_bccss( $setting_value )

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

				<?php if ( BCCSS_IS_PLUGIN ) the_plugin_location_message() ?>
				
			</div>
		</div>
		<?php

	}
}

if ( ! function_exists( 'the_plugin_location_message' )){
	function the_plugin_location_message() {
	
		?>
		<p style="max-width:600px">
			<?php echo _("You're running Better Custom CSS as a plugin. To avoid accidental deactivation, you can run Better Custom CSS code directly from the child theme. Just move plugin folder to the child theme folder and add to functions.php in the child theme:");?>
		</p>
		
		<p style="max-width: 600px;background-color: #ddd;width: fit-content;padding: 0 10px 3px;font-weight: 500;">
			require_once ( trailingslashit( get_theme_file_path() ) . 'better-custom-css/better-custom-css.php');
		</p>
		
		<p style="max-width:600px">
			<?php echo _('After you do that, this plugin\'s settings menu will be automatically moved to theme menu "Appearance".'); ?>
		</p>

		<?php

	}
}


if ( ! function_exists( 'disable_autoload_in_options_table_bccss' )){
	function disable_autoload_in_options_table_bccss( $setting_value ) {
	
		$setting_status_string = ( $setting_value == '1' ? '1' : '0');

		if ( isset( $_REQUEST["settings-updated"] ) ) update_option( 'bccss-disabled', $setting_status_string , 'no' );
	
	}
}
