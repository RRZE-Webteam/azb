<div class="form-group">
  <label class="control-label col-xs-12 col-sm-3" name="<?= $attributes['name']; ?>"><?= $label; ?></label>
  <div class="input-group col-xs-12 col-sm-6">
    <select 
      class="form-control" 
      <?php foreach($attributes as $attrName=>$attrValue):

        $attrString = '%s="%s"';
        echo sprintf($attrString, $attrName, $attrValue);

      endforeach; ?>
    >

      <?php foreach($choices as $key=>$text): ?>
        <?php $selectedAttr = ($key == $value) ? 'selected="selected"' : ''; ?>
        <option value="<?= $key; ?>" <?=$selectedAttr; ?>><?= $text; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>
