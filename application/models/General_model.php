<?php

class General_model extends MY_Model
{
  public function getBewerbung($bewerbungsnummer = NULL)
  {
    if(!$bewerbungsnummer) {
      $bewerbungsnummer = $this->getNummer();
    }

    return $this->getRowWhere( array('bewerbungsnummer' => $bewerbungsnummer) );
  }

}
