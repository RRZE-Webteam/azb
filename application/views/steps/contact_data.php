<?php echo form_open( 'steps/contact_data/process' ); ?>

<?php
  $this->view('steps/templates/_contact_data.php', ['displayErrors' => $displayErrors]);
?>

  <?php $this->load->view('steps/back_and_forward', array('predecessorURL' => base_url())); ?>

</form>

