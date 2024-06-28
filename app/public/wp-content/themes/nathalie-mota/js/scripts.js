(function($) {
  $(document).ready(function() {
    // Ouvre la modale lors du clic sur le lien "Contact"
    $('.open-contact-modal').on('click', function(e) {
      e.preventDefault();
      $('#contact-modal').fadeIn();
    });

    // Ferme la modale lors du clic en dehors de celle-ci
    $(document).on('click', function(e) {
      if ($(e.target).closest('.modal-content').length === 0 && !$(e.target).hasClass('open-contact-modal')) {
        $('#contact-modal').fadeOut();
      }
    });

    // Ferme la modale lorsque le formulaire est envoyé
    $('#contact-modal form').on('submit', function() {
      $('#contact-modal').fadeOut();
    });

    // Requête AJAX pour récupérer les données des photos
    $.ajax({
      url: nathaliemotaAjax.ajaxurl,
      type: 'post',
      data: {
        action: 'request_photos'
      },
      success: function(response) {
        if(response) {
          let output = '';
          $.each(response, function(index, photo) {
            output += '<div class="photo-item" data-photo-id="' + photo.id + '">';
            output += '<a href="' + photo.image + '" class="fancybox" data-fancybox="gallery" data-single-url="' + photo.link + '">';
            output += '<img src="' + photo.image + '" alt="' + photo.title + '">';
            output += '<div class="photo-overlay">';
            output += '<div class="photo-title" id="photo-title-' + photo.id + '">' + photo.title + '</div>';
            output += '<div class="photo-eye"><i class="fa-regular fa-eye photo-eye-icon"></i></div>';
            output += '<div class="photo-expand"><i class="fa-solid fa-expand photo-expand-icon"></i></div>';
            output += '<div class="photo-category">' + photo.category + '</div>';
            output += '</div>';
            output += '</a>';
            output += '</div>';
          });
          $('#photo-gallery').html(output);

          // Initialiser la nouvelle lightbox après avoir ajouté les photos
          Lightbox.init();

          // Gestionnaire d'événements pour l'icône de l'œil
          $('.photo-eye-icon').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var photoLink = $(this).closest('.photo-item').find('a').attr('data-single-url');
            window.location.href = photoLink;
          });

          // Gestionnaire d'événements pour l'icône d'expansion
          $('.photo-expand-icon').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('a.fancybox').click();
          });

          // Empêcher le titre d'être cliquable
          $('.photo-title').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
          });
        } else {
          $('#photo-gallery').html('<p>No photos found</p>');
        }
      }
    });
  });
})(jQuery);

(function($) {
    $(document).ready(function() {
        
        // Gestion du bouton "Charger plus"
        var paged = 2; // Commencez à la page 2 car la première page est déjà chargée
        $('#load-more').on('click', function() {
            $.ajax({
                url: nathaliemotaAjax.ajaxurl,
                type: 'post',
                data: {
                    action: 'load_more_photos',
                    paged: paged
                },
                success: function(response) {
                    console.log ("succes")
                    if(response.success) {
                      console.log (response.data)
                        $('.photo-gallery').append(response.data);
                        paged++;
                        
                        // Réinitialise Lightbox pour les nouvelles photos
                        Lightbox.init();
                        
                        // Si toutes les photos sont chargées, masque le bouton
                        if(paged > 3) { // Supposant que vous avez 16 photos au total (2 pages de 8)
                            $('#load-more').hide();
                        }
                    } else {
                        $('#load-more').hide();
                    }
                }
            });
        });
    });
})(jQuery);


