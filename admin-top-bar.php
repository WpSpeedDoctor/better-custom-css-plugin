<?php

/**
 * Admin back-end
*/

if ( ! defined( 'WPINC' ) ) {
  die;
}

add_action( 'wp_before_admin_bar_render' , 'better_custom_css_admin_menu' );

if ( ! function_exists( 'better_custom_css_admin_menu' )){
    function better_custom_css_admin_menu() {

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

        bccss_submenus($current_slug);

    }
}

if ( ! function_exists( 'bccss_get_submenus_array' )){
    function bccss_get_submenus_array() {
        $submenu_create_for = array( 
            
                                    'template',
                                    'page',
                                    'inline'
                                );

        if ( is_woo_active() ){

            $submenu_create_for[]='woocommerce';

            $submenu_create_for[]='woocommerce-page';
        }

        return $submenu_create_for;

    }
}



if ( ! function_exists( 'bccss_submenus' )){
    function bccss_submenus( $current_slug ) {
        
        $submenu_create_for = bccss_get_submenus_array();

        foreach ( $submenu_create_for as $key => $css_type) {

            $css_asset_file_array = get_css_file_path($css_type);
            
            if ( $css_asset_file_array )

                bccss_add_submenu( $css_type, $css_asset_file_array['present'], $key, $current_slug );
        }

    
    }
}

if ( ! function_exists( 'bccss_get_sumenu_display_name' )){
    function bccss_get_sumenu_display_name( $css_type ) {
    
        if ( $css_type == 'woocommerce' ) return 'all woocommerce pages';

        if ( $css_type == 'woocommerce-page' ) return str_remove_dashes( bccss_get_woocommerce_page_type() );
        
        if ( $css_type == 'template' )  {

            global $template;

            return 'current theme template "'.basename($template,'.php').'"';
        }
        
        if ( $css_type == 'inline' ) return 'current page inline';

        return 'current '.str_remove_dashes( $css_type );
    }
}


if ( ! function_exists( 'bccss_add_submenu' )){
    function bccss_add_submenu( $css_type, $present, $key, $current_slug) {
        
        global $wp_admin_bar;

        $menu_display_name = bccss_get_sumenu_display_name( $css_type );

        $args = array(
                'id' => 'bccss-top-submenu'.$key,
                'parent' => 'bccss-top-menu',
                'meta' => array()
        );

        if (!$present) {

            $args['title'] = _('Create CSS file for '.$menu_display_name);

            $args['href'] = $current_slug.'='.$css_type;

        } else {

            $args['title'] = '<i>'._( ucfirst($menu_display_name).' CSS file is already present').'</i>';

        }

        $wp_admin_bar->add_menu($args);
    
    }
}
