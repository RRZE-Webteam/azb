<?php $textFragments = $this->lib_text->loadTextFragments('schritte/unterlagen/fragmente'); ?>

  <?php $this->lib_text->loadText('schritte/unterlagen/kopf')->output(); ?>

<div class="alert alert-info">
  <?php echo $this->lib_text->loadTextFragments('schritte/unterlagen/fragmente')['info_dateien']; ?>
</div>

<div class="alert alert-warning">
<span class="glyphicon glyphicon-exclamation-sign"> </span>
  <?php echo $this->lib_text->loadTextFragments('schritte/unterlagen/fragmente')['hinweis_klicke_weiter']; ?>
</div>

<?php
  if(isset($errors)):
  foreach($errors as $error):
?>
  <div class="alert alert-danger"><?=$error;?></div>
<?php
  endforeach;
  endif;
?>

<div class="progress" id="upload-progress" style="display: none">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
  </div>
</div>

<?php echo form_open_multipart('steps/uploads/process', array('name' => 'uploads'));?>

<?php

  $uploadData = array(
    [ 'html_name' => 'Anschreiben', 'text' => $textFragments['titel_anschreiben'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>' ],
    [ 'html_name' => 'Lebenslauf', 'text' => $textFragments['titel_lebenslauf'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>' ],
    [ 'html_name' => 'Foto', 'text' => $textFragments['titel_bewerbungsfoto'] ],
    [ 'html_name' => 'Zeugnisse', 'text' => $textFragments['titel_zeugnisse'] . '<span class="form-required" title="Diese Angabe wird benötigt.">*</span>' ],
    [ 'html_name' => 'Sonstiges', 'text' => $textFragments['titel_sonstiges'] ],
    [ 'html_name' => 'Behindertenausweis', 'text' =>  $textFragments['titel_schwerbehindertenausweis'] ]
  );

  // determine css_id and existing_file from html_name
  foreach($uploadData as &$field) {
    $field['css_id'] = strtolower($field['html_name']);


    if( isset($files[$field['html_name']]) ) {
      $field['existing_file'] = $files[ $field['html_name'] ]['dateiname'];
      $field['upload_id'] = $files[ $field['html_name'] ]['upload_id'];
    }
    else {
      $field['existing_file'] = NULL;
    }
  }

  // display all the upload forms
  foreach($uploadData as $fieldData) {
    $this->load->view('steps/upload_field', $fieldData);
  }

?>

<?php $this->load->view('steps/back_and_forward', array('predecessorURL' => $predecessorURL)); ?>

</form>

<?php

  $uploadDataJSON = json_encode($uploadData);
?>

<script>

$(function() {
  uploadData = <?= $uploadDataJSON; ?>;

  // JSify upload fields
  $.each(uploadData, function(index, uploadField) {
    container = $('#' + uploadField.css_id);

    container.find('.file-input').hide();

    // bind event handlers
    setUpAddControl(container);
    setUpRemoveControlExistingFile( container );
    setUpRemoveControlNewFile( container );


    if(uploadField.existing_file != null) {

      container

      .find('.existing-file')
        .show()
        .data('upload_id', uploadField.upload_id)

      .find('.file-info').text( uploadField.existing_file );

    } else {
      container.find('.add-file').show();
    }
  });


  // bind to form.onSubmit event
  $('form[name="uploads"]').submit( function() { overrideFormAction(); return false; });


  window.onbeforeunload = function() { return leavePage(); }

});


function callFunctionWhenFileSelected(element, functionToCall)
{
  if($(element).val() != '') {
    functionToCall();
    return;
  }

  setTimeout(function() { callFunctionWhenFileSelected(element, functionToCall); }, 2000);

}



function overrideFormAction()
{
  // when upload starts, user should confirm leaving the page
  setShowLeaveConfirmation();

  // upload progress ------
  $('#upload-progress').show();

  progressHandler = function(data) {
    percentVal = Math.round(data.loaded / data.total * 100);
    $('#upload-progress > .progress-bar').attr('aria-valuenow', percentVal )
                                         .css('width', String(percentVal) + '%')
  };

  // ------

  xhrHandler = function() {
    var myXhr = $.ajaxSettings.xhr();

    if(myXhr.upload) {
      myXhr.upload.addEventListener('progress', progressHandler, false);
    }

    return myXhr;
  };

  // ajax request was successful; "fake" loading the next step 
  // by replacing document with the ajax response
  successHandler = function(result) {
    unsetShowLeaveConfirmation();

    var newDoc = document.open("text/html", "replace");
    newDoc.write(result);
    newDoc.close();
  };

  var form = $('form[name="uploads"]');
  var formData = new FormData( form[0] );

  $.ajax({
    url: form.attr('action'),  //Server script to process data
    type: 'POST',
    xhr:  xhrHandler,
    //Ajax events
    success: successHandler,
    // Form data
    data: formData,
    //Options to tell jQuery not to process data or worry about content-type.
    cache: false,
    contentType: false,
    processData: false
  });
}



function setUpAddControl(container)
{
  $( container ).find('.add-file').click(function() {
    setShowLeaveConfirmation();
    // show file dialog
    $( container ).find('.file-input').trigger('click');


    fileInput = $( container ).find('input.file-input');
    
    callFunctionWhenFileSelected(fileInput,  function() {
      filename = '...';

      $( container ).find('.new-file').show()
                    .find('.file-info').text(filename);

      $( container ).find('.add-file').hide();
    });

  });
}


function setUpRemoveControlExistingFile( container )
{
  $( container ).find('.existing-file > .remove-file').click( function() {
    // show confirmation dialog TODO

      eventHandler = function(result) {
        if(result == '1') {
          $( container ).find('.existing-file').hide()
                        .find('.file-info').empty();

          $( container ).find('.add-file').show();
        }
      };

      uploadId = $( container ).find('.existing-file').data('upload_id');

      $.get('<?= base_url(); ?>steps/uploads/ajax_remove_file/' + uploadId, eventHandler);
  });

}


function setUpRemoveControlNewFile( container )
{
  $( container ).find('.new-file > .remove-file').click( function() {
    // show confirmation dialog TODO
    //

    $( container ).find('.new-file').hide()
                  .find('.file-info').empty();

    $( container ).find('.file-input').val('');

    $( container ).find('.add-file').show();

  });
}



function setShowLeaveConfirmation()
{
  window.showLeaveConfirmation = true;
}

function unsetShowLeaveConfirmation()
{
  window.showLeaveConfirmation = false;
}

function leavePage()
{
  if( typeof(window.showLeaveConfirmation) != 'undefined'
    && window.showLeaveConfirmation ) {

      return 'Es gibt nicht-gespeicherte Änderungen. Seite wirklich verlassen?';
  }

}



</script>
