<?php 

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );

function nathalie_mota_enqueue_styles() {
    wp_enqueue_style('nathalie-mota-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_styles');

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