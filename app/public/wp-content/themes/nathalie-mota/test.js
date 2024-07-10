(function($) {
  $(document).ready(function() {
    // Initialisation de Select2
    $("#category, #format, #tri").select2({
      minimumResultsForSearch: Infinity, // Désactive la barre de recherche
      width: '100%' // Assure que le select prend toute la largeur disponible
    });

    // Gestion de la modale de contact
    var modal = document.getElementById('contact-modal');

    $('.open-contact-modal, .btn-contact').on('click', function(e) {
      e.preventDefault();
      var reference = $(this).data('reference') || '';
      
      $('#contact-modal').fadeIn();
      
      // Remplir le champ de référence
      var referenceField = $('#contact-modal input[name="reference"]');
      if (referenceField.length) {
          referenceField.val(reference);
      }
    });

    // Ferme la modale lors du clic en dehors de celle-ci
    $(document).on('click', function(e) {
      if ($(e.target).closest('.modal-content').length === 0 && !$(e.target).hasClass('open-contact-modal') && !$(e.target).hasClass('btn-contact')) {
        $('#contact-modal').fadeOut();
      }
    });

    // Ferme la modale lorsque le formulaire est envoyé
    $('#contact-modal form').on('submit', function() {
      $('#contact-modal').fadeOut();
    });

    // Variables pour le filtrage et la pagination
    var currentPage = 1;
    var category = '';
    var format = '';
    var tri = '';

    // Fonction pour charger les photos
    function loadPhotos(page = 1, replace = true) {
      $.ajax({
        url: nathaliemotaAjax.ajaxurl,
        type: 'post',
        data: {
          action: 'request_photos',
          paged: page,
          category: category,
          format: format,
          tri: tri
        },
        success: function(response) {
          if(response.success) {
            let output = '';
            $.each(response.data.photos, function(index, photo) {
              output += '<div class="photo-item" data-photo-id="' + photo.id + '">';
              output += '<a href="' + photo.image + '" class="custom-lightbox" data-fancybox="gallery" data-single-url="' + photo.link + '"';
              output += ' data-title="' + photo.title + '"';
              output += ' data-category="' + photo.category + '"';
              output += ' data-reference="' + photo.reference + '">';
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
          
            
            if (replace) {
              $('.photo-gallery').html(output);
            } else {
              $('.photo-gallery').append(output);
            }

            // Mettre à jour le bouton "Charger plus"
            if (page >= response.data.max_pages) {
              $('#load-more').hide();
            } else {
              $('#load-more').show();
            }

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
              $(this).closest('a.custom-lightbox').click();
            });

            // Empêcher le titre d'être cliquable
            $('.photo-title').on('click', function(e) {
              e.preventDefault();
              e.stopPropagation();
            });
          } else {
            $('.photo-gallery').html('<p>Aucune photo trouvée</p>');
            $('#load-more').hide();
          }
        }
      });
    }

    // Charger les photos initiales
    loadPhotos();

    // Gestionnaires d'événements pour les menus déroulants
    $('#category, #format, #tri').on('change', function() {
      category = $('#category').val();
      format = $('#format').val();
      tri = $('#tri').val();
      currentPage = 1;
      loadPhotos(currentPage, true);
    });

    // Gestion du bouton "Charger plus"
    $('#load-more').on('click', function() {
      currentPage++;
      loadPhotos(currentPage, false);
    });

    // Nouvelle section pour gérer la section 3 de single.php/content-photo.php
    // Gestionnaire d'événements pour l'icône de l'œil dans la section 3
    $('.section-3 .photo-eye-icon').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var photoLink = $(this).closest('a').attr('data-single-url');
        window.location.href = photoLink;
    });

    // Gestionnaire d'événements pour l'icône d'expansion dans la section 3
    $('.section-3 .photo-expand-icon').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).closest('a.custom-lightbox').click();
    });

    // Initialiser Lightbox pour les nouvelles images dans la section 3
    Lightbox.init();
  });

  // Gestion des flèches de navigation
  document.addEventListener('DOMContentLoaded', function() {
    const arrows = document.querySelectorAll('.prev-arrow, .next-arrow');
    arrows.forEach(arrow => {
        arrow.addEventListener('click', function(e) {
            e.preventDefault();
            const imageName = this.getAttribute('data-image');
            const imageUrl = '/wp-content/themes/nathalie-mota/assets/images/' + imageName;
            document.querySelector('.small-photo').src = imageUrl;
            
            // Mettre à jour les flèches
            updateArrows(imageName);
        });
    });

    function updateArrows(currentImage) {
      const images = window.photoImages || [];
      let currentIndex = images.indexOf(currentImage);
      
      const prevArrow = document.querySelector('.prev-arrow');
      const nextArrow = document.querySelector('.next-arrow');
      
      // Navigation infinie
      const prevIndex = (currentIndex - 1 + images.length) % images.length;
      const nextIndex = (currentIndex + 1) % images.length;
      
      prevArrow.style.display = 'inline-block';
      prevArrow.setAttribute('data-image', images[prevIndex]);
      
      nextArrow.style.display = 'inline-block';
      nextArrow.setAttribute('data-image', images[nextIndex]);
    }
  });

  // Gestion des liens de navigation
  $('.nav-link').on('mouseenter', function() {
      $(this).find('.nav-thumbnail').stop().fadeIn(200);
  }).on('mouseleave', function() {
      $(this).find('.nav-thumbnail').stop().fadeOut(200);
  });
  
})(jQuery);
