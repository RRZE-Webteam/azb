<?php $fragments = $this->lib_text->loadEnumeratedTexts('seiten/hilfe'); ?>

<?php 
  foreach($fragments as $fragment) {
    $fragment->output();
  }
?>
