<?php
  function print_auswahlfeld_datum($prefix) {
  ?>
    <div class="form-group row">
      <div class="col-md-4">
	<select name="<?php echo $prefix; ?>_tag" class="form-control">
	  <?php
	    for($i=1;$i<=31; $i++) {
	      echo sprintf('<option value="%1$s">%1$s</option>', $i);
	    } ?>
	</select>
      </div>
      <div class="col-md-4">
	<select name="<?php echo $prefix; ?>_monat" class="form-control">
	  <?php
	    for($i=1;$i<=12; $i++) {
	    $monthName = date("F", mktime(0, 0, 0, $i, 10));
	      echo sprintf('<option value="%s">%s</option>', $i, $monthName);
	    } ?>
	</select>
      </div>
      <div class="col-md-4">
	<select name="<?php echo $prefix; ?>_jahr" class="form-control">
	  <?php
	    $currentYear = date('Y');
	    $offset = 15;

	    for($i=$currentYear-15;$i>=1945; $i--) {
	      echo sprintf('<option value="%1$s">%1$s</option>', $i);
	    } ?>
	</select>
      </div>
    </div>
    <?php
  }

  function create_skill_options() {
    ?>
    <option value="0">keine Kenntnisse</option>
    <option value="1">Anfängerkenntnisse</option>
    <option value="2">Fortgeschrittenenkenntnisse</option>
    <option value="3">Expertenkenntnisse</option>
    <?php
  }

  function create_auswahlfeld_schulabschluesse($name) {
    ?>
    <select name="<?php echo $name; ?>" id="<?php echo $name; ?>" class="form-control">
      <option value="keiner">keine Angabe</option>
      <option value="abitur">Abitur</option>
      <optgroup label="Fachabitur">
        <option value="fachabitur__sozial">
          Fachabitur - sozialer Zweig
        </option>
        <option value="fachabitur__technisch">
          Fachabitur - technischer Zweig
        </option>
        <option value="fachabitur__wirtschaftlich">
          Fachabitur - wirtschaftlicher Zweig
        </option>
      </optgroup>
      <optgroup label="mittlerer Bildungsabschluss">
        <option value="mittlerer_bildungsabschluss__naturwissenschaftlich">
          MBA - naturwissenschaftlicher Zweig
        </option>
        <option value="mittlerer_bildungsabschluss__neusprachlich">
          MBA - neusprachlicher Zweig
        </option>
        <option value="mittlerer_bildungsabschluss__sozial">
          MBA - sozialer Zweig
        </option>
        <option value="mittlerer_bildungsabschluss__technisch">
          MBA - technischer Zweig
        </option>
        <option value="mittlerer_bildungsabschluss__wirtschaftlich">
          MBA - wirtschaftlicher Zweig
        </option>
      </optgroup>
      <optgroup label="qualifizierender Hauptschulabschluss">
        <option value="quali__naturwissenschaftlich">
          QA - naturwissenschaftlicher Zweig
        </option>
        <option value="quali__neusprachlich">
          QA - neusprachlicher Zweig
        </option>
        <option value="quali__sozial">
          QA - sozialer Zweig
        </option>
        <option value="quali__technisch">
          QA - technischer Zweig
        </option>
        <option value="quali__wirtschaftlich">
          QA - wirtschaftlicher Zweig
        </option>
      </optgroup>
    </select>
    <?php
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
  <meta charset="UTF-8" />
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet"
    href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
  <link rel="stylesheet" href="style.css" />
  <script
    src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js">
  </script>
  <script src="js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <script src="/js/jquery.mousewheel.min.js"></script>
  <script>
   $(function() {
    var spinner_englisch = $( "#spinner_englisch" ).spinner({ max: 6, min:1 });
    var spinner_deutsch = $( "#spinner_deutsch" ).spinner({ max: 6, min:1 });
    var spinner_mathematik = $( "#spinner_mathematik" )
			     .spinner({ max: 6, min:1});
    var spinner_informatik = $( "#spinner_informatik" )
			     .spinner({ max: 6, min:1 });
   });
  </script>
  <script>
  var showProcess = '<?php echo @$_GET['eval']; ?>';
  var objectionMessages = {
    '900000':'Ungültige Auswahl',
    '900001':'Eingabe zu lang',
    '900002':'Ungültige E-Mail-Adresse',
    '900003':'Feld darf nicht leer sein',
    '900004':'Ungültiges Datum',
    '900005':'Ungültige Eingabe',
    '900006':'Ungültige Eingabe',
    '900007':'Ungültiger Dateityp',
    '900008':'Datei zu groß'
  };


  $(document).ready(function(){
    //bind event handlers first
    $("#erworbener_abschluss").change(function() {
      var value = $('option:selected', this).val();
      var feldNotendurchschnitt =
	$("#field_notendurchschnitt_schulabschluss");


      if(value=='keiner') {
	feldNotendurchschnitt.hide();
      }
      else {
	feldNotendurchschnitt.show();
      }
    })
    .trigger('change');

    //TODO: event handler for Praktika

    //then initialize form controls
    if(showProcess=='1')
    {
      var json = $.getJSON('getprocess.php')
	.done(function(data) {
	  initializeForm(data);
	  showObjections(data);
	})
	.fail(function() {
	  $('#errorDisplay').text('Ungültige Prozess-ID');
	});
    }
  });

  function zeigePraktikaFelder(number) {
    ddl = document.getElementById('ddl_anzahl_praktika');

    for(i=1; i<=8; i++) {
      feld = document.getElementById('praktikum'+i);
      if(i<=number)
	feld.style.display = 'block';
      else
	feld.style.display = 'none';
    }
  }

  function changeDatum(prefix, datum) {
    var parts = ["jahr", "monat", "tag"];

    parts.forEach(function(part) {
	$("select[name='"+prefix+"_"+part+"']").val(datum[part]);
    });

  }

  function initializeForm(json) {
    var inputs = ["name", "vorname", "adresse",
		  "postleitzahl", "ort", "email",
		  "notendurchschnitt_schulabschluss"];

    var textareas = ["studium", "berufsausbildung", "hobbys", "anmerkungen"];

    var spinners = ["englisch", "mathematik", "informatik", "deutsch"];

    var selects = ["anrede", "kenntnisse_office", "kenntnisse_betriebssysteme",
		   "kenntnisse_netzwerke", "kenntnisse_hardware"];

    inputs.forEach(function(field) {
      $("input[name='"+field+"']").attr('value', json.data[field]);
    });

    textareas.forEach(function(field) {
      $("textarea[name='"+field+"']").text(json.data[field]);
    });

    var datum = {"jahr":json.data.geburtsdatum_jahr,
		 "monat":json.data.geburtsdatum_monat,
		 "tag":json.data.geburtsdatum_tag
		 };

    spinners.forEach(function(field) {
      spinner = $("#spinner_" + field).spinner("value",
		  json.data["note_" +field]);
    });

    changeDatum("geburtsdatum", datum);

    selects.forEach(function(field) {
      $("select[name='"+ field +"']").val(json.data[field]);
    });


    console.log(json);

    for(i=1; i<=8; i++) {
      $("textarea[id=firma"+i+"]").text(json.data.praktikum[i].firma);

      $("textarea[id=taetigkeit"+i+"]")
	.text(json.data.praktikum[i].taetigkeit);

      $("input[id=dauer"+i+"]").attr('value', json.data.praktikum[i].dauer);
    }

    //Bewerbung

    $("select[name='angestrebter_abschluss']")
    .val(json.data.angestrebter_abschluss);

    $("select[name='erworbener_abschluss']")
    .val(json.data.erworbener_abschluss)
    .trigger('change');

    anzahlPraktika = json.data.anzahl_praktika;
    $("select[id=ddl_anzahl_praktika]").val(anzahlPraktika);
    zeigePraktikaFelder(anzahlPraktika);


  }

  function showObjections(json) {
    console.log(json.objections);

    for(var identifier in json.objections) {
      json.objections[identifier].forEach(function(objection) {
	var $objectionField = $('<div>', {class: "alert alert-danger"});
	$objectionField.text("> "+objectionMessages[objection]);

	$("div[id='field_"+identifier+"']").prepend($objectionField);
	$("div[id='field_"+identifier+"']").addClass('has-error');

      });
    }
  }
</script>
</head>
<body class="container">
<div id='errorDisplay'></div>
<form name="bewerbung" action="process.php" method="POST"
  enctype="multipart/form-data" class="formular">
  <div class="row">
  <div class="col-md-6">
  <fieldset class="panel panel-primary">
    <div class="panel-heading">Persönliche Daten</div>
    <div class="panel-body">
      <div id="field_anrede" class="form-group">
	<label name="anrede" class="control-label">Anrede*</label>
	<div class="input-group">
	  <select name="anrede" class="form-control">
	    <option value="herr">Herr</option>
	    <option value="frau">Frau</option>
	    <option value="keine_angabe">keine Angabe</option>
	    <option value="unbestimmt">unbestimmt</option>
	  </select>
	</div>
      </div>
      <div id="field_name" class="form-group">
	<label name="name" class="control-label">Name*</label>
	<input name="name" class="form-control" required="required" />
      </div>
      <div id="field_vorname" class="form-group">
	<label name="vorname" class="control-label">Vorname*</label>
	<input name="vorname" class="form-control" required="required" />
      </div>
      <div class="datum" id="field_datum" class="form-group">
	<label  class="control-label">Geburtsdatum*</label>
	<?php print_auswahlfeld_datum('geburtsdatum'); ?>
      </div>
      <div id="field_adresse" class="form-group">
	<label name="adresse" class="control-label">Adresse*</label>
	<input name="adresse" class="form-control" required="required" />
      </div>
      <div id="field_postleitzahl" class="form-group">
	<label name="postleitzahl" class="control-label">Postleitzahl*</label>
	<input name="postleitzahl" class="form-control" required="required" />
      </div>
      <div id="field_ort" class="form-group">
	<label name="ort" class="control-label">Ort*</label>
	<input name="ort" class="form-control" required="required" />
      </div>
      <div id="field_email" class="form-group">
	<label name="email" class="control-label">E-Mail*</label>
	<input name="email" class="form-control" required="required"
	  type="email" />
      </div>
    </div>
  </fieldset>

  <fieldset class="panel panel-primary">
    <div class="panel-heading">Sonstiges</div>
    <div class="panel-body">
      <div id="field_hobbys" class="form-group">
	<label name="hobbys" class="control-label">Hobbys*</label>
	<textarea name="hobbys" class="form-control"
	  required="required"></textarea>
      </div>
      <div id="field_anmerkungen" class="form-group">
	<label name="anmerkungen" class="control-label">Anmerkungen</label>
	<textarea name="anmerkungen" class="form-control"></textarea>
      </div>
    </div>
  </fieldset>

<fieldset class="panel panel-primary" class="form-group">
    <div class="panel-heading">Dateianhänge</div>
    <div class="panel-body">
      <div id="field_bewerbungsbild" class="form-group">
	<label class="control-label"
	  name="bewerbungsbild">Bewerbungsbild</label>
	<input type="file" name="bewerbungsbild" />
      </div>
      <div id="field_lebenslauf" class="form-group">
	<label class="control-label"
	  name="lebenslauf">Lebenslauf</label>
	<input type="file" name="lebenslauf" />
      </div>
      <div id="field_anschreiben" class="form-group">
	<label class="control-label"
	  name="anschreiben">Anschreiben</label>
	<input type="file" name="anschreiben" />
      </div>
      <div id="field_zeugnisse" class="form-group">
	<label class="control-label"
	  name="zeugnisse">Zeugnisse</label>
	<input type="file" name="zeugnisse" />
      </div>
      <div id="field_sonstiges" class="form-group">
	<label class="control-label"
	  name="sonstiges">Sonstiges</label>
	<input type="file" name="sonstiges" />
      </div>
      <div id="field_behindertenausweis" class="form-group">
	<label class="control-label"
	  name="behindertenausweis">Behindertenausweis</label>
	<input type="file" name="behindertenausweis" />
      </div>
    </div>
  </fieldset>

  </div>
  <div class="col-md-6">
  <fieldset class="panel panel-primary">
    <div class="panel-heading">Ausbildung</div>
    <div class="panel-body">
      <div id="field_angestrebter_abschluss" class="form-group">
	<label name="angestrebter_abschluss" class="control-label">
	  angestrebter Schulabschluss
	</label>
    <?php create_auswahlfeld_schulabschluesse("angestrebter_abschluss"); ?>

      </div>
      <div id="field_erworbener_abschluss" class="form-group">
	<label name="erworbener_abschluss" class="control-label">
	  bereits erworbener Schulabschluss
	</label>

    <?php create_auswahlfeld_schulabschluesse("erworbener_abschluss"); ?>
      </div>
      <div id="field_notendurchschnitt_schulabschluss" class="form-group
	form-subgroup">
	<label name="notendurchschnitt_schulabschluss" class="control-label">
	  Notendurchschnitt*
	</label>
	<input name="notendurchschnitt_schulabschluss" class="form-control" />
      </div>
      <div class="form-group">
	<label name="einzelnoten_schulzeugnis">
	  Einzelnoten im letzten Schulzeugnis*
	</label>
	<div class="row">
	  <div class="col-lg-3">
	    <div id="field_note_deutsch" class="form-group">
	      <span class="control-label">
		Deutsch
	      </span>
	      <input name="note_deutsch" class="form-control"
		required="required" id="spinner_deutsch" />
	    </div>
	  </div>
	  <div class="col-md-3">
	    <div id="field_note_englisch" class="form-group">
	      <span class="control-label">
		Englisch
	      </span>
	      <input name="note_englisch" class="form-control"
		required="required" id="spinner_englisch" />
	    </div>
	  </div>
	  <div class="col-md-3">
	    <div id="field_note_mathematik" class="form-group">
	      <span class="control-label">
		Mathematik
	      </span>
	      <input name="note_mathematik" class="form-control"
		required="required" id="spinner_mathematik" />
	    </div>
	  </div>
	  <div class="col-md-3">
	    <div id="field_note_informatik" class="form-group">
	      <span class="control-label">
		Informatik
	      </span>
	      <input name="note_informatik" class="form-control"
		required="required" id="spinner_informatik" />
	    </div>
	  </div>
	</div>
      </div>
      <div class="row">
	<div class="col-md-6">
	  <div id="field_berufsausbildung" class="form-group">
	    <label name="berufsausbildung" class="control-label">
	      abgeschlossene Berufsausbildung
	    </label>
	    <textarea class="form-control" rows="4"
	      name="berufsausbildung"></textarea>
	  </div>
	</div>
	<div class="col-md-6">
	  <div id="field_studium" class="form-group">
	    <label name="studium" class="control-label">
	      Studium
	    </label>
	    <textarea class="form-control" rows="4"
	      name="studium"></textarea>
	  </div>
	</div>
      </div>
      <div class="form-group">
	<label name="anzahl_praktika" class="control-label">
	  Anzahl absolvierter Praktika
	</label>
	<select name="anzahl_praktika" id="ddl_anzahl_praktika"
	  onchange="zeigePraktikaFelder(
	    $('#ddl_anzahl_praktika').find(':selected').text())"
	  class="form-control"
	    >
	<?php
	  for($i=0; $i<=8; $i++) {
	    echo sprintf('<option name="%1$s">%1$s</option>', $i);
	  }
	?>
	</select>
      </div>
      <div class="panel-group" id="praktika">
      <?php
	for($i=1; $i<=8; $i++) {
      ?>
	<div class="panel panel-default" id="praktikum<?php echo $i; ?>"
	  style="display: none">
	  <div class="panel-heading">
	    <a data-toggle="collapse" data-parent="#praktika"
	      href="#praktikum-pan<?php echo $i; ?>">
	      Praktikum <?php echo $i; ?>
	    </a>
	  </div>
	  <div class="panel-collapse collapse"
	    id="praktikum-pan<?php echo $i; ?>">
	  <div class="panel-body">
	    <div id="field_firma<?php echo $i; ?>" class="form-group">
	      <label name="firma" class="control-label">bei Firma</label>
	      <textarea name="praktikum[<?php echo $i; ?>][firma]"
		id="firma<?php echo $i; ?>" class="form-control"></textarea>
	    </div>
	    <div id="field_taetigkeit<?php echo $i; ?>" class="form-group">
	      <label name="taetigkeit" class="control-label">Tätigkeit</label>
	      <textarea name="praktikum[<?php echo $i;
		?>][taetigkeit]" id="taetigkeit<?php echo $i; ?>"
		class="form-control"></textarea>
	    </div>
	    <div id="field_dauer<?php echo $i; ?>" class="form-group">
	      <label name="firma" class="control-label">Dauer (in Tagen)</label>
	      <input name="praktikum[<?php echo $i; ?>][dauer]"
		id="dauer<?php echo $i; ?>" class="form-control" />
	    </div>
	  </div>
	</div>
	</div>
      <?php } ?>
      </div>
  </fieldset>

  <fieldset class="panel panel-primary">
    <div class="panel-heading">IT-Kenntnisse</div>
    <div class="panel-body">

      <div id="field_kenntnisse_office" class="form-group">
	<label name="kenntnisse_office" class="control-label">
	  Office-Anwendungen
	</label>
	<select name="kenntnisse_office" class="form-control">
	  <?php create_skill_options(); ?>
	</select>
      </div>

      <div id="field_kenntnisse_betriebssysteme" class="form-group">
	<label name="kenntnisse_betriebssysteme" class="control-label">
	  Betriebssysteme
	</label>
	<select name="kenntnisse_betriebssysteme" class="form-control">
	  <?php create_skill_options(); ?>
	</select>
      </div>

      <div id="field_kenntnisse_netzwerke" class="form-group">
	<label name="kenntnisse_netzwerke" class="control-label">
	  Netzwerke
	</label>
	<select name="kenntnisse_netzwerke" class="form-control">
	  <?php create_skill_options(); ?>
	</select>
      </div>

      <div id="field_kenntnisse_hardware" class="form-group">
	<label name="kenntnisse_hardware" class="control-label">
	  Netzwerke
	</label>
	<select name="kenntnisse_hardware" class="form-control">
	  <?php create_skill_options(); ?>
	</select>
      </div>

    </div>
  </fieldset>
  </div>
  </div><!--row-->
  <input type="submit" />
  <input type="reset" />
</body>
</html>
