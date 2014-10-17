<?php

require_once 'class_form_array.php';
require_once 'form_field/class_selection_field.php';
require_once 'form_field/class_text_field.php';
require_once 'form_field/codes.php';
require_once 'form_field/class_integer_field.php';
require_once 'form_field/class_date_field.php';


class praktikum extends formArray {  
  protected $myBewerbung;
  
  public function linkToBewerbung($bewerbung) {
    $this->myBewerbung = $bewerbung->get_bewerbungsnummer();
  }
  
  function __construct($number) {
    $fields = array();
    
    $fields['firma'] = new textField('firma', 2048);
    $fields['firma']->setFlags(FFF_NONEMPTY, FFFILTER_TRIM);
    
    $fields['taetigkeit'] = $fields['firma']->fclone('taetigkeit');
    
    $fields['dauer'] = new integerField('dauer', 1, 10000);
    $fields['dauer']->setFlags(FFF_NONEMPTY);
    
    //call constructor first!
    parent::__construct(TRUE, $number);
    
    foreach($fields as $field) {
      $this->addField($field);
    }
  }
  
  public function save($databaseObj) {
    $bewerbungsnummer = $this->myBewerbung;
    $num = rand(0, 999999999);
    
    if(!$bewerbungsnummer)
      throw new Exception("Praktikum ist mit keiner Bewerbung verknüpft");
    
    $myQuery = 
     "INSERT INTO praktika 
	(zu_bewerbungsnummer, firma, taetigkeit, dauer)
      VALUES
	($1, $2, $3, $4)";
      
    pg_prepare($databaseObj, "insert_praktikum".$num, $myQuery);
    
    $values = array(
      $bewerbungsnummer,
      $this->firma->getValue(),
      $this->taetigkeit->getValue(),
      $this->dauer->getValue()
    );
    
    print_r($values);
    
    $res = pg_execute($databaseObj, "insert_praktikum".$num, $values);
    
    return $res;
  }
}