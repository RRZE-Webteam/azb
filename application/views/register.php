<?php echo form_open( 'register/process' ); ?>

<?php
$labels = array(
  'anrede' => 'Anrede',
  'vorname' => 'Vorname',
  'nachname' => 'Nachname',
  'geburtsdatum' => 'Geburtsdatum',
  'email' => 'E-Mail',
  'passwort' => 'Passwort<br /><small>mindestens 8 Zeichen</small>',
  'repasswort' => 'Passwort wiederholen'
);
?>


  <div class="panel panel-default">
    <div class="panel-heading">Person</div>
    <div class="panel-body form-horizontal">
      <?php   
        // Anrede {{{
        $this->view('validation_error', ['message' => form_error('anrede')]);

        $this->view(
          'form_fields/select_with_label', 
          array(
            'label' => $labels['anrede'],
            'value' => set_value('anrede'),
            'choices' => $choicesAnrede,
            'attributes' => [
              'name' => 'anrede'
            ]
          ) 
        );
        // }}}


        // Vorname {{{
        $this->view('validation_error', ['message' => form_error('vorname')]);
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => $labels['vorname'],
            'attributes' => [
              'name' => 'vorname',
              'value' => set_value('vorname'),
              'required' => 'required'
            ]
          ) 
        );
        // }}}
       
        
        // Nachname {{{
        $this->view('validation_error', ['message' => form_error('nachname')]);
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => $labels['nachname'],
            'attributes' => [
              'name' => 'nachname',
              'value' => set_value('nachname'),
              'required' => 'required'
            ]
          ) 
        );
        // }}}
        
        // Geburtsdatum {{{
        $this->view('validation_error', ['message' => form_error('geburtsdatum')]);
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => $labels['geburtsdatum'],
            'attributes' => [
              'name' => 'geburtsdatum',
              'value' => set_value('geburtsdatum'),
              'required' => 'required',
              'id' => 'geburtsdatum'
            ]
          ) 
        );
        // }}}
      ?>
    </div>
  </div>


  <div class="panel panel-default">
    <div class="panel-heading">Zugangsdaten</div>
    <div class="panel-body form-horizontal">

      <?php
        // Email {{{
        $this->view('validation_error', ['message' => form_error('email')]);
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => $labels['email'],
            'attributes' => [
              'name' => 'email',
              'value' => set_value('email'),
              'required' => 'required'
            ]
          ) 
        );
        // }}}
      ?>

      <span class="help-block">Du musst ein Passwort vergeben, damit du deine Bewerbung später fortsetzen oder zurückziehen kannst.</span>

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

  <input type="submit" value="Registrieren" class="btn btn-info" />

</form>

<script>
  $(function() {
    $('#geburtsdatum').datepicker( {
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd.mm.yy',
      yearRange: "-100:-13",
	  defaultDate: "-15y"
    });

  });
</script>
