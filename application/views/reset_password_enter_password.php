<?php

$labels = array(
  'passwort' => 'Passwort',
  'repasswort' => 'Passwort wiederholen'
);

?>

<?php echo form_open('reset_password/do_enter_new_password'); ?>

  <div class="panel panel-default">
    <div class="panel-heading">Passwort zurücksetzen</div>
    <div class="panel-body form-horizontal">
      <?php
        // passwort {{{
        $this->view('validation_error', ['message' => form_error('passwort')]);
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => $labels['passwort'],
            'attributes' => [
              'name' => 'passwort',
              'value' => '',
              'required' => 'required',
              'type' => 'password'
            ]
          ) 
        );
        // }}}
      ?>


      <?php
        // Repasswort {{{
        $this->view('validation_error', ['message' => form_error('repasswort')]);
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => $labels['repasswort'],
            'attributes' => [
              'name' => 'repasswort',
              'value' => '',
              'required' => 'required',
              'type' => 'password'
            ]
          ) 
        );
        // }}}
      ?>
    </div>
  </div>


  <input type="submit" value="Passwort zurücksetzen" class="btn btn-info" />

</form>

