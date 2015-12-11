<?php

class Page extends MY_Controller
{
  // show the home page
  public function index()
  {
    if($this->lib_session->isInitialized()) {
      
      $data = array( 'isCompleted' => $this->lib_session->isCompleted() );

      $this->load->withLayout('pages/start_logged_in', $data);
    }
    else {
      $this->load->withLayout('pages/start_not_logged_in');
    }
  }


  public function hilfe()
  {
    $this->load->withLayout('pages/hilfe');
  }

  public function fragen_und_antworten()
  {
    $this->load->withLayout('pages/fragen_und_antworten');
  }


  public function kontakt()
  {
    $this->load->withLayout('pages/kontakt');
  }


  public function impressum()
  {
    $this->load->withLayout('pages/impressum');
  }
}
