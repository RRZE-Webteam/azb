<?php

$textFragments = $this->lib_text->loadTextFragments('schritte/kontakt/fragmente');


$labels = array(
  'adresse' => $textFragments['label_adresse'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',
  'postleitzahl' => $textFragments['label_postleitzahl'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',
  'ort' => $textFragments['label_ort'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',
  'telnummer' => $textFragments['label_telefon'] . '<br/ ><small>' . $textFragments['label_telefon_beispiel'] . '</small>'
);

?>


  <div class="panel panel-default">
    <div class="panel-heading"><?= $textFragments['titel_anschrift']; ?></div>
    <div class="panel-body form-horizontal">

      <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('adresse')]); ?>
      <?php
      $this->view(
        'form_fields/input_with_label', 
        array(
          'label' => $labels['adresse'],
          'attributes' => [
            'name' => 'adresse',
            'value' => set_value('adresse'),
            'required' => TRUE
          ]
        ) 
      );
      ?>

      <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('postleitzahl')]); ?>
      <?php
      $this->view(
        'form_fields/input_with_label', 
        array(
          'label' => $labels['postleitzahl'],
          'attributes' => [
            'name' => 'postleitzahl',
            'value' => set_value('postleitzahl'),
            'required' => TRUE
          ]
        ) 
      );
      ?>

      <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('ort')]); ?>
      <?php
      $this->view(
        'form_fields/input_with_label', 
        array(
          'label' => $labels['ort'],
          'attributes' => [
            'name' => 'ort',
            'value' => set_value('ort'),
            'required' => TRUE
          ]
        ) 
      );
      ?>

    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading"><?= $textFragments['titel_kontakt']; ?></div>
    <div class="panel-body form-horizontal">

      <?php if($displayErrors) $this->view('validation_error', ['message' => form_error('telnummer')]); ?>
      <?php
      $this->view(
        'form_fields/input_with_label', 
        array(
          'label' => $labels['telnummer'],
          'attributes' => [
            'name' => 'telnummer',
            'value' => set_value('telnummer')
          ]
        ) 
      );
      ?>

    </div>
  </div>



