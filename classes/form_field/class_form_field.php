<?php

require_once 'codes.php';


abstract class formField {
    protected $myFlags;
    public $identifier;
    
    function __construct($identifier) {
	$this->myFlags = array();
	$this->identifier = $identifier;
    }
    
    abstract public function validate($objecetor);
    abstract public function input($value, $designator=NULL);
    
    public function setFlags($argList) {
	$args = func_get_args();
	
	foreach($args as $flag)
	    $this->myFlags[] = $flag;
	    
	$this->myFlags = array_unique($this->myFlags);
    }
    
    protected function unsetFlag($flag) {
	if(($key = array_search($flag, $this->myFlags)) !== FALSE) {
	    unset($this->myFlags[$key]);
	}
    }
    
    protected function hasFlags($argList) {
	$flags = func_get_args();

	return empty(array_diff($flags, $this->myFlags));
    }
    
    public function fclone($cloneIdentifier) {
	$newObject = clone $this;
	$newObject->identifier = $cloneIdentifier;
	
	return $newObject;
    }
    
    public abstract function getValue();
    
    public function __tostring() {
      return $this->getValue();
    }

}