<?php get_header(); ?>

<!-- Site Content Goes Here -->
<?php while (have_posts()): the_post(); ?>
  <?php the_content(); ?>
  <div class="wrap-container">
    <div class="column-container">
      <div class="feature-section">
        <div class="feature-section-caption content-area">
          <div class="feature-section-title">
            <p class="feature-section-subtitle">Case Study</p>
            <h2>Uncovering the Invisible</h2>
          </div>
          <div class="feature-section-caption-content">
            <p>
              Artcodes can be used to create an experience. An experience can be an entire exhibition of photographs with commentary and voice overlays, or a single album cover that contains hidden, unlockable content.
            </p>
            <p>
              <a href="#">Learn More ...</a>
            </p>
          </div>
        </div>
        <div class="feature-section-content">
          <div class="feature-section-image" style="background-image: url('http://localhost:8888/gift-framework/wp-content/uploads/2019/09/Title-Card.jpg')">
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endwhile; ?>
<?php get_footer(); ?>
