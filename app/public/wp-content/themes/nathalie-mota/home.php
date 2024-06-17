<?php get_header(); ?>


<?php
$images = get_images_from_directory(get_template_directory() . '/assets/images');
$random_image = $images[array_rand($images)];
$random_image_url = get_template_directory_uri() . '/assets/images/' . basename($random_image);
?>





<div class="container">
    <!-- Hero header avec une image et un texte en surimpression -->

    <!-- Hero header avec une image aléatoire et un texte en surimpression -->
    <div class="hero-header" style="background-image: url('<?php echo $random_image_url; ?>');">
        <div class="hero-overlay">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/images/Titre-header.png" alt="Titre en-tête" class="hero-text">
        </div>
    </div>

    <!-- Menus déroulants -->
    <div class="menu-container">
        <div class="left-side">
            <section class="category-general">
                <select name="category" id="category" class="category">
                    <option value="" disabled selected>CATÉGORIES</option>
                    <option value="reception" class="reception custom-option">Réception</option>
                    <option value="concert" class="concert custom-option">Concert</option>
                    <option value="mariage" class="mariage custom-option">Mariage</option>
                    <option value="television" class="television custom-option">Télévision</option>
                </select>
            </section>
            <section class="format-general">
                <select name="format" id="format" class="format">
                    <option value="" disabled selected>FORMAT</option>
                    <option value="paysage" class="paysage custom-option">Paysage</option>
                    <option value="portrait" class="portrait custom-option">Portrait</option>
                </select>
            </section>
        </div>
        <div class="right-side">
            <section class="tri-general">
                <select name="tri" id="tri" class="tri">
                    <option value="" disabled selected>TRIER PAR</option>
                    <option value="new" class="new custom-option">Nouveautés</option>
                    <option value="old" class="old custom-option">Oeuvres anciennes</option>
                </select>
            </section>
        </div>
    </div>    
    <!-- Galerie de photos -->
    <div class="photo-gallery">
        <?php
            $args = array(
              'post_type' => 'photographies',
              'posts_per_page' => -1, // display all photos
            );
            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    ?>
                    <div class="photo-item">
                        <a href="<?php the_permalink(); ?>" class="photo-link-eye">
                            <?php echo wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), 'full', false, array( 'class' => 'photo-img' ) ); ?>
                            <div class="photo-overlay">
                                <div class="photo-title"><?php the_title(); ?></div>
                                <div class="photo-eye"><i class="fa-regular fa-eye photo-eye-icon"></i></div>
                                <a href="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0]; ?>" class="fancybox photo-link-expand">
                                    <div class="photo-expand"><i class="fa-solid fa-expand photo-expand-icon"></i></div>
                                </a>
                                <div class="photo-category"><?php echo get_the_term_list( $post->ID, 'categorie', '', ', ', '' ); ?></div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                    wp_reset_postdata();
            } else {
                echo '<p>No photos found</p>';
            }
        ?>
    </div>
</div>  


<?php get_footer(); ?>
