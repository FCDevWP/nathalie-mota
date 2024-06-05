

/* Apparition et disparition Modale contact */
(function($) {
    $(document).ready(function() {
      // Ouvrir la modale sur clic
      $('body').on('click', '.open-contact-modal', function() {
        $('#contact-modal').modal('show');
      });
  
      // Fermer la modale sur clic à l'extérieur ou sur le bouton de fermeture
      $('body').on('click', function(event) {
        if ($(event.target).hasClass('modal') || $(event.target).hasClass('close')) {
          $('#contact-modal').modal('hide');
        }
      });
    });
  })(jQuery);
  