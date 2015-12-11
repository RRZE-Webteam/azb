<?php

class MY_Loader extends CI_Loader 
{
  public function success($message, $includeLayout=FALSE)
  {
    if($includeLayout) {
      $this->view('layout/top');
    }

    $this->view('notifications/success', array('message' => $message));

    if($includeLayout) {
      $this->view('layout/bottom');
    }
  }


  public function error($message)
  {
    $this->view('notifications/error', array('message' => $message));
  }


  public function withLayout($view, $viewData=array())
  {
    $this->view('layout/top');

    $this->view($view, $viewData);

    $this->view('layout/bottom');
  }

  public function step($stepName, $viewData)
  {
    $this->load->view('layout/top');

    $progressData = array('progress' => $this->lib_progress->getProgression());

    $viewData = array();
    $viewData['predecessorURL'] = $this->lib_progress->predecessorURL($stepName);

    $this->load->view('progress', $progressData);
    $this->load->view('step/'.$stepName, $viewData);

    $this->load->view('layout/bottom');
  }
}
