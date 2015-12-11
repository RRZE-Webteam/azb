<?php

class Internships extends MY_Step_Controller
{
  const stepName = 'internships';
  const modelName = 'Internships_model';

  protected $internships = array();
  protected $jsEnabled = TRUE;


  public function index()
  {
    if(isset($_SESSION['PRG'])) {
      $this->loadStateFromPreviousRequest();
    }
    else {
      $this->loadInternshipsFromModel();
    }


    $this->load->view('layout/top');

    $progressData = array('progression' => $this->lib_progress->getProgression());

    $viewData = array();
    $viewData['predecessorURL'] = $this->lib_progress->predecessorURL(static::stepName);
    $viewData['internships'] = $this->internships;


    $this->load->view('progress', $progressData);
    $this->load->view('steps/'.static::stepName, $viewData);

    $this->load->view('layout/bottom');
  }


  public function process()
  {
    $this->determineJSEnabled();

    $this->loadInternshipsFromPOST();
    $this->prepInternships();

    if($this->validateInternships() == FALSE) {
      $this->saveStateForNextRequest();
      redirect('steps/'.static::stepName);
    }
    else {
      $this->{static::modelName}->update($this->getOutputForModel());

      $this->{static::modelName}->markAsCompleted();
      redirect( $this->lib_progress->successorURL(static::stepName) );
    }
  }


  protected function loadInternshipsFromModel()
  {
    $praktika = $this->{static::modelName}->get();

    foreach($praktika as $praktikum) {

      $row = array(
        'data' => $praktikum,
        'errors' => $this->getEmptyErrorArray()
      );

      $this->internships[] = $row;
    }
  }


  protected function loadInternshipsFromPOST()
  {
    if($this->isJSEnabled()) {
      $this->loadInternshipsFromPOST_JS();
    }
    else { // no JS
      $this->loadInternshipsFromPOST_noJS();
    }
  }


  protected function loadInternshipsFromPOST_JS()
  {
    $POST = $_POST;
    $indices = array();

    // collect indicies
    foreach($POST as $name=>$value) {
      $matches = array();
      preg_match('/[A-Za-z]+([0-9])+/', $name, $matches);
      
      if( !isset($matches[1]) ) {
        continue;
      }

      $index = $matches[1];
      $indices[] = $index;
    }

    // throw out multiple occurences
    $indices = array_unique($indices);

    foreach($indices as $index) {
      // if anything is missing, ignore and continue
      if( !isset($POST['firma'.$index]) ||
          !isset($POST['dauer'.$index]) ||
          !isset($POST['taetigkeit'.$index]) )
        {
          continue;
        }

      $data = array(
        'firma' => $POST['firma'.$index],
        'dauer' => $POST['dauer'.$index],
        'taetigkeit' => $POST['taetigkeit'.$index]
      );

      $internship = array(
        'data' => $data,
        'errors' => $this->getEmptyErrorArray()
      );

      $this->internships[$index] = $internship;
    }
  }


  protected function loadInternshipsFromPOST_NoJS($POST)
  {
    $POST = $_POST;

    $data = array(
      'firma' => $POST['firma'],
      'dauer' => $POST['dauer'],
      'taetigkeit' => $POST['taetigkeit']
    );

    $internship = array(
      'data' => $data,
      'errors' => $this->getEmptyErrorArray()
    );

    $this->internships = array($internship);
  }


  public function saveStateForNextRequest()
  {
    $this->session->set_flashdata(
      'PRG', array('internships' => $this->internships)
    );
  }


  public function loadStateFromPreviousRequest()
  {
    $this->internships = $_SESSION['PRG']['internships'];
  }


  protected function determineJSEnabled()
  {
    if( !empty($_POST) && isset($_POST['js_enabled']) ) {
      $this->jsEnabled = (string)$_POST['js_enabled'] == '1';
      return;
    }

    if( isset($_SESSION['POST']) && isset($_SESSION['POST']['js_enabled']) ) {
      $this->jsEnabled = (string)$_SESSION['POST']['js_enabled'] == '1';
      return;
    }
  }


  protected function isJSEnabled()
  {
    if($this->jsEnabled === NULL) {
      throw new Exception('js_enabled is undetermined; call determineJSEnabled first');
    }

    return $this->jsEnabled;
  }


  protected function validateInternships()
  {
    $error = FALSE;

    foreach($this->internships as &$internship)
    {
      $errors = &$internship['errors'];
      $data = $internship['data'];

      if( empty($data['firma']) ) {
        $errors['firma'][] = 'Dieses Feld darf nicht leer sein';
        $error = TRUE;
      }

      if( empty($data['taetigkeit']) ) {
        $errors['taetigkeit'][] = 'Dieses Feld darf nicht leer sein';
        $error = TRUE;
      }

      if( empty($data['dauer']) ) {
        $errors['dauer'][] = 'Dieses Feld darf nicht leer sein';
        $error = TRUE;
      }

      if( (string)(int)$data['dauer'] !== (string)$data['dauer'] ) {
        $errors['dauer'][] = 'Bitte geben Sie eine ganze Zahl ein';
        $error = TRUE;

      }
    }

    return !$error;
  }

  protected function getEmptyErrorArray()
  {
    return array(
      'firma' => array(),
      'dauer' => array(),
      'taetigkeit' => array()
    );
  }


  protected function prepInternships()
  {
    foreach($this->internships as &$internship) {
      $data = &$internship['data'];

      $data['dauer'] = trim($data['dauer']);
      $data['firma'] = trim($data['firma']);
      $data['taetigkeit'] = trim($data['taetigkeit']);
    }

  }


  protected function getOutputForModel()
  {
    $output = array();

    foreach($this->internships as $internship) {
      $output[] = $internship['data'];
    }

    return $output;


  }



}
