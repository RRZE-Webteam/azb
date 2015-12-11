<?php

class Uploads extends MY_Step_Controller
{
  const stepName = 'uploads';
  const modelName = 'Uploads_model';

  public function index()
  {
    $this->load->model('Uploads_model');

    $viewData = array('files' => $this->Uploads_model->get());
    $this->loadView($viewData);
  }


  public function process()
  {
    $this->load->model('Uploads_model');
    $this->load->library('upload');

    $uploadNames = $this->Uploads_model->getUploadNames();

    $errors = array();
    $success = TRUE;

    foreach($uploadNames as $uploadName):
      // check if there is a file attached concerning $uploadName
      if( !isset($_FILES[$uploadName]) || $_FILES[$uploadName]['size'] == 0) 
        continue;

      // UPLOAD to temp directory
      if( ! $this->upload->do_upload($uploadName) ) {
        $errors[$uploadName] = $this->upload->display_errors();
        continue;
      }

      // get upload meta data
      $upload = array();
      $upload['path'] = $full_path = $this->upload->data('full_path');
      $upload['filename'] =  htmlentities($_FILES[$uploadName]['name']);

      // update the DB
      $success = $this->Uploads_model->update( array($uploadName => $upload) )
                && $success;

      // delete the temp files
      unlink( $this->upload->data('full_path') );
    endforeach;

    // >> uploading finished <<

    $this->Uploads_model->updateValidity();


    // check requirements
    if(!$this->checkRequiredUploads()) {
      $errors[] = $this->assembleMissingUploadsMessage();
    }

    // if there are any errors, display them
    if(!empty($errors)) {
      $viewData = array(
        'files' => $this->Uploads_model->get(),
        'errors' => $errors
      );

      $this->loadView( $viewData );
      return;
    }


    // if there are any database-related errors
    if(!$success) {
      redirect('error');
      return;
    }


    // all went well
    $this->Uploads_model->markAsCompleted();
    redirect( $this->lib_progress->successorURL() );
  }


  protected function loadView($viewData = array())
  {
    $this->load->view('layout/top');

    $progressData = array('progression' => $this->lib_progress->getProgression());

    $viewData['predecessorURL'] = $this->lib_progress->predecessorURL(static::stepName);

    $this->load->view('progress', $progressData);
    $this->load->view('steps/'.static::stepName, $viewData);

    $this->load->view('layout/bottom');
  }



  public function ajax_remove_file($uploadId)
  {
    $this->load->model('Uploads_model');

    $result = $this->Uploads_model->removeFile($uploadId) ? '1' : '0';

    $this->Uploads_model->updateValidity();

    echo $result;
  }



  protected function checkRequiredUploads()
  {
    $this->load->model('Uploads_model');


    foreach($this->Uploads_model->requiredUploads as $subjekt) {
      $existingUpload = $this->Uploads_model->getBySubjekt($subjekt);
      $newUpload = isset($_FILES[$subjekt]) && $_FILES[$subjekt]['size'] > 0;

      if( !$existingUpload && !$newUpload ) {
        return FALSE;
      }
    }

    return TRUE;
  }


  protected function assembleMissingUploadsMessage()
  {
    $this->load->model('Uploads_model');

    $requiredUploads = $this->Uploads_model->requiredUploads;

    $message = implode(', ', array_slice($requiredUploads, 0, -1));
    $message .= ' und ' . end($requiredUploads);

    $message .= ' müssen vorliegen.';

    return $message;
  }


}
