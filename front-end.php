<?php

if ( ! defined( 'WPINC' ) ) {
  die;
}
	
$asset_location_bccss = get_asset_location_bccss();

define( 'BCCSS_ASSET_PATH', $asset_location_bccss["basedir"] );

define( 'BCCSS_ASSET_URL', $asset_location_bccss["baseurl"] );

define( 'BCCSS_ASSET_QS', isset( $_GET['bccss']) ? $_GET['bccss'] : false );


function get_asset_location_bccss(){

	if ( BCCSS_IS_PLUGIN ) 

		$result = array(

						'basedir' => trailingslashit(wp_get_upload_dir()["basedir"]).'better-custom-css/',

						'baseurl' => trailingslashit(wp_get_upload_dir()["baseurl"]).'better-custom-css/' 
					);

	else
	
		$result = array(

						'basedir' => trailingslashit( get_stylesheet_directory() ).'assets/css/',

						'baseurl' => trailingslashit( get_stylesheet_directory_uri() ).'assets/css/' 
					);

	return $result;

}



if ( !function_exists( 'load_my_styles' ) ){
	function load_styles_bccss() {

		create_css_file_bccss();
		
		load_css_bccss('template');
		
		load_css_bccss('woocommerce');

		load_css_bccss('woocommerce-page');

		load_css_bccss('page'); 
		
		load_css_bccss('inline'); 

		the_debug_bccss();
	}

	add_action( 'wp_print_styles', 'load_styles_bccss', 1 );
}

if ( ! function_exists( 'remove_dashes_from_string_bccss' ) ){
	function remove_dashes_from_string_bccss( $string ) {

		return str_replace( "-", " ", $string );
	
	}
}

if ( ! function_exists( 'is_woo_active_bccss' )){
	function is_woo_active_bccss() {
	
		return ( class_exists( 'WooCommerce' ) ? true : false );
	
	}
}


if ( ! function_exists( 'get_woocommerce_main_template_bccss' )){
	function get_woocommerce_main_template_bccss() {
	
		if ( !is_woo_active_bccss() || !get_woocommerce_page_type_bccss() ) return null;

		return 'template-woocommerce';
	
	}
}


if ( ! function_exists( 'get_woocommerce_page_type_bccss' )){
	function get_woocommerce_page_type_bccss() {
		
		if ( !is_woo_active_bccss() ) return null;

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

if ( ! function_exists( 'get_file_slug_bccss' )){
	function get_file_slug_bccss( $css_type ) {

		if ( $css_type == 'woocommerce') return get_woocommerce_main_template_bccss();

		if ( $css_type == 'woocommerce-page') return get_woocommerce_page_type_bccss();

		if ( $css_type == 'template') return get_template_slug_bccss();

		if ( is_single() || is_page() ) return $css_type.'-'.get_the_ID();

		return null;
	}
}

if ( ! function_exists( 'is_woo_template_present_bccss' )){
	function is_woo_template_present_bccss() {
	
		return get_woocommerce_page_type_bccss();
   
	}
}


if ( ! function_exists( 'get_template_slug_bccss' )){
	function get_template_slug_bccss() {
		
		if ( is_woo_template_present_bccss() ) return null;

		global $template;

		$result = basename($template,'.php');
		
		$result = str_replace("_","-", $result);

		return 'template-'.$result;
	}
}

if ( ! function_exists( 'the_debug_bccss_window_bccss' )){
	function the_debug_bccss_window_bccss( $value='' ) {
		
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

if ( ! function_exists( 'enqueue_style_bccss' )){
	function enqueue_style_bccss( $handle, $file ) {
		
		$style_url =  BCCSS_ASSET_URL. $file;

		$style_path = BCCSS_ASSET_PATH. $file;

		$css_query_string = filemtime( $style_path );

		wp_enqueue_style( $handle, $style_url, array(), $css_query_string, false );

	}
}

if ( ! function_exists( 'the_debug_bccss' )){
	function the_debug_bccss() {
		
		if ( BCCSS_ASSET_QS === false ) return;

		if ( !current_user_can( 'manage_options' ) ) return;

		global $debug_data_css;

		the_debug_bccss_window_bccss($debug_data_css);

	
	}
}

if ( ! function_exists( 'add_to_debug_bccss' )){
	function add_to_debug_bccss($value) {
		global $debug_data_css;

		if (!isset($debug_data_css)) $GLOBALS['debug_data_css'] =='';

		$GLOBALS['debug_data_css'] .= ( empty($value) === true ? '' : $value.'<br>');
	}
}


if ( ! function_exists( 'create_assets_css_folder_bccss' )){
	function create_assets_css_folder_bccss() {
		
		if (!file_exists(BCCSS_ASSET_PATH)) {
			mkdir( BCCSS_ASSET_PATH, 0755, true);
		}
  
	}
}

if ( ! function_exists( 'get_create_filename_bccss' )){
	function get_create_filename_bccss() {
	
		return ( BCCSS_ASSET_QS ? get_file_slug_bccss (BCCSS_ASSET_QS) : false);

	}
}


if ( ! function_exists( 'create_css_file_bccss' )){
	function create_css_file_bccss() {
		
		if( !current_user_can( 'manage_options' ) ) return;

		$filename = get_create_filename_bccss();

		if ($filename === false ) return;

		$file_path = BCCSS_ASSET_PATH.$filename.'.css';

		if ( file_exists( $file_path) ) {

			the_debug_bccss_window_bccss('Already exists -> '.$file_path);
			
			return;
		}

		create_assets_css_folder_bccss();

		$create_file = fopen ($file_path, 'w');

		fclose($create_file);

		the_debug_bccss_window_bccss('Created -> '.$file_path);

	}
}

if ( ! function_exists( 'get_css_file_path_bccss' )){
	function get_css_file_path_bccss($css_type) {
	
		$file_slug = get_file_slug_bccss($css_type);
		
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

if ( ! function_exists( 'enqueue_inline_style_bccss' )){
	function enqueue_inline_style_bccss( $handle, $file_name ) {
	   
		$file_path = BCCSS_ASSET_PATH. $file_name;

		$inline_content = file_get_contents($file_path);
		
		wp_register_style( $handle, false );

		wp_enqueue_style( $handle );

		wp_add_inline_style( $handle, $inline_content );
	
	}
}


if ( ! function_exists( 'load_css_bccss' )){
	function load_css_bccss( $css_type ) {
		
		$css_asset_file_array = get_css_file_path_bccss($css_type);
		
		if ($css_asset_file_array === null ) return;
		
		if ( !$css_asset_file_array || !$css_asset_file_array['present'] ) {

			$file_path = ( $css_asset_file_array ? ' -> '.$css_asset_file_array['filepath'] : '' );

			add_to_debug_bccss( 'Not present '._( get_display_debug_name_bccss( $css_type, $css_asset_file_array ) ).$file_path);

			return;
		}	
		
		$handle = $css_asset_file_array['handle'];

		$filename = $css_asset_file_array['filename'];

		$filepath = $css_asset_file_array['filepath'];

		if ($css_type == 'inline') {

			enqueue_inline_style_bccss( $handle , $filename  );

		} else {

			enqueue_style_bccss( $handle , $filename );

		}

		add_to_debug_bccss( _( 'Loaded ' ). get_display_debug_name_bccss( $css_type, $css_asset_file_array ) .' -> '.$filepath );			
		
	}
}

if ( ! function_exists( 'get_display_debug_name_bccss' )){
	function get_display_debug_name_bccss( $css_type, $css_asset_file_array ) {
	
		if ( $css_type = 'woocommerce-page') return remove_dashes_from_string_bccss($css_asset_file_array['handle']);

		return $css_type;
	
	}
}

