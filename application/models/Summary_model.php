<?php

class Summary_model extends MY_Model implements StepStatus
{
  public function updateValidity() { return TRUE; }
  public function isValid() { return TRUE; }

  public function isCompleted()
  {
    return FALSE;
  }

  public function markAsCompleted() { }


}
