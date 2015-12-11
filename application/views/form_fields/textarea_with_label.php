<div class="form-group">
  <label class="control-label col-xs-12 col-sm-3" name="<?= $attributes['name']; ?>"><?= $label; ?></label>
  <div class="input-group col-xs-12 col-sm-6">
    <textarea class="form-control"
    <?php foreach($attributes as $attrName=>$attrValue):

      $attrString = '%s="%s" ';
      echo sprintf($attrString, $attrName, $attrValue);

    endforeach; ?>
    ><?= $value; ?></textarea>
  </div>
</div>
