<?php

class Uploads_model extends MY_Step_Model
{
  const stepName = 'uploads';

  public $requiredUploads = array('Anschreiben', 'Lebenslauf', 'Zeugnisse');

  protected $uploadNames = array(
    'Foto', 
    'Lebenslauf', 
    'Anschreiben',
    'Zeugnisse',
    'Sonstiges',
    'Behindertenausweis'
  );

  public function update($data) //overrides parent::update()
  {
    $result = TRUE;

    //QUERY
    $query = '
      INSERT INTO %s 
        (subjekt, content, dateiname, zu_bewerbung)
      VALUES
        (:subjekt, :content, :dateiname, :nummer)
    ';

    $query = sprintf($query, $this->tableUploads);

    $PDO = $this->db->conn_id;
    $PDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

    $st = $this->db->conn_id->prepare($query);

    // NUMMER
    $st->bindValue('nummer', $this->getNummer());

    // REMANING
    foreach($data as $key=>&$upload) {
      $st->bindParam('subjekt', $key);
      $st->bindParam('dateiname', $upload['filename']);

      $raw = file_get_contents($upload['path']);
      //$content = str_replace(array("\\\\", "''"), array("\\", "'"), pg_escape_bytea($raw));

      $st->bindParam('content', $raw, PDO::PARAM_LOB);

      $result = $st->execute() && $result;
    }

    return $result;
  }


  public function get() //overrides parent::get()
  {
    $uploads = array_fill_keys( $this->getUploadNames(), NULL );

    foreach($uploads as $subjekt=>&$upload) {
      $select = array(
        'zu_bewerbung' => $this->getNummer(),
        'subjekt' => $subjekt
      );

      $this->db->where($select);

      $result = $this->db->get($this->tableUploads)->result();
      $result = (array)array_shift($result);

      if( $result ) {
        $upload = $result;
      }
    }


    return $uploads;
  }


  public function getBySubjekt($subjekt)
  {
    $select = array(
      'zu_bewerbung' => $this->getNummer(),
      'subjekt' => $subjekt
    );

    $this->db->where($select);

    $result = $this->db->get($this->tableUploads)->result();
    return array_shift($result);
  }


  public function clearBySubjekt($subjekt)
  {
    $select = array(
      'zu_bewerbung' => $this->getNummer(),
      'subjekt' => $subjekt
    );

    $this->db->where($select)
             ->delete($this->tableUploads);
  }


  public function removeFile($uploadId)
  {
    $select = array(
      'zu_bewerbung' => $this->getNummer(),
      'upload_id' => $uploadId
    );

    $this->db->where($select)
             ->delete($this->tableUploads);


    return $this->db->affected_rows() > 0;
  }


  public function getUploadNames()
  {
    return $this->uploadNames;
  }


  public function updateValidity()
  {
    $isValid = $this->isValid();

    $nummer = $this->getNummer();

    $this->db->where('bewerbungsnummer', $nummer);

    $this->db->update(
      $this->tableBewerbung, 
      array( 'invalid_uploads' => !$isValid)
    );
  }


  public function isValid()
  {
    $isValid = TRUE;

    foreach($this->requiredUploads as $upload) {
      $isValid = (bool)$this->getBySubjekt($upload) && $isValid;
    }

    return $isValid;
  }

}
