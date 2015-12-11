<?php

class Contact_data extends MY_Step_Controller
{
  const stepName = 'contact_data';
  const modelName = 'Contact_data_model';

  public function index()
  {
    $displayErrors = FALSE;

    if(isset($_SESSION['POST'])) {
      $this->form_validation->set_data($_SESSION['POST']); 
      $displayErrors = TRUE;
    }
    else {
      $this->form_validation->set_data($this->{static::modelName}->get()); 
    }

    $this->setRules();
    $this->form_validation->run();

    $this->load->view('layout/top');

    $progressData = array('progression' => $this->lib_progress->getProgression());

    $viewData = array();
    $viewData['predecessorURL'] = $this->lib_progress->predecessorURL(static::stepName);
    $viewData['displayErrors'] = $displayErrors;

    $this->load->view('progress', $progressData);
    $this->load->view('steps/'.static::stepName, $viewData);

    $this->load->view('layout/bottom');
  }


  public function process()
  {
    $this->setRules();

    if($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('POST', $_POST);
      redirect('steps/'.static::stepName);
    }
    else {
      $data = array(
        'adresse' => set_value('adresse'),
        'postleitzahl' => set_value('postleitzahl'),
        'ort' => set_value('ort'),
        'telnummer' => set_value('telnummer')
      );

      $this->{static::modelName}->update($data);
      $this->{static::modelName}->markAsCompleted();
      redirect( $this->lib_progress->successorURL(static::stepName) );
    }
  }


  protected function setRules()
  {
    $this->form_validation->set_rules('adresse', 'Adresse', 'trim|required');
    $this->form_validation->set_rules('postleitzahl', 'Postleitzahll', 'trim|required');
    $this->form_validation->set_rules('ort', 'Ort', 'trim|required');
    $this->form_validation->set_rules('telnummer', 'Ort', 'trim');
  }
}

