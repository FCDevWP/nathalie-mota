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

    document.addEventListener('click', function(event) {
      if (event.target.closest('.photo-eye')) {
        event.preventDefault();
        var photoLink = event.target.closest('.photo-item').querySelector('a').dataset.singleUrl;
        window.location.href = photoLink;
      }
    });

    // Ouvrir la lightbox lorsque l'icône du carré est cliquée
    $('.photo-expand-icon').on('click', function(e) {
      e.stopPropagation();
      var photoId = $(this).closest('.photo-item').data('photo-id');
      var photoSrc = $(this).closest('.photo-item').find('img').attr('src');
      var photoAlt = $(this).closest('.photo-item').find('img').attr('alt');
      var photoTitle = $(this).closest('.photo-item').find('.photo-title').text();

      // Créez un objet avec les attributs de l'image pour la lightbox
      var photoObject = {
          src: photoSrc,
          alt: photoAlt,
          title: photoTitle
      };

      // Ouvrez la lightbox avec l'objet d'image
      $.fancybox.open([photoObject]);
    });

    // Empêcher le titre d'être cliquable
    $('.photo-title').on('click', function(e) {
      e.preventDefault();
    });

    //Initialisation & Ajout Fancybox
    Fancybox.bind("[data-fancybox]", {
      loop: true,
      infobar: true,
      caption: function (fancybox, carousel, slide) {
        var caption = $(this).data('caption') || '';
        if (slide.type === 'image') {
          caption = (caption.length ? caption + '<br />' : '') + 'Image ' + (slide.index + 1) + ' of ' + carousel.slides.length + (slide.title.length ? ' - ' + slide.title : '');
        }
        return caption;
      },
    });
  });
})(jQuery);

/* Ajout requete jQuery */
jQuery(document).ready(function($) {
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
          output += '<a href="' + photo.link + '" data-single-url="' + photo.link + '">';
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
      } else {
        $('#photo-gallery').html('<p>No photos found</p>');
      }
    }
  });
});
