<!doctype html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo get_bloginfo('name'); ?> – <?php echo get_bloginfo('description'); ?></title>
  <meta name="description" content="A framework to support museums develop meaningful and personalised experiences for their visitors.">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/icon.png">
  <!-- Place favicon.ico in the root directory -->

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/normalize.css">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.css">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/style.css">
</head>
<body>
    <!--[if lte IE 9]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
    <header class="menu-container wrap-container">
	<figure class="gift-logo">
	</figure>
	<?php wp_nav_menu(array(
	    'container' => 'nav',
	    'container_class' => 'navigation menu main-navigation',
	    'theme_location' => 'primary-menu')); ?>
    </header>
