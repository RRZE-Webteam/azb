<?php

class Other extends MY_Step_Controller
{
  const stepName = 'other';
  const modelName = 'Other_model';


  public function index()
  {
    $displayErrors = FALSE;
    if(isset($_SESSION['POST'])) {
      $this->form_validation->set_data($_SESSION['POST']); 
    }
    else {
      $this->form_validation->set_data($this->{static::modelName}->get()); 
      $displayErrors = TRUE;
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
      $data = $_POST;

      $this->{static::modelName}->update($data);
      $this->{static::modelName}->markAsCompleted();
      redirect( $this->lib_progress->successorURL(static::stepName) );
    }
  }


  protected function setRules()
  {
    $this->form_validation->set_rules(
      'hobbys',
      'Hobbys',
      'max_length[10240]|trim'
    );
  }
}
