<div class="form-group">
  <label class="control-label col-xs-12 col-sm-3" name="<?= $attributes['name']; ?>"><?= $label; ?></label>
  <div class="input-group col-xs-12 col-sm-6">
    <input class="form-control"
    <?php foreach($attributes as $attrName=>$attrValue):

      $attrString = '%s="%s"';

      if($attrName=='value')
        echo sprintf($attrString, $attrName, htmlspecialchars($attrValue));
      else
        echo sprintf($attrString, $attrName, $attrValue);

    endforeach; ?>
    />
  </div>
</div>
