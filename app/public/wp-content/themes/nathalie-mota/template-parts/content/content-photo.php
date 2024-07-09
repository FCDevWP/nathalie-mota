
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
                <p>Année : <?php echo get_the_date('Y'); ?></p>
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
        <div class="navigation-container">
            <?php
            $prev_post = get_previous_post(false);
            $next_post = get_next_post(false);
        
            if (!empty($prev_post)) {
                $prev_thumbnail = get_the_post_thumbnail_url($prev_post->ID, 'thumbnail');
                echo '<a href="' . get_permalink($prev_post->ID) . '" class="nav-link prev-link">';
                echo '<i class="fa-solid fa-arrow-left-long"></i>';
                echo '<img src="' . esc_url($prev_thumbnail) . '" alt="Photo précédente" class="nav-thumbnail prev-thumbnail">';
                echo '</a>';
            }
        
            if (!empty($next_post)) {
                $next_thumbnail = get_the_post_thumbnail_url($next_post->ID, 'thumbnail');
                echo '<a href="' . get_permalink($next_post->ID) . '" class="nav-link next-link">';
                echo '<i class="fa-solid fa-arrow-right-long"></i>';
                echo '<img src="' . esc_url($next_thumbnail) . '" alt="Photo suivante" class="nav-thumbnail next-thumbnail">';
                echo '</a>';
            }
            ?>
        </div>
    </div>

    </section>


    <hr id="line" />
    <section class="section-3">
    <div class="section-3-container">
        <p style="text-align: justify;">Vous aimerez aussi</p>
        <?php
        $related_args = array(
            'post_type' => 'photographies',
            'posts_per_page' => 2,
            'post__not_in' => array(get_the_ID()),
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'term_id',
                    'terms' => wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'ids')),
                ),
            ),
        );
        $related_query = new WP_Query($related_args);
        // var_dump($related_query);
        ?>
        <div class="photo-grid <?php echo ($related_query->post_count == 1) ? 'single-photo' : ''; ?>">
            <?php
            if ($related_query->have_posts()) :
                global $post;
                while ($related_query->have_posts()) : $related_query->the_post();
                    $full_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $categories = get_the_terms(get_the_ID(), 'categorie');
                    $category = $categories ? $categories[0]->name : '';
                    ?>
                    <div class="photo-item <?php echo ($related_query->post_count == 1) ? 'single-photo-item' : ''; ?>" style="margin-bottom: 20px;">
                        <a href="<?php echo esc_url($full_image_url); ?>"
                           class="custom-lightbox"
                           data-fancybox="gallery"
                           data-single-url="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('large', array('class' => 'photo-img')); ?>
                            <div class="photo-overlay">
                                <div class="photo-title"><?php the_title(); ?></div>
                                <div class="photo-eye"><i class="fa-regular fa-eye photo-eye-icon"></i></div>
                                <div class="photo-expand"><i class="fa-solid fa-expand photo-expand-icon"></i></div>
                                <div class="photo-category"><?php echo esc_html($category); ?></div>
                            </div>
                        </a>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>Il n\'y a aucune photo supplémentaire dans cette catégorie</p>';
            endif;
            ?>
        </div>
    </div>
</section>



</div>