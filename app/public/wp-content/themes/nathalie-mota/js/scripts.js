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

    // Initialisation de Fancybox
    $("[data-fancybox]").fancybox({
      loop: true,
      infobar: true,
      caption: function (instance, current) {
        var caption = $(current.$content).data('caption') || '';
        if (current.type === 'image') {
          caption = (caption.length ? caption + '<br />' : '') + 'Image ' + (instance.index + 1) + ' of ' + instance.group.length;
        }
        return caption;
      },
    });

    // Ouvre la page single.php lorsque l'icône de l'œil est cliquée
    $('.photo-eye-icon').on('click', function(e) {
      e.preventDefault();
      var photoLink = $(this).closest('.photo-item').find('a').attr('data-single-url');
      window.location.href = photoLink;
    });

    // Ouvre la lightbox lorsque l'icône du carré est cliquée
    $('.photo-expand-icon').on('click', function(e) {
      e.preventDefault();
      $(this).closest('a').trigger('click');
    });


    // Empêcher le titre d'être cliquable
    $('.photo-title').on('click', function(e) {
      e.preventDefault();
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
            output += '<a href="' + photo.link + '" data-single-url="' + photo.link + '" class="fancybox" data-fancybox="gallery">';
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
})(jQuery);



