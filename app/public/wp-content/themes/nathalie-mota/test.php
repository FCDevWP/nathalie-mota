
<!-- Ancien code content-photo.php -->

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
        $current_index = -1;
        $images = preg_grep('~\.(jpeg|jpg|png|gif|webp)$~', scandir($image_dir));
        // var_dump($images); 
        // echo "Featured image file: " . $featured_image_file . "<br>";
        // echo "Current index: " . $current_index . "<br>";


        // Fonction pour comparer les noms de fichiers en ignorant "-scaled"
        function compare_filenames($filename1, $filename2) {
            $filename1 = preg_replace('/\.[^.]+$/', '', $filename1);
            $filename2 = preg_replace('/\.[^.]+$/', '', $filename2);
            $filename1 = preg_replace('/-scaled|-\d+x\d+/', '', $filename1);
            $filename2 = preg_replace('/-scaled|-\d+x\d+/', '', $filename2);
            return stripos($filename1, $filename2) !== false || stripos($filename2, $filename1) !== false;
        }
        


    // Vérifier si le tableau $images n'est pas vide et que l'image mise en avant existe
    if (!empty($images)) {
        $current_index = -1;
        foreach ($images as $index => $image) {
            // echo "Comparing: " . $featured_image_file . " with " . $image . "<br>";
            if (compare_filenames($featured_image_file, $image)) {
                $current_index = $index;
                // echo "Match found at index: " . $current_index . "<br>";
                break;
            }
        }
        
        // Pas besoin de rechercher à nouveau l'index
        $thumbnail_index = ($current_index > 0) ? $current_index - 1 : $current_index + 1;
        $thumbnail_index = max(0, min($thumbnail_index, count($images) - 1));
    
        
        // echo "Thumbnail index: " . $thumbnail_index . "<br>";
        // echo "Images count: " . count($images) . "<br>";
        
        if ($current_index !== -1 && isset($images[$thumbnail_index])) {
            $thumbnail_file = $images[$thumbnail_index];
            $thumbnail_url = get_template_directory_uri() . '/assets/images/' . $thumbnail_file;
        
            echo '<div class="image-container">';
            echo '<img src="' . esc_url($thumbnail_url) . '" alt="Miniature" class="small-photo">';
            // echo "Chemin de l'image : " . $thumbnail_url . "<br>";
            
            // Affichage des flèches
            if ($current_index > 0) {
                $prev_image = array_values($images)[$current_index - 1];
                echo '<a href="#" class="prev-arrow" data-image="' . esc_attr($prev_image) . '"><i class="fa-solid fa-arrow-left-long"></i></a>';
            }
            if ($current_index < count($images) - 1) {
                $next_image = array_values($images)[$current_index + 1];
                echo '<a href="#" class="next-arrow" data-image="' . esc_attr($next_image) . '"><i class="fa-solid fa-arrow-right-long"></i></a>';
            }
            echo '</div>';
        } else {
            echo '<p>Aucune miniature disponible. Current index: ' . $current_index . ', Thumbnail index: ' . $thumbnail_index . '</p>';
        }
        
        
    }            
    ?>

        <script>
        var photoImages = <?php echo json_encode(array_values($images)); ?>;
        </script>
    </div>
    </section>


    <hr id="line" />
    <section class="section-3">
    <div class="section-3-container">
        <p style="text-align: justify;">Vous aimerez aussi</p>
        <div class="photo-grid">
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
                    <div class="photo-item" style="width: 50%; margin-bottom: 20px;">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('large'); ?>
                        </a>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            } else {
                echo '<p>Il n\'y a aucune photo supplémentaire dans cette catégorie</p>';
            }
            ?>
        </div>
    </div>
    </section>

</div>

