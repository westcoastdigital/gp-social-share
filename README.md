## GP Social Share

This plugin is built to add social sharing icons at the bottom of post content.
It makes use of the generate_after_content hook and then echoes out the content, styles and scripts if is_singular.

## Add More Links

You can add more sharing using the following function and modifying it as required

```
function add_extra_icons($social_links) {
 
	$extra_icons = array(
		'<a href=""><i class="fa fa-instagram"></i></a>',
		'<a href=""><i class="fa fa-snapchat"></i></a>',
	);
 
	// combine the two arrays
	$social_links = array_merge($extra_icons, $social_links);
 
	return $social_links;
}
add_filter('add_social_icons', 'add_extra_icons');
```