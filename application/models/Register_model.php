<?php

class Register_model extends MY_Model
{
  public function register($data)
  {
    $data['geburtsdatum'] = date('Y-m-d', strtotime($data['geburtsdatum']));
    $data['passwort'] = hash('sha512', $data['passwort']);

    $this->db->conn_id->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $queryString = $this->db
                   ->set($data)
                   ->get_compiled_insert($this->tableBewerbung);

    $queryString .= ' RETURNING bewerbungsnummer';

    // resort to PDO
    $db = $this->db->conn_id;
    $query = $db->query($queryString);

    return $query->fetchColumn();
  }


  public function resolveFrontendKey($frontendKey)
  {
    $this->db->select('bewerbungsnummer');
    $this->db->where('frontendkey', $frontendKey);

    $query = $this->db->get($this->tableBewerbung);

    return ($query->num_rows() > 0) ? $query->row()->bewerbungsnummer : NULL;
  }


  public function emailBelongsToWithdrawnBewerbung($email)
  {
    $this->db->where('email', $email)
             ->where('zurueckgezogen', TRUE);

    $query = $this->db->get($this->tableBewerbung);

    return ($query->num_rows() > 0);

  }


  public function emailExists($email)
  {
    return $this->rowExists( array('email' => $email) );
  }


  public function confirmEmail($nummer = NULL)
  {
    if(!$nummer)
      $nummer = $this->getNummer();

    $data = array(
      'ist_bestaetigt' => TRUE,
      'frontendkey' => NULL
    );

    $this->db->where('bewerbungsnummer', $nummer);
    $this->db->update($this->tableBewerbung, $data);
  }


  public function isConfirmed($bewerbungsnummer)
  {
    $row = $this->getRow($nummer);

    if(!$row) {
      throw new Exception('Row does not exist');
    }

    return !$row['ist_bestaetigt'];
  }

}
