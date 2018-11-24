<?php get_header(); ?>

<!-- Site Content Goes Here -->
<?php while (have_posts()): the_post(); ?>
    <section class="grid-page wrap-container">
      <div class="feature grid-row">
        <div class="feature tile col-2-width">
          <h1>
            Give visitors the means  <br />to tell their own stories.
          </h1>
          <p>
            <em>digital + physical = hybrid</em>
          </p>
          <p>
            For decades, museums have tried to go digital. But no ‘virtual museum’ can match the experience of a physical visit. We’re bridging this divide: Facilitating hybrid museum experiences.
          </p>
          <p>
            The GIFT Framework provides tools and guidelines for digital sharing and play in physical museums.
          </p>
        </div>
        <div class="faded image tile hide-on-tablet-screens stripes-slope-left" style="background-image: url('<?php echo get_stylesheet_directory_uri() ?>/static-html-css/img/gift-exchange-app-3.jpg');">
        </div>
      </div>
      <div class="grid-break"></div>
      <div class="grid-row">
        <div class="purple coloured tile">
          <h3>
           Gifting
          </h3>
          <p>
           Did you ever make a mixtape for someone else? How about with objects from a museum?
          </p>
          <p>
           The Gift Exchange app invites visitors to see the museum through the eyes of someone else and turn the experience into a gift.
          </p>
        </div>
        <div class="faded image tile hide-on-mobile-screens stripes-slope-left" style="background-image: url('<?php echo get_stylesheet_directory_uri() ?>/static-html-css/img/gift-exchange-app-2.jpg');">
        </div>
      </div>
      <div class="grid-row">
        <div class="faded image tile hide-on-mobile-screens stripes-slope-left" style="background-image: url('<?php echo get_stylesheet_directory_uri() ?>/static-html-css/img/artcodes-3.jpg');">
        </div>
        <div class="blue coloured tile">
          <h3>
           ArtCodes
          </h3>
          <p>
           Artcodes are digital markers that can be hand-crafted to match the aesthetic of the museum, or even drawn by visitors to leave their mark both physically and digitally.
          </p>
          <p>
           The Artcodes app can also be used as a prototyping tool to explore hybrid experiences quickly and easily.
          </p>
        </div>
      </div>
      <div class="grid-row">
        <div class="red coloured tile">
          <h3>
           Ideation
          </h3>
          <p>
           Ideation cards can be used to quickly generate new ideas for your museum. The cards help you bring into play all the different considerations you should have in mind when developing new ideas, such as organisational goals, visitor needs, technological capabilities, IPR and a large number of practical and aesthetic considerations.
          </p>
        </div>
        <div class="faded image tile hide-on-mobile-screens stripes-slope-left" style="background-image: url('<?php echo get_stylesheet_directory_uri() ?>/static-html-css/img/visitorbox-design-cards-3.jpg');">
        </div>
      </div>
      <div class="column-container">
        <div class="text-section">
          <h2>
            GIFT is an EU-funded Horizon 2020 Research Project.
          </h2>
          <p>
            Bringing together <em>artists</em>, <em>designers</em>, <em>museum professionals</em> and <em>computer scientists</em>, the project explores hybrid forms of museum experiences to help museums create personal encounters with cultural heritage - both in physical and digital forms.
          </p>
          <p>
            <a href="#">Learn more</a> about the project, or <a href="#">check out our publications</a>.
          </p>
        </div>
      </div>
      <div class="project-partner-logos">
        <div class="project-partner-logo" style="background-image: url(<?php echo get_stylesheet_directory_uri() ?>/static-html-css/img/project-partner-logos/it-university-of-copenhagen.png)"></div>
        <div class="project-partner-logo" style="background-image: url(<?php echo get_stylesheet_directory_uri() ?>/static-html-css/img/project-partner-logos/university-of-nottingham.png)"></div>
        <div class="project-partner-logo" style="background-image: url(<?php echo get_stylesheet_directory_uri() ?>/static-html-css/img/project-partner-logos/uppsala-universitet.png)"></div>
        <div class="project-partner-logo" style="background-image: url(<?php echo get_stylesheet_directory_uri() ?>/static-html-css/img/project-partner-logos/blast-theory.png)"></div>
        <div class="project-partner-logo" style="background-image: url(<?php echo get_stylesheet_directory_uri() ?>/static-html-css/img/project-partner-logos/nextgame.png)"></div>
        <div class="project-partner-logo" style="background-image: url(<?php echo get_stylesheet_directory_uri() ?>/static-html-css/img/project-partner-logos/europeana.png)"></div>
        <div class="project-partner-logo" style="background-image: url(<?php echo get_stylesheet_directory_uri() ?>/static-html-css/img/project-partner-logos/culture-24.png)"></div>
      </div>
    </section>
<?php endwhile; ?>
<?php get_footer(); ?>
