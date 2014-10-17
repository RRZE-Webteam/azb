<?php

abstract class formArray {
  protected $myFields;
  protected $amEnumerable;
  protected $myNumber;
  
  function __construct($enumerable=FALSE, $number=0) {
    $this->amEnumerable = $enumerable;
    $this->myNumber = $number;
  }
  
  public function addField(&$field) {
      $identifier = $field->identifier;
      
      if($this->amEnumerable)
	$identifier .= $this->myNumber;
      
      $field->identifier = $identifier;
      
      if(isset($this->myFields[$identifier])) {
	  throw new Exception(
	      sprintf('Field "%s" is already defined', $identifier));
      }
      
      $this->myFields[$identifier] = $field;
  }
  
  public function __get($member) {
    $identifier = $member . (($this->amEnumerable) ? $this->myNumber: NULL);
    if(!isset($this->myFields[$identifier])) {
	throw new Exception(
	    sprintf('Field "%s" not found', $member));
    }
    else {
	return $this->myFields[$identifier];
    }
      
  }
  
  public function validate($objector) {
    foreach($this->myFields as $field) {
	$field->validate($objector);
    }
  }
}