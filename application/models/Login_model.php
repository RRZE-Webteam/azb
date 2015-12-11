<?php

class Login_model extends MY_Model
{
  public function resolveMailAddress($email)
  {
    $this->db->select('bewerbungsnummer');
    $this->db->where('email', $email);

    $query = $this->db->get($this->tableBewerbung);

    return ($query->num_rows() > 0) ? $query->row()->bewerbungsnummer : NULL;
  }

  public function isLoginValid($data)
  {
    $data = array(
      'email' => $data['email'],
      'passwort' => $this->getPasswordHash($data['passwort'])
    );

    return $this->rowExists($data);
  }

  public function isConfirmed($data)
  {
    $data = array(
      'email' => $data['email'],
      'passwort' => $this->getPasswordHash($data['passwort']),
      'ist_bestaetigt' => TRUE
    );

    return $this->rowExists($data);
  }


  public function isWithdrawn($data)
  {
    $data = array(
      'email' => $data['email'],
      'passwort' => $this->getPasswordHash($data['passwort']),
      'zurueckgezogen' => TRUE
    );

    return $this->rowExists($data);
  }


  protected function getPasswordHash($password)
  {
    return hash('sha512', $password);
  }



}
