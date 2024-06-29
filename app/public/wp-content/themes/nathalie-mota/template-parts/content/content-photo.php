<?php
/**
 * Template part for displaying photo content
 *
 * @package WordPress
 * @subpackage nathaliemota
 * @since nathaliemota 1.0
 */
?>
<pre> 
<?php 
/* récupération taxonomie Catégorie */
    $terms= wp_get_post_terms(get_the_ID(), 'categorie');
    $categorie='';
    foreach ( $terms as $term ) {
        $categorie=$term->name;
    }


/* récupération taxonomie Format */
                
    $terms= wp_get_post_terms(get_the_ID(), 'format');
    $format='';
    foreach ( $terms as $term ) {
        $format=$term->name;
    }
                
?>
</pre>


<div class="photo-content">
    <section class="section-1">
        <div class="left-column">
            <div class="photo-meta column">
                <h1 class="photo-title-new"><?php the_title(); ?></h1>
                <p>Référence :   </p>
                <p>Catégories : <?php echo $categorie; ?></p>
                <p>Format : <?php echo $format; ?></p>
                <p>Type : <?php /* Ajouter ici le code pour afficher le type */ ?></p>
                <p>Année : <?php /* Ajouter ici le code pour afficher l'année */ ?></p>
                <hr />
            </div>
        </div>
        <div class="right-column">
            <?php the_post_thumbnail('full', array('class' => 'photo-img')); ?>
        </div>
    </section>

    <section class="section-2">
        <div class="left-side">
            <p>Cette photo vous intéresse ?</p>
            <a href="#" class="btn-contact">Contact</a>
        </div>
        <div class="right-side">
            <?php

            // Récupérer l'ID de l'image mise en avant
            $featured_image_id = get_post_thumbnail_id(get_the_ID());

            // Récupérer l'URL de l'image mise en avant
            $featured_image_url = wp_get_attachment_image_url($featured_image_id, 'full');

            // Récupérer le nom de fichier de l'image mise en avant
            $featured_image_file = basename($featured_image_url);

            // Récupérer le répertoire des images
            $image_dir = get_template_directory_uri() . '/assets/images/';

            // Récupérer les fichiers dans le répertoire
            $images = array_diff(scandir(get_template_directory() . '/assets/images/'), array('.', '..'));

            // Vérifier si le tableau $images n'est pas vide et que l'image mise en avant existe
            if (!empty($images) && in_array($featured_image_file, $images)) {
                // Trouver l'index de l'image courante
                $current_index = array_search($featured_image_file, $images);

                // Afficher l'image courante
                echo '<img src="' . $featured_image_url . '" alt="' . get_the_title() . '" class="small-photo">';

                // Afficher les flèches de navigation
                if ($current_index > 0) {
                    echo '<a href="#" class="prev-arrow"><i class="fas fa-arrow-left"></i></a>';
                }
                if ($current_index < count($images) - 1) {
                    echo '<a href="#" class="next-arrow"><i class="fas fa-arrow-right"></i></a>';
                }
            } else {
                // Si le tableau $images est vide ou que l'image mise en avant n'existe pas, affichez un message d'erreur ou une image par défaut
                echo '<p>Aucune image trouvée dans le répertoire /assets/images/</p>';
            }
            ?>
        </div>
        
    
    </section>
    <hr id="line" / >
    <section class="section-3">
        <p>Vous aimerez aussi</p>
        <div class="related-photos">
            <?php
            // Récupérer les photos liées (même catégorie par exemple)
            $related_args = array(
                'post_type' => 'photographies',
                'posts_per_page' => 2,
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categories',
                        'field' => 'slug',
                        'terms' => wp_get_post_terms(get_the_ID(), 'categories', array('fields' => 'slugs')),
                    ),
                ),
            );
            $related_query = new WP_Query($related_args);

            if ($related_query->have_posts()) {
                while ($related_query->have_posts()) {
                    $related_query->the_post();
                    ?>
                    <div class="related-photo">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('thumbnail'); ?>
                            <h3><?php the_title(); ?></h3>
                        </a>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </section>
