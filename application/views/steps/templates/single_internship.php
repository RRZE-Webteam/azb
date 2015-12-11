<?php

$textFragments = get_instance()->lib_text->loadTextFragments('schritte/praktika/fragmente'); ?>

<?php
// LABELS
$labels = array(
  'firma' => $textFragments['label_firma'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',

  'dauer' => $textFragments['label_dauer'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',

  'taetigkeit' => $textFragments['label_taetigkeit'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>',
);
?>

<div class="panel panel-default internship">
  <div class="panel-heading">

    <a href="javascript:void(0)" class="remove-internship btn btn-danger btn-sm">
     <span class="glyphicon glyphicon-trash"> </span>
    </a>

    <span class="heading-string"><?= $textFragments['panel_ueberschrift']; ?> %s</span>
  </div>

  <div class="panel-body form-horizontal">


  <?php $this->view('validation_error', ['message' => $errorFirma]); ?>
  <?php
    // Firma {{{
    $this->view(
      'form_fields/input_with_label', 
      array(
        'label' => $labels['firma'],
        'attributes' => [
          'name' => 'firma',
          'value' => $valueFirma,
          'required' => 'required'
        ]
      ) 
    );
    // }}}
  ?>


  <?php $this->view('validation_error', ['message' => $errorDauer]); ?>
  <?php
    // Dauer {{{
    $this->view(
      'form_fields/input_with_label', 
      array(
        'label' => $labels['dauer'],
        'attributes' => [
          'name' => 'dauer',
          'value' => $valueDauer,
          'required' => 'required'
        ]
      ) 
    );
    // }}}
  ?>


  <?php $this->view('validation_error', ['message' => $errorTaetigkeit]); ?>
  <?php
    // Dauer {{{
    $this->view(
      'form_fields/textarea_with_label', 
      array(
        'label' => $labels['taetigkeit'],
        'value' => $valueTaetigkeit,
        'attributes' => [
          'name' => 'taetigkeit',
          'required' => 'required'
        ]
      ) 
    );
    // }}}
  ?>

  </div>
</div>
