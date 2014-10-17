<?php

require_once 'class_form_field.php';
require_once 'codes.php';

class dateField extends formField {
    protected $myDay;
    protected $myMonth;
    protected $myYear;
    
    function construct($identifier) {
	parent::__construct($identifier);
    }
    
    public function input($value, $designator=NULL) {
	switch(strtolower($designator)) {
	    case 'y': case 'j': case 'jahr': case 'year':
	    {
		$this->myYear = $value;
		break;
	    }
	    case 'm': case 'monat': case 'month':
	    {
		$this->myMonth = $value;
		break;
	    }	    
	    case 'd': case 't': case 'tag': case 'day':
	    {
		$this->myDay = $value;
		break;
	    }	    
	    default:
	    {
		throw new Exception('Do not know what to do with 
				    "'.$designator.'"');
	    }
	}
    }
    
    public function getValue() {
      $date = mktime(0,0,0, $this->myMonth, $this->myDay, 
			      $this->myYear);
			
      return (string)($date);
    }
    
    public function validate($objector)
    {
	$date = mktime(0,0,0, $this->myMonth, $this->myDay, 
			$this->myYear);
			
	if($date==0) {
	    $objector->object(FFOBJ_INVALID_DATE, $this->identifier);
	}
    }
}
