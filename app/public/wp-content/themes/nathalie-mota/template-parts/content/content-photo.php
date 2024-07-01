<?php
/**
 * Template part for displaying photo content
 *
 * @package WordPress
 * @subpackage nathaliemota
 * @since nathaliemota 1.0
 */
?>

<div class="photo-content">
    <section class="section-1">
        <div class="left-column">
            <div class="photo-meta column">
                <h1 class="photo-title-new"><?php the_title(); ?></h1>
                <?php 
                /* récupération taxonomie Catégorie */
                $terms = wp_get_post_terms(get_the_ID(), 'categorie');
                $categorie = '';
                foreach ($terms as $term) {
                    $categorie = $term->name;
                }

                /* récupération taxonomie Format */
                $terms = wp_get_post_terms(get_the_ID(), 'format');
                $format = '';
                foreach ($terms as $term) {
                    $format = $term->name;
                }
                ?>
                <p>Référence : <?php echo get_field('reference'); ?></p>
                <p>Catégories : <?php echo $categorie; ?></p>
                <p>Format : <?php echo $format; ?></p>
                <p>Type : <?php echo get_field('type'); ?></p>
                <p>Année : <?php echo get_field('annee'); ?></p>
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
        <a href="#" class="btn-contact" data-bs-toggle="modal" data-bs-target="#contact-modal">Contact</a>
    </div>
    <div class="right-side">
        <?php
        // Récupérer l'ID de l'image mise en avant
        $featured_image_id = get_post_thumbnail_id(get_the_ID());
        
        // Vérifier si une image mise en avant existe
        if (!$featured_image_id) {
            echo '<p>Pas d\'image mise en avant pour cet article.</p>';
            return;
        }

        // Récupérer l'URL de l'image mise en avant
        $featured_image_url = wp_get_attachment_image_url($featured_image_id, 'full');

        // Récupérer le nom de fichier de l'image mise en avant
        $featured_image_file = basename($featured_image_url);

        // Récupérer le répertoire des images
        $image_dir = get_template_directory() . '/assets/images/';

        if (!is_dir($image_dir)) {
            echo '<p>Le répertoire des images n\'existe pas.</p>';
            return;
        }

        // Récupérer les fichiers d'image dans le répertoire
        $images = preg_grep('~\.(jpeg|jpg|png|gif|webp)$~', scandir($image_dir));

        // Fonction pour comparer les noms de fichiers en ignorant "-scaled"
        function compare_filenames($filename1, $filename2) {
            $filename1 = preg_replace('/-scaled|-\d+x\d+/', '', pathinfo($filename1, PATHINFO_FILENAME));
            $filename2 = preg_replace('/-scaled|-\d+x\d+/', '', pathinfo($filename2, PATHINFO_FILENAME));
            return strcasecmp($filename1, $filename2) === 0;
        }

    // Vérifier si le tableau $images n'est pas vide et que l'image mise en avant existe
    if (!empty($images)) {
        $current_index = -1;
        foreach ($images as $index => $image) {
            if (compare_filenames($featured_image_file, $image)) {
                $current_index = $index;
                break;
            }
        }

        if ($current_index !== -1) {
            // Assurer que l'index est dans les limites valides
            $current_index = array_search($images[$current_index], array_values($images));

            // Déterminer l'index de la miniature à afficher (précédente ou suivante)
            $thumbnail_index = ($current_index > 0) ? $current_index - 1 : $current_index + 1;
            $thumbnail_index = max(0, min($thumbnail_index, count($images) - 1));

            // Obtenir le nom de fichier de la miniature
            $thumbnail_file = $images[$thumbnail_index];

            // Construire l'URL de la miniature
            $thumbnail_url = get_template_directory_uri() . '/assets/images/' . $thumbnail_file;

            // Afficher la miniature et les flèches dans la nouvelle structure
            echo '<div class="image-container">';
            echo '<img src="' . esc_url($thumbnail_url) . '" alt="Miniature" class="small-photo">';
            echo '<div class="navigation-arrows">';
            if ($current_index > 0) {
                $prev_image = array_values($images)[$current_index - 1];
                echo '<a href="#" class="prev-arrow" data-image="' . esc_attr($prev_image) . '"><i class="fa-solid fa-arrow-left-long"></i></a>';
            }
            if ($current_index < count($images) - 1) {
                $next_image = array_values($images)[$current_index + 1];
                echo '<a href="#" class="next-arrow" data-image="' . esc_attr($next_image) . '"><i class="fa-solid fa-arrow-right-long"></i></a>';
            }
            echo '</div>'; // Fermeture de navigation-arrows
            echo '</div>'; // Fermeture de image-container
        } else {
            echo '<p>Image mise en avant non trouvée dans le répertoire.</p>';
        }
    } else {
        echo '<p>Aucune image trouvée dans le répertoire.</p>';
    }
    ?>

        <script>
        var photoImages = <?php echo json_encode(array_values($images)); ?>;
        </script>
    </div>
    </section>


    <hr id="line" />
    <section class="section-3">
        <p>Vous aimerez aussi</p>
        <?php
        // Récupérer les photos liées (même catégorie par exemple)
        $related_args = array(
            'post_type' => 'photographies',
            'posts_per_page' => 2,
            'post__not_in' => array(get_the_ID()),
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'slugs')),
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
        } else {
            echo '<p>Il n\'y a aucune photo supplémentaire de cette catégorie</p>';
        }
        ?>
    </section>

</div>
