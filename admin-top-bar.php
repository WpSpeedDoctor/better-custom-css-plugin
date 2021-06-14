<?php

/**
 * Admin back-end
*/

if ( ! defined( 'WPINC' ) ) {
  die;
}

add_action( 'wp_before_admin_bar_render' , 'better_custom_css_admin_menu_bccss' );

if ( ! function_exists( 'better_custom_css_admin_menu_bccss' )){
	function better_custom_css_admin_menu_bccss() {

		if (!current_user_can( 'manage_options' )) return;

		global $wp_admin_bar, $wp;
		
		$current_slug = add_query_arg(  'bccss', '' );

		$args = array(
				'id' => 'bccss-top-menu',
				'title' => _('Better Custom CSS'),
				'href' => $current_slug,
				'meta' => array()
		);

		$wp_admin_bar->add_menu($args);

		submenus_bccss($current_slug);

	}
}

if ( ! function_exists( 'get_submenus_array_bccss' )){
	function get_submenus_array_bccss() {
		$submenu_create_for = array( 
			
									'template',
									'page',
									'inline'
								);

		if ( is_woo_active_bccss() ){

			$submenu_create_for[]='woocommerce';

			$submenu_create_for[]='woocommerce-page';
		}

		return $submenu_create_for;

	}
}



if ( ! function_exists( 'submenus_bccss' )){
	function submenus_bccss( $current_slug ) {
		
		$submenu_create_for = get_submenus_array_bccss();

		foreach ( $submenu_create_for as $key => $css_type) {

			$css_asset_file_array = get_css_file_path_bccss($css_type);
			
			if ( $css_asset_file_array )

				add_submenu_bccss( $css_type, $css_asset_file_array['present'], $key, $current_slug );
		}

	
	}
}

if ( ! function_exists( 'get_sumenu_display_name_bccss' )){
	function get_sumenu_display_name_bccss( $css_type ) {
	
		if ( $css_type == 'woocommerce' ) return _('all woocommerce pages');

		if ( $css_type == 'woocommerce-page' ) return remove_dashes_from_string_bccss( get_woocommerce_page_type_bccss() );
		
		if ( $css_type == 'template' )  {

			global $template;

			return _('current theme template').' "'.basename($template,'.php').'"';
		}
		
		if ( $css_type == 'inline' ) return 'current page inline';

		return _('current').' '.remove_dashes_from_string_bccss( $css_type );
	}
}


if ( ! function_exists( 'add_submenu_bccss' )){
	function add_submenu_bccss( $css_type, $present, $key, $current_slug) {
		
		global $wp_admin_bar;

		$menu_display_name = get_sumenu_display_name_bccss( $css_type );

		$args = array(
				'id' => 'bccss-top-submenu'.$key,
				'parent' => 'bccss-top-menu',
				'meta' => array()
		);

		if (!$present) {

			$args['title'] = _('Create CSS file for').' '._( $menu_display_name );

			$args['href'] = $current_slug.'='.$css_type;

		} else {

			$args['title'] = '<i>'.ucfirst($menu_display_name).' '._( 'CSS file is already present').'</i>';

		}

		$wp_admin_bar->add_menu($args);
	
	}
}
