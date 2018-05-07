<?php
/*
Plugin Name: GP Social Share - SVG
Plugin URI: https://github.com/WestCoastDigital/gp-social-share
Description: Add social share icons to single posts within GeneratePress
Version: 1.0.0
Author: Jon Mather
Author URI: https://github.com/WestCoastDigital/
Text Domain: gp-social
Domain Path: /languages
*/

require 'settings.php';

// Get current theme
$theme = wp_get_theme();

// Ensure GeneratePress is current or parent theme
if ( 'GeneratePress' == $theme->name || 'GeneratePress' == $theme->parent_theme ) {

	if( !function_exists( 'wcd_register_styles_scripts ') ) {

		function wcd_register_styles_scripts() {

			wp_register_style( 'social-share-css', plugins_url( '/css/gp-social-share.css', __FILE__ ), array(), 'all' );
			
			wp_register_script( 'social-share-js', plugin_dir_url( __FILE__ ) . 'js/gp-social-share.js', array('jquery'), '1.0' );

		}
		add_action( 'wp_enqueue_scripts', 'wcd_register_styles_scripts' );

	} //  wcd_register_styles_scripts


	if( !function_exists( 'wcd_social_share_filter ') ) {

		function wcd_social_share_filter() {

			$title = get_the_title();
			$url = urlencode( get_permalink() );
			$excerpt = wp_trim_words( get_the_content(), 40 );
			$thumbnail = get_the_post_thumbnail_url( 'full' );
			$options = get_option( 'wcd_social_share_options' );
			$facebook_icon = $options['gp_social_facebook'];
			$twitter_icon = $options['gp_social_twitter'];
			$linkedin_icon = $options['gp_social_linkedin'];
			$google_icon = $options['gp_social_google'];
			$pinterest_icon = $options['gp_social_pinterest'];
			$email_icon = $options['gp_social_email'];

			$social_links = array(

				'<a href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '" class="fb-share" title="' . __( 'Share this post!', 'gp-social' ) . '">' . $facebook_icon . '</a>',
				'<a href="https://twitter.com/share?url=' . $url . '&text=' . $excerpt . '" class="tw-share" title="' . __( 'Tweet this post!', 'gp-social' ) . '">' . $twitter_icon . '</a>',
				'<a href="http://www.linkedin.com/shareArticle?url=' . $url . '&title=' . $title . '" class="li-share" title="' . __( 'Share this post!', 'gp-social' ) . '">' . $linkedin_icon . '</a>',
				'<a href="https://plus.google.com/share?url=' . $url . '" class="gp-share" title="' . __( 'Share this post!', 'gp-social' ) . '">' . $google_icon . '</a>',
				'<a href="https://pinterest.com/pin/create/bookmarklet/?media=' . $thumbnail . '&url=' . $url . '&description=' . $title . '" class="pt-share" title="' . __( 'Pin this post!', 'gp-social' ) . '">' . $pinterest_icon . '</a>',
				'<a href="mailto:?Subject=' . urlencode( $title ) . '" target="_top" class="em-share" title="' . __( 'Email this post!', 'gp-social' ) . '">' . $email_icon . '</a>',

			);

			$list = '<ul id="gp-social-share">';

			// Users can now add additional icons as they require them (example in readme.md)
			if( has_filter('add_social_icons') ) {

				$social_links = apply_filters( 'add_social_icons', $social_links );

			}

			// Create the social list
			foreach( $social_links as $social_link ) :

				$list .= '<li>' . $social_link . '</li>';

			endforeach;

			$list .= '</ul>';

			return $list;
		}

	} // wcd_social_share_filter



	if( !function_exists( 'wcd_add_social_icons ') ) {

		function wcd_add_social_icons() {

			// Check to ensure we are on a single post
			if ( is_single() ) {

				// Enqueue base style now we are in the hook
				wp_enqueue_style( 'social-share-css' );

				// Enqueue base script now we are in the hook
				wp_enqueue_script( 'social-share-js' );

				// Echo out the social icons
				echo wcd_social_share_filter();

			}

		}
		add_action( 'generate_after_content', 'wcd_add_social_icons' );

	} // wcd_add_social_icons

}