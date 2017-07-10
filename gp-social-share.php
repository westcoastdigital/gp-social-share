<?php
/*
Plugin Name: GP Social Share
Plugin URI: https://github.com/WestCoastDigital/gp-social-share
Description: Add social share icons to single posts within GeneratePress
Version: 1.0.0
Author: Workpower Media
Author URI: https://workpowermedia.com.au
Text Domain: gp-social
Domain Path: /languages
*/

// Get current theme
$theme = wp_get_theme();

// Ensure GeneratePress is current or parent theme
if ( 'GeneratePress' == $theme->name || 'GeneratePress' == $theme->parent_theme ) {

	if( !function_exists( 'workpower_register_styles_scripts ') ) {

		function workpower_register_styles_scripts() {

			// Check if fontawesome is already enqueued
			if( !wp_style_is( 'fontawesome', 'enqueued' ) ) {

				// Register FontAwesome
				wp_register_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',  array(), 'all' );

			}

			wp_register_style( 'social-share-css', plugins_url( '/css/gp-social-share.css', __FILE__ ), array(), 'all' );
			
			wp_register_script( 'social-share-js', plugin_dir_url( __FILE__ ) . 'js/gp-social-share.js', array('jquery'), '1.0' );

		}
		add_action( 'wp_enqueue_scripts', 'workpower_register_styles_scripts' );

	} //  workpower_register_styles_scripts


	if( !function_exists( 'workpower_social_share_filter ') ) {

		function workpower_social_share_filter() {

			$title = get_the_title();
			$url = urlencode( get_permalink() );
			$excerpt = get_the_excerpt();
			$thumbnail = get_the_post_thumbnail_url( 'full' );

			$social_links = array(

				'<a href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '" class="fb-share" title="' . __( 'Share this post!', 'gp-social' ) . '"><i class="fa fa-facebook"></i></a>',
				'<a href="https://twitter.com/share?url=' . $url . '&text=' . $excerpt . '" class="tw-share" title="' . __( 'Tweet this post!', 'gp-social' ) . '"><i class="fa fa-twitter"></i></a>',
				'<a href="http://www.linkedin.com/shareArticle?url=' . $url . '&title=' . $title . '" class="li-share" title="' . __( 'Share this post!', 'gp-social' ) . '"><i class="fa fa-linkedin"></i></a>',
				'<a href="https://plus.google.com/share?url=' . $url . '" class="gp-share" title="' . __( 'Share this post!', 'gp-social' ) . '"><i class="fa fa-google-plus"></i></a>',
				'<a href="https://pinterest.com/pin/create/bookmarklet/?media=' . $thumbnail . '&url=' . $url . '&description=' . $title . '" class="pt-share" title="' . __( 'Pin this post!', 'gp-social' ) . '"><i class="fa fa-pinterest"></i></a>',
				'<a href="mailto:?Subject=' . urlencode( $title ) . '" target="_top" class="em-share" title="' . __( 'Email this post!', 'gp-social' ) . '"><i class="fa fa-envelope"></i></a>',

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

	} // workpower_social_share_filter



	if( !function_exists( 'workpower_add_social_icons ') ) {

		function workpower_add_social_icons() {

			// Check to ensure we are on a single post
			if ( is_single() ) {

				// Enqueue FontAwesome now we are in the hook
				if( !wp_style_is( 'fontawesome', 'enqueued' ) ) {
					
					wp_enqueue_style( 'fontawesome' );
					
				}

				// Enqueue base style now we are in the hook
				wp_enqueue_style( 'social-share-css' );

				// Enqueue base script now we are in the hook
				wp_enqueue_script( 'social-share-js' );

				// Echo out the social icons
				echo workpower_social_share_filter();

			}

		}
		add_action( 'generate_after_content', 'workpower_add_social_icons' );

	} // workpower_add_social_icons

}