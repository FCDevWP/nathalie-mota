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
        <a href="#" class="btn-contact" data-bs-toggle="modal" data-bs-target="#contact-modal" data-reference="<?php echo get_field('reference'); ?>">Contact</a>
    </div>
    <div class="right-side">
    <?php
    // Vérifier si une image en vedette est définie pour le message en cours
    if (has_post_thumbnail()) {
        // Récupérer l'ID de l'image mise en avant
        $featured_image_id = get_post_thumbnail_id(get_the_ID());

        // Vérifier si une image mise en avant existe
        if (!$featured_image_id) {
            echo '<p>Pas d&#039;image mise en avant pour cet article.</p>';
            return;
        }

        // Récupérer l'URL de l'image mise en avant
        $featured_image_url = wp_get_attachment_image_url($featured_image_id, 'full');

        // Récupérer le nom de fichier de l'image mise en avant
        $featured_image_file = basename($featured_image_url);

        // Récupérer le répertoire des images
        $image_dir = get_template_directory() . '/assets/images/';

        if (!is_dir($image_dir)) {
            echo '<p>Le répertoire des images n&#039;existe pas.</p>';
            return;
        }

        // Récupérer les fichiers d'image dans le répertoire
        $images = preg_grep('~\.(jpeg|jpg|png|gif|webp)$~', scandir($image_dir));

        // Réindexer le tableau $images
        $images = array_values($images);

        // Fonction pour comparer les noms de fichiers en ignorant "-scaled"
        function compare_filenames($filename1, $filename2) {
            $filename1_base = pathinfo($filename1, PATHINFO_FILENAME);
            $filename2_base = pathinfo($filename2, PATHINFO_FILENAME);

            // Ignorer "-scaled" dans les noms de fichiers
            $filename1_base = str_replace('-scaled', '', $filename1_base);
            $filename2_base = str_replace('-scaled', '', $filename2_base);

            return $filename1_base === $filename2_base;
        }

        $current_index = -1;
        $thumbnail_index = -1;
        foreach ($images as $index => $image) {
            if (compare_filenames($featured_image_file, $image)) {
                $current_index = $index;
                break;
            }
        }

        if ($current_index != -1) {
            $thumbnail_index = ($current_index + 1) % count($images);
            $thumbnail_file = $images[$thumbnail_index];
            $thumbnail_url = get_template_directory_uri() . '/assets/images/' . $thumbnail_file;

            $prev_index = ($current_index - 1 + count($images)) % count($images);
            $next_index = ($current_index + 1) % count($images);

            echo '<div class="image-container">';
            echo '<img src="' . esc_url($thumbnail_url) . '" alt="Miniature" class="small-photo">';

            echo '<div class="arrow-container">';
            if ($prev_index != $current_index) {
                $prev_image = $images[$prev_index];
                echo '<a href="#" class="prev-arrow" data-image="' . esc_attr($prev_image) . '"><i class="fa-solid fa-arrow-left-long"></i></a>';
            }
            if ($next_index != $current_index) {
                $next_image = $images[$next_index];
                echo '<a href="#" class="next-arrow" data-image="' . esc_attr($next_image) . '"><i class="fa-solid fa-arrow-right-long"></i></a>';
            }
            echo '</div>'; // Fermeture de arrow-container

            echo '</div>'; // Fermeture de image-container
        } else {
            echo '<p>Aucune miniature disponible. Current index: ' . $current_index . ', Thumbnail index: ' . $thumbnail_index . '</p>';
        }
    } else {
        echo '<p>Aucune image en vedette n&#039;est définie pour ce message.</p>';
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
