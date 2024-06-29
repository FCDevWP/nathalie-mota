// Récupérer le répertoire des images
$image_dir = get_template_directory() . '/assets/images/';

echo "Chemin du répertoire : " . $image_dir . "<br>";
echo "Le répertoire existe : " . (is_dir($image_dir) ? 'Oui' : 'Non') . "<br>";
if (is_dir($image_dir)) {
    echo "Contenu du répertoire : <pre>" . print_r(scandir($image_dir), true) . "</pre>";
} else {
    echo "Impossible d'accéder au répertoire.<br>";
}

// Récupérer les fichiers d'image dans le répertoire
$images = preg_grep('~\.(jpeg|jpg|png|gif|webp)$~', scandir($image_dir));

// Déboguer l'image mise en avant
echo "ID de l'image mise en avant : " . $featured_image_id . "<br>";
echo "URL de l'image mise en avant : " . $featured_image_url . "<br>";
echo "Nom de fichier de l'image mise en avant : " . $featured_image_file . "<br>";

// Vérifier si le tableau $images n'est pas vide et que l'image mise en avant existe
if (!empty($images) && in_array($featured_image_file, $images)) {
    // Trouver l'index de l'image courante
            $current_index = array_search($featured_image_file, $images);

            // Déterminer l'index de la miniature à afficher (précédente ou suivante)
            $thumbnail_index = ($current_index > 0) ? $current_index - 1 : $current_index + 1;

            // S'assurer que l'index est dans les limites du tableau
            $thumbnail_index = max(0, min($thumbnail_index, count($images) - 1));

            // Obtenir le nom de fichier de la miniature
            $thumbnail_file = $images[$thumbnail_index];

            // Construire l'URL de la miniature
            $thumbnail_url = get_template_directory_uri() . '/assets/images/' . $thumbnail_file;

            // Afficher la miniature
            echo '<img src="' . esc_url($thumbnail_url) . '" alt="Miniature" class="small-photo">';

            // Afficher les flèches de navigation
            if ($current_index > 0) {
                echo '<a href="#" class="prev-arrow"><i class="fas fa-arrow-left"></i></a>';
            }
            if ($current_index < count($images) - 1) {
                echo '<a href="#" class="next-arrow"><i class="fas fa-arrow-right"></i></a>';
            }
} else {
    echo '<p>Image mise en avant non trouvée dans le répertoire.</p>';
    echo '<p>Nom de fichier de l\'image mise en avant : ' . $featured_image_file . '</p>';
}