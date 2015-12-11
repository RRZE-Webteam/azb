<?php


class Contact_data_model extends MY_Step_Model
{ 
  const stepName = 'contact_data';

  protected $concernedColumns = array(
    'adresse',
    'postleitzahl',
    'ort',
    'telnummer'
  );


}
