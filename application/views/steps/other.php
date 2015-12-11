<?php echo form_open( 'steps/other/process' ); ?>

<?php
  $viewData = array('displayErrors' => $displayErrors);
  $this->view('steps/templates/_other.php', $viewData); 
?>

  <?php $this->load->view('steps/back_and_forward', array('predecessorURL' => $predecessorURL)); ?>

</form>

