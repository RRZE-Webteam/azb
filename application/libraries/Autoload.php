<?php

class Autoload
{
  function __construct()
  {
    require_once(APPPATH . 'interfaces/interface.StepStatus.php');
    require_once(APPPATH . 'libraries/classes/class.TextObject.php');

  }
}
