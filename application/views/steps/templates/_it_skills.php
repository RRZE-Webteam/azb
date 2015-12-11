<div id="it-skills">
<?php


$textFragments = $this->lib_text->loadTextFragments('schritte/it_kenntnisse/fragmente');

$labels = array(
  'kenntnisse_office' => $textFragments['label_kenntnisse'],
  'kenntnisse_betriebssysteme' => $textFragments['label_kenntnisse'],
  'kenntnisse_netzwerke' => $textFragments['label_kenntnisse'],
  'kenntnisse_hardware' => $textFragments['label_kenntnisse'],

  'kenntnisse_office_txt' => $textFragments['label_beschreibung'],
  'kenntnisse_betriebssysteme_txt' => $textFragments['label_beschreibung'],
  'kenntnisse_netzwerke_txt' => $textFragments['label_beschreibung'],
  'kenntnisse_hardware_txt' => $textFragments['label_beschreibung']
);

?>


  <div class="panel panel-default two-columns">
    <div class="panel-heading"><?= $textFragments['ueberschrift_office']; ?></div>
    <div class="panel-body form-horizontal">

        <p>
          <?= $textFragments['erlaeuterung_office']; ?>
        </p>

        <?php
          if($displayErrors)
            $this->view('validation_error', ['message' => form_error('kenntnisse_office')]);
        ?>
        <?php
        // Kenntnisse Office {{{
        $this->view(
          'form_fields/select_with_label', 
          array(
            'label' => $labels['kenntnisse_office'],
            'value' => set_value('kenntnisse_office'),
            'choices' => $choicesKenntnisse,
            'attributes' => [
              'name' => 'kenntnisse_office'
            ]
          ) 
        );
        // }}}
        ?>

        <?php
          if($displayErrors)
            $this->view('validation_error', ['message' => form_error('kenntnisse_office_txt')]);
        ?>
        <?php
        // Beschreibung Office {{{
        $this->view(
          'form_fields/textarea_with_label', 
          array(
            'label' => $labels['kenntnisse_office_txt'],
            'value' => set_value('kenntnisse_office_txt'),
            'attributes' => [
              'name' => 'kenntnisse_office_txt'
            ]
          ) 
        );
        // }}}
        ?>
    </div>
  </div>


  <div class="panel panel-default two-columns">
    <div class="panel-heading"><?= $textFragments['ueberschrift_betriebssysteme']; ?></div>
    <div class="panel-body form-horizontal">

        <p>
          <?= $textFragments['erlaeuterung_betriebssysteme']; ?>
        </p>

        <?php
          if($displayErrors)
            $this->view('validation_error', ['message' => form_error('kenntnisse_betriebssysteme')]);
        ?>
        <?php
        // Kenntnisse Betriebssysteme {{{
        $this->view(
          'form_fields/select_with_label', 
          array(
            'label' => $labels['kenntnisse_betriebssysteme'],
            'value' => set_value('kenntnisse_betriebssysteme'),
            'choices' => $choicesKenntnisse,
            'attributes' => [
              'name' => 'kenntnisse_betriebssysteme'
            ]
          ) 
        );
        // }}}
        ?>

        <?php
          if($displayErrors)
            $this->view('validation_error', ['message' => form_error('kenntnisse_betriebssysteme_txt')]);
        ?>
        <?php
        // Beschreibung Betriebssysteme {{{
        $this->view(
          'form_fields/textarea_with_label', 
          array(
            'label' => $labels['kenntnisse_betriebssysteme_txt'],
            'value' => set_value('kenntnisse_betriebssysteme_txt'),
            'attributes' => [
              'name' => 'kenntnisse_betriebssysteme_txt'
            ]
          ) 
        );
        // }}}
        ?>

    </div>
  </div>


  <div class="panel panel-default two-columns">
    <div class="panel-heading"><?= $textFragments['ueberschrift_netzwerke']; ?></div>
    <div class="panel-body form-horizontal">

        <p>
          <?= $textFragments['erlaeuterung_netzwerke']; ?>
        </p>

        <?php
          if($displayErrors)
            $this->view('validation_error', ['message' => form_error('kenntnisse_netzwerke')]);
        ?>
        <?php
        // Kenntnisse Netzwerke {{{
        $this->view(
          'form_fields/select_with_label', 
          array(
            'label' => $labels['kenntnisse_netzwerke'],
            'value' => set_value('kenntnisse_netzwerke'),
            'choices' => $choicesKenntnisse,
            'attributes' => [
              'name' => 'kenntnisse_netzwerke'
            ]
          ) 
        );
        // }}}
        ?>

        <?php
          if($displayErrors)
            $this->view('validation_error', ['message' => form_error('kenntnisse_netzwerke_txt')]);
        ?>
        <?php
        // Beschreibung Netzwerke {{{
        $this->view(
          'form_fields/textarea_with_label', 
          array(
            'label' => $labels['kenntnisse_netzwerke_txt'],
            'value' => set_value('kenntnisse_netzwerke_txt'),
            'attributes' => [
              'name' => 'kenntnisse_netzwerke_txt'
            ]
          ) 
        );
        // }}}
        ?>

    </div>
  </div>



  <div class="panel panel-default two-columns">
    <div class="panel-heading"><?= $textFragments['ueberschrift_hardware']; ?></div>
    <div class="panel-body form-horizontal">

        <p>
          <?= $textFragments['erlaeuterung_hardware']; ?>
        </p>

        <?php
          if($displayErrors)
            $this->view('validation_error', ['message' => form_error('kenntnisse_hardware')]);
        ?>
        <?php
        // Kenntnisse Hardware {{{
        $this->view(
          'form_fields/select_with_label', 
          array(
            'label' => $labels['kenntnisse_hardware'],
            'value' => set_value('kenntnisse_hardware'),
            'choices' => $choicesKenntnisse,
            'attributes' => [
              'name' => 'kenntnisse_hardware'
            ]
          ) 
        );
        // }}}
        ?>

        <?php
          if($displayErrors)
            $this->view('validation_error', ['message' => form_error('kenntnisse_hardware_txt')]);
        ?>
        <?php
        // Beschreibung Hardware {{{
        $this->view(
          'form_fields/textarea_with_label', 
          array(
            'label' => $labels['kenntnisse_hardware_txt'],
            'value' => set_value('kenntnisse_hardware_txt'),
            'attributes' => [
              'name' => 'kenntnisse_hardware_txt'
            ]
          ) 
        );
        // }}}
        ?>

    </div>
  </div>




</div>

