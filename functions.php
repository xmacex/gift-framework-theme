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
add_action('the_post', 'init_post_credits');


/**
 * Allow oEmbeds from Sketchfab. See https://help.sketchfab.com/hc/en-us/articles/203059088-Compatibility#Troubleshooting for WordPress users
 */
wp_oembed_add_provider('#https?://sketchfab\.com/.*#i', 'https://www.sketchfab.com/oembed', true);

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

/**
 * Support for featured images
 */
add_theme_support('post-thumbnails');
add_image_size('cover-image', 1440, 500);

/**
 * Remove empty paragraphs created by wpautop()
 * @author Ryan Hamilton
 * @link https://gist.github.com/Fantikerz/5557617
 */
function remove_empty_p($content)
{
    $content = force_balance_tags($content);
    $content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
    $content = preg_replace('~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content);
    return $content;
}

/**
 * We use a shortcode to display the credits of the post. However, we would like
 * to display these credits within the footer. We temporarily store information
 * inside of the post meta to persist the credit information so it could be
 * displayed within a template outside of the loop.
 */
function init_post_credits() {
  if (metadata_exists('post', get_the_ID(), 'credits')) {
    delete_post_meta(get_the_ID(), 'credits');
  }
}

/**
 * Remove the extra paragraphs that get wrapped around shortcode elements
 * @author Johann Heyne
 * @link https://wordpress.org/plugins/shortcode-empty-paragraph-fix/
 */
function remove_p_around_shortcodes($content)
{
    $content = remove_empty_p($content);

    $content_to_replace = array(
	'<p>[' => '[',
	'<p>[/' => '[/',
	']</p>' => ']',
	']<br />' => ']'
    );

    return strtr($content, $content_to_replace);
}

/**
 * Remove extra paragraphs that get wrapped around elements
 */
function remove_p($content)
{
    $content = remove_empty_p($content);

    $content_to_replace = array(
	'<p>' => '',
	'</p>' => '',
	'<br />' => ''
    );

    return strtr($content, $content_to_replace);
}

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

/*
 * Add the image and call to action to the article
 *
 * @return string HTML representation
 */
function prepend_image_and_call_to_action_to_article()
{
    $imgurl = get_the_post_thumbnail_url();
    $postfields = get_post_custom();

    $call_to_action_link = isset($postfields['call_to_action_link']) ? $postfields['call_to_action_link'][0] : NULL;
    $call_to_action_link_label = isset($postfields['call_to_action_link_label']) ? $postfields['call_to_action_link_label'][0] : NULL;
    $call_to_action_link_description = isset($postfields['call_to_action_link_description']) ? $postfields['call_to_action_link_description'][0] : NULL;

    $call_to_action_link_secondary = isset($postfields['call_to_action_link_secondary']) ? $postfields['call_to_action_link_secondary'][0] : NULL;
    $call_to_action_link_label_secondary = isset($postfields['call_to_action_link_label_secondary']) ? $postfields['call_to_action_link_label_secondary'][0] : NULL;
    $call_to_action_link_description_secondary = isset($postfields['call_to_action_link_description_secondary']) ? $postfields['call_to_action_link_description_secondary'][0] : NULL;
    $call_to_action_link_new_tab = isset($postfields['call_to_action_link_new_tab']) ? (strtolower($postfields['call_to_action_link_new_tab'][0]) === 'true') : false;

    $image_and_call_to_action = '';

    if ($imgurl || $call_to_action_link_label || $call_to_action_link_label_secondary)
    {

	$image_and_call_to_action_b = '<aside class="image-and-call-to-action">';
	$image_and_call_to_action_e = '</aside>';

	$feature_image_el = '';
	if ($imgurl) {
            $feature_image_b = '<div class="featured-image" style="background-image: url(\'' . $imgurl . '\')">';
            $feature_image_e = '</div>';
            $feature_image_el = $feature_image_b .
				$feature_image_e;
	}

	$call_to_action_link_and_call_to_action_description_el = NULL;
	if ($call_to_action_link_label) {
            $call_to_action_link_and_call_to_action_description_el = generate_call_to_action_link_and_description(
                $call_to_action_link_label,
                $call_to_action_link,
                $call_to_action_link_description,
		$call_to_action_link_new_tab
            );
	}

	$call_to_action_link_secondary_and_call_to_action_description_secondary_el = NULL;
	if ($call_to_action_link_label_secondary) {
            $call_to_action_link_secondary_and_call_to_action_description_secondary_el = generate_call_to_action_link_and_description(
                $call_to_action_link_label_secondary,
                $call_to_action_link_secondary,
                $call_to_action_link_description_secondary,
		$call_to_action_link_new_tab
                ['secondary']
            );
	}

	$image_and_call_to_action = $image_and_call_to_action_b .
                                    $feature_image_el .
                                    $call_to_action_link_and_call_to_action_description_el .
                                    $call_to_action_link_secondary_and_call_to_action_description_secondary_el .
                                    $image_and_call_to_action_e;

    }

    echo $image_and_call_to_action;

}

/**
 * Generates a call to action link and description that appears at the
 * top-right of the page.
 *
 * @param string $call_to_action_link_label The label that appears within the
 * call to action link
 * @param string $call_to_action_link A Page ID or URL that the call to action
 * links to
 * @param string $call_to_action_link_description A small description that
 * appears under the call to action link
 * @param boolean $call_to_action_link_new_tab Should the link open in a new tab
 * @param string[] $classes Additional CSS classes to add to the call to action
 * link button
 *
 * @return string HTML representation of the call to action link and description
 */
function generate_call_to_action_link_and_description($call_to_action_link_label, $call_to_action_link = '', $call_to_action_link_description = '', $call_to_action_link_new_tab = false, $classes = []) {

    $call_to_action_link_el = '';
    if ($call_to_action_link_label) {

	$link_url = '';
	$external_url = false;
	if ($call_to_action_link && is_numeric($call_to_action_link)) {
	    $link_url = get_post($call_to_action_link)->guid;
	} else {
	    $link_url = $call_to_action_link;
	    $external_url = true;
	}

	$external_url = $external_url || $call_to_action_link_new_tab;

	$classes_as_string = '';
	if (!empty($classes)) {
	    $classes_as_string = ' ' . implode(' ', $classes);
	}

	if ($link_url) {
	    $call_to_action_link_b = '<a id="call-to-action-link" class="button' . $classes_as_string . '" ' . ($external_url ? ' target="_blank"' : '') . ' href="' . $link_url . '">';
	} else {
	    $call_to_action_link_b = '<a id="call-to-action-link" class="button placeholder">';
	}
	$call_to_action_link_e = '</a>';
	$call_to_action_link_el = $call_to_action_link_b .
				  $call_to_action_link_label .
				  $call_to_action_link_e;
    }

    $call_to_action_link_description_el = '';
    if ($call_to_action_link_description) {
	$call_to_action_link_description_b = '<label for="call-to-action-link" class="description">';
	$call_to_action_link_description_e = '</label>';
	$call_to_action_link_description_el = $call_to_action_link_description_b .
                                              $call_to_action_link_description .
                                              $call_to_action_link_description_e;

    }

    return $call_to_action_link_el . $call_to_action_link_description_el;
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
        if(strpos($class, ' ') !== false)
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
    $classes[] = "full-width";
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
    $classes[] = "column-container";
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
    $classes[] = "content-wrap";
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
    $classes[] = "full-width-inner";
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
    $classes[] = "has-column-layout";
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
    $classes[] = "full-width-inner-col";
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
    $classes[] = "full-width-image-container";
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
    $classes[] = "full-width-video-container-wrap";
    return container(
        container($content, ["full-width-video-container"]),
        $classes
    );
}

/**
 * A feature block container
 *
 * @param string $content Content from the database
 * @param string $classes[] A string to append to classes
 *
 * @return string HTML representation
 */
function container_feature_block($content, $classes=[])
{
    $classes[] = "feature-block";
    $classes[] = "content-area";
    return container($content, $classes);
}

/**
 * A feature block caption container
 *
 * @param string $content Content from the database
 * @param string $classes[] A string to append to classes
 *
 * @return string HTML representation
 */
function container_feature_block_caption($content, $classes=[])
{
    $classes[] = "feature-block-caption";
    return container($content, $classes);
}

/**
 * A feature block image container
 *
 * @param string $content Content from the database
 * @param string $classes[] A string to append to classes
 *
 * @return string HTML representation
 */
function container_feature_block_image($content, $classes=[])
{
    $classes[] = "feature-block-image";
    return container($content, $classes);
}

/**
 * A feature block tile list container
 *
 * @param string $content Content from the database
 * @param string $classes[] A string to append to classes
 *
 * @return string HTML representation
 */
function container_feature_block_tile_list($content, $classes=[])
{
    $classes[] = "feature-block-tile-list";
    return container($content, $classes);
}

/**
 * A thumbnail gallery container
 *
 * @param string $content Content from the database
 * @param string $classes[] A string to append to classes
 *
 * @return string HTML representation
 */
function container_thumbnail_gallery_inner($content, $classes=[])
{
    $classes[] = "thumbnail-gallery-inner";
    return container($content, $classes);
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
    $classes[] = "grid-row";
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
    $classes[] = "tile";
    $style_attribute = '';
    if (!empty($background_image_url)) {
	$style_attribute = 'style="background-image: url(\'' . $background_image_url . '\')"';
    }

    return '<div class="' . implode(' ', $classes) . '" ' . $style_attribute . '>' . $content . '</div>';
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
    $classes[] = "grid-break";
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
    $classes[] = "text-section";
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
    $classes[] = "reference-list";
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
            'byline' => ''), $atts
    );

    $bc = get_breadcrumb();

    $heading = '<h1>' . $a['byline'] . '</h1>';
    $blurb = '<p>' . $content . '</p>';

    return do_shortcode(
        container_column(
            container_column_inner(
                $bc . $heading . $blurb
            )
        )
    );
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
    $content = $heading . $text;
    if ($a['links']) {
	$links_b = '<ul class="list-of-links">';
	$links_e = '</ul>';
	$links = "";
	foreach (explode(",", $a['links']) as $pid) {
            $post = get_post($pid);
            $link = '<a href="' . $post->guid . '">'. $post->post_title . '</a>';
            $listitem = '<li>' . $link . '</li>';
            $links .= $listitem;
	}
	$content .= $links_b . $links . $links_e;
    }
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

    $container_classes = ["image-container"];

    $feature_content = '';
    if ($a['media'] !== '' || !empty($content)) {
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
            $feature_content = $img;
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
            $container_classes[] = 'dark';
            $container_classes[] = 'edge-to-edge';
	} else if (!empty($content)) {
            $feature_content = remove_p($content);
	}
    }

    return remove_empty_p(container_fw(
        $feature_content,
        $container_classes
    ));
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
            ), ["how-to", "preserve-horizontal-col-layout-on-tablet"]
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
 * A shortcode for displaying the credits that will appear within the footer
 * section of the page. The shortcode does not return HTML, instead, the HTML
 * will be rendered within footer.php
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 */

function credits($atts, $content=null)
{   if (!metadata_exists('post', get_the_ID(), 'credits')) {
      add_post_meta(get_the_ID(), 'credits', $content);
    } else {
      update_post_meta(get_the_ID(), 'credits', $content);
    }
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
    return container_fw(container_fw_inner($content), array('dark', 'code'));
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
            'item' => null,
	    'new_tab' => null), $atts
    );

    if (isset($a['new_tab'])) {
	// $a['new_tab'] = (bool)$a['new_tab'];
	$a['new_tab'] = (strtolower($a['new_tab']) === "true");
    }

    $external_url = false;
    if (is_numeric($a['item'])) {
        $url = get_post($a['item'])->guid;
    } else {
        $url = $a['item'];
        $external_url = true;
    }

    if ($url) {
	return '<a class="button" href="' . $url . '"' . (($external_url || $a['new_tab']) ? ' target="_blank"' : '') . '>' . $a['label'] . '</a>';
    } else {
	return '<a class="button placeholder" ' . (($a['new_tab'] === false) ? '' : 'target="_blank"') . '>' . $a['label'] . '</a>';
    }
}

/**
 * A feature block
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function feature_block($atts, $content=null)
{
    $a = shortcode_atts(
	array(
	    'is_hero' => false,
	    'is_downshifted' => false,
	    'is_highlighted' => false), $atts
    );

    $classes = array();

    if ($a['is_hero'] === 'true') {
	$classes[] = 'hero';
    }

    if ($a['is_downshifted'] === 'true') {
	$classes[] = 'downshifted';
    }

    if ($a['is_highlighted'] === 'true') {
	$classes[] = 'highlighted';
    }

    return do_shortcode(
	container_feature_block($content, $classes)
    );
}

/**
 * A feature block's caption
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function feature_block_caption($atts, $content=null) {

    return do_shortcode(
	container_feature_block_caption($content)
    );

}

/**
 * A feature block's image
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function feature_block_image($atts, $content=null) {

    $a = shortcode_atts(
	array(
	    'media' => null
	), $atts
    );

    if (!is_null($a['media'])) {

	$url = get_media_url_from_id_or_url($a['media']);

	$content = '';
	$content .= '<img class="feature-block-image-image" src="' . $url . '" />';
	$content .= '<div class="feature-block-image-displayable" style="background-image: url(\'' . $url . '\')">';
	$content .= '</div>';

	return do_shortcode(
	    container_feature_block_image($content)
	);
    }

}

/**
 * A feature block's tile list
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function feature_block_tile_list($atts, $content=null) {

    return remove_empty_p(do_shortcode(
	container_feature_block_tile_list(
	    remove_p_around_shortcodes($content)
	)
    )
    );

}

/**
 * A feature block's tile
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function feature_block_tile($atts, $content=null) {

    $a = shortcode_atts(
	array(
	    'icon' => null,
	    'link' => null
	), $atts
    );

    $img = '';
    if (is_numeric($a['icon'])) {
	$attachment = get_post($a['icon']);
	$img_src = $attachment->guid;
	$img_alt = $attachment->post_title;
	$img = '<img src="' . $img_src . '" alt="' . $img_alt . '" />';
    }

    $url = '';
    if (is_numeric($a['link'])) {
	$attachment = get_post($a['link']);
	if ($attachment) {
	    $url = $attachment->guid;
	}
    } else if (esc_url_raw($a['link']) === $a['link']) {
	$url = $a['link'];
    }

    $tile_b = '<a class="feature-block-tile"' . ($url ? ' href="' . $url . '"' : '') . '>';
    $tile_c = '<p>' . $content . '</p>';
    $tile_e = '</a>';

    return $tile_b . $img . $tile_c . $tile_e;

}

/**
 * A full width thumbnail gallery
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function full_width_thumbnail_gallery($atts, $content=null)
{

    $a = shortcode_atts(
	array(
	    'title' => null,
	    'circular_images' => false,
	    'fitted_images' => false
	), $atts
    );

    $classes = ['thumbnail-gallery'];

    if ($a['circular_images']) {
	$classes[] = 'circular-images';
    }

    if ($a['fitted_images']) {
	$classes[] = 'fitted-images';
    }

    return remove_empty_p(do_shortcode(
	container_fw(
            container_fw_inner(
		($a['title'] ? '<h2>' . $a['title'] .'</h2>' : '')
              . container_thumbnail_gallery_inner(
		  remove_p_around_shortcodes($content)
              ),
		$classes)
	  , ['no-background'])
    )
    );

}

/**
 * A single thumbnail instance
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function thumbnail($atts, $content=null)
{

    $a = shortcode_atts(
	array(
	    'media' => null,
	    'caption' => null,
	    'subcaption' => null,
	    'subsubcaption' => null,
	    'url' => null
	), $atts
    );

    if (!is_null($a['media'])) {

	$url = get_media_url_from_id_or_url($a['media']);

	$figure_b = '<figure class="thumbnail">';
	$figure_img_div = '<div class="thumbnail-image" style="background-image: url(' . $url . ')" />';
	$figure_e = '</figure>';

	$figure_figcaption = '';
	if ($a['caption'] || $a['subcaption'] || $a['subsubcaption'])
	{
	    $figure_figcaption_b = '<figcaption>';
	    $figure_figcaption_caption = $a['caption'] ? '<p>' . $a['caption'] . '</p>' : '';
	    $figure_figcaption_subcaption = $a['subcaption'] ? '<p><small>' . $a['subcaption'] . '</small></p>' : '';
	    $figure_figcaption_subsubcaption = $a['subsubcaption'] ? '<p><small>' . $a['subsubcaption'] . '</small></p>' : '';
	    $figure_figcaption_e = '</figcaption>';
	    $figure_figcaption = $figure_figcaption_b
                               . $figure_figcaption_caption
                               . $figure_figcaption_subcaption
                               . $figure_figcaption_subsubcaption
                               . $figure_figcaption_e;
	}

        $html = $figure_b . $figure_img_div . $figure_figcaption . $figure_e;

        if (!is_null($a['url'])) {
            $html = '<a href="' . $a['url'] . '" target="_blank">' . $html . '</a>';
        }

        return $html;
    }
}

/**
 * A gallery of captioned images
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function captioned_image_gallery($atts, $content=null)
{
  $a = shortcode_atts(
    array(
      'headline' => '',
      'subheadline' => ''), $atts
  );

  $rendered_content = '';
  $rendered_content .= $a['headline'] ? '<h2>' . $a['headline'] . '</h2>' : '';
  $rendered_content .= $a['subheadline'] ? '<h3>' . $a['subheadline'] . '</h3>' : '';
  $rendered_content .= '<div class="captioned-image-gallery-images">';
  $rendered_content .= do_shortcode($content);
  $rendered_content .= '</div>';

  return remove_empty_p(container_column(
    $rendered_content,
    ['captioned-image-gallery']
  ));
}

/**
 * A single captioned image
 *
 * @param array  $atts    Shortcode attributes
 * @param string $content Content from the database
 *
 * @return string HTML representation
 */
function captioned_image($atts, $content=null)
{
  $a = shortcode_atts(
    array(
      'image' => ''), $atts
  );

  $image_url = get_media_url_from_id_or_url($a['image']);

  $figure_b = '<figure>';
  $img = '<img src="' . $image_url . '" />';
  $figcaption = '<figcaption>' . $content . '</figcaption>';
  $figure_e = '</figure>';

  return $figure_b . $img . $figcaption . $figure_e;
}

/**
 * Add the shortcodes.
 */
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
add_shortcode('call_to_action', 'call_to_action_button');

add_shortcode('text', 'text_section');
add_shortcode('code', 'code');

add_shortcode('feature_block', 'feature_block');
add_shortcode('feature_block_caption', 'feature_block_caption');
add_shortcode('feature_block_image', 'feature_block_image');
add_shortcode('feature_block_tile_list', 'feature_block_tile_list');
add_shortcode('feature_block_tile', 'feature_block_tile');

add_shortcode('full_width_thumbnail_gallery', 'full_width_thumbnail_gallery');
add_shortcode('thumbnail', 'thumbnail');
add_shortcode('captioned_image_gallery', 'captioned_image_gallery');
add_shortcode('captioned', 'captioned_image');

add_shortcode('references', 'references');
add_shortcode('credits', 'credits');

/* Some utility functions just to output re-used HTML. There are
 * better ways to do this stuff */

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
 * Generic media function, either accepts a WordPress Media Post ID or just an
 * external url
 *
 * @return string The URL of the image, or FALSE if invalid
 */
function get_media_url_from_id_or_url($id_or_url) {

    $url = false;
    if (is_numeric($id_or_url)) {
	$attachment = get_post($id_or_url);
	if ($attachment) {
	    $url = $attachment->guid;
	}
    } else if (esc_url_raw($id_or_url) === $id_or_url) {
	$url = $id_or_url;
    }
    return $url;

}
