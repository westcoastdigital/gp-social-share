<?php
add_action( 'admin_menu', 'wcd_add_admin_menu' );
add_action( 'admin_init', 'wcd_social_share_options_init' );


function wcd_add_admin_menu(  ) { 

	add_submenu_page( 'themes.php', 'GP Social Share', 'GP Social Share', 'manage_options', '_gp_social_share_-_svg', 'wcd_options_page' );

}


function wcd_social_share_options_init(  ) { 

	register_setting( 'gpSocialShare', 'wcd_social_share_options' );

	add_settings_section(
		'wcd_gpSocialShare_section', 
		__( 'Social Share Icon - SVG Code', 'gp-social' ), 
		'wcd_social_share_options_section_callback', 
		'gpSocialShare'
	);

	add_settings_field( 
		'gp_social_facebook', 
		__( 'Facebook Icon', 'gp-social' ), 
		'gp_social_facebook_render', 
		'gpSocialShare', 
		'wcd_gpSocialShare_section' 
	);

	add_settings_field( 
		'gp_social_twitter', 
		__( 'Twitter Icon', 'gp-social' ), 
		'gp_social_twitter_render', 
		'gpSocialShare', 
		'wcd_gpSocialShare_section' 
	);

	add_settings_field( 
		'gp_social_linkedin', 
		__( 'LinkedIn Icon', 'gp-social' ), 
		'gp_social_linkedin_render', 
		'gpSocialShare', 
		'wcd_gpSocialShare_section' 
	);

	add_settings_field( 
		'gp_social_google', 
		__( 'GooglePlus Icon', 'gp-social' ), 
		'gp_social_google_render', 
		'gpSocialShare', 
		'wcd_gpSocialShare_section' 
	);

	add_settings_field( 
		'gp_social_pinterest', 
		__( 'Pinterest Icon', 'gp-social' ), 
		'gp_social_pinterest_render', 
		'gpSocialShare', 
		'wcd_gpSocialShare_section' 
	);

	add_settings_field( 
		'gp_social_email', 
		__( 'Email Icon', 'gp-social' ), 
		'gp_social_email_render', 
		'gpSocialShare', 
		'wcd_gpSocialShare_section' 
	);


}


function gp_social_facebook_render(  ) { 

	$options = get_option( 'wcd_social_share_options' );
	?>
	<textarea cols='40' rows='5' name='wcd_social_share_options[gp_social_facebook]'><?php echo $options['gp_social_facebook']; ?></textarea>
    <p><?php echo $options['gp_social_facebook']; ?></p>
    <?php

}


function gp_social_twitter_render(  ) { 

	$options = get_option( 'wcd_social_share_options' );
	?>
	<textarea cols='40' rows='5' name='wcd_social_share_options[gp_social_twitter]'><?php echo $options['gp_social_twitter']; ?></textarea>
    <p><?php echo $options['gp_social_twitter']; ?></p>
    <?php

}


function gp_social_linkedin_render(  ) { 

	$options = get_option( 'wcd_social_share_options' );
	?>
	<textarea cols='40' rows='5' name='wcd_social_share_options[gp_social_linkedin]'><?php echo $options['gp_social_linkedin']; ?></textarea>
    <p><?php echo $options['gp_social_linkedin']; ?></p>
    <?php

}


function gp_social_google_render(  ) { 

	$options = get_option( 'wcd_social_share_options' );
	?>
	<textarea cols='40' rows='5' name='wcd_social_share_options[gp_social_google]'><?php echo $options['gp_social_google']; ?></textarea>
    <p><?php echo $options['gp_social_google']; ?></p>
    <?php

}


function gp_social_pinterest_render(  ) { 

	$options = get_option( 'wcd_social_share_options' );
	?>
	<textarea cols='40' rows='5' name='wcd_social_share_options[gp_social_pinterest]'><?php echo $options['gp_social_pinterest']; ?></textarea>
    <p><?php echo $options['gp_social_pinterest']; ?></p>
    <?php

}


function gp_social_email_render(  ) { 

	$options = get_option( 'wcd_social_share_options' );
	?>
	<textarea cols='40' rows='5' name='wcd_social_share_options[gp_social_email]'><?php echo $options['gp_social_email']; ?></textarea>
	<p><?php echo $options['gp_social_email']; ?></p>
    <?php

}


function wcd_social_share_options_section_callback(  ) { 

	echo __( 'Copy in your SVG generated code here', 'gp-social' );

}


function wcd_options_page(  ) { 

	?>
	<form action='options.php' method='post'>

		<h2>GP Social Share</h2>

		<?php
		settings_fields( 'gpSocialShare' );
		do_settings_sections( 'gpSocialShare' );
		submit_button();
		?>

	</form>
	<?php

}

?>