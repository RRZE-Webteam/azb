<?php

// TODO "autoload..."
include(APPPATH.'core/MY_Step_model.php');

class MY_Model extends CI_Model
{
  // TODO into config?
  protected $tableBewerbung = 'bewerbung';
  protected $tablePraktika = 'praktika';
  protected $tableUploads = 'uploads';

  // TODO ugly. move somewhere else
  public function renameKey(&$array, $keyOld, $keyNew)
  {
    foreach($array as $key=>$value) {
      if($key!=$keyOld) continue;

      $array[$keyNew] = $value;
      unset($array[$keyOld]);
      break;
    }
  }


  protected function rowExists($data, $table = NULL)
  {
    if(!$table) $table = $this->tableBewerbung;

    $this->db->where($data);
    $query = $this->db->get($table);

    return ($query->num_rows() > 0);
  }


  protected function getRowWhere($data, $table = NULL)
  {
    if(!$table) $table = $this->tableBewerbung;

    $this->db->where($data);
    $query = $this->db->get($table);

    return ($query->num_rows() > 0) ? $query->row_array() : NULL;
  }



  protected function getNummer()
  {
    $this->load->library('lib_session');
    $nummer = $this->lib_session->getNummer();

    return $nummer;
  }


}

