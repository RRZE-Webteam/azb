<?php

define('TEXT_DIR', APPPATH.'/text/');

class Lib_text
{
  protected $variables = array();


  function __construct()
  {
    $this->loadDefaultVariables();
  }


  public function loadText($path)
  {
    $filename = TEXT_DIR.$path;

    // check if file exists
    if( !file_exists( $filename ) ) {
      throw new Exception("$filename not found");
    }

    // get file content
    $content = file_get_contents($filename);

    // create text object
    $textObject = new TextObject($content);

    foreach($this->variables as $name=>$value) {
      $textObject->bindVariable($name, $value);
    }


    return $textObject;
  }


  public function loadEnumeratedTexts($path)
  {
    $actual_path = TEXT_DIR . $path;

    // check if path exists
    if( !file_exists( $actual_path ) ) {
      throw new Exception("$actual_path not found");
    }
    
    // get all files named "#-name"
    
    $files = scandir($actual_path);

    foreach($files as $key => $file) {
      if( ! preg_match('/^[0-9]+.+$/', $file) ) {
        unset($files[$key]);
      } 
    }

    // load all the files
    $array = array();

    foreach($files as $file) {
      $array[] = $this->loadText($path . '/' . $file);
    }

    return $array;

  }


  public function loadTextFragments($path)
  {
    // TODO check extension and append only if needed
    $actual_path = TEXT_DIR . $path . '.php';

    // check if path exists
    if( !file_exists( $actual_path ) ) {
      throw new Exception("$actual_path not found");
    }


    $fragments = function() use($actual_path) {
      $fragment = array();

      include($actual_path);

      return $fragment;
    };

    // hack
    $fragments = $fragments();

    return $fragments;
  }

  
  public function bindVariable($name, $value)
  {
    $this->variables[$name] = $value;
  }


  protected function loadDefaultVariables()
  {
    $file = TEXT_DIR . 'variablen.php';

    $variables = include($file);

    foreach($variables as $name => $value) {
      $this->bindVariable($name, $value);
    }
  }

}
