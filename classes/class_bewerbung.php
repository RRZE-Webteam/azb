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
		
    $kenntnisseFeld = $fields['kenntnisse_office'] = new 
      selectionField('kenntnisse_office', $this->get_kenntnisse_bewertungen());
    
    $fields[] = $kenntnisseFeld->fclone('kenntnisse_betriebssysteme');
    $fields[] = $kenntnisseFeld->fclone('kenntnisse_netzwerke');
    $fields[] = $kenntnisseFeld->fclone('kenntnisse_hardware');
    
    $fields[] = $genericIntegerField->fclone('note_deutsch');
    $fields[] = $genericIntegerField->fclone('note_englisch');
    $fields[] = $genericIntegerField->fclone('note_mathematik');
    $fields[] = $genericIntegerField->fclone('note_informatik');      
    
    $hobbies = $fields[] = new textField('hobbys', 2048);
    $hobbies->setFlags(FFF_NONEMPTY, FFFILTER_TRIM);
    
    $fields[] = $genericTextArea->fclone('berufsausbildung');
    $fields[] = $genericTextArea->fclone('studium');
    $fields[] = $genericTextArea->fclone('anmerkungen'); 
    $fields['notendurchschnitt'] = 
      new textField('notendurchschnitt_schulabschluss', 4);
    $fields['notendurchschnitt']->setFlags(FFFILTER_TRIM);
    
    $fields[] = $genericTextArea->fclone('kenntnisse_office_txt');
    $fields[] = $genericTextArea->fclone('kenntnisse_betriebssysteme_txt');
    $fields[] = $genericTextArea->fclone('kenntnisse_netzwerke_txt');
    $fields[] = $genericTextArea->fclone('kenntnisse_hardware_txt');
    
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
    return array('keiner', 'abitur', 
		 'fachabitur__sozial', 'fachabitur__technisch', 
		 'fachabitur__wirtschaftlich', 
		 'mittlerer_bildungsabschluss__naturwissenschaftlich',
		 'mittlerer_bildungsabschluss__neusprachlich',
		 'mittlerer_bildungsabschluss__sozial',
		 'mittlerer_bildungsabschluss__technisch',
		 'mittlerer_bildungsabschluss__wirtschaftlich',
		 'quali__naturwissenschaftlich',
		 'quali__neusprachlich',
		 'quali__sozial',
		 'quali__technisch',
		 'quali__wirtschaftlich');
  }
  
  private function get_kenntnisse_bewertungen() {
    return array(0,1,2,3);
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
	notendurchschnitt_schulabschluss, bewerbernummer, anmerkungen,
	kenntnisse_office, kenntnisse_betriebssysteme, kenntnisse_netzwerke,
	kenntnisse_hardware, kenntnisse_office_txt, 
	kenntnisse_betriebssysteme_txt, kenntnisse_netzwerke_txt, 
	kenntnisse_hardware_txt)
      VALUES
	($1, $2, $3, $4, $5 ,$6, $7 , $8, $9, $10, $11, $12, $13, $14, $15, 
	  $16, $17, $18, $19, $20)
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
      $bewerbernummer,
      $this->anmerkungen->getValue(),
      $this->kenntnisse_office->getValue(),
      $this->kenntnisse_betriebssysteme->getValue(),
      $this->kenntnisse_netzwerke->getValue(),
      $this->kenntnisse_hardware->getValue(),
      $this->kenntnisse_office_txt->getValue(),
      $this->kenntnisse_betriebssysteme_txt->getValue(),
      $this->kenntnisse_netzwerke_txt->getValue(),
      $this->kenntnisse_hardware_txt->getValue()
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