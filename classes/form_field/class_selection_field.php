<?php
require_once 'class_form_field.php';

class selectionField extends formField {
    private $myChoices;
    private $myChoice;
    
    function __construct($identifier, $choices=NULL) {
	if($choices)
	    $this->determineChoices($choices);
	    
	parent::__construct($identifier);
    }
    
    public function determineChoices($choices) {
	$this->myChoices = $choices;
    }
    
    public function input($value, $designator=NULL) {
	$this->myChoice = $value;
    }
    
    public function validate($objector) {
	$isValid = in_array($this->myChoice, $this->myChoices);
	if(!$isValid)
	    $objector->object(FFOBJ_BAD_CHOICE, $this->identifier);
    }
    
    public function getValue() {
      return $this->myChoice;
    }
}