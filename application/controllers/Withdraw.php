<?php

class Withdraw extends MY_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->requireLogin();
  }


  public function index()
  {
    // show confirm dialog

    $viewData = array(
      'proceed_url' => base_url() . 'withdraw/do_withdraw',
      'cancel_url' =>  base_url(),
      'proceed_label' => 'Bewerbung zurückziehen',
      'message' => 'Möchten Sie Ihre Bewerbung wirklich zurückziehen? Ihr Account wird damit gelöscht!',
      'severity' => 'danger'
    );

    $this->load->withLayout('confirm_dialog', $viewData);
  }


  public function do_withdraw()
  {
    $this->load->model('Bewerbung_model');
    $this->Bewerbung_model->withdrawBewerbung();

    $this->session->sess_destroy();

    redirect('/');
  }
}
