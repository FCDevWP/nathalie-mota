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
jQuery(document).ready(function ($) {
  Fancybox.bind("[data-fancybox]", {
    loop: true,
    infobar: true,
    caption: function (fancybox, carousel, slide) {
      var caption = $(this).data('caption') || '';
      if (slide.type === 'image') {
        caption = (caption.length ? caption + '<br />' : '') + '<small>Image ' + (slide.index + 1) + ' of ' + carousel.slides.length + (slide.title.length ? ' - ' + slide.title : '') + '</small>';
      }
      return caption;
    },
  });
});



jQuery(document).ready(function($) {
  Fancybox.bind("[data-fancybox]", {
    // Options de Fancybox
    backFocus: false,
    clickContent: false,
    clickSlide: false,
    clickOutside: false,
    dragToClose: false,
    escape: false,
    keyboard: false,
    rightClick: false,
    scrollOutside: false,
    touch: false,
    animationDuration: 300,
    backdrop: {
      opacity: 0.5,
      color: "#000"
    },
    arrows: true,
    infobar: false,
    toolbar: false,
    buttons: [],
    loop: true,
    slideShow: {
      autoStart: false,
      speed: 3000
    },
    fullScreen: {
      autoStart: false
    },
    image: {
      zoom: false,
      protect: true
    },
    thumb: {
      autoStart: false
    },
    iframe: {
      preload: false
    },
    a11y: {
      enabled: true,
      hideShowInterstitial: true,
      hideShowInterstitialDelay: 500,
      keyboardNavigationInterstitial: true
    },
    on: {
      init: function(instance) {
        
      },
      ready: function(instance) {
        
      },
      show: function(instance) {
        
      },
      hide: function(instance) {
        
      },
      destroy: function(instance) {
       
        // Code à exécuter lors de l'initialisation de Fancybox
      },
      ready: function(instance) {
        // Code à exécuter lorsque Fancybox est prêt
      },
      show: function(instance) {
        // Code à exécuter lorsque Fancybox est affiché
      },
      hide: function(instance) {
        // Code à exécuter lorsque Fancybox est caché
      },
      destroy: function(instance) {
        // Code à exécuter lorsque Fancybox est détruit
      }
    }
  });
});

document.addEventListener('click', function(event) {
  if (event.target.closest('.photo-eye')) {
      // L'icône de l'œil a été cliquée, ne rien faire ici.
  } else if (event.target.closest('.photo-expand')) {
      // Le carré a été cliqué, ouvrir la lightbox.
      event.preventDefault();
      var imageSrc = event.target.closest('.photo-item').querySelector('img').src;
      Fancybox.show([{ src: imageSrc }]);
  } else if (event.target.closest('.photo-title')) {
      // Le titre a été cliqué, empêcher l'ouverture de la lightbox.
      event.preventDefault();
  }
});



