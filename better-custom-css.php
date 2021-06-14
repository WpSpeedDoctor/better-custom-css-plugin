<?php
	
/**
 * @wordpress-plugin
 * Plugin Name:       Better custom CSS
 * Description:       A better way to add custom CSS per page or temaplate
 * Version:           1.1.1
 * Author:            Jaro Kurimsky <pixtweaks@protonmail.com>
 * Author URI:        https://github.com/WpSpeedDoctor/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */


if ( ! defined( 'WPINC' ) ) {
  die;
}

define('BCCSS_IS_PLUGIN', is_int( strpos( __DIR__, basename(WP_PLUGIN_DIR) ) ) );

start_bccss();

function start_bccss() {

	if (is_admin()) {
	
		back_end_bccss();

	} else {

		front_end_bccss();

	}

}


function load_topbar_menu_for_admin_bccss() {

		if ( current_user_can( 'manage_options' ) && !get_option('bccss-disabled') )
		
			require_once plugin_dir_path( __FILE__ ) . 'admin-top-bar.php';
}



function front_end_bccss() {

	require_once plugin_dir_path( __FILE__ ) . 'front-end.php'; 

	add_action('wp','load_topbar_menu_for_admin_bccss');

}



function back_end_bccss() {

	require_once plugin_dir_path( __FILE__ ) . 'admin-menu.php';

}

