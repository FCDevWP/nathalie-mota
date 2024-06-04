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
    <header id="header" class="header flexrow">
		<div class="container-header flexrow">
			<a href="<?php echo home_url( '/' ); ?>" aria-label="Page d'accueil de Nathalie Mota">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.png" 
				alt="Logo <?php echo bloginfo('name'); ?>">
			</a>
			<nav id="navigation">
				<?php 
					// Affichage du menu main déclaré dans functions.php
					wp_nav_menu(array('theme_location' => 'main')); 
				?>
				<button id="modal__burger" class="btn-modal" aria-label="Menu pour la version portable">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </button>
				
                <div id="modal__content" class="modal__content">           
					<?php 				
					wp_nav_menu(array('theme_location' => 'main')); 
					?>
                </div>
			</nav>
		</div>
	</header>	