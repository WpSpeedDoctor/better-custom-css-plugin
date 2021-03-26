<?php

if ( ! defined( 'WPINC' ) ) {
  die;
}

define( 'BCCSS_ASSET_PATH', trailingslashit(wp_get_upload_dir()["basedir"]).'better-custom-css/');

define( 'BCCSS_ASSET_URL', trailingslashit(wp_get_upload_dir()["baseurl"]).'better-custom-css/');

define( 'BCCSS_ASSET_QS', isset( $_GET['bccss']) ? $_GET['bccss'] : false );


if ( !function_exists( 'load_my_styles' ) ){
    function load_bccss_styles() {

        create_css_file();
        
        load_css('template');
        
        load_css('woocommerce');

        load_css('woocommerce-page');

        load_css('page'); 
        
        load_css('inline'); 

        the_debug();
    }

    add_action( 'wp_print_styles', 'load_bccss_styles', 1 );
}

if ( ! function_exists( 'str_remove_dashes' ) ){
	function str_remove_dashes( $string ) {
	
		return str_replace( "-", " ", $string );
	
	}
}

if ( ! function_exists( 'is_woo_active' )){
    function is_woo_active() {
    
        return ( class_exists( 'WooCommerce' ) ? true : false );
    
    }
}


if ( ! function_exists( 'bccss_get_woocommerce_main_template' )){
    function bccss_get_woocommerce_main_template() {
    
        if ( !is_woo_active() || !bccss_get_woocommerce_page_type() ) return null;

        return 'template-woocommerce';
    
    }
}


if ( ! function_exists( 'bccss_get_woocommerce_page_type' )){
    function bccss_get_woocommerce_page_type() {
        
        if ( !is_woo_active() ) return null;

        if ( is_cart() ) return 'woocommerce-cart';
        
        if ( is_account_page() ) return 'woocommerce-account';

        if ( is_shop() ) return 'woocommerce-shop';

        if ( is_product() ) return 'woocommerce-product';

        if ( is_product_category() ) return 'woocommerce-product-category';

        if ( is_product_tag() ) return 'woocommerce-product-tag';
        
        if ( is_checkout() ) return 'woocommerce-checkout';

        // if (  ) return 'woocommerce-';

        // if (  ) return 'woocommerce-';

        // if (  ) return 'woocommerce-';

        return null;
    
    }
}

if ( ! function_exists( 'get_file_slug' )){
    function get_file_slug( $css_type ) {

        if ( $css_type == 'woocommerce') return bccss_get_woocommerce_main_template();

        if ( $css_type == 'woocommerce-page') return bccss_get_woocommerce_page_type();

        if ( $css_type == 'template') return get_template_slug();

        if ( is_single() || is_page() ) return $css_type.'-'.get_the_ID();

        return null;
    }
}

if ( ! function_exists( 'is_woo_template_present' )){
    function is_woo_template_present() {
    
        return bccss_get_woocommerce_page_type();
   
    }
}


if ( ! function_exists( 'get_template_slug' )){
    function get_template_slug() {
        
        if ( is_woo_template_present() ) return null;

        global $template;

        $result = basename($template,'.php');
        
        $result = str_replace("_","-", $result);

        return 'template-'.$result;
    }
}

if ( ! function_exists( 'the_debug_window' )){
    function the_debug_window( $value='' ) {
        
        if (empty($value)) return;

        ?>
        <style>
            .debug_box {
                position:fixed;
                bottom:55px;
                right:10px;
                z-index:9999;
                background-color:#ddd;
                border:1px solid grey;
                line-height:30px;
                color:#000;
                font-size:20px;
                max-height:800px;
                overflow-y:scroll;
                padding:0 35px 0 5px;
            }
        </style>
        <div id="dw" class="debug_box"><?php echo $value; ?></div>
        <?php
    }
}

if ( ! function_exists( 'bccss_enqueue_style' )){
    function bccss_enqueue_style( $handle, $file ) {
        
        $style_url =  BCCSS_ASSET_URL. $file;

        $style_path = BCCSS_ASSET_PATH. $file;

        $css_query_string = filemtime( $style_path );

        wp_enqueue_style( $handle, $style_url, array(), $css_query_string, false );

    }
}

if ( ! function_exists( 'the_debug' )){
    function the_debug() {
        
        if ( BCCSS_ASSET_QS === false ) return;

        if ( !current_user_can( 'manage_options' ) ) return;

        global $debug_data_css;

        the_debug_window($debug_data_css);

    
    }
}

if ( ! function_exists( 'add_to_debug' )){
    function add_to_debug($value) {
        global $debug_data_css;

        if (!isset($debug_data_css)) $GLOBALS['debug_data_css'] =='';

        $GLOBALS['debug_data_css'] .= ( empty($value) === true ? '' : $value.'<br>');
    }
}


if ( ! function_exists( 'create_assets_css_folder' )){
    function create_assets_css_folder() {
        
        if (!file_exists(BCCSS_ASSET_PATH)) {
            mkdir( BCCSS_ASSET_PATH, 0755, true);
        }
  
    }
}

if ( ! function_exists( 'get_create_filename' )){
    function get_create_filename() {
    
        return ( BCCSS_ASSET_QS ? get_file_slug (BCCSS_ASSET_QS) : false);

    }
}


if ( ! function_exists( 'create_css_file' )){
    function create_css_file() {
        
        if( !current_user_can( 'manage_options' ) ) return;

        $filename = get_create_filename();

        if ($filename === false ) return;

        $file_path = BCCSS_ASSET_PATH.$filename.'.css';

        if ( file_exists( $file_path) ) {

            the_debug_window('Already exists -> '.$file_path);
            
            return;
        }

        create_assets_css_folder();

        $create_file = fopen ($file_path, 'w');

        fclose($create_file);

        the_debug_window('Created -> '.$file_path);

    }
}

if ( ! function_exists( 'get_css_file_path' )){
	function get_css_file_path($css_type) {
	
		$file_slug = get_file_slug($css_type);
        
        if (!$file_slug) return $file_slug;

        $file_name = $file_slug.'.css';

        $css_file_path = BCCSS_ASSET_PATH.$file_name;

    	$result['handle'] = $file_slug;
    
    	$result['filepath'] = $css_file_path;

    	$result['filename'] = $file_name;

        $result['present'] = file_exists($css_file_path);

        return $result;
	
	}
}

if ( ! function_exists( 'bccss_enqueue_inline_style' )){
	function bccss_enqueue_inline_style( $handle, $file_name ) {
	   
        $file_path = BCCSS_ASSET_PATH. $file_name;

        $inline_content = file_get_contents($file_path);
        
        wp_register_style( $handle, false );

        wp_enqueue_style( $handle );

        wp_add_inline_style( $handle, $inline_content );
	
	}
}


if ( ! function_exists( 'load_css' )){
    function load_css( $css_type ) {
        
        $css_asset_file_array = get_css_file_path($css_type);
        
        if ($css_asset_file_array === null ) return;
        
        if ( !$css_asset_file_array || !$css_asset_file_array['present'] ) {

            $file_path = ( $css_asset_file_array ? ' -> '.$css_asset_file_array['filepath'] : '' );

        	add_to_debug( 'Not present '._( bccss_get_display_debug_name( $css_type, $css_asset_file_array ) ).$file_path);

        	return;
        }    
        
        $handle = $css_asset_file_array['handle'];

        $filename = $css_asset_file_array['filename'];

        $filepath = $css_asset_file_array['filepath'];

        if ($css_type == 'inline') {

        	bccss_enqueue_inline_style( $handle , $filename  );

        } else {

            bccss_enqueue_style( $handle , $filename );

        }

        add_to_debug( 'Loaded '._( bccss_get_display_debug_name( $css_type, $css_asset_file_array ) ).' -> '.$filepath );            
        
    }
}

if ( ! function_exists( 'bccss_get_display_debug_name' )){
	function bccss_get_display_debug_name( $css_type, $css_asset_file_array ) {
	
		if ( $css_type = 'woocommerce-page') return str_remove_dashes($css_asset_file_array['handle']);

		return $css_type;
	
	}
}

