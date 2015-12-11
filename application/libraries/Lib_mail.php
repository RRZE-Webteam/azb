<?php

class Lib_mail {
  public function dispatchMail($subject, $recipient, $textContent)
  {
    $CI = &get_instance();

    $CI->load->library('email');

    $CI->email->from('rrze-fachinformatikerausbildung@fau.de', 'RRZE Ausbildung');
    $CI->email->subject($subject);
    $CI->email->to($recipient);
    $CI->email->message($textContent);


    return $CI->email->send();
  }


  public function assembleMail($bewerbung_data, $content)
  {
    $begruessungen = get_instance()->lib_text->loadTextFragments('mails/begruessungen');

    $viewData = array(
      'bewerbung' => $bewerbung_data,
      'content' => $content,
      'begruessungen' => $begruessungen,
      'signatur' => (string)get_instance()->lib_text->loadText('mails/signatur')
    );

    return get_instance()->load->view('mail_template', $viewData, TRUE);
  }
}
