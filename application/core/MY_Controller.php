<?php

include('MY_Step_Controller.php');

class MY_Controller extends CI_Controller
{

  
  protected function requireLogin()
  {
    $this->load->library('lib_session');

    if(!$this->lib_session->isInitialized()) {
      redirect('login');
      exit;
    }
  }


  protected function requireNoLogin($redirect = NULL)
  {
    $this->load->library('lib_session');

    if($this->lib_session->isInitialized() && $redirect) {
      redirect( $redirect );
      exit;
    }
  }


  protected function showError($message = NULL)
  {
    $this->session->set_flashdata('error_message', $message);
    redirect('error');
  }


  protected function requireNotCompleted()
  {
    $this->load->library('lib_session');
    $this->load->model('Bewerbung_model');

    if($this->Bewerbung_model->isCompleted()) {
      redirect('display/already_completed');
      exit;
    }
  }


}
