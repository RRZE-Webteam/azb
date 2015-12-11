<?php

class It_skills extends MY_Step_Controller
{
  const stepName = 'it_skills';
  const modelName = 'It_skills_model';


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
    $viewData['choicesKenntnisse'] = $this->getKenntnisseChoiceMap();
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
    $choices_kenntnisse = 
      implode(',', array_keys($this->getKenntnisseChoiceMap()));

    $this->form_validation->set_rules(
      'kenntnisse_office',
      'Kenntnisse Office',
      "in_list[$choices_kenntnisse]"
    );

    $this->form_validation->set_rules(
      'kenntnisse_betriebssysteme',
      'Kenntnisse Betriebssysteme',
      "in_list[$choices_kenntnisse]"
    );
    
    $this->form_validation->set_rules(
      'kenntnisse_netzwerke',
      'Kenntnisse Netzwerke',
      "in_list[$choices_kenntnisse]"
    );

    $this->form_validation->set_rules(
      'kenntnisse_hardware',
      'Kenntnisse Hardware',
      "in_list[$choices_kenntnisse]"
    );


    $this->form_validation->set_rules(
      'kenntnisse_office_txt',
      'Beschreibung Office',
      'max_length[10240]|trim'
    );


    $this->form_validation->set_rules(
      'kenntnisse_betriebssysteme_txt',
      'Beschreibung Betriebssysteme',
      'max_length[10240]|trim'
    );

    $this->form_validation->set_rules(
      'kenntnisse_netzwerke_txt',
      'Beschreibung Netzwerke',
      'max_length[10240]|trim'
    );

    $this->form_validation->set_rules(
      'kenntnisse_hardware_txt',
      'Beschreibung Hardware',
      'max_length[10240]|trim'
    );
  }

  protected function getKenntnisseChoiceMap()
  {
    $choices = array(
      '-1' => 'keine Angabe',
      '0' => 'keine Kenntnisse',
      '1' => 'Anfängerkenntnisse',
      '2' => 'Fortgeschrittenenkenntnisse',
      '3' => 'Expertenkenntnisse'
    );

    return $choices;
  }

}
