<footer class="wrap-container">
    <div class="footer-container">
      <div class="footer-container-inner">
        <?php if (metadata_exists('post', get_the_ID(), 'credits')) : ?>
          <div class="credits">
            <?php
              $credits_meta = get_post_meta(get_the_ID(), 'credits');
              echo $credits_meta[0];
            ?>
          </div>
        <?php endif; ?>
        <p class="footer-header"><?php echo get_option('footer_header'); ?></p>
        <div class="eu-flag-and-footer-header">
          <img class="eu-flag-footer" src="<?php echo get_stylesheet_directory_uri(); ?>/img/eu-flag-footer.png" alt="European Union Flag" />
          <p class="footer-body"><?php echo get_option('footer_text'); ?></p>
        </div>
    	</div>
    </div>
    <div class="column-container">
      <div class="footer-project-partner-logos">
        <figure class="footer-project-partner-logo">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/project-partners/it-university-of-copenhagen.jpg" alt="IT University of Copenhagen" />
        </figure>
        <figure class="footer-project-partner-logo">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/project-partners/the-university-of-nottingham.png" alt="The University of Nottingham" />
        </figure>
        <figure class="footer-project-partner-logo">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/project-partners/uppsala-universitet.png" alt="Uppsala Universitet" />
        </figure>
        <figure class="footer-project-partner-logo">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/project-partners/blast-theory.png" alt="Blast Theory" />
        </figure>
        <figure class="footer-project-partner-logo">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/project-partners/nextgame.png" alt="NextGame" />
        </figure>
        <figure class="footer-project-partner-logo">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/project-partners/europeana.png" alt="Europeana Foundation" />
        </figure>
        <figure class="footer-project-partner-logo">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/project-partners/culture-24.png" alt="Culture 24" />
        </figure>
      </div>
    </div>
</footer>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-141747450-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-141747450-1', {
    'custom_map': {'dimension1': 'wp_admin_logged_in'}
  });
  <?php
    if (current_user_can('editor') || current_user_can('administrator')) {
      echo "gtag('event', 'wp_admin_logged_in_dimension', {'wp_admin_logged_in': 'true'});";
    }
  ?>
</script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/vendor/smooth-scroll.polyfills.js"></script>

<?php wp_footer(); ?>
</body>
</html>
