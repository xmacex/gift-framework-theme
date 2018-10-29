<?php
function register_primary_menu()
{
    register_nav_menu('primary-menu', __('Primary Menu'));
}
add_action('init', 'register_primary_menu');

/* Support for featured image */
add_theme_support('post-thumbnails');
add_image_size('cover-image', 1440, 500);

/* Define content filters. These could go to a separate file actually */
function decorate_article_with_container($content)
{
    $article_b = '<article class="article-content wrap-container">';
    $article_e = '</article>';

    $cta = call_to_action();
    $bc = get_breadcrumb();

    return $article_b . container_column($cta . container_column_inner($bc . $content)) . $article_e;
}

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

/* Add the content filters */
add_filter('the_content', 'decorate_article_with_container');
add_filter('the_content', 'prepend_cover_to_article');

/* Shortcodes. There might be better, more sustainable, cooler ways to achieve these things */
function leading_content($atts, $content=null)
{
    $a = shortcode_atts(array('byline' => ''), $atts);
    $heading = '<h1>' . $a['byline'] . '</h1>';
    $blurb = '<p>' . $content . '</p>';
    return $heading . $blurb;
}

function container($content, $classes=null)
{
    return '<div class="' . $classes . '">' . $content . '</div>';
}

function container_fw($content, $classes=null)
{
    return container($content, "full-width" . $classes);
}

function container_column($content, $classes=null)
{
    return container($content, "column-container" . $classes);
}

function container_column_inner($content, $classes=null)
{
    return container($content, "column-container-inner" . $classes);
}

function container_inner_fw_has_col_layout($content, $classes=null)
{
    return container($content, "full-width-inner has-column-layout" . $classes);
}

function container_fw_inner_col($content, $classes=null)
{
    return container($content, "full-width-inner-col" . $classes);
}

function container_fw_img($content, $classes=null)
{
    return container($content, "full-width-image-container");
}

function questions($atts, $content=null)
{
    return do_shortcode(
        container_fw(
            container_inner_fw_has_col_layout($content)));
}

function question($atts, $content=null)
{
    $a = shortcode_atts(array(
        'question' => '',
        'links' => ''), $atts);

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
    return container_fw_inner_col($content);
}

function what_question($atts, $content=null)
{
    return question($atts, $content);
}

function how_question($atts, $content=null)
{
    return question($atts, $content);
}

function why_question($atts, $content=null)
{
    return question($atts, $content);
}

function results($atts, $content=null)
{
    return container_column(
        container_column_inner('<p>' . $content . '</p>'));
}

function feature($atts, $content=null)
{
    $a = shortcode_atts(array(
        'media' => ''), $atts);

    $attachment = get_post($a['media']);
    $img_b = '<img class="full-width-image"';
    $img_e = '"></img>';
    // $url = wp_get_attachment_image_src($a['media'], 'full-size')[0];
    $url = $attachment->guid;
    $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);

    return container_fw(
        container_fw_img($img_b . 'src="' . $url . '" alt="' . $alt . '"' . $img_e), " dark");
}

function testimonials($atts, $content=null)
{
    return do_shortcode(
        container_fw(
            container_inner_fw_has_col_layout($content)));
}

function testimonial($atts, $content=null)
{
    $a = shortcode_atts(array(
        'role' => '',
        'location' => ''), $atts);

    $quote = '<blockquote>' . '<p>' . $content . '</p>' . '</blockquote>';
    $address_b = '<address class="quote-source">';
    $address_e = '</address>';
    $address = $address_b . $a['role'] . ', ' . $a['location'] . $address_e;
    $content = $quote . $address;
    return container_fw_inner_col($content);
}

add_shortcode('leading_content', 'leading_content');

add_shortcode('questions', 'questions');
add_shortcode('what', 'what_question');
add_shortcode('how', 'how_question');
add_shortcode('why', 'why_question');

add_shortcode('results', 'results');
add_shortcode('feature', 'feature');

add_shortcode('testimonials', 'testimonials');
add_shortcode('testimonial', 'testimonial');

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