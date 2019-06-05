<footer class="wrap-container">
    <div class="footer-container">
      <div class="footer-container-inner">
        <p class="footer-header">Learn more about <a href="<?php echo get_permalink(357); ?>">The GIFT Project</a>.</p>
        <img class="eu-flag-footer" src="<?php echo get_stylesheet_directory_uri(); ?>/img/eu-flag-footer.png" alt="European Union Flag" />
        <p>
		      This project has received funding from the European Union’s Horizon 2020 research and innovation programme under grant agreement No 727040.
        </p>
    	</div>
    </div>
</footer>

<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
 window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
 ga('create', 'UA-XXXXX-Y', 'auto'); ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/vendor/smooth-scroll.polyfills.js"></script>

<?php wp_footer(); ?>
</body>
</html>
