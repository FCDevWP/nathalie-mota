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
  
