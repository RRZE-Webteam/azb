<?php

class Register_model extends MY_Model
{
  public function register($data)
  {
    $data['geburtsdatum'] = date('Y-m-d', strtotime($data['geburtsdatum']));
    $data['passwort'] = hash('sha512', $data['passwort']);
    $data['uuid'] = $this->gen_uuid();

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



  // source: http://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
  protected function gen_uuid() {
      return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
          // 32 bits for "time_low"
          mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

          // 16 bits for "time_mid"
          mt_rand( 0, 0xffff ),

          // 16 bits for "time_hi_and_version",
          // four most significant bits holds version number 4
          mt_rand( 0, 0x0fff ) | 0x4000,

          // 16 bits, 8 bits for "clk_seq_hi_res",
          // 8 bits for "clk_seq_low",
          // two most significant bits holds zero and one for variant DCE1.1
          mt_rand( 0, 0x3fff ) | 0x8000,

          // 48 bits for "node"
          mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
      );
  }
}
