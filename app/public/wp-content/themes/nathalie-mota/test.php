<?php 
function nathaliemota_request_photos(){
    $query = new WP_Query([
        'post_type' => 'Mes photographies',
        'posts_per_page' => 2
    ]);

    if($query->have_posts()) {
        wp_send_json($query);
    } else {
        wp_send_json(false);
    };

    wp_die();
}

add_action('wp_ajax_request_photos', 'nathaliemota_request_photos');
add_action('wp_ajax_nopriv_request_photos', 'nathaliemota_request_photos');