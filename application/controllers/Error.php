<?php

class Error extends MY_Controller
{
  public function index()
  {
    $message = isset( $_SESSION['error_message'] ) ?
               $_SESSION['error_message'] : 'Ein Fehler ist aufgetreten';

    $this->load->withLayout('notifications/error', [ 'message' => $message ]);
  }
}
