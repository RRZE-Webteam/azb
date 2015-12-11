<?php echo form_open( 'steps/internships/process', array('id' => 'form')); ?>

<?php
  $this->view('steps/templates/_internships.php');
?>

<?php $this->load->view('steps/back_and_forward', array('predecessorURL' => $predecessorURL)); ?>

</form>
