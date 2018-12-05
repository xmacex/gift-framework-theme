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
 * @param string[] $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container($content, $classes=[])
{
    foreach($classes as $class)
    {
        if(strpos($class, ' '))
        {
            throw new UnexpectedValueException("Class contains a space");
        }
    }
    return '<div class="' . implode(' ', $classes) . '">' . $content . '</div>';
}

/**
 * A full-width container, a row.
 *
 * @param string $content Content from the database
 * @param string[] $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_fw($content, $classes=[])
{
    array_push($classes, "full-width");
    return container($content, $classes);
}

/**
 * A column container, a row.
 *
 * @param string $content Content from the database
 * @param string[] $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_column($content, $classes=[])
{
    array_push($classes, "column-container");
    return container($content, $classes);
}

/**
 * An inner container for column container, a column.
 *
 * @param string $content Content from the database
 * @param string[] $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_column_inner($content, $classes=[])
{
    array_push($classes, "column-container-inner");
    return container($content, $classes);
}

/**
 * An inner container for full width container.
 *
 * @param string $content Content from the database
 * @param string[] $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_fw_inner($content, $classes=[])
{
    array_push($classes, "full-width-inner");
    return container($content, $classes);
}

/**
 * An inner container for full width container with column inside, a row.
 *
 * @param string $content Content from the database
 * @param string $classes[] A string to append to classes
 *
 * @return string HTML representation
 */
function container_fw_inner_has_col_layout($content, $classes=[])
{
    array_push($classes, "has-column-layout");
    return container_fw_inner($content, $classes);
}

/**
 * An inner container for full width container container, a column.
 *
 * @param string $content Content from the database
 * @param string[] $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_fw_inner_col($content, $classes=[])
{
    array_push($classes, "full-width-inner-col");
    return container($content, $classes);
}

/**
 * A full-width image container.
 *
 * @param string $content Content from the database
 * @param string $classes[] A string to append to classes
 *
 * @return string HTML representation
 */
function container_fw_img($content, $classes=[])
{
    array_push($classes, "full-width-image-container");
    return container($content, $classes);
}

/**
 * A full-width video container.
 *
 * @param string $content Content from the database
 * @param string[] $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_fw_video($content, $classes=[])
{
    array_push($classes, "full-width-video-container-wrap");
    return container(
            container($content, ["full-width-video-container"]),
            $classes
    );
}

/**
 * A grid row container.
 *
 * @param string $content Content from the database
 * @param string $classes[] A string to append to classes
 *
 * @return string HTML representation
 */
function container_grid_row($content, $classes=[])
{
    array_push($classes, "grid-row");
    return container($content, $classes);
}

/**
 * A grid tile container.
 *
 * @param string $content Content from the database
 * @param string $classes[] A string to append to classes
 * @param string $background_image_url A background image URL
 *
 * @return string HTML representation
 */
function container_grid_tile($content, $classes=[], $background_image_url=null)
{
    array_push($classes, "tile");
    $style_attribute = '';
    if (!empty($background_image_url)) {
      $style_attribute = 'style=" background-image: url(\'' . $background_image_url . '\')"';
    }

    return '<div class=' . implode(' ', $classes) . $style_attribute . '>' . $content . '</div>';
}

/**
 * A grid break container.
 *
 * @param string $content Content from the database
 * @param string $classes[] A string to append to classes
 *
 * @return string HTML representation
 */
function container_grid_break($content, $classes=[])
{
    array_push($classes, "grid-break");
    return container($content, $classes);
}

/**
 * A container for a text section
 *
 * @param string $content Content from the database
 * @param string[] $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_text_section($content, $classes=[])
{
    array_push($classes, "text-section");
    return container($content, $classes);
}

/**
 * A container for a reference list.
 *
 * @param string $content Content from the database
 * @param string[] $classes A string to append to classes
 *
 * @return string HTML representation
 */
function container_reference_list($content, $classes=[])
{
    array_push($classes, "reference-list");
    return container($content, $classes);
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

    $author_citation = '';
    if (!empty(get_the_author_meta('user_firstname')) && !empty(get_the_author_meta('user_lastname'))) {
      $author_name = get_the_author_meta('user_firstname') . ' ' . get_the_author_meta('user_lastname');
      $author_citation = $author_name ? '<p class="author">by <em>' . $author_name . '</em>' : '';

      if (!empty(get_the_author_meta('description'))) {
        $author_citation .= '<br /><span class="author-description">' . get_the_author_meta('description') . '</span>';
      }

      $author_citation .= '</p>';

    }

    $heading = '<h1>' . $a['byline'] . '</h1>';
    $blurb = '<p>' . $content . '</p>';

    return do_shortcode(
        container_column(
            $cta . container_column_inner(
                $bc . $heading . $author_citation . $blurb
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
    $links = "";
    if ($a['links']) {
        foreach (explode(",", $a['links']) as $pid) {
            $post = get_post($pid);
            $link = '<a href="' . $post->guid . '">'. $post->post_title . '</a>';
            $listitem = '<li>' . $link . '</li>';
            $links .= $listitem;
        }
    }
    $content = $heading . $text . $links_b . $links . $links_e;
    return container_fw_inner_col($content);
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

    if ($a['media'] !== '') {
      /**
       * Quick check if it's numeric so as to determine if it's a media ID
       * Should probably refactor for the check to be more specific so as to
       * check for a positive integer instead.
       */
      if (is_numeric($a['media'])) {
        $attachment = get_post($a['media']);
        $img_b = '<img class="full-width-image" ';
        $img_e = '/>';
        $url = $attachment->guid;
        $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
        $img = $img_b . 'src="' . $url . '" alt="' . $alt . '"' . $img_e;
        $feature_content = container_fw_img($img);
      /**
       * Checks for the presence of a Vimeo URL via regular expression and then
       * generates an <iframe> of a Vimeo player based on that ID.
       * @link https://stackoverflow.com/questions/10488943/easy-way-to-get-vimeo-id-from-a-vimeo-url#comment-35026186
       */
      } else if (preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $a['media'], $match)) {
        $vimeo_id = $match[5];
        $iframe_b = '<iframe ';
        $iframe_e = 'frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe>';
        $iframe = $iframe_b . 'src="https://player.vimeo.com/video/' . $vimeo_id . '" ' . $iframe_e;
        $feature_content = container_fw_video($iframe);
      }
    }

    return container_fw(
        $feature_content,
        " dark edge-to-edge"
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
function text_in_column($atts, $content=null)
{
    return do_shortcode(
        container_column(container_column_inner($content))
    );
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
    return container_column(
            container_text_section($content)
           );
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
 * A full-width section for code example shortcode.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function code($atts, $content=null)
{
    return container_fw(container_fw_inner($content), " dark code");
}

/**
 * A call-to-action button at the bottom of a page.
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function call_to_action_button($atts, $content=null)
{
    $a = shortcode_atts(
        array(
            'label' => null,
            'item' => null), $atts
    );

    if (is_numeric($a['item'])) {
        $url = get_post($a['item'])->guid;
    } else {
        $url = $a['item'];
    }

    return '<a class="button" href="' . $url . '">' . $a['label'] . '</a>';
}

/**
 * A grid row
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function grid_row($atts, $content=null)
{

  $a = shortcode_atts(
      array(
          'is_featured' => false,
          'stack_image_as_background_on_mobile' => false), $atts
  );

  $classes = array();

  if ($a['is_featured'] === 'true') {
    $classes[] = 'feature';
  }

  if ($a['stack_image_as_background_on_mobile'] === 'true') {
    $classes[] = 'stack-image-as-background-on-mobile-screens';
  }

  return do_shortcode(
          container_grid_row($content, implode($classes, ' '))
         );
}

/**
 * A grid tile
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function grid_tile($atts, $content=null)
{

  $a = shortcode_atts(
      array(
          'is_larger' => false,
          'hide_on' => null,
          'media' => null,
          'highlight' => null), $atts
  );

  $classes = array();
  $url = '';

  if ($a['is_larger'] === 'true') {
    $classes[] = 'col-2-width';
  }

  if (!is_null($a['hide_on'])) {
    if ($a['hide_on'] === 'tablet') {
      $classes[] = 'hide-on-tablet-screens';
    } else if ($a['hide_on'] === 'mobile') {
      $classes[] = 'hide-on-mobile-screens';
    }
  }

  if (!is_null($a['media'])) {

    if (is_numeric($a['media'])) {
      $attachment = get_post($a['media']);
      if ($attachment) {
        $url = $attachment->guid;
      }
    } else if (esc_url_raw($a['media']) === $a['media']) {
      $url = $a['media'];
    }

    if (!empty($url)) {
      $classes[] = 'faded';
      $classes[] = 'image';
      $classes[] = 'stripes-slope-left';
    }

  }

  if (!is_null($a['highlight'])) {
    $classes[] = 'coloured';
    $classes[] = $a['highlight'];
  }

  return container_grid_tile($content, implode($classes, ' '), $url);
}

/**
 * A grid break
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function grid_break($atts, $content=null)
{
  return container_grid_break($content);
}

/**
 * Add the shortcodes.
 */
add_shortcode('call_to_action_area', 'call_to_action_area');
add_shortcode('leading_content', 'leading_content');

add_shortcode('questions', 'questions');
add_shortcode('what', 'question');
add_shortcode('how', 'question');
add_shortcode('why', 'question');

add_shortcode('results', 'results');
add_shortcode('feature', 'feature');

add_shortcode('testimonials', 'testimonials');
add_shortcode('testimonial', 'testimonial');

add_shortcode('how_to', 'how_to');
add_shortcode('step', 'how_to_step');

add_shortcode('content', 'text_in_column');
add_shortcode('implement', 'text_in_column');
add_shortcode('call_to_action', 'call_to_action_button'); // 'get_started_now_button');

add_shortcode('text', 'text_section');
add_shortcode('code', 'code');

add_shortcode('grid_row', 'grid_row');
add_shortcode('grid_tile', 'grid_tile');
add_shortcode('grid_break', 'grid_break');

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
    $nav_b = '<nav class="navigation breadcrumbs"><ul>';
    $nav_e = '</ul></nav>';
    global $post;
    if ($post->post_parent) {
        $ppost = get_post($post->post_parent);
        $parent_b = '<li><a href="';
        $parent_m = '">';
        $parent_e = '</a></li>';
        $ptitle = $ppost->post_title;
        $parent = $parent_b . $ppost->guid . $parent_m . $ptitle . ' //' . $parent_e;
    } else {
        $parent = null;
    }
    $current_b = '<li>';
    $current_e = '</li>';
    $current = $current_b . get_the_title() . $current_e;;
    // return $bc_b . $title . $bc_e;
    return $nav_b . $parent . $current . $nav_e;
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
