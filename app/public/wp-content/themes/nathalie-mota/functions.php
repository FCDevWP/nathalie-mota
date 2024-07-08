<?php 

// Ajouter la prise en charge des images mises en avant
add_theme_support('post-thumbnails');

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support('title-tag');

// Ajout de Select2
function enqueue_select2_scripts() {
    wp_enqueue_style('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
    wp_enqueue_script('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_select2_scripts');

// Ajout style (modifié pour charger après Select2)
function nathalie_mota_enqueue_styles() {
    wp_enqueue_style('nathalie-mota-style', get_stylesheet_uri(), array('select2'));
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_styles');

/* Ajout typographie Space Mono et poppins */
function nathaliemota_custom_fonts() {
    wp_enqueue_style('nathaliemota-space-mono', get_template_directory_uri() . '/fonts/Space_Mono/space-mono.css', array(), '1.0.0');
    wp_enqueue_style('nathaliemota-poppins', get_template_directory_uri() . '/fonts/Poppins/poppins.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'nathaliemota_custom_fonts');

/* JQuery et JQuery UI dans JS Inclusion de scripts et styles */
function nathalie_mota_enqueue_scripts() {
    wp_enqueue_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'));
    wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_script('nathalie-mota-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery', 'fancybox', 'select2'), null, true);
    
    wp_localize_script('nathalie-mota-scripts', 'nathaliemotaAjax', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]);
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_scripts');

/**
 * Displays the post thumbnail.
 */
function nathaliemota_post_thumbnail() {
    if (post_password_required() || is_attachment() || ! has_post_thumbnail()) {
        return;
    }
 
    if (is_singular()) :
        ?>
        <figure class="post-thumbnail">
            <?php the_post_thumbnail(); ?>
        </figure><!-- .post-thumbnail -->
    <?php else : ?>
        <figure class="post-thumbnail">
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
        </figure><!-- .post-thumbnail -->
    <?php
    endif;
}
 
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function nathaliemota_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
 
    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date())
    );
 
    echo '<span class="posted-on">' . $time_string . '</span>';
}
 
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function nathaliemota_entry_footer() {
    // Hide category and tag text for pages.
    if ('post' === get_post_type()) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list(esc_html__(', ', 'nathaliemota'));
        if ($categories_list) {
            /* translators: %s: category list. */
            printf('<span class="cat-links">' . esc_html__('Posted in %s', 'nathaliemota') . '</span>', $categories_list);
        }
 
        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'nathaliemota'));
        if ($tags_list) {
            /* translators: %s: tag list. */
            printf('<span class="tags-links">' . esc_html__('Tagged %s', 'nathaliemota') . '</span>', $tags_list);
        }
    }
 
    if (!is_single() && ! post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    /* translators: %s: post title */
                    __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'nathaliemota'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            )
        );
        echo '</span>';
    }
 
    edit_post_link(
        sprintf(
            wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                __('Edit <span class="screen-reader-text">%s</span>', 'nathaliemota'),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            wp_kses_post(get_the_title())
        ),
        '<span class="edit-link">',
        '</span>'
    );
}


// Fonction pour choix aléatoire des photos hero header
function get_images_from_directory($directory) {
    $images = glob($directory . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    return $images;
}

// Ajout fonction AJAX pour photos
function nathaliemota_request_photos() {
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $tri = isset($_POST['tri']) ? sanitize_text_field($_POST['tri']) : '';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $args = [
        'post_type' => 'photographies',
        'posts_per_page' => 8,
        'paged' => $paged,
        'tax_query' => [],
    ];

    if (!empty($category)) {
        $args['tax_query'][] = [
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
        ];
    }

    if (!empty($format)) {
        $args['tax_query'][] = [
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        ];
    }

    if ($tri === 'new') {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    } elseif ($tri === 'old') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $photos = [];
        while ($query->have_posts()) {
            $query->the_post();
            $categories = get_the_terms(get_the_ID(), 'categorie');
            $category = $categories ? $categories[0]->name : '';
            $reference = get_field('reference');
            $photos[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'link' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                'category' => $category,
                'reference' => $reference,
            ];
        }
        wp_send_json_success([
            'photos' => $photos,
            'max_pages' => $query->max_num_pages,
        ]);
    } else {
        wp_send_json_error('No photos found');
    }

    wp_die();
}

add_action('wp_ajax_request_photos', 'nathaliemota_request_photos');
add_action('wp_ajax_nopriv_request_photos', 'nathaliemota_request_photos');

// Inclure le fichier CSS pour la page de détail des photographies
function nathaliemota_enqueue_single_photo_styles() {
    if ( is_singular( 'photographies' ) ) {
        wp_enqueue_style( 'nathaliemota-single-photo', get_template_directory_uri() . '/css/single-photo.css', array(), filemtime( get_template_directory() . '/css/single-photo.css' ) );
    }
}
add_action( 'wp_enqueue_scripts', 'nathaliemota_enqueue_single_photo_styles' );

// Ajout FancyBox pour lightbox & Fancybox CSS
function nathaliemota_enqueue_fancybox_scripts() {
    wp_enqueue_style('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css', array(), '3.5.7');
    wp_enqueue_script('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js', array('jquery'), '3.5.7', true);
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_fancybox_scripts');

function nathaliemota_enqueue_fancybox_custom_styles() {
    wp_enqueue_style('fancybox-custom', get_template_directory_uri() . '/css/fancybox-custom.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_fancybox_custom_styles');

// Ajout Fontawesome
function nathaliemota_enqueue_fontawesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_fontawesome');

// Ajout nouveaux fichiers lightbox
function nathaliemota_enqueue_lightbox_scripts() {
    wp_enqueue_script('nathaliemota-lightbox', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), '1.0', true);
    wp_enqueue_style('nathaliemota-lightbox', get_template_directory_uri() . '/css/lightbox.css');
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_lightbox_scripts');

function load_more_photos() {
    $paged = $_POST['paged'];
    $args = array(
        'post_type' => 'photographies',
        'posts_per_page' => 8,
        'paged' => $paged
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            $full_image_url = get_the_post_thumbnail_url($post->ID, 'full');
            $categories = get_the_terms($post->ID, 'categorie');
            $category = $categories ? $categories[0]->name : '';
            $reference = get_field('reference');
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
        $output = ob_get_clean();
        wp_reset_postdata();
        wp_send_json_success($output);
    } else {
        wp_send_json_error('No more photos');
    }
    
    wp_die();
}

add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


