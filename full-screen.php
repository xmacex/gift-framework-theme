<?php /* Template Name: Full Screen */ ?>
<?php get_header(); ?>

<!-- Site Content Goes Here -->
<?php while (have_posts()): the_post(); ?>
  <?php the_content(); ?>
<?php endwhile; ?>
<?php get_footer(); ?>
