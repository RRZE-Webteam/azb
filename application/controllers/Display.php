<?php

class Display extends MY_Controller
{
  // TODO that redundancy
  //
  public function confirmation_success()
  {
    $this->load->withLayout('notifications/confirmation_success');
  }

  public function registration_complete()
  {
    $this->load->view('notifications/registration_complete');
  }

  public function resend_confirmation_mail_complete()
  {
    $message = 'Bestätigungs-Mail verschickt';
    $this->load->success($message, TRUE);
  }

  public function login_when_withdrawn()
  {
    $this->load->withLayout('notifications/login_when_withdrawn');
  }

  public function already_completed()
  {
    $this->load->withLayout('notifications/already_completed');
  }

  public function login_when_unconfirmed()
  {
    $this->load->withLayout('notifications/login_when_unconfirmed');
  }


  public function register_when_withdrawn()
  {
    $this->load->withLayout('notifications/register_when_withdrawn');
  }

  public function password_reset_request_sent()
  {
    $this->load->withLayout('notifications/password_reset_request_sent');
  }


  public function password_reset_success()
  {
    $this->load->withLayout('notifications/password_reset_success');
  }
}
