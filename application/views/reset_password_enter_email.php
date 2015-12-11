<?php

$labels = array(
  'email' => 'E-Mail',
);

?>

<?php echo form_open('reset_password/request_password_reset'); ?>

  <div class="panel panel-default">
    <div class="panel-heading">Passwort zurücksetzen</div>
    <div class="panel-body form-horizontal">
      <?php
      // E-Mail {{{
      $this->view('validation_error', ['message' => form_error('email')]);
      $this->view(
        'form_fields/input_with_label', 
        array(
          'label' => $labels['email'],
          'attributes' => [
            'name' => 'email',
            'value' => set_value('email'),
            'required' => 'required',
            'id' => 'email'
          ]
        ) 
      );
      // }}}
      ?>
    </div>
  </div>


  <input type="submit" value="Wiederherstellungs-Link anfordern" class="btn btn-info" />

</form>

