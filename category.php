<?php get_header(); ?>

<section class="grid-page wrap-container">
    <div class="column-container grid-container">
  <?php while (have_posts()): the_post(); ?>
	    <div class="case-study grid-section">
		<div class="faded image tile stripes-slope-right" style="background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')"></div>
		<div class="tile">
		    <h3><?php echo the_title(); ?></h3>
		    <?php echo the_content('<p>Learn more&hellip;</p>'); ?>
		</div>
	    </div>
	<?php endwhile ?>
    </div>
</section>

<?php get_footer(); ?>
