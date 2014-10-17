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
    $pdf = array('pdf');
    
    $fields['bewerbungsbild'] = new imageUploadField('bewerbungsbild', 
      1024, 1024, 4096);
    $fields['bewerbungsbild']->setFlags(FFF_NONEMPTY);
    
    $fields['bewerbungsunterlagen'] = new uploadField('bewerbungsunterlagen', 
      $pdf, 10240);
    $fields['bewerbungsunterlagen']->setFlags(FFF_NONEMPTY);
    
    $fields['behindertenausweis'] = 
      new uploadField('behindertenausweis', $pdf, 10240);
    
    foreach($fields as $field) {
      $this->addField($field);
    }
  }
  
  public function save($databaseObj, $path) {
    $bewerbungsnummer = $this->myBewerbung;
    $this->bewerbungsbild->convertToJpeg();
    
    $subjects = array('bewerbungsbild', 'bewerbungsunterlagen', 
      'behindertenausweis');
      
    foreach($subjects as $subject) {
      $field = $this->{$subject};
      
      $myQuery = 
      "INSERT INTO uploads 
	  (subjekt, dateiname, speicherort, zu_bewerbung)
	VALUES
	  ($1, $2, $3, $4)
	RETURNING upload_id";
	
	pg_prepare($databaseObj, "insert_".$subject, $myQuery);
	
	$fileInfo = $field->getValue();
	
	$values = array($subject, $fileInfo['name'], $path, 
	  $bewerbungsnummer);
	
	$res = pg_execute($databaseObj, "insert_".$subject, $values);
	
	$row = pg_fetch_row($res);
	$uploadId = $row[0];
	
	$fileInfo = $field->getValue();
	$ext = $field->getType();
	
	move_uploaded_file($fileInfo['tmp_name'], $path.$uploadId.'.'.$ext);
    }
  }
}