

/* Apparition et disparition Modale contact */
(function($) {
  $(document).ready(function() {
    // Initialise le widget de dialogue
    $('#contact-modal').dialog({
      autoOpen: false,
      modal: true,
      title: 'Contact'
    });

    // Ouvre le dialogue sur clic
    $('body').on('click', '.open-contact-modal', function() {
      console.log('La modale est ouverte !');
      $('#contact-modal').dialog('open');
    });

    // Ferme le dialogue sur clic à l'extérieur ou sur le bouton de fermeture
    $('body').on('click', function(event) {
      if ($(event.target).hasClass('modal') || $(event.target).hasClass('close')) {
        $('#contact-modal').dialog('close');
      }
    });
  });
})(jQuery);
