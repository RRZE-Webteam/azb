<?php
error_reporting(-1);
ini_set('display_errors', 'On');

session_start();

  require_once 'classes/class_bewerber.php';
  require_once 'classes/class_bewerbung.php';
  require_once 'classes/class_praktikum.php';
  require_once 'classes/class_bewerbung_attachments.php';

  require_once 'classes/form_field/class_objector.php';

  require_once 'conf/conf.php';

  define('DEFAULT_UPLOAD_DIR', '../uploads/');

  $dbObj = pg_connect($db_conn_string);


//############################################################################
//Bewerber
//############################################################################
  $bewerber = new bewerber();
  bindFields(array('anrede', 'name', 'vorname', 'adresse',
			'email', 'postleitzahl', 'ort'), $bewerber);

  $geb_jahr = extractField('geburtsdatum_jahr');
  $geb_monat = extractField('geburtsdatum_monat');
  $geb_tag = extractField('geburtsdatum_tag');

  $bewerber->geburtsdatum->input($geb_jahr, 'y');
  $bewerber->geburtsdatum->input($geb_monat, 'm');
  $bewerber->geburtsdatum->input($geb_tag, 'd');

  $bewerbung = new bewerbung();

//############################################################################
//Bewerbung
//############################################################################
  bindFields(array('angestrebter_abschluss', 'erworbener_abschluss',
		   'notendurchschnitt_schulabschluss', 'note_deutsch',
		   'note_englisch', 'note_mathematik', 'note_informatik',
		   'hobbys', 'berufsausbildung', 'studium'), $bewerbung);

  $bewerbung->setBewerber($bewerber);

//############################################################################
//Praktika
//############################################################################
  $anzahl_praktika = extractField('anzahl_praktika');

  $praktikaData = extractField('praktikum');
  $praktika = array();

  for($i=1; $i<=$anzahl_praktika; $i++) {
    $praktikumData = $praktikaData[$i];

    $praktikum = new praktikum($i);

    bindFields(array('firma', 'taetigkeit', 'dauer'), $praktikum,
      $praktikumData);

    $bewerbung->addPraktikum($praktikum);
  }

//############################################################################
//Dateianhaenge
//############################################################################

  $attachments = new bewerbungAttachments();

  bindFields(array('bewerbungsbild', 'bewerbungsunterlagen',
    'behindertenausweis'), $attachments, $_FILES);

  $bewerbung->setAttachments($attachments);

//############################################################################
//Validieren
//############################################################################
  $objector = new objector();
  $bewerbung->validate($objector);
  $objections = $objector->gatherObjections();

  $success = empty($objections);
  $redirect='';

  if($success) {
      //save to databse
      echo $bewerbung->save($dbObj, DEFAULT_UPLOAD_DIR);
      $redirect="formular.php";
  }
  else {
    $process['objections'] = $objections;
    $process['data'] = $_POST;

    $json = json_encode($process);

    $_SESSION['process'] = $json;

    $redirect='formular.php?eval=1';
  }

//############################################################################
//Hilfsfunktionen
//############################################################################

  function bindFields($identifiers, $target, $source=NULL) {
    if(!is_array($identifiers))
      $identifiers = array($identifiers);

    foreach($identifiers as $identifier) {
      $value = extractField($identifier, $source);
      $target->{$identifier}->input($value);
    }
  }

  function extractField($key, $from=NULL) {
    $from = ($from) ? $from : $_POST;

    return isset($from[$key]) ? $from[$key] : NULL;
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
<script>
window.location.replace('<?php echo $redirect; ?>');
</script>
<body />
</html>
