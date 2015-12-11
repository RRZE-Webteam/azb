<?php

class Internships_model extends MY_Step_Model
{
  const stepName = 'internships';

  public function update($data) // overrides parent::update()
  {
    $this->load->library('lib_session');
    $nummer = $this->lib_session->getNummer();

    $this->db->trans_start();

    $this->clearInternships($nummer);

    foreach($data as $internship) {
      $this->addInternship($internship, $nummer);
    }

    $this->db->trans_complete();

    return (bool)$this->db->trans_status();
  }


  protected function addInternship($data, $bewerbungsnummer)
  {
    $data['zu_bewerbung'] = $bewerbungsnummer;

    $this->db->where('bewerbungsnummer', $bewerbungsnummer);
    $this->db->insert($this->tablePraktika, $data);
  }


  protected function clearInternships($bewerbungsnummer)
  {
    $this->db->where('zu_bewerbung', $bewerbungsnummer)
             ->delete($this->tablePraktika);
  }


  public function get() // overrides parent::get()
  {
    $nummer = $this->getNummer();

    $this->db->where('zu_bewerbung', $nummer);
    $result_array = $this->db->get( $this->tablePraktika )->result_array();

    foreach($result_array as &$result) {
      unset($result['zu_bewerbung']);
    }

    return $result_array;
  }


}
