<?php echo form_open( 'steps/it_skills/process' ); ?>

<?php
  $viewData = array( 
    'choicesKenntnisse' => $choicesKenntnisse,
    'displayErrors' => $displayErrors
  );

  $this->view('steps/templates/_it_skills.php', $viewData); 
?>

<?php $this->load->view('steps/back_and_forward', array('predecessorURL' => $predecessorURL)); ?>

</form>

