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

    function test_label_should_be_used_if_given()
    {
        $label = "Button label";
        $id = self::factory()->post->create();

        $html = call_to_action_button(['label' => $label, 'item' => $id]);

        $this->assertContains('>' . $label . '</a>', $html);
    }

    function test_label_should_be_used_for_placeholders_too_if_given()
    {
        $label = "Button label";
        $html = call_to_action_button(['label' => $label]);

        $this->assertContains('>' . $label . '</a>', $html);
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

    function test_explicitly_asking_for_target_should_do_so_with_string_true()
    {
        $id = self::factory()->post->create();

        $html = call_to_action_button(['label' => "Label",
                                       'item' => $id,
                                       'new_tab' => "true"]);

        $this->assertNotEmpty($html);
        $this->assertContains('target="_blank"', $html);
    }

    function test_case_of_new_tab_attribute_should_be_ignored()
    {
        $id = self::factory()->post->create();

        $html = call_to_action_button(['label' => "Label",
                                       'item' => $id,
                                       'new_tab' => "True"]);

        $this->assertNotEmpty($html);
        $this->assertContains('target="_blank"', $html);
    }


    function test_only_specifying_string_true_should_have_target()
    {
        $id = self::factory()->post->create();

        $html = call_to_action_button(['label' => "Label",
                                       'item' => $id,
                                       'new_tab' => "false"]);

        $this->assertNotEmpty($html);
        $this->assertNotContains('target="_blank"', $html);
    }

    function test_explicitly_requesting_new_tab_should_have_priority()
    {
        $id = self::factory()->post->create();

        $internal_html = call_to_action_button(['label' => "Label",
                                                'item' => $id,
                                                'new_tab' => "true"]);

        $this->assertNotEmpty($internal_html);
        $this->assertContains('target="_blank"', $internal_html);

        $external_html = call_to_action_button(['label' => "Label",
                                                'item' => "http://q.ux",
                                                'new_tab' => "false"]);

        $this->assertNotEmpty($external_html);
        $this->assertNotContains('target="_blank"', $external_html);

        $placeholder_html = call_to_action_button(['label' => "Label",
                                                   'new_tab' => "false"]);

        $this->assertNotEmpty($placeholder_html);
        $this->assertNotContains('target="_blank"', $placeholder_html);

    }
}
