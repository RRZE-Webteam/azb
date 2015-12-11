<?php

class Bewerbung_model extends MY_Model
{
  public function setCompletedStatus($value = TRUE)
  {
    $nummer = $this->getNummer();

    $this->db->where('bewerbungsnummer', $nummer);
    $this->db->update($this->tableBewerbung, array( 'abgeschlossen' => $value ));
  }


  public function withdrawBewerbung()
  {
    $nummer = $this->getNummer();

    $this->db->where('bewerbungsnummer', $nummer);
    $this->db->update($this->tableBewerbung, array( 'zurueckgezogen' => TRUE ));
  }

  public function isCompleted()
  {
    $nummer = $this->getNummer();

    $this->db->where('bewerbungsnummer', $nummer)
             ->select('abgeschlossen');

    return (bool)$this->db->get( $this->tableBewerbung )->row()->abgeschlossen;

  }

}
