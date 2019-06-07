<?php
class testGenerateCallToAction extends WP_UnitTestCase {
    function setUp()
    {
        $this->action_id = self::factory()->attachment->create([
            'id' => 10
        ]);

        $this->id = $this::factory()->post->create();
    }

    function test_unit_testing_is_in_place()
    {
        $this->assertTrue(true);
    }

    function test_without_label_should_die()
    {
	$this->expectException("ArgumentCountError");
	$this->expectExceptionMessage("Too few arguments");
        $html = generate_call_to_action_link_and_description();
    }

    function test_even_without_link_should_generate_cta()
    {
	add_post_meta($this->id, 'call_to_action_link_label', "Link label here");

        $html = generate_call_to_action_link_and_description(
	    get_post_meta($this->id, 'call_to_action_link_label', true)
	);

        $this->assertNotEquals('', $html);
	$this->assertStringStartsWith('<', $html);
	$this->assertEquals('<a id="call-to-action-link" class="button placeholder">Link label here</a>', $html);
    }

    function test_new_tab_unspecified_should_not_have_target_blank()
    {
        add_post_meta($this->id, 'call_to_action_link_label', "Link label here");
        add_post_meta($this->id, 'call_to_action_link', $this->action_id);
        add_post_meta($this->id, 'call_to_action_link_description', "Link description here");
        
        $html = generate_call_to_action_link_and_description(
            get_post_meta($this->id, 'call_to_action_link_label', true),
            get_post_meta($this->id, 'call_to_action_link', true),
            get_post_meta($this->id, 'call_to_action_link_description', true)
        );
        
        $this->assertStringStartsWith('<', $html);
        $this->assertStringEndsWith('</label>', $html);
        $this->assertContains('Link label here', $html);
        $this->assertContains('Link description here', $html);
        $this->assertNotContains('target="_blank"', $html);
    }

    function test_new_tab_string_true_should_have_target_blank()
    {
        add_post_meta($this->id, 'call_to_action_link_label', "Link label here");
        add_post_meta($this->id, 'call_to_action_link', $this->action_id);
        add_post_meta($this->id, 'call_to_action_link_new_tab', "true");
        
        $html = generate_call_to_action_link_and_description(
            get_post_meta($this->id, 'call_to_action_link_label', true),
            get_post_meta($this->id, 'call_to_action_link', true),
            get_post_meta($this->id, 'call_to_action_link_description', true),
            get_post_meta($this->id, 'call_to_action_link_new_tab', true)
        );

        $this->assertContains('target="_blank"', $html);
    }

    function test_new_tab_boolean_true_should_not_add_target_blank()
    {
	add_post_meta($this->id, 'call_to_action_link_label', "Link label here");
        add_post_meta($this->id, 'call_to_action_link_new_tab', true);

        $html = generate_call_to_action_link_and_description(
            get_post_meta($this->id, 'call_to_action_link_label', true),
            get_post_meta($this->id, 'call_to_action_link', true),
            get_post_meta($this->id, 'call_to_action_link_description', true),
            get_post_meta($this->id, 'call_to_action_link_new_tab', true)
        );

	$this->assertNotEmpty($html);
        $this->assertNotContains('target="_blank"', $html);
    }

    function test_new_tab_string_false_should_not_add_target_blank()
    {
	add_post_meta($this->id, 'call_to_action_link_label', "Link label here");
        add_post_meta($this->id, 'call_to_action_link_new_tab', "false");

        $html = generate_call_to_action_link_and_description(
            get_post_meta($this->id, 'call_to_action_link_label', true),
            get_post_meta($this->id, 'call_to_action_link', true),
            get_post_meta($this->id, 'call_to_action_link_description', true),
            get_post_meta($this->id, 'call_to_action_new_tab', true)
        );

	$this->assertNotEmpty($html);
        $this->assertNotContains('target="_blank"', $html);
    }

    function test_new_tab_boolean_false_should_not_add_target_blank()
    {
	add_post_meta($this->id, 'call_to_action_link_label', "Link label here");
        add_post_meta($this->id, 'call_to_action_link_new_tab', false);

        $html = generate_call_to_action_link_and_description(
            get_post_meta($this->id, 'call_to_action_link_label', true),
            get_post_meta($this->id, 'call_to_action_link', true),
            get_post_meta($this->id, 'call_to_action_link_description', true),
            get_post_meta($this->id, 'call_to_action_new_tab', true)
        );

	$this->assertNotEmpty($html);
        $this->assertNotContains('target="_blank"', $html);
    }
}
