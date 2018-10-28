<?php
function register_primary_menu()
{
    register_nav_menu('primary-menu', __('Primary Menu'));
}
add_action('init', 'register_primary_menu');

/* Support for featured image */
add_theme_support('post-thumbnails');
add_image_size('cover-image', 1440, 500);

/* Define filters. These could go to a separate file actually */

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

function decorate_article_with_container($content)
{
    $article_b = '<article class="article-content wrap-container">';
    $article_e = '</article>';
    $colcontainer_b = '<div class="column-container">';
    $colcontainer_e = '</div>';
    $colcontainerinner_b = '<div class="column-container-inner">';
    $colcontainerinner_e = '</div>';

    $cta = call_to_action();
    $bc = breadcrumbs();

    return $article_b . $colcontainer_b . $cta . $colcontainerinner_b . $bc . $content . $colcontainerinner_e . $colcontainer_e . $article_e;
}

/* Add the content filters */
add_filter('the_content', 'decorate_article_with_container');
add_filter('the_content', 'prepend_cover_to_article');

/* Some utility functions just to output re-used HTML. There are
 * better ways to do this stuff */
function call_to_action()
{
    $html = '<div class="call-to-action-area"><a id="call-to-action-link" class="button" href="#">Get Started Now</a><label for="call-to-action-link" class="description">Interested? Register with us now and a member of the Gift Project Team will contact you and guide you through the process.</label></div>';
    return $html;
}

function breadcrumbs()
{
    $html = '<nav class="navigation breadcrumbs"><ul><li><a href="#">Gift Exchange App</a></li></ul></nav>';
    return $html;
}

/* This should maybe be merged with get_started_now_button() */
function get_started_now_link()
{
    return '<a id="call-to-action-link" class="button" href="#">Get Started Now</a>';
}

function get_started_now_button()
{
    return '<a class="button" href="#">Get Started Now</a>';
}