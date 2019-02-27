<?php get_header(); ?>

<!-- Site Content Goes Here -->
<?php while (have_posts()): the_post(); ?>
  <?php prepend_image_and_call_to_action_to_article(); ?>
  <article class="article-content wrap-container content-area">
    <?php the_content(); ?>
  </article>
<?php endwhile; ?>
<?php get_footer(); ?>
