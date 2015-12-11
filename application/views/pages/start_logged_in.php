<?php $fragments = $this->lib_text->loadTextFragments('seiten/start/fragmente'); ?>

<div class="action <?php if($isCompleted) echo 'action-inactive'; ?>">
  <h1>
    <div class="action-icon">
      <span class="glyphicon glyphicon-play"> </span>
    </div>

    <a href="<?= base_url(); ?>resume"><?= $fragments['fortsetzen_ueberschrift']; ?></a>
  </h1>
  
    <?= $fragments['fortsetzen_text']; ?>
</div>


<div class="action">
  <h1>
    <div class="action-icon">
      <span class="glyphicon glyphicon-remove"></span>
    </div>

  <a href="<?= base_url(); ?>withdraw"> <?= $fragments['zurueckziehen_ueberschrift']; ?> </a>
  </h1>

  <?= $fragments['zurueckziehen_text']; ?>
</div>


