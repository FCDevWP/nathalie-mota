<?php get_header(); ?>
   
<!-- Hero header avec une image et un texte en surimpression -->
<div class="hero-header">
  <img src="<?php echo get_template_directory_uri() ?>/assets/images/nathalie-9.webp" alt="Image héroïque" class="hero-image">
  <div class="hero-overlay">
    <img src="<?php echo get_template_directory_uri() ?>/assets/images/Titre-header.png" alt="Titre en-tête" class="hero-text">
  </div>
</div>

<!-- Menus déroulants -->
<div class="menu-container">
  <div class="left-side">
    <section class="category-general">
      <select name="category" id="category" class="category">
        <option value="" disabled selected>CATÉGORIES</option>
        <option value="reception" class="reception">Réception</option>
        <option value="concert" class="concert">Concert</option>
        <option value="mariage" class="mariage">Mariage</option>
        <option value="television" class="television">Télévision</option>
      </select>
    </section>
    <section class="format-general">
      <select name="format" id="format" class="format">
        <option value="" disabled selected>FORMAT</option>
        <option value="paysage" class="paysage">Paysage</option>
        <option value="portrait" class="portrait">Portrait</option>
      </select>
    </section>
  </div>
  <div class="right-side">
    <section class="tri-general">
      <select name="tri" id="tri" class="tri">
        <option value="" disabled selected>TRIER PAR</option>
        <option value="new" class="new">Nouveautés</option>
        <option value="old" class="old">Oeuvres anciennes</option>
      </select>
    </section>
  </div>
</div>


<br>


<button class="open-contact-modal">Ouvrir la modale</button>

<!-- Galerie de photos -->
<div id="photo-gallery" class="photo-gallery">
    <?php
    // Query to get the 16 latest photos
    $query = new WP_Query(array(
        'post_type' => 'mes_photographies',
        'posts_per_page' => 16
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="photo-item">
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
                    <h2><?php the_title(); ?></h2>
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

<?php get_footer(); ?>
