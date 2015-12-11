<h1>Fragen &amp; Antworten</h1>

<?php foreach($this->lib_text->loadEnumeratedTexts('seiten/fragen_und_antworten') as $textObject) : ?>
  <div class="question-container">
  <?php $textObject->output(); ?>
  </div>
<?php endforeach; ?>


