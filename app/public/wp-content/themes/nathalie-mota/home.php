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
            'posts_per_page' => -1,
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $full_image_url = get_the_post_thumbnail_url($post->ID, 'full');
                $categories = get_the_terms($post->ID, 'categorie');
                $category = $categories ? $categories[0]->name : '';
                $reference = get_field('reference'); // Assurez-vous que 'reference' est le nom correct du champ ACF
                ?>
                <div class="photo-item">
                    <a href="<?php echo esc_url($full_image_url); ?>" 
                       class="fancybox" 
                       data-fancybox="gallery" 
                       data-single-url="<?php the_permalink(); ?>"
                       data-title="<?php the_title(); ?>"
                       data-category="<?php echo esc_attr($category); ?>"
                       data-reference="<?php echo esc_attr($reference); ?>">
                        <?php the_post_thumbnail('large', array('class' => 'photo-img')); ?>
                        <div class="photo-overlay">
                            <div class="photo-title"><?php the_title(); ?></div>
                            <div class="photo-eye"><i class="fa-regular fa-eye photo-eye-icon"></i></div>
                            <div class="photo-expand"><i class="fa-solid fa-expand photo-expand-icon"></i></div>
                            <div class="photo-category"><?php echo $category; ?></div>
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
