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
    $bc = get_breadcrumb();

    return $article_b . $colcontainer_b . $cta . $colcontainerinner_b . $bc . $content . $colcontainerinner_e . $colcontainer_e . $article_e;
}

/* Add the content filters */
add_filter('the_content', 'decorate_article_with_container');
add_filter('the_content', 'prepend_cover_to_article');

/* Shortcodes. There might be better, more sustainable, cooler ways to achieve these things */
function leading_content($atts, $content = null)
{
    $a = shortcode_atts(array('byline' => ''), $atts);
    $heading = '<h1>' . $a['byline'] . '</h1>';
    $blurb = '<p>' . $content . '</p>';
    return $heading . $blurb;
}

function the_three_questions($atts, $content = null)
{
    $a = shortcode_atts(array(
        'question' => '',
        'links' => ''), $atts);

    $container_b = '<div class=full-width-inner-col>';
    $container_e = '</div>';

    $heading = '<h3>' . $a['question'] . '</h3>';
    $text = '<p>' . $content . '</p>';
    $links_b = '<ul class="list-of-links">';
    $links_e = '</ul>';
    if($a['links'])
    {
        foreach(explode(",", $a['links']) as $pid) {
            $post = get_post($pid);
            $link = '<a href=">' . '#' . '">'. $post->post_title . '</a>';
            $listitem = '<li>' . $link . '</li>';
            $links .= $listitem;
        }
    }
    $content = $heading . $text . $links_b . $links . $links_e;
    return $container_b . $content . $container_e;
}

function what_question($atts, $content = null)
{
    return the_three_questions($atts, $content);
}

function how_question($atts, $content = null)
{
    return the_three_questions($atts, $content);
}

function why_question($atts, $content = null)
{
    return the_three_questions($atts, $content);
}

add_shortcode('leading_content', 'leading_content');
add_shortcode('what', 'what_question');
add_shortcode('how', 'how_question');
add_shortcode('why', 'why_question');

/* Some utility functions just to output re-used HTML. There are
 * better ways to do this stuff */
function call_to_action()
{
    $html = '<div class="call-to-action-area"><a id="call-to-action-link" class="button" href="#">Get Started Now</a><label for="call-to-action-link" class="description">Interested? Register with us now and a member of the Gift Project Team will contact you and guide you through the process.</label></div>';
    return $html;
}

function get_breadcrumb()
{
    $bc_b = '<nav class="navigation breadcrumbs"><ul><li><a href="#">';
    $bc_e = '</a></li></ul></nav>';
    $title = get_the_title();
    return $bc_b . $title . $bc_e;
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