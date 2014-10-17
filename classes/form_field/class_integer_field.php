<?php

require_once 'class_form_field.php';
require_once 'codes.php';

class integerField extends formField {
    protected $myMinValue;
    protected $myMaxValue;
    
    protected $myValue;
    
    function __construct($identifier, $minValue=NULL, 
			$maxValue=NULL) {
			
	$this->myMinValue = $minValue;
	$this->myMaxValue = $maxValue;
	
	parent::__construct($identifier);
    }
    
    public function input($value, $designator=NULL) {
	$this->myValue = $value;
    }
    
    public function getValue() {
      return $this->myValue;
    }
    
    public function validate($objector) {
	$identifier = $this->identifier;
	$value = $this->myValue;
	
	if($this->hasFlags(FFF_NONEMPTY) && empty($value)) {
	    $objector->object(FFOBJ_EMPTY, $this->identifier);
	    return;
	}
	
	//is integer?
	if(!$this->is_integer($value)) {
	    $objector->object(FFOBJ_NOTANINT, $identifier);
	    return;
	}
	//cast to int to verify range
	$value = (int)$value;
	
	 if($this->myMaxValue!==NULL && ($value>$this->myMaxValue))
	    $objector->object(FFOBJ_NUMBEROUTOFRANGE, $identifier);
	    
	 if($this->myMinValue!==NULL && ($value<$this->myMinValue))
	    $objector->object(FFOBJ_NUMBEROUTOFRANGE, $identifier);	    
    }
    
    private function is_integer($var, $signed=FALSE) {
      $varStr = (string)$var;
      
      $i = 0;
      $first = substr($varStr, 0, 1);
      
      if($signed && ($first=='+' || $first=='-')) {
	$i++;
      }
      
      $allowed='0123456789';
      $allowed=str_split($allowed);
      
      for($i; $i<strlen($varStr); $i++) {
	$current = substr($varStr, $i, 1);
	
	if(!in_array($current, $allowed))
	  return FALSE;
      }
      
      return TRUE;
    }
    
    
}
