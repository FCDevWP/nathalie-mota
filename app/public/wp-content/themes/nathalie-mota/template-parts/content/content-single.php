<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage nathaliemota
 * @since nathaliemota 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <!-- <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        <?php nathaliemota_posted_on(); ?> -->
    </header><!-- .entry-header -->

    <!-- <?php nathaliemota_post_thumbnail(); ?> -->

    <div class="entry-content">
        <div class="photo-categories">
            <?php
            $taxonomy = 'categories'; // Remplacez par le nom de votre taxonomie
            $terms = get_the_term_list( get_the_ID(), $taxonomy, '', ', ', '' );
            if ( ! empty( $terms ) ) {
                printf( '<span class="categories-label">%s</span> %s', esc_html__( 'Categories: ', 'nathaliemota' ), $terms );
            }
            ?>
        </div>
        <?php
            the_content(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'nathaliemota' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post( get_the_title() )
                )
            );

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'nathaliemota' ),
                    'after'  => '</div>',
                )
            );
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php nathaliemota_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->

