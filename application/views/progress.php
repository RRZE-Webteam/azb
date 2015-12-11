<div id="progress">
  <?php foreach($progression as $step): ?>

  <?php
    // span css classes
    $classes = array();

    $classes[] = $step->isActive ? 'active' : 'not-active';
    $classes[] = $step->isCompleted ? 'completed' : 'not-completed';
    $classes[] = $step->isNext ? 'next' : NULL;
    $classes[] = $step->number;

    // remove NULL values
    array_filter($classes);

    $classes = implode(' ', $classes);

    // text / link
    $text = $step->text;
    $target = $step->isActive ? '#' : base_url() . $step->url;

    $isClickable = ($step->isCompleted || $step->isNext);

    if($isClickable) {
      $content = sprintf('<a href="%s">%s</a>', $target, $text);
    }
    else {
      $content = $text;
    }

  ?>
	<span class="<?= $classes; ?>"> <?= $content; ?></span>
  <?php endforeach; ?>
</div>
