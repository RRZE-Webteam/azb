<?php

// wird eingebunden in MY_Controller.php

class MY_Step_Controller extends MY_Controller
{
  const stepNAme = 'OVERRIDE_ME_PLEASE';
  const modelName = 'OVERRIDE_ME_PLEASE';

  function __construct()
  {
    parent::__construct();

    $this->lib_progress->load();
    $this->lib_progress->setCurrentStep(static::stepName);
    $this->lib_progress->initialize();

    $this->requireLogin();
    $this->requireNotCompleted();
    $this->requirePreviousStepsCompleted( static::stepName );

    $this->load->model(static::modelName);

    $this->load->library('form_validation');
  }



  protected function requirePreviousStepsCompleted( $stepName )
  {
    if( ! $this->lib_progress->previousStepsCompleted( $stepName) ) {
      $this->session->set_flashdata('error_message', 'Permission denied');
      redirect('error');
    }

  }



}
