<?php

defined( 'ABSPATH' ) or die( 'Cannot access pages directly.' );

if ( !class_exists( 'wcdgpSocialShare' ) ) {

    class wcdgpSocialShare {

        public function social_share_filter() {

            $title = get_the_title();
            $url = urlencode( get_permalink() );
            $excerpt = wp_trim_words( get_the_content(), 40 );
            $thumbnail = get_the_post_thumbnail_url( 'full' );
            $options = get_option( 'social_share_options' );
            $facebook = $options['gp_social_facebook'];
            $author = get_the_author();
            if( $facebook ) {
                $facebook_icon = $facebook;
            } else {
                $facebook_icon = wcdgpSocialShare::default_facebook();
            }
            $twitter = $options['gp_social_twitter'];
            if( $twitter ) {
                $twitter_icon = $facebook;
            } else {
                $twitter_icon = wcdgpSocialShare::default_twitter();
            }
            $linkedin = $options['gp_social_linkedin'];
            if( $linkedin ) {
                $linkedin_icon = $linkedin;
            } else {
                $linkedin_icon = wcdgpSocialShare::default_linkedin();
            }
            $google = $options['gp_social_google'];
            if( $google ) {
                $google_icon = $google;
            } else {
                $google_icon = wcdgpSocialShare::default_google();
            }
            $pinterest = $options['gp_social_pinterest'];
            if( $pinterest ) {
                $pinterest_icon = $pinterest;
            } else {
                $pinterest_icon = wcdgpSocialShare::default_pinterest();
            }
            $whatsapp = $options['gp_social_whatsapp'];
            if( $whatsapp ) {
                $whatsapp_icon = $whatsapp;
            } else {
                $whatsapp_icon = wcdgpSocialShare::default_whatsapp();
            }
            $email = $options['gp_social_email'];
            if( $email ) {
                $email_icon = $email;
            } else {
                $email_icon = wcdgpSocialShare::default_email();
            }
            
            if ( !function_exists( 'gp_social_email_body' ) ) {
                $email_body = __('Check out this awesome article by', 'gp-social');
                $email_body .= ' ' . $author . '. ';
                $email_body .= $url;
            } else {
                $email_body = gp_social_email_body();
            }

            $social_links = array(

                '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '" onclick="return false" class="fb-share" title="' . __( 'Share this post!', 'gp-social' ) . '">' . $facebook_icon . '</a>',
                '<a href="https://twitter.com/share?url=' . $url . '&text=' . $excerpt . '" class="tw-share" title="' . __( 'Tweet this post!', 'gp-social' ) . '">' . $twitter_icon . '</a>',
                '<a href="http://www.linkedin.com/shareArticle?url=' . $url . '&title=' . $title . '" class="li-share" title="' . __( 'Share this post!', 'gp-social' ) . '">' . $linkedin_icon . '</a>',
                '<a href="https://plus.google.com/share?url=' . $url . '" class="gp-share" title="' . __( 'Share this post!', 'gp-social' ) . '">' . $google_icon . '</a>',
                '<a href="https://pinterest.com/pin/create/bookmarklet/?media=' . $thumbnail . '&url=' . $url . '&description=' . $title . '" class="pt-share" title="' . __( 'Pin this post!', 'gp-social' ) . '">' . $pinterest_icon . '</a>',
                '<a href="whatsapp://send?text=' . $url . '" class="wa-share" data-action="share/whatsapp/share" title="' . __( 'Share this post!', 'gp-social' ) . '">' . $whatsapp_icon . '</a>',
                '<a href="mailto:?Subject=' .  $title . '&Body=' . $email_body . '" target="_top" class="em-share" title="' . __( 'Email this post!', 'gp-social' ) . '">' . $email_icon . '</a>',

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
        }// social_share_filter

        public	function register_styles_scripts() {

            wp_register_style( 'social-share-css', plugins_url( '/css/gp-social-share.css', __FILE__ ), array(), 'all' );
                
            wp_register_script( 'social-share-js', plugin_dir_url( __FILE__ ) . 'js/gp-social-share.js', array('jquery'), '1.0' );
    
        }

        public function add_social_icons() {

			// Check to ensure we are on a single post
			if ( is_single() ) {

				// Enqueue base style now we are in the hook
				wp_enqueue_style( 'social-share-css' );

				// Enqueue base script now we are in the hook
				wp_enqueue_script( 'social-share-js' );

				// Echo out the social icons
				echo wcdgpSocialShare::social_share_filter();

			}// is_single

        }// add_social_icons

        public function add_admin_menu() { 

            add_submenu_page( 'themes.php', 'GP Social Share', 'GP Social Share', 'manage_options', '_gp_social_share_-_svg', 'wcdgpSocialShare::options_page' );
        
        }// add_admin_menu
        
        
        public function social_share_options_init() {
        
            register_setting( 'gpSocialShare', 'social_share_options' );
        
            add_settings_section(
                'gpSocialShare_section', 
                __( 'Social Share Icon - SVG Code', 'gp-social' ), 
                'wcdgpSocialShare::social_share_options_section_callback', 
                'gpSocialShare'
            );
        
            add_settings_field( 
                'gp_social_facebook', 
                __( 'Facebook Icon', 'gp-social' ), 
                'wcdgpSocialShare::gp_social_facebook_render', 
                'gpSocialShare', 
                'gpSocialShare_section' 
            );
        
            add_settings_field( 
                'gp_social_twitter', 
                __( 'Twitter Icon', 'gp-social' ), 
                'wcdgpSocialShare::gp_social_twitter_render', 
                'gpSocialShare', 
                'gpSocialShare_section' 
            );
        
            add_settings_field( 
                'gp_social_linkedin', 
                __( 'LinkedIn Icon', 'gp-social' ), 
                'wcdgpSocialShare::gp_social_linkedin_render', 
                'gpSocialShare', 
                'gpSocialShare_section' 
            );
        
            add_settings_field( 
                'gp_social_google', 
                __( 'GooglePlus Icon', 'gp-social' ), 
                'wcdgpSocialShare::gp_social_google_render', 
                'gpSocialShare', 
                'gpSocialShare_section' 
            );
        
            add_settings_field( 
                'gp_social_pinterest', 
                __( 'Pinterest Icon', 'gp-social' ), 
                'wcdgpSocialShare::gp_social_pinterest_render', 
                'gpSocialShare', 
                'gpSocialShare_section' 
            );
        
            add_settings_field( 
                'default_whatsapp', 
                __( 'Whatsapp Icon', 'gp-social' ),
                'wcdgpSocialShare::gp_social_whatsapp_render',
                'gpSocialShare', 
                'gpSocialShare_section' 
            );
        
            add_settings_field( 
                'gp_social_email', 
                __( 'Email Icon', 'gp-social' ), 
                'wcdgpSocialShare::gp_social_email_render', 
                'gpSocialShare', 
                'gpSocialShare_section' 
            );

            add_settings_field( 
                'hook_select_field', 
                __( 'Select Hook Placement', 'gp-social' ), 
                'wcdgpSocialShare::hook_select', 
                'gpSocialShare', 
                'gpSocialShare_section' 
            );
        
        }// social_share_options_init

        public function default_facebook() {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/></svg>';
            return $svg;
        }// default facebook icon

        public function gp_social_facebook_render() { 

            $options = get_option( 'social_share_options' );
            ?>
            <textarea cols='40' rows='5' name='social_share_options[gp_social_facebook]'><?php echo $options['gp_social_facebook']; ?></textarea>
            <p><?php
            if ( ! $options['gp_social_facebook'] ) {
                echo 'Default Icon: ' . wcdgpSocialShare::default_facebook();
            } else {
                echo $options['gp_social_facebook'];
            }
            ?></p>
            <?php

        }// gp_social_facebook_render

        public function default_twitter() {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.066 9.645c.183 4.04-2.83 8.544-8.164 8.544-1.622 0-3.131-.476-4.402-1.291 1.524.18 3.045-.244 4.252-1.189-1.256-.023-2.317-.854-2.684-1.995.451.086.895.061 1.298-.049-1.381-.278-2.335-1.522-2.304-2.853.388.215.83.344 1.301.359-1.279-.855-1.641-2.544-.889-3.835 1.416 1.738 3.533 2.881 5.92 3.001-.419-1.796.944-3.527 2.799-3.527.825 0 1.572.349 2.096.907.654-.128 1.27-.368 1.824-.697-.215.671-.67 1.233-1.263 1.589.581-.07 1.135-.224 1.649-.453-.384.578-.87 1.084-1.433 1.489z"/></svg>';
            return $svg;
        }// default twitter icon

        public function gp_social_twitter_render() { 

            $options = get_option( 'social_share_options' );
            ?>
            <textarea cols='40' rows='5' name='social_share_options[gp_social_twitter]'><?php echo $options['gp_social_twitter']; ?></textarea>
            <p><?php
            if ( ! $options['gp_social_twitter'] ) {
                echo 'Default Icon: ' . wcdgpSocialShare::default_twitter();
            } else {
                echo $options['gp_social_twitter'];
            }
            ?></p>
            <?php

        }// gp_social_twitter_render

        public function default_linkedin() {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/></svg>';
            return $svg;
        }// default linkedin icon

        public function gp_social_linkedin_render() { 

            $options = get_option( 'social_share_options' );
            ?>
            <textarea cols='40' rows='5' name='social_share_options[gp_social_linkedin]'><?php echo $options['gp_social_linkedin']; ?></textarea>
            <p><?php
            if ( ! $options['gp_social_linkedin'] ) {
                echo 'Default Icon: ' . wcdgpSocialShare::default_linkedin();
            } else {
                echo $options['gp_social_linkedin'];
            }
            ?></p>
            <?php

        }// gp_social_linkedin_render

        public function default_google() {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2.917 16.083c-2.258 0-4.083-1.825-4.083-4.083s1.825-4.083 4.083-4.083c1.103 0 2.024.402 2.735 1.067l-1.107 1.068c-.304-.292-.834-.63-1.628-.63-1.394 0-2.531 1.155-2.531 2.579 0 1.424 1.138 2.579 2.531 2.579 1.616 0 2.224-1.162 2.316-1.762h-2.316v-1.4h3.855c.036.204.064.408.064.677.001 2.332-1.563 3.988-3.919 3.988zm9.917-3.5h-1.75v1.75h-1.167v-1.75h-1.75v-1.166h1.75v-1.75h1.167v1.75h1.75v1.166z"/></svg>';
            return $svg;
        }// default google icon

        public function gp_social_google_render() { 

            $options = get_option( 'social_share_options' );
            ?>
            <textarea cols='40' rows='5' name='social_share_options[gp_social_google]'><?php echo $options['gp_social_google']; ?></textarea>
            <p><?php
            if ( ! $options['gp_social_google'] ) {
                echo 'Default Icon: ' . wcdgpSocialShare::default_google();
            } else {
                echo $options['gp_social_google'];
            }
            ?></p>
            <?php

        }// gp_social_google_render

        public function default_pinterest() {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 19c-.721 0-1.418-.109-2.073-.312.286-.465.713-1.227.87-1.835l.437-1.664c.229.436.895.804 1.604.804 2.111 0 3.633-1.941 3.633-4.354 0-2.312-1.888-4.042-4.316-4.042-3.021 0-4.625 2.027-4.625 4.235 0 1.027.547 2.305 1.422 2.712.132.062.203.034.234-.094l.193-.793c.017-.071.009-.132-.049-.202-.288-.35-.521-.995-.521-1.597 0-1.544 1.169-3.038 3.161-3.038 1.72 0 2.924 1.172 2.924 2.848 0 1.894-.957 3.205-2.201 3.205-.687 0-1.201-.568-1.036-1.265.197-.833.58-1.73.58-2.331 0-.537-.288-.986-.886-.986-.702 0-1.268.727-1.268 1.7 0 .621.211 1.04.211 1.04s-.694 2.934-.821 3.479c-.142.605-.086 1.454-.025 2.008-2.603-1.02-4.448-3.553-4.448-6.518 0-3.866 3.135-7 7-7s7 3.134 7 7-3.135 7-7 7z"/></svg>';
            return $svg;
        }// default pinterest icon

        public function gp_social_pinterest_render() { 

            $options = get_option( 'social_share_options' );
            ?>
            <textarea cols='40' rows='5' name='social_share_options[gp_social_pinterest]'><?php echo $options['gp_social_pinterest']; ?></textarea>
            <p><?php
            if ( ! $options['gp_social_pinterest'] ) {
                echo 'Default Icon: ' . wcdgpSocialShare::default_pinterest();
            } else {
                echo $options['gp_social_pinterest'];
            }
            ?></p>
            <?php

        }// gp_social_pinterest_render

        public function default_whatsapp() {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 1.856.001 3.598.723 4.907 2.034 1.31 1.311 2.031 3.054 2.03 4.908-.001 3.825-3.113 6.938-6.937 6.938z"/></svg>';
            return $svg;
        }// default whatsapp icon

        public function gp_social_whatsapp_render() { 

            $options = get_option( 'social_share_options' );
            ?>
            <textarea cols='40' rows='5' name='social_share_options[gp_social_whatsapp]'><?php echo $options['gp_social_whatsapp']; ?></textarea>
            <p><?php
            if ( ! $options['gp_social_whatsapp'] ) {
                echo 'Default Icon: ' . wcdgpSocialShare::default_whatsapp();
            } else {
                echo $options['gp_social_whatsapp'];
            }
            ?></p>
            <?php

        }// gp_social_email_render

        public function default_email() {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 .02c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.99 6.98l-6.99 5.666-6.991-5.666h13.981zm.01 10h-14v-8.505l7 5.673 7-5.672v8.504z"/></svg>';
            return $svg;
        }// default email icon

        public function gp_social_email_render() { 

            $options = get_option( 'social_share_options' );
            ?>
            <textarea cols='40' rows='5' name='social_share_options[gp_social_email]'><?php echo $options['gp_social_email']; ?></textarea>
            <p><?php
            if ( ! $options['gp_social_email'] ) {
                echo 'Default Icon: ' . wcdgpSocialShare::default_email();
            } else {
                echo $options['gp_social_email'];
            }
            ?></p>
            <?php

        }// gp_social_email_render

        public function hook_select() { 

            $options = get_option( 'social_share_options' );
            ?>
            <select name='social_share_options[hook_select_field]'>
                <option value='5' <?php selected( $options['hook_select_field'], 5 ); ?>>generate_after_content</option>
                <option value='1' <?php selected( $options['hook_select_field'], 1 ); ?>>generate_before_content</option>
                <option value='2' <?php selected( $options['hook_select_field'], 2 ); ?>>generate_before_entry_title</option>
                <option value='3' <?php selected( $options['hook_select_field'], 3 ); ?>>generate_after_entry_title</option>
                <option value='4' <?php selected( $options['hook_select_field'], 4 ); ?>>generate_after_entry_content</option>
                <option value='6' <?php selected( $options['hook_select_field'], 6 ); ?>>generate_before_comments_container</option>
                <option value='7' <?php selected( $options['hook_select_field'], 7 ); ?>>generate_inside_comments</option>
                <option value='8' <?php selected( $options['hook_select_field'], 8 ); ?>>generate_below_comments_title</option>
                <option value='9' <?php selected( $options['hook_select_field'], 9 ); ?>>generate_after_main_content</option>
                <option value='10' <?php selected( $options['hook_select_field'], 10 ); ?>>generate_before_right_sidebar_content</option>
                <option value='11' <?php selected( $options['hook_select_field'], 11 ); ?>>generate_after_right_sidebar_content</option>
            </select>
        
        <?php
        
        }

        public function social_share_options_section_callback() { 

            echo __( 'Copy in your SVG generated code here', 'gp-social' );

        }// social_share_options_section_callback

        public function options_page() { 

            ?>
            <form action='options.php' method='post'>

                <h2><?php echo __( 'GP Social Share', 'gp-social' ); ?></h2>

                <?php
                settings_fields( 'gpSocialShare' );
                do_settings_sections( 'gpSocialShare' );
                submit_button();
                ?>

            </form>
            <?php

        }// options_page

        public function settings_link( $links ) {
            $mylinks = array(
            '<a href="' . admin_url( 'themes.php?page=_gp_social_share_-_svg' ) . '">' . __( 'Settings', 'gp-social' ) . '</a>',
            );
           return array_merge( $links, $mylinks );
           }

    } // class wcdgpSocialShare
}// checks class doesnt exist

?>