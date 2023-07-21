<?php
/**
Plugin Name: Traveler Rest API
Plugin URI: https://shinetheme.com/
Description: This plugin is used for Traveler Theme
Version: 1.0.2
Author: ShineTheme
Author URI: https://shinetheme.com/
License: GPLv2 or later
Text Domain: traveler-rest-api
*/
if ( !function_exists( 'add_action' ) ) {
	echo __('Hi there!  I\'m just a plugin, not much I can do when called directly.','traveler-rest-api');
	exit;
}
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}
define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}


function stt_add_plugin_link( $links, $file ) {
	
    if ( $file != basename( plugin_dir_path( __FILE__ ) ) . '/traveler-rest-api.php' ) {
		return $links;
	}
	if ( ! current_user_can( 'administrator' ) ) {
		return $links;
	}
    
    $settings_link = sprintf( __( '<a href="%s">Settings</a>', 'traveler-rest-api' ), esc_url( admin_url( 'admin.php?page=st_traveler_option#/option_bc' ) ) );

	array_unshift( $links, $settings_link );

	return $links;
}
add_filter( 'plugin_action_links', 'stt_add_plugin_link', 10, 2 );
