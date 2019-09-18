<?php get_header(); ?>

<!-- Site Content Goes Here -->
<?php while (have_posts()): the_post(); ?>
  <?php the_content(); ?>
  <div class="wrap-container">
    <div class="column-container">
      <!-- Case Study Example Feature Section -->
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
      <!-- Quotable Example Feature Section -->
      <div class="feature-section with-quote">
        <div class="feature-section-caption content-area">
          <div class="feature-section-title">
            <p class="feature-section-subtitle">Insight</p>
            <h2>Have Blast Theory Created the Future of Museums?</h2>
          </div>
          <div class="feature-section-caption-content">
            <p>
              Asks Kevin Bacon, Digital Manager at Brighton Museum. He explains the museum’s rationale for experimenting with the app:
            </p>
          </div>
        </div>
        <div class="feature-section-content">
          <div class="feature-section-quote article-content">
            <blockquote>
              Technologies can be effective ways of providing more content to visitors, but they often rub against the grain of the social experience, resulting in a low uptake. On the surface, Gift does much the same: the visitor uses their mobile phone to create and share content in a solitary way. But because it is so rooted in the practice of creating and sending gifts, it can enhance the social experience of the museum. A gift could be sent to a friend in another gallery, who is then encouraged to seek out the shared exhibit. It can even be shared with someone outside of the museum, so that they can enjoy their gift at home, and possibly visit the museum themselves in the future. (…) By turning an ephemeral message into a gift, Blast Theory’s Gift app taps into the long-established practice of museum visitors acquiring souvenirs of their experience.
            </blockquote>
          </div>
        </div>
      </div>
      <!-- Tools Overview Feature Section -->
      <div class="feature-section category-overview">
        <div class="feature-section-caption content-area">
          <div class="feature-section-title">
            <p class="feature-section-subtitle">Design & Planning Tools</p>
            <h2 style="color: #FE7062">Generate, Strengthen and Test your Ideas</h2>
          </div>
        </div>
        <div class="feature-section-content">
          <div class="feature-section-image faded" style="background-image: url('http://localhost:8888/gift-framework/wp-content/uploads/2018/11/visitorbox-design-cards-3-1-1.jpg')">
          </div>
        </div>
      </div>
      <div class="category-list">
        <p></p><div class="category-list-item"><a href="http://localhost:8888/gift-framework/visitorbox-design-cards/"><img class="category-list-item-featured-image" src="http://localhost:8888/gift-framework/wp-content/uploads/2018/11/visitorbox-design-cards-3-1-1.jpg" alt="VisitorBox Ideation Cards"><div class="category-list-item-featured-image-displayable" style="background-image: url('http://localhost:8888/gift-framework/wp-content/uploads/2018/11/visitorbox-design-cards-3-1-1.jpg')"></div><h3 style="color: #E35249">Generate Ideas</h3><h2>VisitorBox Ideation Cards</h2><p>
        <p class="learn-more">Learn More ...</p></a></div><p></p>
        <p></p><div class="category-list-item"><a href="http://localhost:8888/gift-framework/asapmap/"><img class="category-list-item-featured-image" src="http://localhost:8888/gift-framework/wp-content/uploads/2019/05/IMG_8144-1.jpg" alt="The ASAP Map"><div class="category-list-item-featured-image-displayable" style="background-image: url('http://localhost:8888/gift-framework/wp-content/uploads/2019/05/IMG_8144-1.jpg')"></div><h3 style="color: #E35249">Strengthen Ideas</h3><h2>The ASAP Map</h2><p>
        <p class="learn-more">Learn More ...</p></a></div><p></p>
        <p></p><div class="category-list-item"><a href="http://localhost:8888/gift-framework/experimentplanner/"><img class="category-list-item-featured-image" src="http://localhost:8888/gift-framework/wp-content/uploads/2019/05/UNADJUSTEDNONRAW_thumb_51-1.jpg" alt="The Experiment Planner"><div class="category-list-item-featured-image-displayable" style="background-image: url('http://localhost:8888/gift-framework/wp-content/uploads/2019/05/UNADJUSTEDNONRAW_thumb_51-1.jpg')"></div><h3 style="color: #E35249">Test Ideas</h3><h2>The Experiment Planner</h2><p>
        <p class="learn-more">Learn More ...</p></a></div><p></p>
        </div>
    </div>
  </div>
<?php endwhile; ?>
<?php get_footer(); ?>
