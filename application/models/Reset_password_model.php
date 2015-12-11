<?php

class Reset_password_model extends MY_Model
{
  public function getMostRecentPasswordRequestDate( $bewerbungsnummer )
  {
    $this->db->where('bewerbungsnummer', $bewerbungsnummer)
             ->select('passwort_wiederherstellen_datum');

    $row = $this->db->get($this->tableBewerbung)->row();

    return strtotime($row ? $row->passwort_wiederherstellen_datum : NULL);
  }


  public function requestPasswordReset($bewerbungsnummer)
  {
    $token = md5($bewerbungsnummer . time());

    $this->db->where('bewerbungsnummer', $bewerbungsnummer)
             ->set('passwort_wiederherstellen_datum', date('Y-m-d H:i:s.ue'))
             ->set('passwort_wiederherstellen_token', $token);

    $this->db->update($this->tableBewerbung);

    return $token;
  }


  public function isTokenValid($token)
  {
    $this->db->where('passwort_wiederherstellen_token', $token);

    $query = $this->db->get($this->tableBewerbung);

    return $query->num_rows() > 0;
  }


  public function resolveToken($token)
  {
    $this->db->where('passwort_wiederherstellen_token', $token)
             ->select('bewerbungsnummer');

    $query = $this->db->get($this->tableBewerbung);

    return $query->row()->bewerbungsnummer;
  }


  public function updatePassword($bewerbungsnummer, $password)
  {
    $this->db->where('bewerbungsnummer', $bewerbungsnummer)
             ->set('passwort', hash('sha512', $password));

    $this->db->update($this->tableBewerbung);
  }


  public function invalidateToken($token)
  {
    $this->db->where('passwort_wiederherstellen_token', $token)
             ->set('passwort_wiederherstellen_token', '');

    $this->db->update( $this->tableBewerbung );
  }
}
