<?php get_header(); ?>

<!-- Site Content Goes Here -->
<?php while (have_posts()): the_post(); ?>
    <?php echo prepend_cover_to_article(); ?>
    <article class="article-content wrap-container content-area">
	<?php the_content(); ?>
    </article>
<?php endwhile; ?>
<?php get_footer(); ?>
