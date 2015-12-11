<?php

class Lib_session 
{
  protected $CI;

  function __construct()
  {
    $this->CI = &get_instance();
  }

  public function isInitialized()
  {
    return isset($_SESSION['bewerbungsnummer']);
  }

  public function initialize($nummer)
  {
    $_SESSION['bewerbungsnummer'] = $nummer;

    $this->CI->lib_progress->load();
    $this->CI->lib_progress->initialize();
  }


  public function isCompleted()
  {
    $this->CI->load->model('General_model');

    $data = $this->CI->General_model->getBewerbung();

    return (bool)$data['abgeschlossen'];

  }


  public function markAsCompleted()
  {
    $this->CI->load->model('Bewerbung_model');

    $this->CI->Bewerbung_model->setCompletedStatus(TRUE);
  }


  public function getNummer()
  {
    if(!$this->isInitialized()) {
      throw new Exception('Bewerbung not initialized');
    }

    return $_SESSION['bewerbungsnummer'];
  }
}
