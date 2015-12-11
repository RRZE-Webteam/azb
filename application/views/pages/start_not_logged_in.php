<?php $this->lib_text->loadText('seiten/start/text')->output(); ?>

<?php $fragments = $this->lib_text->loadTextFragments('seiten/start/fragmente'); ?>

<div class="action action-bewerben">

  <h1>
    <div class="action-icon">
      <span class="glyphicon glyphicon-arrow-right"></span>
    </div>

    <a href="<?= base_url(); ?>register"><?= $fragments['registrierung_ueberschrift'];?></a>
  </h1>

  <?= $fragments['registrierung_text']; ?>
</div>

<div class="action">
  <h1>
    <div class="action-icon">
      <span class="glyphicon glyphicon-lock"></span>
    </div>

    <a href="<?= base_url(); ?>login"><?= $fragments['einloggen_ueberschrift']; ?></a>
  </h1>
  <?= $fragments['einloggen_text']; ?>
</div>

