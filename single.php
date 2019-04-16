<?php get_header(); ?>

<?php the_post(); ?>
<?php echo prepend_cover_to_article(); ?>
<article class="article-content wrap-container">
    <div class="column-container">
	<div class="column-container-inner">
	    <h1><?php echo the_title(); ?></h1>
	    <?php the_content(); ?>
	    <?php author_citation(); ?>
	</div>
    </div>
</article>

<?php get_footer(); ?>
