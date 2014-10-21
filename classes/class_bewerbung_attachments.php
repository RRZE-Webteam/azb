<?php

require_once 'class_form_array.php';
require_once 'form_field/class_upload_field.php';
require_once 'form_field/class_image_upload_field.php';


class bewerbungAttachments extends formArray {  
  protected $myBewerbung;
  
  public function linkToBewerbung($bewerbung) {
    $this->myBewerbung = $bewerbung->get_bewerbungsnummer();
  }
  function __construct() {
    $fields = array();
    $types = array('pdf', 'jpg', 'jpeg', 'doc', 'docx', 'png');
    
    $genericUploadField = new uploadField('generic', $types, 10240);
    $genericUploadField->setFlags(FFF_NONEMPTY);
    
    $fields[] = $genericUploadField->fclone('bewerbungsbild');
    $fields[] = $genericUploadField->fclone('lebenslauf');
    $fields[] = $genericUploadField->fclone('anschreiben');
    $fields[] = $genericUploadField->fclone('zeugnisse');
    $fields[] = $genericUploadField->fclone('sonstiges');
    
    $behindertenausweis = $fields[] = 
      $genericUploadField->fclone('behindertenausweis');
    $behindertenausweis->unsetFlag(FFF_NONEMPTY);


    foreach($fields as $field) {
      $this->addField($field);
    }
  }
  
  public function save($databaseObj, $path) {
    $bewerbungsnummer = $this->myBewerbung;
    
    $subjects = array('bewerbungsbild', 'lebenslauf', 
      'anschreiben', 'zeugnisse', 'sonstiges', 'behindertenausweis');
      
    foreach($subjects as $subject) {
      $field = $this->{$subject};
      
      $myQuery = 
      "INSERT INTO uploads 
	  (subjekt, dateiname, content, mime_type, zu_bewerbung)
	VALUES
	  ($1, $2, $3, $4, $5)
	RETURNING upload_id";
	
	pg_prepare($databaseObj, "insert_".$subject, $myQuery);
	
	$fileInfo = $field->getValue();
	
	$content = pg_escape_bytea(file_get_contents($fileInfo['tmp_name']));
	$mimeType = system("file -i -b ".$fileInfo['tmp_name']);
	
	if(empty($content))
	  continue;
	
	$values = array($subject, $fileInfo['name'], $content, $mimeType,
	  $bewerbungsnummer);
	
	$res = pg_execute($databaseObj, "insert_".$subject, $values);
	
	$row = pg_fetch_row($res);
	$uploadId = $row[0];
	
	$fileInfo = $field->getValue();
	$ext = $field->getType();

    }
  }
}