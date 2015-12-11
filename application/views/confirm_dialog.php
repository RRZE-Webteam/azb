<?php
  if( ! isset($severity) ) $severity = 'default';
  if( ! isset($proceed_label) ) $proceed_label = 'Weiter';
  if( ! isset($cancel_label) ) $cancel_label = 'Abbrechen';

?>
<div class="alert alert-<?= $severity; ?>">
<?= $message; ?>
</div>

<a href="<?= $cancel_url; ?>" class="btn btn-default"><?= $cancel_label; ?></a>
<a href="<?= $proceed_url; ?>" class="btn btn-<?= $severity; ?>"><?= $proceed_label; ?></a>
