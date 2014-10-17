<?php

require_once 'class_form_array.php';
require_once 'form_field/class_selection_field.php';
require_once 'form_field/class_text_field.php';
require_once 'form_field/codes.php';
require_once 'form_field/class_integer_field.php';
require_once 'form_field/class_date_field.php';


class bewerbung extends formArray {
  protected $myAttachments;
  protected $myPraktika;
  protected $myBewerber;
  
  protected $myBewerbungsnummer;
  
  function __construct() {
    $this->myPraktika = array();
    
    $genericIntegerField = new integerField('generic', 0, 6);
    $genericIntegerField->setFlags(FFF_NONEMPTY);
    
    $genericTextArea = new textField('hobbys', 2048);
    $genericTextArea->setFlags(FFFILTER_TRIM);
    
    $fields = array();
    
    $fields['angestrebter_abschluss'] = 
      new selectionField('angestrebter_abschluss', 
			 $this->get_schulabschluesse());
    $fields[] =	$fields['angestrebter_abschluss']
		->fclone('erworbener_abschluss');
    
    $fields[] = $genericIntegerField->fclone('note_deutsch');
    $fields[] = $genericIntegerField->fclone('note_englisch');
    $fields[] = $genericIntegerField->fclone('note_mathematik');
    $fields[] = $genericIntegerField->fclone('note_informatik');      
    
    $fields['hobbys'] = new textField('hobbys', 2048);
    $fields['hobbys']->setFlags(FFF_NONEMPTY, FFFILTER_TRIM);
    
    $fields[] = $genericTextArea->fclone('berufsausbildung');
    $fields[] = $genericTextArea->fclone('studium');
    
    $fields['notendurchschnitt'] = 
      new textField('notendurchschnitt_schulabschluss', 4);
    $fields['notendurchschnitt']->setFlags(FFFILTER_TRIM);
    
    foreach($fields as $field) {
      $this->addField($field);
    }
  }
  
  public function validate($objector) {
    foreach($this->myPraktika as $praktikum) {
      $praktikum->validate($objector);
    }
    
    $this->myBewerber->validate($objector);
    $this->myAttachments->validate($objector);
    
    parent::validate($objector);
  }
  
  private function get_schulabschluesse() {
    return array('abitur', 'fachabitur', 'mittlerer_bildungsabschluss', 
		 'qualifizierender_hauptschulabschluss', 'keiner');
  }
  
  public function get_bewerbungsnummer() {
    if(!isset($this->myBewerbungsnummer))
      return FALSE;
    else {
      return $this->myBewerbungsnummer;
    }
    
  }
  
  public function addPraktikum(&$praktikum) {
    $this->myPraktika[] = $praktikum;
  }
  
  public function setAttachments(&$attachmentsObj) {
    $this->myAttachments = $attachmentsObj;
  }  
  
  public function setBewerber(&$bewerber) {
    $this->myBewerber = &$bewerber;
  }
  
  public function save($databaseObj, $uploadDir) {
    $bewerbernummer = $this->myBewerber->save($databaseObj);
    
    $myQuery = 
     "INSERT INTO bewerbungen 
	(note_deutsch, note_englisch, 
	note_mathematik, note_informatik, hobbys, studium, berufsausbildung, 
	angestrebter_abschluss, erworbener_abschluss, 
	notendurchschnitt_schulabschluss, bewerbernummer)
      VALUES
	($1, $2, $3, $4, $5 ,$6, $7 , $8, $9, $10, $11)
      RETURNING bewerbungsnummer";
      
    pg_prepare($databaseObj, "insert_bewerbung", $myQuery);
    
    $notendurchschnitt = str_replace(',', '.', 
	  $this->notendurchschnitt_schulabschluss->getValue());
    
    if(empty($notendurchschnitt))
      $notendurchschnitt = 0;
    
    $values = array(
      $this->note_deutsch->getValue(),
      $this->note_englisch->getValue(),
      $this->note_mathematik->getValue(),
      $this->note_informatik->getValue(),
      $this->hobbys->getValue(),
      $this->studium->getValue(),
      $this->berufsausbildung->getValue(),
      $this->angestrebter_abschluss->getValue(),
      $this->erworbener_abschluss->getValue(),
      $notendurchschnitt,
      $bewerbernummer
    );
    
    $res = pg_execute($databaseObj, "insert_bewerbung", $values);
    
    $row = pg_fetch_row($res);
    $this->myBewerbungsnummer = $row[0];
    
    foreach($this->myPraktika as $praktikum) {
      $praktikum->linkToBewerbung($this);
      $praktikum->save($databaseObj);
    }
   
    $attachments = $this->myAttachments;
    $attachments->linkToBewerbung($this);
    $attachments->save($databaseObj, $uploadDir);
  
    return $this->myBewerbungsnummer;
  }
}