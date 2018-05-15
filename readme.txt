=== GP Social Share ===
Contributors: WestCoastDigital
Tags: social, share, svg
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 1.0
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add social share icons to single posts within GeneratePress Theme

== Description ==

This plugin hooks into the generate_after_content hook to append social share icons to the single post page by default.

It uses the if_single() WordPress hook to ensure only fires on all single posts.

Configured shared content:

Image = post featured Image - full url
Title = post title
Content = the first 40 words of the content
URL = the post permalink

== Social Media Channels ==
These are the social channels currently supported by the plugin
* Facebook
* Twitter
* Google+
* Pinterest
* LinkedIn
* Email

== Installation ==

Ensure GeneratePress is your current active theme


1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Appearance->GP Social Share screen to add your own SVG code for the icons and choose your hook placement

== Frequently Asked Questions ==

= Nothing happens when I activate the plugin =

Ensure you have the GeneratePress Theme active.

= Do I have to use the premium version of the GeneratePress Theme? =

No. This plugin works with the theme and does not require the premium plugin.

= Can I display the amount of times my post has been shared? =

No. This plugin does not use any API's or receive any data from the shared content. It is intentionally built to be light weight.

= Can I change the email body? =

Yes. Just add a function called gp_social_email_body which returns your body content.

= Can I use the media uploader to upload SVG icons? =

No. WordPress has SVG disabled by default due to potential security issues, the decision was made to support this and stick to inline SVG code.

== Changelog ==

= 1.0.2 =
Added support for custom email body

= 1.0.1 =
Wrapped functions in class for conflict support
Updated readme
Added WhatsApp support
Added hook option to display icons
Converted jQuery to vanilla JS

= 1.0 =
This version allows you to paste in your own SVG icon code

= 0.5 =
* Initial Build

== Customisations ==

If you want to find custom icons, I recommend you check out [https://iconmonstr.com](https://iconmonstr.com/)

To use Iconmonstr SVG code
1. Search for your required icon
1. Click on the icon you like
1. Ensure SVG is selected
1. Agree to the license conditions
1. Click on Embed
1. Ensure Inline is selected
1. Highlight the displayed SVG code
1. Copy and paste the code into the relevant icon section
1. Save Changes at the bottom of the page

You can add more sharing using the following function and modifying it as required

```
function add_extra_icons($social_links) {
 
	$extra_icons = array(
		'<a href="https://twitter.com/share?url=' . $url . '&text=' . $excerpt . '" class="tw-share" title="' . __( 'Tweet this post!', 'gp-social' ) . '">' . $twitter_icon . '</a>',
	);
 
	// combine the two arrays
	$social_links = array_merge($extra_icons, $social_links);
 
	return $social_links;
}
add_filter('add_social_icons', 'add_extra_icons');
```