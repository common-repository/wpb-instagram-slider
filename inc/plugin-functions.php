<?php

/**
 * WPB Instagram Slider Plugin
 *
 * Main function file
 *
 * Author: WpBean
 */


/**
 * Get the setting values 
 */

if( !function_exists('wpb_is_get_option') ){
	function wpb_is_get_option( $option, $section, $default = '' ) {
	 
	    $options = get_option( $section );
	 
	    if ( isset( $options[$option] ) ) {
	        return $options[$option];
	    }
	 
	    return $default;
	}
}

/**
 * Get our data
 */

if( !function_exists('wpb_is_fetchData') ){
	function wpb_is_fetchData( $url ){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}

/**
 * Enqueue Script For Front-end
 */

if( !function_exists('wpb_is_adding_scripts') ){

	function wpb_is_adding_scripts() {

		wp_register_style( 'wpb-is-bootstrap-grid',  plugins_url( '../assets/css/bootstrap-grid.css', __FILE__ ), array(), '3.3.7' );

		wp_enqueue_style( 'owl-carousel',  plugins_url( '../assets/css/owl.carousel.css', __FILE__ ), array(), '2.2.1' );
		wp_enqueue_script( 'owl-carousel', plugins_url( '../assets/js/owl.carousel.js', __FILE__ ), array('jquery'), '2.2.1', false);

		wp_register_script( 'match-height', plugins_url( '../assets/js/jquery.matchHeight.js', __FILE__ ), array('jquery'), '0.7.2', false);

		wp_register_style( 'lightcase', plugins_url( '../assets/css/lightcase.css', __FILE__ ), array(), '2.4.0' );
		wp_register_script( 'lightcase', plugins_url( '../assets/js/lightcase.js', __FILE__ ), array('jquery'), '2.4.0', false);
		
		wp_enqueue_script( 'instafeed', plugins_url( '../assets/js/instafeed.js', __FILE__ ), array('jquery'), '1.9.3', false);

		wp_register_style( 'wpb-is-main', plugins_url( '../assets/css/main.css', __FILE__ ), array(), '1.0' );
		wp_register_script('wpb-is-main', plugins_url( '../assets/js/main.js', __FILE__ ), array('jquery'), '1.0', false);
		
	}

}
add_action( 'wp_enqueue_scripts', 'wpb_is_adding_scripts' );



/**
 * Data attribute Array to data types for slider
 */

if( !function_exists('wpb_is_data_attributes') ){
	function wpb_is_data_attributes( $array ){
		
		$output = array();

		if( !empty($array) ){
			foreach ($array as $key => $value) {
				$output[] = 'data-'. $key .'="'. $value .'" ';
			}
		}

		return $output;
	}
}



/**
 * Adding the menu page
 */

if( !function_exists('wpb_is_register_menu_page') ){
	function wpb_is_register_menu_page() {
	    add_menu_page(
	        __( 'WPB Instagram Slider', WPB_IS_TEXTDOMAIN ),
	        __( 'WPB Instagram', WPB_IS_TEXTDOMAIN ),
	        apply_filters( 'wpb_wcs_settings_user_capability', 'manage_options' ),
	        WPB_IS_TEXTDOMAIN.'-about',
	        'wpb_is_get_menu_page',
	        'dashicons-images-alt'
	    );
	}
}
add_action( 'admin_menu', 'wpb_is_register_menu_page' );


/**
 * Getting the menu page
 */

if( !function_exists('wpb_is_get_menu_page') ){
	function wpb_is_get_menu_page(){
		require ( 	WPB_IS_PLUGIN_DIR . 'admin/admin-page.php' );
	}
}


/**
 * Admin scripts
 */

if( !function_exists('wpb_is_load_admin_scripts') ){
	function wpb_is_load_admin_scripts() {
	    wp_register_style( 'wpb-is-admin', plugins_url( '../admin/assets/css/admin-style.css', __FILE__ ), array(), '1.0' );
	    wp_register_script( 'wpb-is-admin-js', plugins_url( '../admin/assets/js/admin-script.js', __FILE__ ) , array ('jquery'), '', true );
	}
}
add_action( 'admin_enqueue_scripts', 'wpb_is_load_admin_scripts' );



/**
 * Adding the Setting fields for configuring the Instagram access token
 */

add_action('admin_init', 'wpb_is_plugin_custom_settings');

if( !function_exists('wpb_is_plugin_custom_settings') ){
	function wpb_is_plugin_custom_settings() {
	    register_setting('wpb_is_settings', 'wpb_is_access_token');
	    register_setting('wpb_is_settings', 'wpb_is_user_id');
	    add_settings_section('wpb-is-custom-options', esc_html__( 'Configure Your Instagram Access Token', WPB_IS_TEXTDOMAIN ), 'wpb_is_custom_options', 'wpb_is_options');
	    add_settings_field('wpb_is_access_token', esc_html__( 'Access Token', WPB_IS_TEXTDOMAIN ), 'wpb_is_access_token', 'wpb_is_options', 'wpb-is-custom-options');
	    add_settings_field('wpb_is_user_id', esc_html__( 'User ID', WPB_IS_TEXTDOMAIN ), 'wpb_is_user_id', 'wpb_is_options', 'wpb-is-custom-options');
	}
}

if( !function_exists('wpb_is_custom_options') ){
	function wpb_is_custom_options() {
		$wpb_is_access_token = esc_attr( get_option('wpb_is_access_token') );
		$wpb_is_user_id = esc_attr( get_option('wpb_is_user_id') );

		if( $wpb_is_access_token == '' || $wpb_is_user_id == '' ){
			echo esc_html__( 'Login to your Instagram account and click the get access token button, after that save the changes.', WPB_IS_TEXTDOMAIN );
		}

	}
}

if( !function_exists('wpb_is_access_token') ){
	function wpb_is_access_token() {
	    $wpb_is_access_token = esc_attr( get_option('wpb_is_access_token') );
	    echo '<input type="text" name="wpb_is_access_token" value="'.$wpb_is_access_token.'" placeholder="'. esc_html__( 'Access Token', WPB_IS_TEXTDOMAIN ) .'" >';
	}
}

if( !function_exists('wpb_is_user_id') ){
	function wpb_is_user_id() {
	    $wpb_is_user_id = esc_attr( get_option('wpb_is_user_id') );
	    echo '<input type="text" name="wpb_is_user_id" value="'.$wpb_is_user_id.'" placeholder="'. esc_html__( 'User ID', WPB_IS_TEXTDOMAIN ) .'" >';
	}
}

if( !function_exists('wpb_is_reset_options_process') ){
	function wpb_is_reset_options_process( $input ) {
	    if ( isset($_POST['wpb_is_reset_options']) ) {
	        add_settings_error('wpb_is_settings', 'wpb_is_reset_options', __('Your settings has been changed defualt setting.', 'text-domain'), 'updated');
	        return array('wpb_is_access_token' => '', 'wpb_is_user_id' => '' ); //Default settings
	    }

	    return $input;
	}
}