<?php

class Register extends MY_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->requireNoLogin( 'resume' );
    $this->load->library('form_validation');
  }


  public function index()
  { 
    if(isset($_SESSION['POST'])) {
      $this->form_validation->set_data($_SESSION['POST']); 
      $this->setRules();
      $this->form_validation->run();
    }

    $viewData = array(
      'choicesAnrede' => $this->getAnredeChoiceMap()
    );

    $this->load->withLayout('register', $viewData);
    //
  }


  public function process()
  {
    $this->load->library('lib_session');
    $this->load->model('Register_model');

    // does user try to re-register when Bewerbung has been withdrawn?
    if( $this->Register_model->emailBelongsToWithdrawnBewerbung( $_POST['email'] ) )
    {
      redirect('display/register_when_withdrawn');
    }

    $this->setRules();

    if($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('POST', $_POST);
      redirect('register');
    }

    // validation suceeded
    $data = $_POST;
    unset($data['repasswort']);

    $nummer = $this->Register_model->register($data);

    if(!$nummer) {
      redirect('error');
      exit;
    }

    $this->dispatchConfirmationMail($nummer);

    redirect('display/registration_complete');
  }

  public function resend_confirmation_mail()
  {
    $email = $_GET['email'];

    $this->load->model('Register_model');
    $nummer = $this->Register_model->resolveMailAddress($email);

    if(!$this->Register_model->isConfirmed($nummer)) {
      $this->dispatchConfirmationMail($nummer);
    }

    redirect('display/resend_confirmation_mail_complete');
  }


  protected function dispatchConfirmationMail($bewerbungsnummer)
  {
    $this->load->library('Lib_mail');
    $this->load->model('General_model');

    $data = $this->General_model->getBewerbung($bewerbungsnummer);

    $textObject = $this->lib_text->loadText('mails/account_bestaetigen');

    $linkUrl = base_url() . 'register/confirm/' . $data['frontendkey'];
    $textObject->bindVariable('link_bestaetigung', $linkUrl);

    $textContent = $this->lib_mail->assembleMail($data, (string)$textObject);

    $this->lib_mail->dispatchMail(
      $this->lib_text->loadTextFragments('mails/betreff')['account_bestaetigen'],
      $data['email'], 
      $textContent
    );
  }

  public function confirm($uuid)
  {
    $this->load->model('Register_model');
    $this->load->library('lib_session');

    $nummer = $this->Register_model->resolveFrontendKey($uuid);

    if(!$nummer) {
      redirect('error');
      exit;
    }

    $this->Register_model->confirmEmail($nummer);

    redirect('display/confirmation_success');
  }



  protected function setRules()
  {
    $this->form_validation
         ->set_rules('geburtsdatum', 'Geburtsdatum', 'callback_validate_geburtsdatum');

    $this->form_validation->set_rules('vorname', 'Vorname', 'trim|required');
    $this->form_validation->set_rules('nachname', 'Nachname', 'trim|required');
    $this->form_validation
         ->set_rules('email', 'E-Mail', 'trim|valid_email|is_unique[bewerbung.email]');
    $this->form_validation->set_rules('passwort', 'Passwort', 'min_length[8]|required');
    $this->form_validation
         ->set_rules('repasswort', 'Passwort wiederholen', 'matches[passwort]');

    $choicesAnrede = implode(',', array_keys($this->getAnredeChoiceMap()));
    $this->form_validation->set_rules('anrede', 'Anrede', "in_list[$choicesAnrede]");
  }


  public function validate_geburtsdatum($value)
  {
    if( empty($value) ) {
      $this->form_validation->set_message(
        'validate_geburtsdatum',
        'Dieses Feld darf nicht leer sein'
      );
      return FALSE;
    }

    if( !strtotime($value) ) {
      $this->form_validation->set_message(
        'validate_geburtsdatum',
        'Ungültiges Datum'
      );
      return FALSE;
    }


    return date('d.m.Y', strtotime($value));

  }


  protected function getAnredeChoiceMap()
  {
    $anrede_choices = array(
      'herr' => 'Herr',
      'frau' => 'Frau',
      'unbestimmt' => 'unbestimmt',
      'keine_angabe' => 'keine Angabe'
    );

    return $anrede_choices;
  }
}

