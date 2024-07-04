(function($) {
  $(document).ready(function() {
    // Initialisation de Select2
    $("#category").select2();
    $("#format").select2();
    $("#tri").select2();

    // Ouvre la modale lors du clic sur le lien "Contact" (existant)
    $('.open-contact-modal, .btn-contact').on('click', function(e) {
      e.preventDefault();
      $('#contact-modal').fadeIn();
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
})(jQuery);

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

document.addEventListener('DOMContentLoaded', function() {
  var myModal = new bootstrap.Modal(document.getElementById('contact-modal'), {
      keyboard: false
  });

  document.querySelectorAll('.btn-contact').forEach(function(button) {
      button.addEventListener('click', function(event) {
          event.preventDefault();
          myModal.show();
      });
  });
});
