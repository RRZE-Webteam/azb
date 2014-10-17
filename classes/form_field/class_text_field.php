<?php

require_once 'class_form_field.php';
require_once 'codes.php';


class textField extends formField {
    protected $myMaxLength;
    protected $myContent;
    
    function __construct($identifier, $maxLength, $initialFlags=NULL) {
	$this->setLength($maxLength);
	$this->setFlags($initialFlags);
	
	parent::__construct($identifier);
    }
    
    public function setLength($length) {
	if(!is_numeric($length))
	    throw new Exception('Invalid length supplied');
	    
	$this->myMaxLength = $length;
    }
    
    public function input($value, $designator=NULL) {
	$this->myContent = $this->filter($value);
    }
    
    public function getValue() {
      return $this->myContent;
    }
    
    public function validate($objector) {
	$content = $this->myContent;

	if($this->hasFlags(FFF_NONEMPTY) && empty($content)) {
	    $objector->object(FFOBJ_EMPTY, $this->identifier);
	    return;
	}
	
	//too long?
	if(strlen($content)>$this->myMaxLength)
	    $objector->object(FFOBJ_TOOLONG, $this->identifier);
	    
	//is e-mail address?
	if($this->hasFlags(FFF_EMAIL) && strstr($content, '@')===FALSE)
	    $objector->object(FFOBJ_INVALID_EMAIL, $this->identifier);
    }
    
    protected function filter($string) {
      if($this->hasFlags(FFFILTER_TRIM))
	return trim($string);
	
      return $string;
    }
}
