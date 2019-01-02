<?php
class CallToActionTest extends WP_UnitTestCase {
    function test_unit_testing_is_in_place()
    {
        return $this->assertEquals(true, true);
    }

    function test_should_provide_the_same_output_as_previous_static_html()
    {
        $staticHtml = '<div class="call-to-action-area"><a id="call-to-action-link" class="button" href="#">Get Started Now</a><label for="call-to-action-link" class="description">Interested? Register with us now and a member of the Gift Project Team will contact you and guide you through the process.</label></div>';

        $button_text = 'Get Started Now';
        $url = '#';
        $text = 'Interested? Register with us now and a member of the Gift Project Team will contact you and guide you through the process.';

        $this->assertEquals(
            $staticHtml,
            call_to_action($button_text, $url, $text));
    }
}

class ContainerDecoratorTest extends WP_UnitTestCase {
    function test_container_without_classes_should_just_wrap_content()
    {
        $this->assertEquals(
            '<div class="">Content here</div>',
            container("Content here")
        );
    }

    function test_container_should_add_single_class_parameter()
    {
        $this->assertEquals(
            '<div class="a-class">Content here</div>',
            container("Content here", ["a-class"])

        );
    }

    function test_container_should_add_multiple_class_parameters()
    {
        $this->assertEquals(
            '<div class="a-class another-class">Content here</div>',
            container("Content here", ["a-class", "another-class"])

        );
        $this->assertEquals(
            '<div class="a-class another-class one-more">Content here</div>',
            container("Content here", ["a-class", "another-class", "one-more"])

        );
    }

    /**
     * @dataProvider classWithSpacesProvider
     */
    function test_container_should_reject_classes_with_invalid_chrs($params)
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage("Class contains a space");
        container("Content here", $params);
    }

    function test_immediate_derivate_container_should_just_wrap_content()
    {
        $this->assertEquals(
            '<div class="full-width">Content here</div>',
            container_fw("Content here")
        );
    }
    
    function test_immediate_derivate_container_should_add_single_class()
    {
        $this->assertEquals(
            '<div class="a-class full-width">Content here</div>',
            container_fw("Content here", ["a-class"])
        );
    }

    function test_further_derivate_container_should_just_wrap_content()
    {
        $this->assertEquals(
            '<div class="has-column-layout full-width-inner">Content here</div>',
            container_fw_inner_has_col_layout("Content here")
        );
    }

    function test_higher_derivate_container_should_just_wrap_content()
    {
        $this->assertEquals(
            '<div class="full-width-video-container-wrap"><div class="full-width-video-container">Content here</div></div>',
            container_fw_video("Content here"));
    }

    /**
     * Data providers
     */
    function classWithSpacesProvider()
    {
        return [
            'Class with space' => [
                ['spacy class']
            ],
            'Class with leading space' => [
                [' spacyclass']
            ]
        ];
    }
}

class PartnerWidgetTest extends WP_UnitTestCase
{
    function test_decorator_wraps_content_with_minimal_arguments()
    {
        $output = partner(null, "Organization Name");

        $this->assertEquals(
            '<div class="participant">Organization Name</div>',
            $output);
    }

    function test_decorator_generates_link_when_given_url()
    {
        $output = partner(['url'=>'http://example.org'], "Organization Name");

        $this->assertEquals(
            '<div class="participant"><a href="http://example.org">Organization Name</a></div>',
            $output);
    }

    function test_decorator_generates_link_when_given_logo_and_url()
    {
        $media = $this->factory->attachment->create(); // ID is returned
        $output = partner(['logo'=>$media, 'url'=>'http://example.org'], "Organization Name");

        $this->assertEquals(
            '<div class="participant"><a href="http://example.org"><img class="participant-logo" src="http://example.org/?attachment_id=' . $media . '"/>Organization Name</a></div>',
            $output);
    }

    /**
     * Integration tests for shortcodes
     */
    function test_shortcode_calls_decorator_with_minimal_parameters()
    {
        ob_start();
        echo do_shortcode('[partner]Organization Name[/partner]');
        $output = ob_get_clean();

        $this->assertEquals(
            '<div class="participant">Organization Name</div>',
            $output);
    }

    function test_shortcode_generates_link_when_given_url()
    {
        ob_start();
        echo do_shortcode('[partner url=http://example.org]Organization Name[/partner]');
        $output = ob_get_clean();
        
        $this->assertEquals(
            '<div class="participant"><a href="http://example.org">Organization Name</a></div>',
            $output);
    }

    function test_shortcode_generates_link_when_given_url_and_logo()
    {
        $media = $this->factory->attachment->create(); // ID is returned
        ob_start();
        echo do_shortcode('[partner logo=' . $media . ' url=http://example.org]Organization Name[/partner]');
        $output = ob_get_clean();

        $this->assertEquals(
            '<div class="participant"><a href="http://example.org"><img class="participant-logo" src="http://example.org/?attachment_id=' . $media . '"/>Organization Name</a></div>',
            $output);
    }
}
