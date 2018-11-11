<?php
require('tests/mockwp.php');
require('functions.php');

use PHPUnit\Framework\TestCase;

class testCallToAction extends TestCase {
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
