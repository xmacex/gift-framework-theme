<!doctype html>
<html class="no-js" lang="en">

<head>
  <?php wp_head(); ?>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo get_bloginfo('name'); ?> – <?php echo get_bloginfo('description'); ?></title>
  <meta name="description" content="A framework to support museums develop meaningful and personalised experiences for their visitors.">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="<?php echo get_theme_file_uri('site.webmanifest'); ?>">

  <link rel="shortcut icon" type="image/png" href="<?php echo get_theme_file_uri('favicon.ico'); ?>">
  <link rel="apple-touch-icon" href="<?php echo get_theme_file_uri('icon.png') ; ?>">
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WM6T7TQ');</script>
<!-- End Google Tag Manager -->
</head>
<body <?php body_class(); ?>>
    <!--[if lte IE 9]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WM6T7TQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <header class="menu-container wrap-container<?php echo (has_post_thumbnail() || is_front_page()) ? ' white-on-mobile' : '' ?><?php echo (is_front_page()) ? ' overlaid on-image' : '' ?>">
      <a class="home-link" href="<?php echo get_home_url(); ?>">
        <figure class="gift-logo">
      	</figure>
      </a>
    	<?php wp_nav_menu(array(
    	    'container' => 'nav',
    	    'container_class' => 'navigation menu main-navigation',
    	    'theme_location' => 'primary-menu')); ?>
      <button class="menu-toggler"></button>
    </header>
    <div class="floating menu-container wrap-container" style="display: none">
      <nav class="navigation menu floating-navigation">
        <ul id="menu-floating-menu" class="menu">
          <li clas="menu-item">
            <a href="#">Change: How & Why?</a>
          </li>
          <li clas="menu-item">
            <a href="#">Systems & Content</a>
          </li>
          <li clas="menu-item">
            <a href="#">Culture</a>
          </li>
          <li clas="menu-item">
            <a href="#">People</a>
          </li>
          <li clas="menu-item">
            <a href="#">Understanding</a>
          </li>
        </ul>
      </nav>
    </div>
