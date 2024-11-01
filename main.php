<?php
/**
 * Plugin Name:       WPB Instagram Gallery Slider and Grid
 * Plugin URI:        https://wpbean.com/product/wpb-instagram-slider
 * Description:       Creating Instagram Images Slider in WordPress Site.
 * Version:           1.0.3
 * Author:            WpBean
 * Author URI:        https://wpbean.com
 * Text Domain:       wpb-instagram-slider
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 


/**
 * Checking If PRO version active
 */

if ( defined( 'WPB_INSTAGRAM_SLIDER_PRO' ) ) {
	return false;
}

/**
 * Remove plugin option on plugin deactivation
 */

register_deactivation_hook( __FILE__, 'wpb_is_plugin_deactivation_hook' );

if( !function_exists( 'wpb_is_plugin_deactivation_hook' ) ){
	function wpb_is_plugin_deactivation_hook() {

		$keep_settings_when_plugin_removed = wpb_is_get_option( 'keep_settings_when_plugin_removed', 'wpb_is_general', '' );

		if( $keep_settings_when_plugin_removed != 'on' ){
			delete_option( 'wpb_is_access_token' );
	    	delete_option( 'wpb_is_user_id' );
		}
	}
}

/**
 * Define constant
 */

define( 'WPB_IS_TEXTDOMAIN', 'wpb-instagram-slider' );
define( 'WPB_IS_PLUGIN_DIR', plugin_dir_path(__FILE__) );
define( 'WPB_IS_PLUGIN_DIR_FILE', __FILE__ );


/**
 * Localization
 */

add_action( 'init', 'wpb_is_textdomain' );

if( !function_exists( 'wpb_is_textdomain' ) ){
	function wpb_is_textdomain() {
		load_plugin_textdomain( WPB_IS_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

/**
 * Add plugin action links
 */

if( !function_exists( 'wpb_is_plugin_actions' ) ){
	function wpb_is_plugin_actions( $links ) {
		if( is_admin() ){
			$links[] = '<a href="https://wpbean.com/support/" target="_blank">'. __('Support', WPB_IS_TEXTDOMAIN) .'</a>';
			$links[] = '<a href="admin.php?page=wpb-instagram-slider-about">'. __('Setup Access Token', WPB_IS_TEXTDOMAIN) .'</a>';
			$links[] = '<a href="admin.php?page=wpb-instagram-slider-settings">'. __('Settings', WPB_IS_TEXTDOMAIN) .'</a>';
		}
		return $links;
	}
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'wpb_is_plugin_actions' );


/**
 * Requred files 
 */

require_once dirname( __FILE__ ) . '/inc/plugin-functions.php';
require_once dirname( __FILE__ ) . '/inc/plugin-shortcode.php';

require_once dirname( __FILE__ ) . '/admin/settings/class-setting-api.php';
require_once dirname( __FILE__ ) . '/admin/settings/class-setting-config.php';