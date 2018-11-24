<?php get_header(); ?>

<!-- Site Content Goes Here -->
<?php while (have_posts()): the_post(); ?>
    <section class="grid-page wrap-container">
      <?php the_content(); ?>
    </section>
<?php endwhile; ?>
<?php get_footer(); ?>
