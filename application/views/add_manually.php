<?php echo form_open_multipart( 'add_manually/process', array('id' => 'form') ); ?>

<?php

$this->load->view('steps/templates/_personal_data', array('form' => $personal_data));
$this->load->view('steps/templates/_contact_data', array('form' => $contact_data));
$this->load->view('steps/templates/_education', array('form' => $education));
$this->load->view('steps/templates/_internships', array('form' => $internships));
$this->load->view('steps/templates/_it_skills', array('form' => $it_skills));
$this->load->view('steps/templates/_uploads_manually', array('form' => $it_skills));
$this->load->view('steps/templates/_other', array('form' => $other));

?>

<input name="submit" type="submit" value="Speichern" />

</form>
