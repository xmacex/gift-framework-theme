<?php get_header(); ?>

<!-- Site Content Goes Here -->
<?php while (have_posts()): the_post();
// prepend_cover_to_article filter runs here
// wrap_content_in_article filter runs here
the_content();
endwhile;
?>
<?php get_footer(); ?>
