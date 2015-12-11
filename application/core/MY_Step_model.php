<?php

class MY_Step_model extends MY_Model implements StepStatus
{
  const stepName = 'OVERRIDE_ME_PLEASE';

  protected $concernedColumns = array();
  protected $emptyValues = array();


  // updates current step
  // TODO restrict to concernedColumns
  public function update($data)
  {
    $nummer = $this->getNummer();

    $data['bewerbungsnummer'] = $nummer;

    $this->db->where('bewerbungsnummer', $nummer);
    $this->db->update($this->tableBewerbung, $data);

    //TODO return proper value
    return TRUE;
  }


  // get all the concernedColumns
  public function get()
  {
    return $this->getColumnsOfCurrentBewerbung(
      $this->concernedColumns
    );
  }



  // TODO move to MY_Model or General_model
  protected function getColumnsOfCurrentBewerbung($columns)
  {
    if(is_array($columns))
      $columns = implode(',', $columns);

    $nummer = $this->getNummer();

    $this->db->where('bewerbungsnummer', $nummer);
    $this->db->select($columns);

    return $this->db->get( $this->tableBewerbung )
                    ->row_array();
  }


  // interface StepStatus
  public function markAsCompleted()
  {
    if($this->isCompleted()) return;

    $nummer = $this->getNummer();

    $this->db->where('bewerbungsnummer', $nummer);
    $this->db->set('current_step', $this->lib_progress->getStepNumberByName(static::stepName));

    $this->db->update($this->tableBewerbung);
  }

  public function isCompleted()
  {
    $this->db->where('bewerbungsnummer', $this->getNummer());
    $this->db->select('current_step');

    $currentStep = $this->db->get($this->tableBewerbung)->row()->current_step;

    $myStep = $this->lib_progress->getStepNumberByName(static::stepName);

    return $myStep <= $currentStep;
  }

  public function updateValidity() { return TRUE; }

  public function isValid() { return TRUE; }



}
