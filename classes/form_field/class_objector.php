<?php

class objector {
    private $myObjections;
    
    public function object($objectionCode, $identifier) {
	$this->myObjections[$identifier][] = $objectionCode;
    }
    
    public function gatherObjections() {
	return ($this->myObjections);
    }
}