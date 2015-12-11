<?php

class Complete extends MY_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->requireLogin();
  }


  public function index()
  {
    $this->load->model('Bewerbung_model');

    if($this->Bewerbung_model->isCompleted()) {
      $this->showError('Bewerbung ist bereits abgeschlossen');
    }

    // for each step, get the associated model
    $this->lib_progress->load();
    $stepModels = array();
    foreach($this->lib_progress->getProgression() as $step) {
      $stepModels[] = $step->model;
    }

    // check if something is missing (currently only relevant for uploads)
    $isValid = TRUE;
    foreach($stepModels as $stepModel) {
      $this->load->model($stepModel);

      $this->$stepModel->updateValidity();
      $isValid = $this->$stepModel->isValid() && $isValid;
    }


    // TODO error message
    if(!$isValid) {
      $this->session->set_flashdata('errorMessage', 'Ihre Bewerbung ist unvollständig! (Die entsprechenden Bereiche werden rot markiert)');
      redirect('steps/summary');
      return;
    }

    $this->dispatchConfirmationMail();
    $this->Bewerbung_model->setCompletedStatus( TRUE );

    redirect('/');
  }


  protected function dispatchConfirmationMail()
  {
    $this->load->library('Lib_mail');
    $this->load->model('General_model');

    $data = $this->General_model->getBewerbung($this->lib_session->getNummer());

    $textObject = $this->lib_text->loadText('mails/bewerbung_abgeschlossen');
    $textContent = $this->lib_mail->assembleMail($data, (string)$textObject);

    $this->lib_mail->dispatchMail(
      $this->lib_text->loadTextFragments('mails/betreff')['bewerbung_abgeschlossen'], 
      $data['email'], 
      $textContent
    );

  }

}
