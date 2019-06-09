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
        <p class="footer-header">Learn more about <a href="<?php echo get_permalink(357); ?>">The GIFT Project</a>.</p>
        <img class="eu-flag-footer" src="<?php echo get_stylesheet_directory_uri(); ?>/img/eu-flag-footer.png" alt="European Union Flag" />
        <p>
		      This project has received funding from the European Union’s Horizon 2020 research and innovation programme under grant agreement No 727040.
        </p>
    	</div>
    </div>
</footer>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-141747450-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-141747450-1');
</script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/vendor/smooth-scroll.polyfills.js"></script>

<?php wp_footer(); ?>
</body>
</html>
