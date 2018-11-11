<?php
/* Define functions for enqueuing styles and Javascript stuff, and add
   them to the appropriate action which is evoked by wp_head(); */
function enqueue_styles()
{
    wp_enqueue_style("normalize", get_stylesheet_directory_uri() . "/css/normalize.css");
    wp_enqueue_style("main", get_stylesheet_directory_uri() . "/css/main.css", array("normalize"));
    wp_enqueue_style("bootstrap", "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css");
    wp_enqueue_style("style", get_stylesheet_directory_uri() . "/css/style.css", array("main"));
}

function enqueue_scripts()
{
    wp_enqueue_script('modernizr', get_theme_file_uri('js/vendor/modernizr-3.6.0.min.js'));
    wp_enqueue_script('popper', get_theme_file_uri('js/vendor/popper-1.12.9.min.js'));
    wp_enqueue_script('bootstrap', get_theme_file_uri('js/vendor/bootstrap-4.0.0.min.js'), array('jquery'));

    wp_enqueue_script('plugins', get_theme_file_uri('js/plugins.js'));
    wp_enqueue_script('main', get_theme_file_uri('js/main.js'));
}

add_action('wp_enqueue_scripts', 'enqueue_styles');
add_action('wp_enqueue_scripts', 'enqueue_scripts');

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

    // $cta = call_to_action();
    // $bc = get_breadcrumb();

    return $article_b . $content . $article_e;

    // return $article_b . container_column($cta . container_column_inner($bc)) . $content . $article_e;
}

function prepend_cover_to_article()
{
    if(has_post_thumbnail())
    {
        $imgurl = get_the_post_thumbnail_url();
        $cover_b = '<section class="cover stripes-slope-left" style="background-image: url(\'';
        $cover_e = '\')"></section>';
        $cover = $cover_b . $imgurl . $cover_e;
        return $cover;
    }
}

/* Decorator Pattern inspired wrapper functions */
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

function container_fw_inner($content, $classes=null)
{
    return container($content, $classes . " full-width-inner");
}

function container_fw_inner_has_col_layout($content, $classes=null)
{
    return container_fw_inner($content, $classes . " has-column-layout");
}

function container_fw_inner_col($content, $classes=null)
{
    return container($content, "full-width-inner-col" . $classes);
}

function container_fw_img($content, $classes=null)
{
    return container($content, "full-width-image-container");
}

function container_grid($content, $classes=null)
{
    return container_column($content, $classes . " grid-container");
}

function container_grid_section($content, $classes=null)
{
    return container($content, $classes . " grid-section");
}

function container_grid_tile($content, $classes=null)
{
    return container($content, $classes . " tile");
}

function container_grid_tile_title($content, $classes=null)
{
    return container_grid_tile($content, $classes . " title");
}

function container_grid_tile_description($content, $classes=null)
{
    return container_grid_tile($content, $classes . " description");
}

function container_text_section($content, $classes=null)
{
    return container($content, "text-section");
}

/* Shortcodes. There might be better, more sustainable, cooler ways to achieve these things */
function leading_content($atts, $content=null)
{
    $a = shortcode_atts(array(
        'byline' => '',
	'cta_label' => null,
	'cta_item' => null,
	'cta_text' => null,
    ), $atts);

    if (is_numeric($a['cta_item']))
    {
	$attachment = get_post($a['cta_item']);
	$url = $attachment->guid;
    } else {
	$url = $a['cta_item'];
    }

    $cta = call_to_action($a['cta_label'], $url, $a['cta_text']);
    $bc = get_breadcrumb();
    $heading = '<h1>' . $a['byline'] . '</h1>';
    $blurb = '<p>' . $content . '</p>';
    return do_shortcode(
        container_column(
            $cta . container_column_inner(
                $bc . $heading . $blurb)));
}

function call_to_action_area($atts, $content=null)
{
    $a = shortcode_atts(array(
        'label' => null,
        'item' => null), $atts);
    
    return call_to_action($a['label'], $a['item'], $content);
}

function questions($atts, $content=null)
{
    return do_shortcode(
        container_fw(
            container_fw_inner_has_col_layout($content)));
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
	$links = "";
        foreach(explode(",", $a['links']) as $pid) {
            $post = get_post($pid);
            $link = '<a href="' . '#' . '">'. $post->post_title . '</a>';
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
    $img_b = '<img class="full-width-image" ';
    $img_e = '/>';
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
            container_fw_inner_has_col_layout($content)));
}

function testimonial($atts, $content=null)
{
    $a = shortcode_atts(array(
        'role' => '',
        'location' => ''), $atts);

    $quote = '<blockquote>' . $content . '</blockquote>';
    $address_b = '<address class="quote-source">';
    $address_e = '</address>';
    $address = $address_b . $a['role'] . ', ' . $a['location'] . $address_e;
    $content = $quote . $address;
    return container_fw_inner_col($content);
}

function how_to($atts, $content=null)
{
    $a = shortcode_atts(array(
        'prompt' => '',
        'motivation' => '',
        'readmore' => '',
        'readmoredesc' => ''), $atts);

    $header = '<h2>' . $a['prompt'] . '</h2>';
    $blurb = '<p>' . $a['motivation'] . '</p>';
    $readmore = '<a href="' . get_post($a['readmore'])->guid . '">' . $a['readmoredesc'] . '</a>';

    return do_shortcode(
        container_fw(
            container_fw_inner(
                container_column(container_column_inner($header . $blurb)) . '<div class="has-column-layout">' . $content . '</div>' . container_column(container_column_inner($readmore))), " how-to"));
}

function how_to_step($atts, $content=null)
{
    $a = shortcode_atts(array(
        'icon' => ''), $atts);

    $attachment = get_post($a['icon']);
    $fig_b = '<figure class="step">';
    $fig_e = '</figure>';
    $url = $attachment->guid;
    $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
    $caption = '<figcaption>' . $content . '</figcaption>';
    $figure = $fig_b . '<img src="' . $url . '" alt="' . $alt . '">' . $caption . $fig_e;
    return container_fw_inner_col($figure);
}

function implement($atts, $content=null)
{
    return do_shortcode(
        container_column(container_column_inner($content))); //. $cta)));
}

function grid($atts, $content=null)
{
    return do_shortcode(container_grid($content));
}

/* Not exposed, and also maybe not used. Remove. */
function grid_section($atts, $content=null)
{
    return container_grid_section($content);
}

function title_grid($atts, $content=null)
{
    $a = shortcode_atts(array(
	'title' => NULL,
	'bg' => NULL,
	'img' => NULL), $atts);

    $bg = get_post($a['bg']);
    $attachment = get_post($a['img']);

    $bgurl = $bg->guid;
    $url = $attachment->guid;

    $bgimage = '<div class="layers-image-container" style="background-image:url(\'' . $bgurl . '\');"></div>';

    $header_tile = container_grid_tile_title('<h1>' . $a['title'] . '</h1>');
    $desc_tile = container_grid_tile_description($content . $bgimage);
    $image_tile = '<div class="extra stripes-slope-left faded image tile" style="background-image:url(\'' . $url . '\');"></div>';
    $grid = $header_tile . $desc_tile . $image_tile;

    // return container_grid(container_grid_section($grid, " title"));
    return container_grid_section($grid, " title");
}

function feature_grid($atts, $content=null)
{
    return do_shortcode(container_grid_section($content, "feature"));
}

function feature_grid_item($atts, $content=null)
{
    $a = shortcode_atts(array(
	'img' => NULL,
	'highlight' => NULL), $atts);

    $attachment = get_post($a['img']);
    $url = $attachment->guid;
    $img = '<div class="faded image tile stripes-slope-right" style="background-image:url(\'' . $url . '\');"></div>';
    $highlight = $a['highlight'];
    if ($a['highlight']) {
	$highlight .= " coloured";
    }
    $text = container_grid_tile($content, $highlight);
    return $img . $text;
}

function text_section($atts, $content=null)
{
    return container_text_section($content);
}

add_shortcode('call_to_action_area', 'call_to_action_area');
add_shortcode('leading_content', 'leading_content');

add_shortcode('questions', 'questions');
add_shortcode('what', 'what_question');
add_shortcode('how', 'how_question');
add_shortcode('why', 'why_question');

add_shortcode('results', 'results');
add_shortcode('feature', 'feature');

add_shortcode('testimonials', 'testimonials');
add_shortcode('testimonial', 'testimonial');

add_shortcode('how_to', 'how_to');
add_shortcode('step', 'how_to_step');

add_shortcode('implement', 'implement');
add_shortcode('call_to_action', 'get_started_now_button');

add_shortcode('grid', 'grid');
add_shortcode('title_grid', 'title_grid');
// add_shortcode('grid_section', 'grid_section'); // maybe not expose this one?
add_shortcode('feature_grid', 'feature_grid');
add_shortcode('fp_feature', 'feature_grid_item');

add_shortcode('text', 'text_section');

/* Some utility functions just to output re-used HTML. There are
 * better ways to do this stuff */

/**
 * Generator for call-to-action divs.
 *
 * Expected to be called by shortcode

 * @param string $button_label Button label
 * @param string $url Item to link to. Currently only an URL
 * @param string $text. A little blurb of text to show below the button
 *
 * @return string HTML div for the call-to-action area
 */
function call_to_action($button_text, $url, $text)
{
    $div_b = '<div class="call-to-action-area">';
    $div_e = '</div>';
    $a_b = '<a id="call-to-action-link" class="button" href="';
    $a_m = '">';
    $a_e = '</a>';
    $label_b = '<label for="call-to-action-link" class="description">';
    $label_e = '</label>';

    $a = $a_b . $url . $a_m . $button_text . $a_e;
    $label = $label_b . $text . $label_e;
    $div = $div_b . $a . $label . $div_e;
    
    return $div;
}

function get_breadcrumb()
{
    $bc_b = '<nav class="navigation breadcrumbs"><ul><li><a href="#">';
    $bc_e = '</a></li></ul></nav>';
    $title = get_the_title();
    return $bc_b . $title . $bc_e;
}

function get_started_now_button()
{
    return '<a class="button" href="#">Get Started Now</a>';
}
