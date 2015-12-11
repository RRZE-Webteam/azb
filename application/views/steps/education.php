<?php echo form_open( 'steps/education/process' ); ?>

<?php
  $viewData = array(
    'choices_angestrebter_abschluss' => $choices_angestrebter_abschluss,
    'choices_erworbener_abschluss' => $choices_erworbener_abschluss,
    'displayErrors' => $displayErrors
  );

  $this->view('steps/templates/_education.php', $viewData); 
?>

  <?php $this->load->view('steps/back_and_forward', array('predecessorURL' => base_url())); ?>

</form>

