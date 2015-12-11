<?php

$textFragments = $this->lib_text->loadTextFragments('schritte/sonstiges/fragmente');

$labels = array(
  'hobbys' => $textFragments['label_hobbys']
);
?>


  <div class="panel panel-default">
    <div class="panel-heading"><?= $textFragments['titel_sonstiges']; ?></div>
    <div class="panel-body form-horizontal">

      <span class="help-block"><?= $textFragments['erlaeuterung_hobbys']; ?></span>

      <?php
        if($displayErrors)
          $this->view('validation_error', ['message' => form_error('hobbys')]);
      ?>
      <?php
        // Hobbys {{{
        $this->view(
          'form_fields/textarea_with_label', 
          array(
            'label' => $labels['hobbys'],
            'value' => set_value('hobbys'),
            'attributes' => [
              'name' => 'hobbys'
            ]
          ) 
        );
        // }}}

      ?>

    </div>
  </div>


