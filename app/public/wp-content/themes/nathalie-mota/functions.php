<?php 

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );


// Ajout style
function nathalie_mota_enqueue_styles() {
    wp_enqueue_style('nathalie-mota-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_styles');

/* ajout typographie Space Mono et poppins */

function nathaliemota_custom_fonts() {
    wp_enqueue_style( 'nathaliemota-space-mono', get_template_directory_uri() . '/fonts/Space_Mono/space-mono.css', array(), '1.0.0' );
    wp_enqueue_style( 'nathaliemota-poppins', get_template_directory_uri() . '/fonts/Poppins/poppins.css', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'nathaliemota_custom_fonts' );


/* JQuery et JQuery UI dans JS */
function nathalie_mota_enqueue_scripts() {
    wp_enqueue_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'));
    wp_enqueue_script('nathalie-mota-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery', 'jquery-ui'));
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_scripts');

// Enregistrer les menus de navigation
function register_my_menus() {
    register_nav_menus(
      array(
        'main-menu' => __( 'Menu Principal' ),
      )
    );
  }
  add_action( 'init', 'register_my_menus' );

// Ajout page administration thème
function nathaliemota_add_admin_pages() {
    add_menu_page ('Paramètres du thème Nathalie Mota', 'Nathalie-Mota', 'manage_options', 'nathaliemota-settings', 'nathaliemota_theme_settings', 'dashicons-admin-settings', 60 );
}

function nathaliemota_theme_settings() {
    ?>
    <div class="wrap">
        <h1><?php echo get_admin_page_title(); ?></h1>
        <form action="options.php" method="post">
            <?php settings_fields('nathaliemota_settings_fields'); ?>
            <?php do_settings_sections('nathaliemota_settings_section'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Enregistrement des champs et des sections
function nathaliemota_settings_register() {
    register_setting('nathaliemota_settings_fields', 'nathaliemota_settings_fields', 'nathaliemota_settings_fields_validate');
    add_settings_section('nathaliemota_settings_section', __('Section 1', 'nathaliemota'), 'nathaliemota_settings_section_introduction', 'nathaliemota_settings_section');
    add_settings_field('nathaliemota_settings_field_title', 'Titre du site', 'nathaliemota_settings_field_title_output', 'nathaliemota_settings_section', 'nathaliemota_settings_section');
    add_settings_field('nathaliemota_settings_field_slogan', 'Slogan du site', 'nathaliemota_settings_field_slogan_output', 'nathaliemota_settings_section', 'nathaliemota_settings_section');
    add_settings_field('nathaliemota_settings_field_phone_number', 'Numéro de téléphone', 'nathaliemota_settings_field_phone_number_output', 'nathaliemota_settings_section', 'nathaliemota_settings_section');
    add_settings_field('nathaliemota_settings_field_email', 'Courriel', 'nathaliemota_settings_field_email_output', 'nathaliemota_settings_section', 'nathaliemota_settings_section');
}

function nathaliemota_settings_section_introduction() {
    echo __('Paramétrez les différentes options du thème Nathalie Mota.', 'nathaliemota');
}

function nathaliemota_settings_field_title_output() {
    $value = get_option('nathaliemota_settings_field_title');

    echo '<input type="text" name="nathaliemota_settings_field_title" value="'. $value .'" />';
}

function nathaliemota_settings_field_slogan_output() {
    $value = get_option('nathaliemota_settings_field_slogan');

    echo '<input type="text" name="nathaliemota_settings_field_slogan" value="'. $value .'" />';
}

function nathaliemota_settings_field_phone_number_output() {
    $value = get_option('nathaliemota_settings_field_phone_number');

    echo '<input type="text" name="nathaliemota_settings_field_phone_number" value="'. $value .'" />';
}

function nathaliemota_settings_field_email_output() {
    $value = get_option('nathaliemota_settings_field_email');

    echo '<input type="text" name="nathaliemota_settings_field_email" value="'. $value .'" />';
}

function nathaliemota_settings_fields_validate($inputs) {
    if (!empty($_POST)) {
        if(!empty($_POST['nathaliemota_settings_field_title'])) {
            update_option('nathaliemota_settings_field_title', $_POST['nathaliemota_settings_field_title']);
        }
        if(!empty($_POST['nathaliemota_settings_field_slogan'])) {
            update_option('nathaliemota_settings_field_slogan', $_POST['nathaliemota_settings_field_slogan']);
        }
        if(!empty($_POST['nathaliemota_settings_field_phone_number'])) {
            update_option('nathaliemota_settings_field_phone_number', $_POST['nathaliemota_settings_field_phone_number']);
        }
        if(!empty($_POST['nathaliemota_settings_field_email'])) {
            update_option('nathaliemota_settings_field_email', $_POST['nathaliemota_settings_field_email']);
        }
    }
    return $inputs;
}

add_action('admin_menu', 'nathaliemota_add_admin_pages', 10);
add_action('admin_init', 'nathaliemota_settings_register');

/**
 * Displays the post thumbnail.
 */
function nathaliemota_post_thumbnail() {
    if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
        return;
    }
 
    if ( is_singular() ) :
        ?>
 
        <figure class="post-thumbnail">
            <?php the_post_thumbnail(); ?>
        </figure><!-- .post-thumbnail -->
 
    <?php else : ?>
 
        <figure class="post-thumbnail">
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
        </figure><!-- .post-thumbnail -->
 
    <?php
    endif; // End is_singular().
}
 
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function nathaliemota_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
 
    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() )
    );
 
    echo '<span class="posted-on">' . $time_string . '</span>';
}
 
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function nathaliemota_entry_footer() {
    // Hide category and tag text for pages.
    if ( 'post' === get_post_type() ) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( esc_html__( ', ', 'nathaliemota' ) );
        if ( $categories_list ) {
            /* translators: %s: category list. */
            printf( '<span class="cat-links">' . esc_html__( 'Posted in %s', 'nathaliemota' ) . '</span>', $categories_list );
        }
 
        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'nathaliemota' ) );
        if ( $tags_list ) {
            /* translators: %s: tag list. */
            printf( '<span class="tags-links">' . esc_html__( 'Tagged %s', 'nathaliemota' ) . '</span>', $tags_list );
        }
    }
 
    if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    /* translators: %s: post title */
                    __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'nathaliemota' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            )
        );
        echo '</span>';
    }
 
    edit_post_link(
        sprintf(
            wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                __( 'Edit <span class="screen-reader-text">%s</span>', 'nathaliemota' ),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            wp_kses_post( get_the_title() )
        ),
        '<span class="edit-link">',
        '</span>'
    );
}

// Ajout CPT Photographie

function nathaliemota_register_custom_post_types() {
    $labels_photographie = array(
        'menu_name'         => __('Photographies', 'nathaliemota'),
        'name_admin_bar'    => __('Photographie', 'nathaliemota'),
        'add_new_item'      => __('Ajouter une nouvelle photograhie', 'nathaliemota'),
        'new_item'          => __('Nouvelle photographie', 'nathaliemota'),
        'edit_item'         => __('Modifier l\'ajout', 'nathaliemota'),
    );

    $args_photographie = array(
        'label'             => __('Photographies', 'nathaliemota'),
        'description'       => __('Photographies', 'nathaliemota'),
        'labels'            => $labels_photographie,
        'supports'          => array('title', 'thumbnail', 'excerpt', 'editor'),
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'menu_position'    => 40,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export'        => true,
        'has_archive'       => true,
        'exclude_from_search'   => false,
        'publicly_queryable' => true,
        'capability_type'   => 'post',
        'menu_icon'  => 'dashicons-drumstick',
    );

    register_post_type('cif_photographie', $args_photographie);
}

add_action('init', 'nathaliemota_register_custom_post_types', 11);
