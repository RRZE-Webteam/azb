<?php

require_once 'class_form_array.php';
require_once 'form_field/class_selection_field.php';
require_once 'form_field/class_text_field.php';
require_once 'form_field/codes.php';
require_once 'form_field/class_integer_field.php';
require_once 'form_field/class_date_field.php';


class bewerber extends formArray {
  protected $myBewerbernummer;
  
  function __construct() {     
      //generisches Textfeld zum klonen
      $genericTextField = new textField('name', 64);
      $genericTextField->setFlags(FFF_NONEMPTY, FFFILTER_TRIM);
      
      $fields = array();
      
      $fields[] = new selectionField('anrede', $this->getAnreden());
      $fields[] = $genericTextField->fclone('name');
      $fields[] = $genericTextField->fclone('vorname');
      $fields[] = $genericTextField->fclone('adresse');
      $fields[] = $genericTextField->fclone('ort');
      
      $fields['email'] = new textField('email', 256);
      $fields['email']->setFlags(FFF_EMAIL, FFF_NONEMPTY, FFFILTER_TRIM);
      
      $fields[] = new integerField('postleitzahl', 1000, 99999);
      $fields[] = new dateField('geburtsdatum');
      
      foreach($fields as $field) {
	$this->addField($field);
      }
  }
  
  public function getBewerbernummer() {
    return $this->myBewerbernummer;
  }
  
  private function getAnreden() {
    return array('herr', 'frau', 'keine_angabe', 'unbestimmt');
  }
  
public function save($databaseObj) {
    $myQuery = 
     "INSERT INTO bewerber 
	(anrede, nachname, vorname, adresse, postleitzahl, ort,
	 geburtsdatum, email)
      VALUES
	($1, $2, $3, $4 ,$5, $6 , to_timestamp($7), $8)
      RETURNING bewerbernummer";
      
    pg_prepare($databaseObj, "insert_bewerber", $myQuery);
    
    $values = array(
      $this->anrede->getValue(),
      $this->name->getValue(),
      $this->vorname->getValue(),
      $this->adresse->getValue(),
      $this->postleitzahl->getValue(),
      $this->ort->getValue(),
      $this->geburtsdatum->getValue(),
      $this->email->getValue()
    );
    
    $res = pg_execute($databaseObj, "insert_bewerber", $values);
    
    $row = pg_fetch_row($res);
    $this->myBewerbernummer = $row[0];   
    
    return $this->myBewerbernummer;
  }
}