<?php

class Login extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->requireNoLogin( 'resume' );

    $this->load->library('form_validation');
  }

  public function index()
  {
    $this->load->withLayout('login');
    //
  }

  public function process()
  {
    $this->load->library('lib_session');
    $this->load->model('Login_model');

    $this->setRules();

    if($this->form_validation->run() == FALSE) {
      $this->load->withLayout('login');
      return;
    }


    if(!$this->Login_model->isLoginValid($_POST)) {
      $this->load->withLayout('login', ['error_message' => 'Login fehlgeschlagen']);
      return;
    }


    // so the login data is valid, but ...
    //

    //  ... is the account confirmed?
    if(!$this->Login_model->isConfirmed($_POST)) {
      redirect('display/login_when_unconfirmed');
      return;
    }

    //  ... has the Bewerbung been withdrawn?
    if($this->Login_model->isWithdrawn($_POST)) {
      redirect('display/login_when_withdrawn');
      return;
    }


    $nummer = $this->Login_model->resolveMailAddress($_POST['email']);

    if(!$nummer) {
      throw new Exception('Login valid but e-mail not found');
    }

    $this->lib_session->initialize($nummer);

    redirect('resume');
  }



  protected function setRules()
  {
    $this->form_validation->set_rules('email', 'E-Mail', 'trim|required');
    $this->form_validation->set_rules('passwort', 'Passwort', 'required');
    
  }


}
