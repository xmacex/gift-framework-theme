<?php
/**
 * Define functions for enqueuing styles and Javascript stuff, and add
 * them to the appropriate action which is evoked by wp_head();
 *
 * @author  Mace Ojala <maco@itu.dk>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL3
 * @link    https://github.com/xmacex/gift-framework-theme
 */

/**
 * Get stylesheets in place
 *
 * @return null
 */
function enqueue_styles()
{
    wp_enqueue_style(
        "normalize",
        get_stylesheet_directory_uri() . "/css/normalize.css"
    );
    wp_enqueue_style(
        "main",
        get_stylesheet_directory_uri() . "/css/main.css",
        array("normalize")
    );
    wp_enqueue_style(
        "bootstrap",
        "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    );
    wp_enqueue_style(
        "style",
        get_stylesheet_directory_uri() . "/css/style.css",
        array("main")
    );
}

/**
 * Get Javascript in place
 */
function enqueue_scripts()
{
    wp_enqueue_script(
        'modernizr',
        get_theme_file_uri('js/vendor/modernizr-3.6.0.min.js')
    );
    wp_enqueue_script(
        'popper',
        get_theme_file_uri('js/vendor/popper-1.12.9.min.js')
    );
    wp_enqueue_script(
        'bootstrap',
        get_theme_file_uri('js/vendor/bootstrap-4.0.0.min.js'),
        array('jquery')
    );
    wp_enqueue_script(
        'plugins',
        get_theme_file_uri('js/plugins.js')
    );
    wp_enqueue_script(
        'main',
        get_theme_file_uri('js/main.js')
    );
}

add_action('wp_enqueue_scripts', 'enqueue_styles');
add_action('wp_enqueue_scripts', 'enqueue_scripts');

/**
 * Primary menu
 *
 * @return null
 */
function register_primary_menu()
{
    register_nav_menu('primary-menu', __('Primary Menu'));
}
add_action('init', 'register_primary_menu');

/* Support for featured image */
add_theme_support('post-thumbnails');
add_image_size('cover-image', 1440, 500);

/**
 * Define content filters. These could go to a separate file actually
 */

/**
 * Wrapper function for getting the whole article in an article container
 *
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function decorate_article_with_container($content)
{
    $article_b = '<article class="article-content wrap-container">';
    $article_e = '</article>';

    return $article_b . $content . $article_e;
}

/**
 * Add the cover, namely the image to the content
 *
 * @return string HTML representation
 */
function prepend_cover_to_article()
{
    if (has_post_thumbnail()) {
        $imgurl = get_the_post_thumbnail_url();
        $cover_b = '<section class="cover stripes-slope-left" style="background-image: url(\'';
        $cover_e = '\')"></section>';
        $cover = $cover_b . $imgurl . $cover_e;
        return $cover;
    }
}

/** 
 * Decorator Pattern inspired wrapper functions
 */

/**
 * A most generic container.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container($content, $classes=null)
{
    return '<div class="' . $classes . '">' . $content . '</div>';
}

/**
 * A full-width container, a row.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_fw($content, $classes=null)
{
    return container($content, "full-width" . $classes);
}

/**
 * A column container, a row.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_column($content, $classes=null)
{
    return container($content, "column-container" . $classes);
}

/**
 * An inner container for column container, a column.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_column_inner($content, $classes=null)
{
    return container($content, "column-container-inner" . $classes);
}

/**
 * An inner container for full width container.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_fw_inner($content, $classes=null)
{
    return container($content, $classes . " full-width-inner");
}

/**
 * An inner container for full width container with column inside, a row.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_fw_inner_has_col_layout($content, $classes=null)
{
    return container_fw_inner($content, $classes . " has-column-layout");
}

/**
 * An inner container for full width container container, a column.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_fw_inner_col($content, $classes=null)
{
    return container($content, "full-width-inner-col" . $classes);
}

/**
 * A full-width image container.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_fw_img($content, $classes=null)
{
    return container($content, "full-width-image-container");
}

/**
 * A grid container.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_grid($content, $classes=null)
{
    return container_column($content, $classes . " grid-container");
}

/**
 * A container for a grid section.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_grid_section($content, $classes=null)
{
    return container($content, $classes . " grid-section");
}

/**
 * A grid tile container.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_grid_tile($content, $classes=null)
{
    return container($content, $classes . " tile");
}

/**
 * A grid tile container for a title.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_grid_tile_title($content, $classes=null)
{
    return container_grid_tile($content, $classes . " title");
}

/**
 * A grid tile container for a description.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_grid_tile_description($content, $classes=null)
{
    return container_grid_tile($content, $classes . " description");
}

/**
 * A container for a text section
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_text_section($content, $classes=null)
{
    return container($content, "text-section");
}

/**
 * A container for a reference list.
 *
 * @param string $content Content from the database
 * @param string $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_reference_list($content, $classes=null)
{
    return container($content, "reference-list");
}

/**
 * Shortcodes.
 * There might be better, more sustainable, cooler ways to achieve these
 * things
 */

/**
 * Leading content of the page shortcode.
 *
 * This includes the call-to-action area near the top
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function leading_content($atts, $content=null)
{
    $a = shortcode_atts(
        array(
            'byline' => '',
            'cta_label' => null,
            'cta_item' => null,
            'cta_text' => null), $atts
    );

    if (is_numeric($a['cta_item'])) {
        $attachment = get_post($a['cta_item']);
        $url = $attachment->guid;
    } else {
        $url = $a['cta_item'];
    }

    if ($a['cta_label']) {
        $cta = call_to_action($a['cta_label'], $url, $a['cta_text']);
    } else {
        $cta = null;
    }
    $bc = get_breadcrumb();
    $heading = '<h1>' . $a['byline'] . '</h1>';
    $blurb = '<p>' . $content . '</p>';
    return do_shortcode(
        container_column(
            $cta . container_column_inner(
                $bc . $heading . $blurb
            )
        )
    );
}

/**
 * Generate the call to action area shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function call_to_action_area($atts, $content=null)
{
    $a = shortcode_atts(
        array(
            'label' => null,
            'item' => null), $atts
    );
    
    return call_to_action($a['label'], $a['item'], $content);
}

/**
 * Wrapper for the questions section shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function questions($atts, $content=null)
{
    return do_shortcode(
        container_fw(
            container_fw_inner_has_col_layout($content)
        )
    );
}

/**
 * Wrapper for a question shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function question($atts, $content=null)
{
    $a = shortcode_atts(
        array(
            'question' => '',
            'links' => ''), $atts
    );

    $heading = '<h3>' . $a['question'] . '</h3>';
    $text = '<p>' . $content . '</p>';
    $links_b = '<ul class="list-of-links">';
    $links_e = '</ul>';
    if ($a['links']) {
        $links = "";
        foreach (explode(",", $a['links']) as $pid) {
            $post = get_post($pid);
            $link = '<a href="' . '#' . '">'. $post->post_title . '</a>';
            $listitem = '<li>' . $link . '</li>';
            $links .= $listitem;
        }
    }
    $content = $heading . $text . $links_b . $links . $links_e;
    return container_fw_inner_col($content);
}

/**
 * Wrapper for a "what" question shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function what_question($atts, $content=null)
{
    return question($atts, $content);
}

/**
 * Wrapper for a "how" question shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function how_question($atts, $content=null)
{
    return question($atts, $content);
}

/**
 * Wrapper for a "why" question shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function why_question($atts, $content=null)
{
    return question($atts, $content);
}

/**
 * Wrapper for results section shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function results($atts, $content=null)
{
    return container_column(
        container_column_inner('<p>' . $content . '</p>')
    );
}

/**
 * Wrapper for feature on page shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function feature($atts, $content=null)
{
    $a = shortcode_atts(
        array(
            'media' => ''), $atts
    );

    $attachment = get_post($a['media']);
    $img_b = '<img class="full-width-image" ';
    $img_e = '/>';
    // $url = wp_get_attachment_image_src($a['media'], 'full-size')[0];
    $url = $attachment->guid;
    $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);

    $img = $img_b . 'src="' . $url . '" alt="' . $alt . '"' . $img_e;

    return container_fw(
        container_fw_img($img, " dark")
    );
}

/**
 * Wrapper for testimonials shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function testimonials($atts, $content=null)
{
    return do_shortcode(
        container_fw(
            container_fw_inner_has_col_layout($content)
        )
    );
}

/**
 * Wrapper for a single testimonial shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function testimonial($atts, $content=null)
{
    $a = shortcode_atts(
        array(
            'role' => '',
            'location' => ''), $atts
    );

    $quote = '<blockquote>' . $content . '</blockquote>';
    $address_b = '<address class="quote-source">';
    $address_e = '</address>';
    $address = $address_b . $a['role'] . ', ' . $a['location'] . $address_e;
    $content = $quote . $address;
    return container_fw_inner_col($content);
}

/**
 * Wrapper for a how-to steps shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function how_to($atts, $content=null)
{
    $a = shortcode_atts(
        array(
            'prompt' => '',
            'motivation' => '',
            'readmore' => '',
            'readmoredesc' => ''), $atts
    );

    $header = '<h2>' . $a['prompt'] . '</h2>';
    $blurb = '<p>' . $a['motivation'] . '</p>';
    $readmore = '<a href="' . get_post($a['readmore'])->guid . '">' . $a['readmoredesc'] . '</a>';

    return do_shortcode(
        container_fw(
            container_fw_inner(
                container_column(
                    container_column_inner(
                        $header . $blurb
                    )
                ) . '<div class="has-column-layout">' . $content . '</div>' . container_column(
                    container_column_inner($readmore)
                )
            ), " how-to"
        )
    );
}

/**
 * Wrapper for a single how-to step shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function how_to_step($atts, $content=null)
{
    $a = shortcode_atts(
        array(
            'icon' => ''), $atts
    );

    $attachment = get_post($a['icon']);
    $fig_b = '<figure class="step">';
    $fig_e = '</figure>';
    $url = $attachment->guid;
    $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
    $img = '<img src="' . $url . '" alt="' . $alt . '">';
    $caption = '<figcaption>' . $content . '</figcaption>';
    $figure = $fig_b . $img . $caption . $fig_e;
    return container_fw_inner_col($figure);
}

/**
 * Wrapper for a implementation instructions shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function implement($atts, $content=null)
{
    return do_shortcode(
        container_column(container_column_inner($content))
    );
}

/**
 * Wrapper for a grid shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function grid($atts, $content=null)
{
    return do_shortcode(container_grid($content));
}

/**
 * Wrapper for a grid shortcode.
 *
 * Not exposed, and also maybe not used. Remove.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function grid_section($atts, $content=null)
{
    return container_grid_section($content);
}

/**
 * A title grid shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function title_grid($atts, $content=null)
{
    $a = shortcode_atts(
        array(
            'title' => null,
            'bg' => null,
            'img' => null), $atts
    );

    $bg = get_post($a['bg']);
    $attachment = get_post($a['img']);

    $bgurl = $bg->guid;
    $url = $attachment->guid;

    $bgimage = '<div class="layers-image-container" style="background-image:url(\'' . $bgurl . '\');"></div>';

    $header_tile = container_grid_tile_title('<h1>' . $a['title'] . '</h1>');
    $desc_tile = container_grid_tile_description($content . $bgimage);
    $image_tile = '<div class="extra stripes-slope-left faded image tile" style="background-image:url(\'' . $url . '\');"></div>';
    $grid = $header_tile . $desc_tile . $image_tile;

    return container_grid_section($grid, " title");
}

/**
 * A feature grid shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function feature_grid($atts, $content=null)
{
    return do_shortcode(container_grid_section($content, "feature"));
}

/**
 * A feature grid item shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function feature_grid_item($atts, $content=null)
{
    $a = shortcode_atts(
        array(
            'img' => null,
            'highlight' => null), $atts
    );

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

/**
 * A text section shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function text_section($atts, $content=null)
{
    return container_text_section($content);
}

/**
 * A reference list shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 * 
 * @return string HTML representation
 */
function references($atts, $content=null)
{
    return container_reference_list($content);
}

/**
 * Add the shortcodes.
 */
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

add_shortcode('references', 'references');

/* Some utility functions just to output re-used HTML. There are
 * better ways to do this stuff */

/**
 * Generator for call-to-action divs.
 *
 * Expected to be called by shortcode

 * @param string $button_label Label to produce on the button
 * @param string $url          Item to link to. Currently only an URL
 * @param string $text         A little blurb of text to show below the button
 *
 * @return string HTML div for the call-to-action area
 */
function call_to_action($button_label, $url, $text)
{
    $div_b = '<div class="call-to-action-area">';
    $div_e = '</div>';
    $a_b = '<a id="call-to-action-link" class="button" href="';
    $a_m = '">';
    $a_e = '</a>';
    $label_b = '<label for="call-to-action-link" class="description">';
    $label_e = '</label>';

    $a = $a_b . $url . $a_m . $button_label . $a_e;
    $label = $label_b . $text . $label_e;
    $div = $div_b . $a . $label . $div_e;
    
    return $div;
}

/**
 * Generator for a navigation breadcrumb for the current post.
 *
 * @return string HTML representation 
 */
function get_breadcrumb()
{
    $bc_b = '<nav class="navigation breadcrumbs"><ul><li><a href="#">';
    $bc_e = '</a></li></ul></nav>';
    $title = get_the_title();
    return $bc_b . $title . $bc_e;
}

/**
 * Generator for a a generic get started now button.
 *
 * @return string HTML representation 
 */
function get_started_now_button()
{
    return '<a class="button" href="#">Get Started Now</a>';
}
