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
</head>
<body>
    <!--[if lte IE 9]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
    <header class="menu-container wrap-container <?php echo has_post_thumbnail() && is_singular() ? 'white' : '' ?>">
      <a class="home-link" href="<?php echo get_home_url(); ?>">
        <figure class="gift-logo">
      	</figure>
      </a>
    	<?php wp_nav_menu(array(
    	    'container' => 'nav',
    	    'container_class' => 'navigation menu main-navigation',
    	    'theme_location' => 'primary-menu')); ?>
    </header>
