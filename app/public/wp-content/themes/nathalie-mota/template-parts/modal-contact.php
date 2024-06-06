<div class="modal fade" id="contact-modal" tabindex="-1" role="dialog" aria-labelledby="contact-modal-label" aria-hidden="true">
  <div class="modal-overlay"> 
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Contact header.png" alt="Contact header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php echo $args['formulaire_contact']; ?>
        </div>
      </div>
    </div>
  </div>
</div>
