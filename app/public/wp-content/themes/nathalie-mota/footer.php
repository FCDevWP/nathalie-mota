


        <footer>
            <div class="nav-footer">
                <span><a href="<?php echo get_permalink(get_page_by_path('mentions-legales')); ?>">MENTIONS LEGALES</a></span>
                <span><a href="<?php echo get_permalink(get_page_by_path('vie-privee')); ?>">VIE PRIVÉE</a></span>
                <span><a href="<?php echo get_permalink(get_page_by_path('tous-droits-reserves')); ?>">TOUS DROITS RÉSERVÉS</a></span>
            </div>
        </footer>

        <?php
            ob_start(); // Démarrer la mise en mémoire tampon
            echo do_shortcode('[contact-form-7 id="6bdc12a" title="Contact form nathaliemota"]');
            $formulaire_contact = ob_get_clean(); // Arrêter la mise en mémoire tampon et obtenir le contenu
            $args = array('formulaire_contact' => $formulaire_contact);
            get_template_part('template-parts/modal-contact', null, $args);
        ?>
        <?php wp_footer(); ?>
    </body>
</html>