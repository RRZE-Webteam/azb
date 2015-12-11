<?php
$textFragments = $this->lib_text->loadTextFragments('schritte/unterlagen/fragmente');


if( ! isset($text) )
  $text = $html_name;


?>

<div class="form-group upload" id="<?php echo $css_id; ?>">
  <label class="control-label" name="<?= $html_name; ?>"><?= $text; ?></label>


  <div class="existing-file" style="display: none">
    <a href="javascript:void(0)" class="btn btn-danger btn-sm remove-file">
      <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> <?= $textFragments['button_entfernen']; ?>
    </a>

    <div class="file-info"></div>
  </div>

  <div class="new-file" style="display: none">
    <a href="javascript:void(0)" class="btn btn-warning btn-sm remove-file">
      <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> <?= $textFragments['button_abbrechen']; ?>
    </a>

    <div class="file-info"></div>
  </div>

  <div class="add-file-container">
    <a href="javascript:void(0)" class="btn btn-success btn-sm add-file" style="display: none">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?= $textFragments['button_hinzufuegen']; ?>
    </a>

    <input
      type="file" 
      class="file-input"
      name="<?= $html_name; ?>" 
     ></input>
   </div>

</div>




