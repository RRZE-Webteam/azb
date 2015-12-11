<div class="alert alert-info">
  Prüfe hier noch einmal deine Angaben und korrigiere diese gegebenenfalls.
</div>

<?php if($errorMessage): ?>
  <div class="alert alert-danger">
    <?= $errorMessage; ?>
  </div>

<?php endif; ?>

<div class="panel panel-default summary person">
  <div class="panel-heading">Person</div>

  <table class="table table-bordered noten">

    <tr>
      <td><span class="field-label">Name</span></td>
      <td><span class="field name"><?= "$vorname $nachname"; ?></span></td>
    </tr>


    <tr>
      <td><span class="field-label">Geburtsdatum</span></td>
      <td><span class="field geburtsdatum"><?= "$geburtsdatum"; ?></span></td>
    </tr>

  </table>

  <div class="panel-heading">Kontakt
  	<a href="<?php base_url();?>contact_data" class="btn btn-default btn-xs">
    	<span class="glyphicon glyphicon-pencil"> </span>
    </a></div>
  <table class="table table-bordered noten">

    <tr>
      <td><span class="field-label">Anschrift</span></td>
      <td>
        <span class="field adresse"><?= $adresse; ?></span>
        ,&nbsp;
        <span class="field postleitzahl"><?= $postleitzahl; ?></span>
        <span class="field ort"><?= "$ort"; ?></span>
      </td>
    </tr>

    <tr>
      <td><span class="field-label">Telefon</span></td>
      <td><span class="field telefon"><?= "$telnummer"; ?></span></td>
    </tr>


  </table>
</div>



<?php
  $CI = &get_instance();
  $CI->load->config('custom');

  $s = $CI->config->item('db_value_translations')['schulabschluesse'];
?>

<div class="panel panel-default summary education">
  <div class="panel-heading">Ausbildung <a href="<?php base_url();?>education" class="btn btn-default btn-xs">
    	<span class="glyphicon glyphicon-pencil"> </span>
    </a></div>

  <table class="table table-bordered noten">

    <tr>
      <td><span class="field-label">Schulabschluss</span></td>
      <td><span class="field name"><?= $s[$erworbener_abschluss]; ?></span></td>
    </tr>


  <?php if($erworbener_abschluss!='keiner'): ?>
    <tr>
      <td><span class="field-label">Notendurchschnitt</span></td>
      <td><span class="field name"><?= $notendurchschnitt_schulabschluss; ?></span></td>
    </tr>
  <?php endif; ?>

  <?php if($erworbener_abschluss!='abitur'): ?>
    <tr>
      <td><span class="field-label">Angestrebter Abschluss</span></td>
      <td><span class="field name"><?= $s[$angestrebter_abschluss]; ?></span></td>
    </tr>
  <?php endif; ?>

  </table>

  <div class="panel-heading">Noten</div>

  <table class="table table-bordered noten">
    <tr>
      <td> <span class="field-label note">Deutsch</span> </td>
      <td> <?= $note_deutsch; ?> </td>
    </tr>

    <tr>
      <td> <span class="field-label note">Englisch</span> </td>
      <td> <?= $note_englisch; ?> </td>
    </tr>

    <tr>
      <td> <span class="field-label note">Mathematik</span> </td>
      <td> <?= $note_mathematik; ?> </td>
    </tr>

    <tr>
      <td> <span class="field-label note">Informatik</span> </td>
      <td> <?= $note_informatik; ?> </td>
    </tr>
  </table>
</div>


<div class="panel panel-default summary internships">
  <div class="panel-heading">Praktika <a href="<?php base_url();?>internships" class="btn btn-default btn-xs">
    	<span class="glyphicon glyphicon-pencil"> </span>
    </a></div>

  <table class="table table-bordered noten">

<?php if( count($praktika) == 0 ): ?>
  <tr><td colspan="3">keine</td></tr>
<?php endif; ?>

  <?php foreach($praktika as $praktikum): ?>
    <tr>
      <td>
        <span class="field-label"><?php echo $praktikum->firma; ?></span>
        , <?= $praktikum->dauer; ?>   Tage
      </td>
      <td><span class="field beschreibung"><?= "$praktikum->taetigkeit"; ?></span></td>
    </tr>
  <?php endforeach; ?>

  </table>
</div>



<?php
  $it_skills = array(
    'kenntnisse_office' => 'Office',
    'kenntnisse_betriebssysteme' => 'Betriebssysteme',
    'kenntnisse_netzwerke' => 'Netzwerke',
    'kenntnisse_hardware' => 'Hardware'
    );


  $it_skills_rating = array(
    '-1' => 'keine Angabe',
    '0' => 'keine',
    '1' => 'Anfängerkenntnisse',
    '2' => 'Fortgeschrittenenkenntnisse',
    '3' => 'Expertenkenntnisse'
    );

?>
<div class="panel panel-default summary it_skills">
  <div class="panel-heading">IT-Kenntnisse <a href="<?php base_url();?>it_skills" class="btn btn-default btn-xs">
    	<span class="glyphicon glyphicon-pencil"> </span>
    </a></div>

  <table class="table table-bordered noten">
  <?php foreach($it_skills as $key=>$label): ?>
    <tr>
      <td><span class="field-label"><?= $label; ?></td>
      <td>
        <span class="field it_skills rating"><?= $it_skills_rating[ $$key ]; ?></span>
        <? if(${$key . '_txt'})  echo ':&nbsp;'. ${$key . '_txt'} ?>

      </td>

    </tr>

  <?php endforeach; ?>
  </table>

</div>



<div class="panel panel-default summary other">
  <div class="panel-heading">Sonstiges <a href="<?php base_url();?>other" class="btn btn-default btn-xs">
    	<span class="glyphicon glyphicon-pencil"> </span>
    </a></div>

  <table class="table table-bordered">
    <tr>
      <td><span class="field-label">Hobbys</a></td>
      <td><?= $hobbys; ?></td>
    </tr>
  </table>
</div>



<?php
  $panelClass = $invalid_uploads ? 'panel-danger' : 'panel-default';

?>
<div class="panel <?= $panelClass; ?> summary uploads">
  <div class="panel-heading">Unterlagen <a href="<?php base_url();?>uploads" class="btn btn-default btn-xs">
    	<span class="glyphicon glyphicon-pencil"> </span>
    </a></div>

  <table class="table table-bordered noten">

  <?php if( count(array_filter($uploads)) == 0 ): ?>
    <tr><td colspan="3">keine</td></tr>
  <?php endif; ?>

  <?php foreach($uploads as $upload): ?>
  <?php if(!$upload) continue; ?>
    <tr>
      <td><span class="field-label"><?php echo $upload['subjekt']; ?></span></td>
      <td><?= $upload['dateiname']; ?></td>
    </tr>
  <?php endforeach; ?>

  </table>
</div>

<div class="step-navigation">
	<a href="<?= $predecessorURL; ?>"  class="btn btn-default">Zur&uuml;ck</a>
	<a href="<?= base_url(); ?>complete" class="btn btn-info">Bewerbung abschließen</a>
</div>
