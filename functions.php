<?php
function register_primary_menu()
{
    register_nav_menu('primary-menu', __('Primary Menu'));
}
add_action('init', 'register_primary_menu');

/* Support for featured image */
add_theme_support('post-thumbnails');
add_image_size('cover-image', 1440, 500);

/* Add the cover section, mostly the image, to a page */
function prepend_cover_to_article($content)
{
    if(has_post_thumbnail()) {
	$imgurl = get_the_post_thumbnail_url();
	
	$cover_b = '<section class="cover" style="background-image: url(\'';
	$cover_e = '\')"></section>';
	$cover = $cover_b . $imgurl . $cover_e;
	
	return $cover . $content;
    } else {
	return $content;
    }
}
add_filter('the_content', 'prepend_cover_to_article');
