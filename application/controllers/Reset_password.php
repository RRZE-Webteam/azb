<?php

class Reset_password extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }


  public function index()
  {
    $this->load->withLayout('reset_password_enter_email');
  }

  
  public function request_password_reset()
  {
    $this->load->model('Reset_password_model');
    $this->load->model('Login_model');
    $this->load->model('General_model');
    $this->load->library('Lib_mail');

    // check the e-mail-address

    $this->form_validation->set_rules('email', 'E-Mail', 'required|trim|valid_email');

    if($this->form_validation->run() == FALSE) {
      $this->load->withLayout('reset_password_enter_email');
      return;
    }


    // get bewerbungsnummer
    $bewerbungsnummer = $this->Login_model->resolveMailAddress($_POST['email']);

    // only if the email exists
    if($bewerbungsnummer) {
      // if the most recent password reset happend > 1 hour ago, display an error
      $mostRecent =
        $this->Reset_password_model->getMostRecentPasswordRequestDate($bewerbungsnummer);

      if( time() - $mostRecent < 3600) {
        $this->showError('Du darfst höchstens 1 Mal pro Stunde ein neues Passwort beantragen.');
        return;
      }


      // assemble password reset mail
      $token = $this->Reset_password_model->requestPasswordReset( $bewerbungsnummer );
      $data = $this->General_model->getBewerbung($bewerbungsnummer);

      $textObject = $this->lib_text->loadText('mails/passwort_vergessen');
      $textObject->bindVariable('link_neues_passwort', 
                                 base_url() . 'reset_password/enter_new_password/' . $token );

      $textContent = $this->lib_mail->assembleMail( $data, (string)$textObject );


      // dispatch password reset mail
      $this->lib_mail->dispatchMail(
        $this->lib_text->loadTextFragments('mails/betreff')['passwort_vergessen'],
        $data['email'], 
        $textContent
      );
    }

    redirect('display/password_reset_request_sent');
  }


  public function enter_new_password($token)
  {
    $this->load->model('Reset_password_model');

    // if token is invalid, display error
    if(!$this->Reset_password_model->isTokenValid($token)) {
      $this->showError('Ungültiges Token.');
      return;
    }

    // save token to session
    $_SESSION['passwordResetToken'] = $token;

    // display reset form
    $this->load->withLayout('reset_password_enter_password');
  }


  public function do_enter_new_password()
  {
    $this->load->model('Reset_password_model');
    
    // check if $_SESSION['passwordResetToken'] is set; if not, display an error
    if( !isset($_SESSION['passwordResetToken']) ) {
      $this->showError('Ungültiges Token.');
      return;
    }

    $token = &$_SESSION['passwordResetToken'];

    $this->form_validation->set_rules('passwort', 'Passwort', 'min_length[8]|required');
    $this->form_validation
         ->set_rules('repasswort', 'Passwort wiederholen', 'matches[passwort]');

    if($this->form_validation->run() == FALSE) {
      $this->load->withLayout('reset_password_enter_password');
      return;
    }


    $bewerbungsnummer = $this->Reset_password_model
                             ->resolveToken($token);


    $this->Reset_password_model->updatePassword($bewerbungsnummer, $_POST['passwort']);
    $this->Reset_password_model->invalidateToken($token);
    unset($token);


    redirect('display/password_reset_success');
  }
}
