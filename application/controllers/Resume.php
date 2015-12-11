<?php

class Resume extends MY_Controller
{
  public function index()
  {
    $this->requireLogin();

    if($this->lib_session->isCompleted()) {
      redirect('page');
      return;
    }
    
    $this->lib_progress->load();
    $firstIncompleteStep = $this->lib_progress->getFirstIncompleteStep();

    $url = base_url() . $firstIncompleteStep->url;
    redirect($url);
  }
}
