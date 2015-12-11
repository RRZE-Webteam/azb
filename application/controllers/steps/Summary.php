<?php

class Summary extends MY_Step_Controller
{
  const stepName = 'summary';
  const modelName = 'Summary_model';


  public function index()
  {
    $this->load->model('General_model');
    $this->load->model('Internships_model');
    $this->load->model('Uploads_model');

    // get Bewerbung
    $bewerbung = $this->General_model->getBewerbung();
    // change date format
    $bewerbung['geburtsdatum'] = date('d.m.Y', strtotime($bewerbung['geburtsdatum']));

    // get Praktika
    $bewerbung['praktika'] = $this->Internships_model->get();

    foreach($bewerbung['praktika'] as &$praktikum) {
      if(empty($praktikum)) {
        unset($praktikum); 
        continue;
      }

      $praktikum = (object)$praktikum;
    }

    // get Uploads
    $bewerbung['uploads'] = $this->Uploads_model->get();

    $data = $bewerbung;

    $data['errorMessage'] = @$_SESSION['errorMessage'];
    $this->load->view('layout/top');

    $progressData = array('progression' => $this->lib_progress->getProgression());

    $viewData = $data;
    $viewData['predecessorURL'] = $this->lib_progress->predecessorURL(static::stepName);

    $this->load->view('progress', $progressData);
    $this->load->view('steps/'.static::stepName, $viewData);

    $this->load->view('layout/bottom');
  }

  // there is nothing to process, so ...
  public function process() { }

}
