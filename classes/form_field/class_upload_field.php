<?php

require_once 'class_form_field.php';
require_once 'codes.php';

class uploadField extends formField {
  protected $myAllowedTypes;
  protected $myMaxFileSize;
  
  protected $myFileInfo;
  
  function __construct($identifier, $allowedTypes, $maxFileSize) {
    $this->setAllowedTypes($allowedTypes);
    $this->myMaxFileSize = $maxFileSize;
    
    parent::__construct($identifier);
  }
  
  public function setMaxFileSize($size) {
    if(!is_numeric($size))
      throw new Exception('Invalid size supplied');
  }
  
  protected function setAllowedTypes($types) {
    $args = $types;
    
    unset($this->myAllowedTypes);
    $this->myAllowedTypes = array();
    
    foreach($args as $arg) {
      $this->myAllowedTypes[] = strtolower($arg);
    }
  }
  
  public function input($value, $designator=NULL) {
    $this->myFileInfo = $value;
  }
  
  public function getValue() {
    return $this->myFileInfo;
  }
  
  public function getType() {
    if(!isset($this->myFileInfo['name']))
      throw new Exception('No file set, cannot determine type');
      
    $filename = $this->myFileInfo['name'];
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));   

  }
  
  public function getFileName() {
    return @$this->myFileInfo['name'];
  }
  
  public function validate($objector) {
    $filename = $this->getFileName();
    $identifier = $this->identifier;
    
    if(!$this->hasFlags(FFF_NONEMPTY) && empty($filename))
      return;
    
    if(empty($filename)) {
      $objector->object(FFOBJ_EMPTY, $identifier);
      return;
    }
      
    $extension = $this->getType();
    
    echo $this->getType();
    if(!in_array($extension, $this->myAllowedTypes))
      $objector->object(FFOBJ_ILLEGAL_FILETYPE, $identifier);
      
    $size = $this->myFileInfo['size']/1024;
    
    if($size>$this->myMaxFileSize)
      $objector->object(FFOBJ_FILE_TOO_BIG, $identifier);
  }
}