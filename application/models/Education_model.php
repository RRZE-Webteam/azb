<?php

class Education_model extends MY_Step_model
{
  const stepName = 'education';

  protected $concernedColumns = array(
    'angestrebter_abschluss',
    'erworbener_abschluss',
    'notendurchschnitt_schulabschluss',
    'berufsausbildung',
    'note_deutsch',
    'note_englisch',
    'note_mathematik',
    'note_informatik'
  );


  public function update($data)
  {
    $data['note_informatik'] = (int)$data['note_informatik'];
    $data['notendurchschnitt_schulabschluss'] = 
      round($data['notendurchschnitt_schulabschluss'], 2);

    return parent::update($data);
  }


  public function get()
  {
    $data = parent::get();

    if((int)$data['note_informatik'] == 0) {
      $data['note_informatik'] = NULL;
    }

    return $data;
  }

}
