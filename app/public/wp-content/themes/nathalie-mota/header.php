<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="keywords" content="nathalie mota, photographe professionnelle, événementiel, réception, concert, mariage, télévision, photo argentique, photo numérique"/>
    <meta name="description" content="Nathalie Mota – photographe professionnelle pour vos événements, réception, concert, mariage, télévision, photo argentique, photo numérique."/>

    <title>Nathalie Mota - Photographe</title>
    <?php wp_head(); ?>
</head>
<body>
	<header>
	  <nav>
	    <div class="logo">
	      <a href="<?php echo home_url(); ?>">
	        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.png" alt="Logo Nathalie Mota">
	      </a>
	    </div>
	    <?php 
	      wp_nav_menu(array(
	        'theme_location' => 'main-menu',
	        'container' => false,
	        'menu_class' => 'main-menu',
	      )); 
	    ?>
	  </nav>
	</header>
