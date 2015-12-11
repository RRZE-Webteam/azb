<?php

class TextObject
{
  protected $variables = array();
  protected $content;

  function __construct($content)
  {
    $this->content = $content;
  }


  public function bindVariable($name, $value)
  {
    $this->variables[$name] = $value;
  }


  public function output($asString = FALSE)
  {
    $output = $this->replaceVariables( $this->content );

    if($asString) {
      return $output;
    } else {
      echo $output;
    }
    

  }


  protected function replaceVariables($string)
  {
    foreach($this->variables as $name=>$value) {
      $search = sprintf("/{%s}/", preg_quote($name));
      $replace = $value;

      $string = preg_replace($search, $replace, $string);
    }

    return $string;

  }


  public function __toString()
  {
    return $this->output(TRUE);
  }

}
