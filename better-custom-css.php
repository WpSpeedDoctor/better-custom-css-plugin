<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Better custom CSS
 * Description:       A better way to add custom CSS per page or temaplate
 * Version:           1.0.0
 * Author:            Jaro Kurimsky <pixtweaks@protonmail.com>
 * Author URI:        https://github.com/WpSpeedDoctor/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
  die;
}
	
if ( ! function_exists( 'bccss_check_if_user_is_admin' )){
	function bccss_check_if_user_is_admin() {

			if ( current_user_can( 'manage_options' ) && !get_option('bccss-disabled') )
			
				require_once plugin_dir_path( __FILE__ ) . 'admin-top-bar.php';
	}
}

if ( ! function_exists( 'bccss_front_end' )){
	function bccss_front_end() {
	
		require_once plugin_dir_path( __FILE__ ) . 'front-end.php'; 

		add_action('wp','bccss_check_if_user_is_admin');

	}
}

if ( ! function_exists( 'bccss_back_end' )){
	function bccss_back_end() {
	
		require_once plugin_dir_path( __FILE__ ) . 'admin-menu.php';
	
	}
}

if (is_admin()) {
	
	bccss_back_end();

} else {

	bccss_front_end();

}
