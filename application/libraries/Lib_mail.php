<?php

class Lib_mail {
  public function dispatchMail($subject, $recipient, $textContent)
  {
    $message = Swift_Message::newInstance()

    ->setSubject($subject)
    ->setFrom(array('rrze-fachinformatikerausbildung@fau.de' => 'RRZE Ausbildung'))
    ->setTo($recipient)
    ->setBody($textContent);

    $transport = Swift_MailTransport::newInstance();
    $mailer = Swift_Mailer::newInstance($transport);

    return $mailer->send($message);
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
