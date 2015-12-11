<?php echo form_open('login/process'); ?>

  <div class="panel panel-default">
    <div class="panel-heading">
      Einloggen 
      (<a href="<?= base_url();?>reset_password/">Passwort vergessen?</a>)
    </div>
    <div class="panel-body form-horizontal"?>
      <?php if(isset($error_message)): ?>
        <div class="alert alert-danger">
          <?= $error_message; ?>
        </div>
      <?php endif; ?>
      <?php
        $this->view('validation_error', ['message' => form_error('email')]);
        // E-Mail {{{
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => 'E-Mail',
            'attributes' => [
              'name' => 'email',
              'value' => set_value('email'),
              'required' => 'required'
            ]
          ) 
        );
        // }}}



        $this->view('validation_error', ['message' => form_error('passwort')]);

        // Passwort {{{
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => 'Passwort',
            'attributes' => [
              'name' => 'passwort',
              'value' => '',
              'type' => 'password',
              'required' => 'required'
            ]
          ) 
        );
        // }}}
      ?>
    </div>
  </div>

  <input type="submit" value="Einloggen" class="btn btn-info" />

</form>

