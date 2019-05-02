<?php
class testAuthorCitation extends WP_UnitTestCase {
    function setUp()
    {
        $this->user = self::factory()->user->create_and_get([
            'first_name' => 'Firstname',
            'last_name' => 'Lastname',
            'user_nicename' => 'firstname-lastname',
            'role' => 'editor',
        ]);

        $this->post = self::factory()->post->create_and_get([
            'post_author' => $this->user->ID,
            'post_type' => 'post',
            'post_status' => 'publish'
        ]);

        $plugins = ['hello.php', 'co-authors-plus/co-authors.plus'];
        deactivate_plugins($plugins);
    }

    function test_unit_testing_is_in_place()
    {
        $this->assertEquals(true, true);
    }

    function test_user_gets_set_up_as_a_post_author()
    {
        $this->assertEquals(
            $this->user->user_login,
            get_user_by('id', $this->post->post_author)->user_login);
    }

    function test_authors_are_wrapped_in_div_with_class_authors()
    {
        setup_postdata($this->post);
        $this->assertStringStartsWith(
            '<div class="authors">',
            get_author_citation());
    }

    function test_author_is_wrapped_in_span_with_class_author()
    {
        setup_postdata($this->post);
        $this->assertRegExp(
            '/<span class="author">.*<\/span>/',
            get_author_citation());
    }

    function test_author_name_is_wrapped_in_em()
    {
        setup_postdata($this->post);
        $this->assertContains(
            '<em>' . get_the_author_meta('display_name') . '</em>',
            get_author_citation()
        );
    }

    function test_author_gets_cited_as_author()
    {
        setup_postdata($this->post);
        $this->assertContains(
            get_the_author_meta('first_name'),
            get_author_citation());
        $this->assertContains(
            get_the_author_meta('last_name'),
            get_author_citation());
        $this->assertContains(
            get_the_author_meta('display_name'),
            get_author_citation());
    }

    function test_a_shipped_plugin_is_activated()
    {
        $plugin = 'hello.php';
        $this->assertFalse(is_plugin_active($plugin));
        $result = activate_plugins($plugin);
        if(is_wp_error($result))
        {
            throw $result;
        }
        $this->assertTrue(is_plugin_active($plugin));
    }

    function test_co_authors_plus_plugin_is_activated()
    {
        $plugin = 'co-authors-plus/co-authors-plus.php';
        $this->assertFalse(is_plugin_active($plugin));
        $result = activate_plugins($plugin);
        if(is_wp_error($result))
        {
            var_dump($result);
        }
        $this->assertTrue(is_plugin_active($plugin));
    }

    function test_author_is_get_as_a_coauthor_too()
    {
        setup_postdata($this->post);

        $plugin = 'co-authors-plus/co-authors-plus.php';
        activate_plugins($plugin);
        $this->assertTrue(is_plugin_active($plugin));

        global $coauthors_plus;
        $this->_cap = $coauthors_plus;

        $coauthor = $this->_cap->get_coauthor_by('id', $this->user->ID);
        $this->assertInstanceOf(WP_User::class, $coauthor);

        $this->assertEquals($this->user->user_login, $coauthor->user_login);
    }

    function test_coauthor_is_added_to_a_post()
    {
        setup_postdata($this->post);

        $plugin = 'co-authors-plus/co-authors-plus.php';
        activate_plugins($plugin);
        $this->assertTrue(is_plugin_active($plugin));

        global $coauthors_plus;
        $this->_cap = $coauthors_plus;
        $this->_cap->action_init();
        $this->_cap->action_init_late();
        sleep(1);
        // We are interested in the author taxonomy
        $this->assertContains('author', get_taxonomies());

        $coauthor = self::factory()->user->create_and_get([
            'first_name' => 'Coau',
            'last_name' => 'Thor',
            'role' => 'editor',
            'user_login' => 'coau thor',
        ]);

        // $this->_cap->add_coauthors($this->post->ID, array($this->user->user_login, $coauthor->user_login), true);
        // xdebug_start_trace('/tmp/testBreakPointTrace');
        // $this->_cap->add_coauthors($this->post->ID, [$coauthor->user_login], true);
        // print(var_dump($coauthor));
        // $this->_cap->add_coauthors($this->post->ID, [$this->user->user_nicename], true);
        $this->_cap->add_coauthors($this->post->ID, ['coau-thor'], true);
        // xdebug_end_trace();
        $this->assertEquals([$this->user, $coauthor], get_coauthors($this->post->ID));
    }
}
