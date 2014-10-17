<?php

require_once 'class_upload_field.php';
require_once 'codes.php';

class imageUploadField extends uploadField {
  protected $myMaxWidth;
  protected $myMaxHeight;
  
  function __construct($identifier, $maxWidth, $maxHeight, $maxFileSize, 
		       $convertTo=NULL) {
    
    $this->myMaxHeight = $maxHeight;
    $this->myMaxWidth = $maxWidth;
    
    $allowedTypes = array('jpg', 'jpeg', 'png');
    parent::__construct($identifier, $allowedTypes, $maxFileSize);
  }

  public function convertToJpeg() {
    if(empty($this->myFileInfo))
      throw new Exception('No file set');
      
    $ext = $this->getType();
    $tempName = $this->myFileInfo['tmp_name'];
    $hImage = NULL;
    
    switch($ext) {
      case 'jpg': case 'jpeg': {
	$hImage = imagecreatefromjpeg($tempName);
	break;
      }
      case 'png': {
	$hImage = imagecreatefrompng($tempName);
	break;
      }
      default: {
	throw new Exception('Invalid image type');
      }
    }
    
    $originalWidth = imagesx($hImage);
    $originalHeight = imagesy($hImage);
    
    $newWidth = $originalWidth;
    $newHeight = $originalHeight;
    
    $ratio = $originalWidth / $originalHeight;
    
    if($originalHeight>$this->myMaxHeight) {
      $newHeight = $this->myMaxHeight;
      $newWidth = $ratio * $newHeight;
    }
    
    if($newWidth>$this->myMaxWidth) {
      $newWidth = $this->myMaxWidth;
      $newHeight = $newWidth / $ratio;
    }
    
    $hResized = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($hResized, $hImage, 0, 0, 0, 0, 
		       $newWidth, $newHeight, $originalWidth, $originalHeight);
    
    imagejpeg($hResized, $tempName, 70);
    
    imagedestroy($hImage);
    imagedestroy($hResized);
    
    $fileBaseName = pathinfo($this->myFileInfo['name'], PATHINFO_FILENAME);
    
    $this->myFileInfo['name'] = $fileBaseName.'.jpeg';
    $this->myFileInfo['size'] = filesize($tempName);
  }
}