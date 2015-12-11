<?php

$textFragments = $this->lib_text->loadTextFragments('schritte/praktika/fragmente');
?>

<!-- TODO text.. -->
<p>Hier kannst du Angaben zu deinen Praktika machen. Füge für jedes Praktikum einen neuen Block hinzu. Wenn du noch keine Praktika absolviert hast, kannst du die Felder leer lassen und diesen Abschnitt einfach mit "Weiter" überspringen.</p>

<div id="internships">


<!-- PROTOTYPE -->
<div class="prototype">
  <?php
    $this->view('steps/templates/single_internship', array(
      'valueDauer' => NULL,
      'valueTaetigkeit' => NULL,
      'valueFirma' => NULL,
      'errorDauer' => NULL,
      'errorTaetigkeit' => NULL,
      'errorFirma' => NULL
    )); 
  ?>
</div>



<!-- EXISTING INTERNSHIPS -->
<?php foreach($internships as $internship): ?>

  <?php
    $this->view('steps/templates/single_internship', array(
      'valueDauer' => $internship['data']['dauer'],
      'valueTaetigkeit' => $internship['data']['taetigkeit'],
      'valueFirma' => $internship['data']['firma'],
      'errorDauer' => reset($internship['errors']['dauer']),
      'errorTaetigkeit' => reset($internship['errors']['taetigkeit']),
      'errorFirma' => reset($internship['errors']['firma'])
    )); 
  ?>

<?php endforeach; ?>


</div><!-- #internships -->


<!-- ADD CONTROL -->
<a href="javascript:void(0)" id="add-internship" class="btn btn-lg btn-success">
  <span class="glyphicon glyphicon-plus"></span>
   <?= $textFragments['button_hinzufuegen']; ?>
</a>


<!-- JS -->
<!-- INTERACTIVE PANEL TITLE -->
<script>
  $(function() {
    // prototype is still in the DOM tree at this point
    window.defaultPanelTitle =  $('.prototype').find('.panel-heading').find('.heading-string').text();

    // when input changes, adjust panel title accordingly
    $('.internship').each(function() {

      var firma = $( this ).find('input[name=firma]');

      firma.change(function()
      {
        replacePanelHeading(
          $( this ).closest('.internship').find('.panel-heading').find('.heading-string'),
          $( this ).val()
        );
      });

      firma.change();

    });
  });
  //
  // HELPERS

  function replacePanelHeading(node, text)
  {
    if(text != '') {
      text = '"' + text + '"';
    }

    $( node ).text(window.defaultPanelTitle.replace('%s', text));
  }

</script>



<!-- CONTROLS -->
<script>
  $(function() {
    $('.internship').each( function() {
      $( this ).find('.remove-internship').click( function() {
        $( this ).closest('.internship').remove();
      });
    });

    $('#add-internship').click( function() {
      var clone = $( window.prototype ).clone(true, true);
      $('#internships').append(clone);

    });
  });
</script>


<!-- IGNORE FIRST EMPTY INTERNSHIP -->

<script>

  $(function() {
    $('input[type=submit]').click( function() {
      var internship = $('.internship').first();

      var emptyFirma = internship.find('input[name=firma]').val() == '';
      var emptyDauer = internship.find('input[name=dauer]').val() == '';
      var emptyTaetigkeit = internship.find('textarea[name=taetigkeit]').val() == '';

      if( emptyFirma && emptyDauer && emptyTaetigkeit ) {
        internship.remove();
      }
    } );
  });


</script>


<!-- ADDING INDICES -->
<script>
  $('form').submit( function() {
    $('.internship').each( function(index, element) {
      var dauerElement = $( this ).find('[name=dauer]');
      var firmaElement = $( this ).find('[name=firma]');
      var taetigkeitElement = $( this ).find('[name=taetigkeit]');

      dauerElement.attr('name', 'dauer'+index);
      firmaElement.attr('name', 'firma'+index);
      taetigkeitElement.attr('name', 'taetigkeit'+index);
    });
  });
</script>


<!-- JS HIDDEN FIELD -->
<script>

$('form').append('<input type="hidden" name="js_enabled" value="1" />');

</script>




<!-- DETACH PROTOTYPE -->
<script>
  $(function() {
    // do this after binding any event handlers! 
    prototype = $('.prototype');
    prototype.detach();
    prototype.show();

    window.prototype = prototype;
  });

</script>





<!-- ALWAYS SHOW ONE INTERNSHIP BOX -->
<script>
  $(function() {
    var internshipsCount = $('.internship').size();

    if(internshipsCount == 0) {
      $('#add-internship').trigger('click');

    }

  });
</script>
