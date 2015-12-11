<?php

$textFragments = $this->lib_text->loadTextFragments('schritte/ausbildung/fragmente');


// Labels {{{
$labels = array(
  'angestrebter_abschluss' => $textFragments['label_angestrebter_abschluss'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',

  'erworbener_abschluss' => $textFragments['label_erworbener_abschluss'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',

  'notendurchschnitt_schulabschluss' => $textFragments['label_notendurchschnitt'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',

  'berufsausbildung' => $textFragments['label_berufsausbildung'],

  'note_deutsch' => $textFragments['label_note_deutsch'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',
  'note_englisch' => $textFragments['label_note_englisch'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',
  'note_mathematik' => $textFragments['label_note_mathematik'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',
  'note_informatik' => $textFragments['label_note_informatik']
);
// }}}


?>


  <div class="panel panel-default">
    <div class="panel-heading"><?= $textFragments['titel_schulabschluss']; ?></div>
    <div class="panel-body form-horizontal">
    <span class="help-block"><?= $textFragments['angestrebter_abschluss']; ?></span>

      <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('angestrebter_abschluss')]); ?>
      <?php
      // angestrebter Abschluss {{{
      $this->view(
        'form_fields/select_with_label', 
        array(
          'label' => $labels['angestrebter_abschluss'],
          'value' => set_value('angestrebter_abschluss'),
          'choices' => $choices_angestrebter_abschluss,
          'attributes' => [
            'name' => 'angestrebter_abschluss'
          ]
        ) 
      );
      // }}}
      ?>
      <hr />
    <span class="help-block"><?= $textFragments['erworbener_abschluss']; ?></span>

      <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('erworbener_abschluss')]); ?>
      <?php
      // erworbener Abschluss {{{
      $this->view(
        'form_fields/select_with_label', 
        array(
          'label' => $labels['erworbener_abschluss'],
          'value' => set_value('erworbener_abschluss'),
          'choices' => $choices_erworbener_abschluss,
          'attributes' => [
            'name' => 'erworbener_abschluss',
            'id' => 'erworbener_abschluss'
          ]
        ) 
      );
      // }}}
      ?>

      <div id="notendurchschnitt-container">
        <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('notendurchschnitt_schulabschluss')]); ?>
        <?php
        // Notendurchschnitt {{{
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => $labels['notendurchschnitt_schulabschluss'],
            'attributes' => [
              'name' => 'notendurchschnitt_schulabschluss',
              'value' => set_value('notendurchschnitt_schulabschluss'),
              'id' => 'notendurchschnitt'
            ]
          ) 
        );
        // }}}
        ?>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading"><?= $textFragments['titel_berufsausbildung']; ?></div>
    <div class="panel-body form-horizontal">
      <span class="help-block"><?= $textFragments['berufsausbildung']; ?></span>
        <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('berufsausbildung')]); ?>
        <?php
        // Berufsausbildung/Studium {{{
        $this->view(
          'form_fields/textarea_with_label', 
          array(
            'label' => $labels['berufsausbildung'],
            'value' => set_value('berufsausbildung'),
            'attributes' => [
              'name' => 'berufsausbildung'
            ]
          ) 
        );
        // }}}
        ?>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading"><?= $textFragments['titel_noten']; ?></div>
    <div class="panel-body form-horizontal">
      <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('note_deutsch')]); ?>
      <?php
        // Note Deutsch {{{
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => $labels['note_deutsch'],
            'attributes' => [
              'name' => 'note_deutsch',
              'value' => set_value('note_deutsch'),
              'required' => 'required',
              'id' => 'note_deutsch'
            ]
          ) 
        );
        // }}}
      ?>
        
      <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('note_englisch')]); ?>
      <?php
        // Note Englisch {{{
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => $labels['note_englisch'],
            'attributes' => [
              'name' => 'note_englisch',
              'value' => set_value('note_englisch'),
              'required' => 'required',
              'id' => 'note_englisch'
            ]
          ) 
        );
        // }}}
        //
      ?>
        
      <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('note_mathematik')]); ?>
      <?php
        // Note Mathematik {{{
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => $labels['note_mathematik'],
            'attributes' => [
              'name' => 'note_mathematik',
              'value' => set_value('note_mathematik'),
              'required' => 'required',
              'id' => 'note_mathematik'
            ]
          ) 
        );
        // }}}
        //
      ?>
        
      <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('note_informatik')]); ?>
      <?php
        // Note Informatik {{{
        $this->view(
          'form_fields/input_with_label', 
          array(
            'label' => $labels['note_informatik'],
            'attributes' => [
              'name' => 'note_informatik',
              'value' => set_value('note_informatik'),
              'id' => 'note_informatik'
            ]
          ) 
        );
        // }}}
      ?>

    </div>
  </div>


<?php // JS ================================================================ ?>

<script>
  var erworbenerAbschluss = $('#erworbener_abschluss');
  var notendurchschnitt = $('#notendurchschnitt-container');


  erworbenerAbschluss.change(function() {
    if( $(this).find('option:selected').attr('value') == 'keiner' ) {
      notendurchschnitt.hide();
    } else {
      notendurchschnitt.show();
    }
  });

  erworbenerAbschluss.trigger('change');


</script>
