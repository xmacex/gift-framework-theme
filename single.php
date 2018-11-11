<?php get_header(); ?>

<?php the_post(); ?>
<section class="cover" style="background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')"></section>
<article class="article-content wrap-container">
    <div class="column-container">
	<div class="column-container-inner">
	    <h1><?php echo the_title(); ?></h1>
	    <?php the_content(); ?>
	</div>
    </div>
</article>

<?php get_footer(); ?>
