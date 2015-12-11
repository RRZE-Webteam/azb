<?php

class Education extends MY_Step_Controller
{
  const stepName = 'education';
  const modelName = 'Education_model';


  public function index()
  {
    $displayErrors = FALSE;

    if(isset($_SESSION['POST'])) {
      $this->form_validation->set_data($_SESSION['POST']); 
      $displayErrors = TRUE;
    }
    else {
      $this->form_validation->set_data($this->{static::modelName}->get()); 
    }

    $this->setRules();
    $this->form_validation->run();

    $this->load->view('layout/top');

    $progressData = array('progression' => $this->lib_progress->getProgression());

    $viewData = array();
    $viewData['predecessorURL'] = $this->lib_progress->predecessorURL(static::stepName);
    $viewData['displayErrors'] = $displayErrors;

    $viewData['choices_angestrebter_abschluss'] = 
      $this->getAngestrebterAbschlussChoiceMap();

    $viewData['choices_erworbener_abschluss'] = 
      $this->getErworbenerAbschlussChoiceMap();

    $this->load->view('progress', $progressData);
    $this->load->view('steps/'.static::stepName, $viewData);

    $this->load->view('layout/bottom');
  }


  public function process()
  {
    $this->setRules();

    if($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('POST', $_POST);
      redirect('steps/'.static::stepName);
    }
    else {
      $data = $_POST;

      $this->{static::modelName}->update($data);
      $this->{static::modelName}->markAsCompleted();
      redirect( $this->lib_progress->successorURL(static::stepName) );
    }
  }


  protected function setRules()
  {
    $choices_abschluss = 
      implode(',', array_keys($this->getAngestrebterAbschlussChoiceMap()));

    $this->form_validation->set_rules(
      'angestrebter_abschluss',
      'Angestrebter Abschluss',
      "in_list[$choices_abschluss]"
    );

    $this->form_validation->set_rules(
      'erworbener_abschluss',
      'Erworbener Abschluss',
      "in_list[$choices_abschluss]"
    );

    $this->form_validation->set_rules(
      'notendurchschnitt_schulabschluss',
      'Notendurchschnitt',
      'callback_validate_notendurchschnitt'
    );


    $this->form_validation->set_rules(
      'berufsausbildung',
      'Berufsausbildung/Studium',
      'max_length[10240]|trim'
    );


    $this->form_validation->set_rules(
      'note_deutsch',
      'Note Deutsch',
      array(
        'greater_than_equal_to[1]',
        'less_than_equal_to[6]',
        'integer',
        'required'
      )
    );

    $this->form_validation->set_rules(
      'note_englisch',
      'Note Englisch',
      array(
        'greater_than_equal_to[1]',
        'less_than_equal_to[6]',
        'integer',
        'required'
      )
    );


    $this->form_validation->set_rules(
      'note_mathematik',
      'Note Mathematik',
      array(
        'greater_than_equal_to[1]',
        'less_than_equal_to[6]',
        'integer',
        'required'
      )
    );


    $this->form_validation->set_rules(
      'note_informatik',
      'Note Informatik',
      array(
        'greater_than_equal_to[1]',
        'less_than_equal_to[6]',
        'integer'
      )
    );
  }


  protected function getAngestrebterAbschlussChoiceMap()
  {
    $schulabschluesseText = $this->lib_text->loadTextFragments('schritte/schulabschluesse');

    $abschluesse_angestrebt = array(
      'qualizifierender_hauptschulabschluss' 
        => $schulabschluesseText['qualizifierender_hauptschulabschluss'],
      'mittlerer_bildungsabschluss' 
        => $schulabschluesseText['mittlerer_bildungsabschluss'],
      'fachabitur' 
        => $schulabschluesseText['fachabitur'],
      'abitur' 
        => $schulabschluesseText['abitur'],
      'keiner'
        => $schulabschluesseText['keiner_angestrebt']
    );

    return $abschluesse_angestrebt;
  }


  protected function getErworbenerAbschlussChoiceMap()
  {
    $schulabschluesseText = $this->lib_text->loadTextFragments('schritte/schulabschluesse');

    $abschluesse_erworben = array(
      'qualizifierender_hauptschulabschluss' 
        => $schulabschluesseText['qualizifierender_hauptschulabschluss'],
      'mittlerer_bildungsabschluss' 
        => $schulabschluesseText['mittlerer_bildungsabschluss'],
      'fachabitur' 
        => $schulabschluesseText['fachabitur'],
      'abitur' 
        => $schulabschluesseText['abitur'],
      'keiner'
        => $schulabschluesseText['keiner_erworben']
    );

    return $abschluesse_erworben;
  }


  public function validate_notendurchschnitt($value)
  {
    // TODO ugly; is there really no better way?
    if( set_value('erworbener_abschluss') == 'keiner' ) {
      return TRUE;
    }

    if( empty($value) ) {
      $this->form_validation->set_message('validate_notendurchschnitt',
        'Feld darf nicht leer sein');
      return FALSE;
    }

    if( (float)$value == 0 ) {
      $this->form_validation->set_message('validate_notendurchschnitt',
        'Bitte eine Zahl in Dezimaldarstellung angeben');
      return FALSE;
    }

    if( $value < 1 or $value > 6) {
      $this->form_validation->set_message('validate_notendurchschnitt',
        'Bitte eine Dezimalzahl zwischen 1 und 6 eingeben');
      return FALSE;
    }


    $value = str_replace(',', '.', $value);
    return round((float)$value, 2);

  }

}

