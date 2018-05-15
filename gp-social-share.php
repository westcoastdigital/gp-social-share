<?php
/*
Plugin Name: GP Social Share
Plugin URI: https://github.com/WestCoastDigital/gp-social-share
Description: Add social share icons to single posts within GeneratePress
Version: 1.0.2
Author: Jon Mather
Author URI: https://github.com/WestCoastDigital/
Text Domain: gp-social
Domain Path: /languages
*/

// Get current theme
$theme = wp_get_theme();

// Ensure GeneratePress is current or parent theme
if ( 'GeneratePress' == $theme->name || 'GeneratePress' == $theme->parent_theme ) {

	require_once( plugin_dir_path( __FILE__ ) . 'inc/class-social-share.php' );
	add_action( 'wp_enqueue_scripts', 'wcdgpSocialShare::register_styles_scripts' );
	$options = get_option( 'social_share_options' );
		$select = $options['hook_select_field'];

	   if ( $select == 5 ) {
			add_action( 'generate_after_content', 'wcdgpSocialShare::add_social_icons' );
		} elseif ( $select == 1 ) {
			add_action( 'generate_before_content', 'wcdgpSocialShare::add_social_icons' );
		} elseif ( $select == 2 ) {
			add_action( 'generate_before_entry_title', 'wcdgpSocialShare::add_social_icons' );
		} elseif ( $select == 3 ) {
			add_action( 'generate_after_entry_title', 'wcdgpSocialShare::add_social_icons' );
		} elseif ( $select == 4 ) {
			add_action( 'generate_after_entry_content', 'wcdgpSocialShare::add_social_icons' );
		} elseif ( $select == 6 ) {
			add_action( 'generate_before_comments_container', 'wcdgpSocialShare::add_social_icons' );
		} elseif ( $select == 7 ) {
			add_action( 'generate_inside_comments', 'wcdgpSocialShare::add_social_icons' );
		} elseif ( $select == 8 ) {
			add_action( 'generate_below_comments_title', 'wcdgpSocialShare::add_social_icons' );
		} elseif ( $select == 9 ) {
			add_action( 'generate_after_main_content', 'wcdgpSocialShare::add_social_icons' );
		} elseif ( $select == 10 ) {
			add_action( 'generate_before_right_sidebar_content', 'wcdgpSocialShare::add_social_icons' );
		} elseif ( $select == 11 ) {
			add_action( 'generate_after_right_sidebar_content', 'wcdgpSocialShare::add_social_icons' );
		} else {
			add_action( 'generate_after_content', 'wcdgpSocialShare::add_social_icons' );
		}
	add_action( 'admin_menu', 'wcdgpSocialShare::add_admin_menu' );
	add_action( 'admin_init', 'wcdgpSocialShare::social_share_options_init' );
	add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'wcdgpSocialShare::settings_link' );

}