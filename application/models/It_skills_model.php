<?php

class It_skills_model extends MY_Step_Model
{
  const stepName = 'it_skills';

  protected $concernedColumns = array(
    'kenntnisse_office',
    'kenntnisse_office_txt',

    'kenntnisse_betriebssysteme',
    'kenntnisse_betriebssysteme_txt',

    'kenntnisse_netzwerke',
    'kenntnisse_netzwerke_txt',

    'kenntnisse_hardware',
    'kenntnisse_hardware_txt'
  );


  // TODO streamline?
   public function update($data)
    {
      $this->load->library('lib_session');
      $nummer = $data['bewerbungsnummer'] = $this->lib_session->getNummer();

      $this->db->where('bewerbungsnummer', $nummer);
      $this->db->update($this->tableBewerbung, $data);

      // TODO
      return TRUE;
    }
}
