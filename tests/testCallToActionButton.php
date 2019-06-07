<?php
class testCallToActionButton extends wp_UnitTEstCase
{
    function test_button_should_be_created_with_default_options()
    {
	$html = call_to_action_button([]);

	$this->assertEquals(
	    '<a class="button placeholder" target="_blank"></a>',
	    $html);
    }
    
    function test_specifying_item_by_id_should_not_have_target()
    {
	$id = self::factory()->post->create();

	$html = call_to_action_button(['label' => "Label", 'item' => $id]);

	$this->assertNotEmpty($html);
	$this->assertNotContains('target="_blank"', $html);
    }

    function test_specifying_item_by_url_should_have_target()
    {
	$html = call_to_action_button(['label' => "Label",
				       'item' => "http://q.ux"]);

	$this->assertNotEmpty($html);
	$this->assertContains('target="_blank"', $html);
    }

    function test_explicitly_asking_for_target_should_do_so()
    {
	$html = call_to_action_button(['label' => "Label",
				       'item' => "http://q.ux",
				       'new_tab' => "true"]);

	$this->assertNotEmpty($html);
	$this->assertContains('target="_blank"', $html);
    }
}
