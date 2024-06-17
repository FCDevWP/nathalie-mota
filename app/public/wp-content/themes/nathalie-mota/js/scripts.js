/* Apparition et disparition Modale contact */
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
    });
  })(jQuery);
  

  /* Ajout requete JQuey */
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
                    output += '<div class="photo-item">';
                    output += '<a href="' + photo.link + '">';
                    output += '<img src="' + photo.image + '" alt="' + photo.title + '">';
                    output += '<h2>' + photo.title + '</h2>';
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

//Initialisation & Ajout Fancybox
jQuery(document).ready(function($) {
  $('.fancybox').fancybox({
      // Options de Fancybox
      loop: true,
      infobar: true,
      caption: function( instance, item ) {
          var caption = $(this).data('caption') || '';
          if (item.type === 'image') {
              caption = (caption.length ? caption + '<br />' : '') + '<small>Image ' + (item.index + 1) + ' of ' + instance.group.length + (item.title.length ? ' - ' + item.title : '') + '</small>';
          }
          return caption;
      }
  });
});
