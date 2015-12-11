<?php

class Add_manually extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    
    // disable this Controller
    exit;
  }


  public function index()
  {
    // load all the forms
    $viewData = $this->loadForms();

    // pass everything to our view
    $this->load->withLayout('add_manually', $viewData);
  }


  public function process()
  {
    $this->load->model('register_model');
    $this->load->model('contact_data_model');
    $this->load->model('education_model');
    $this->load->model('internships_model');
    $this->load->model('it_skills_model');
    $this->load->model('uploads_model');
    $this->load->model('other_model');


    // load all the forms
    $forms = $this->loadForms();

    foreach($forms as &$form) {
      $form->inputPOST($_POST);
    }


    // validate all forms
    $success = TRUE;
    foreach($forms as $key=>&$form)
    {
      $success = $form->validate() && $success;
    }


    // validation failed; re-show forms
    if(!$success) {
      $this->load->withLayout('add_manually', $forms);
      return; // !!
    }


    // collect output
    $output_personal_data = $forms['personal_data']->output();
    $output_contact_data = $forms['contact_data']->output();
    $output_education = $forms['education']->output();
    $output_internships = $forms['internships']->output();
    $output_it_skills = $forms['it_skills']->output();
    $output_other = $forms['other']->output();

    // collect uploads

    $uploads = array();

    foreach($_FILES as $key=>$file) {
      if($file['size'] <= 0) continue;

      $uploads[$key] = array(
        'filename' => $file['name'],
        'path' => $file['tmp_name']
      );
    }


    $nummer = $this->register_model->register($output_personal_data);
    $this->lib_session->initialize($nummer);

    $this->contact_data_model->update($output_contact_data);
    $this->education_model->update($output_education);
    $this->internships_model->update($output_internships);
    $this->it_skills_model->update($output_it_skills);
    $this->uploads_model->update($uploads);
    $this->other_model->update($output_other);

    $this->session->sess_destroy();


    redirect('add_manually');
  }



  protected function loadForms()
  {
    $viewData = array();

    $viewData['personal_data'] = $this->load->form('personal_data');
    $viewData['contact_data'] = $this->load->form('contact_data');
    $viewData['education'] = $this->load->form('education');
    $viewData['internships'] = $this->load->form('internships');
    $viewData['it_skills'] = $this->load->form('it_skills');
    $viewData['other'] = $this->load->form('other');


    return $viewData;
  }

}
