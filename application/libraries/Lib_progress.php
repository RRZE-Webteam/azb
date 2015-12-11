<?php

class Lib_progress
{
  protected $CI;

  protected $progression = array();

  protected $currentStep;
  protected $firstIncompleteStep;

  protected $loaded = FALSE;


  function __construct()
  {
    $this->CI = & get_instance();

    if(!$this->CI->lib_session->isInitialized())
      return;
  }


  public function load()
  {
    // load steps from config
    $this->CI->config->load('custom');

    foreach($this->CI->config->item('progression') as $step) {
      $this->addStep($step[0], $step[1], $step[2], $step[3], $step[4]);
    }

    $this->linkSteps();

    $this->loaded = TRUE;
  }

  public function initialize()
  {
    $this->exceptionIfNotLoaded();

    $this->getFirstIncompleteStep();
    $this->tagSteps();
  }

  public function addStep($number, $name, $url, $model, $text)
  {
    $step = new StdClass;

    $step->number = $number;
    $step->name = $name;
    $step->url = $url;
    $step->model = $model;
    $step->text = $text;
    $step->isActive = FALSE;
    $step->isCompleted = FALSE;
    $step->isNext = FALSE;

    $this->progression[$number] = &$step;
  }


  protected function linkSteps()
  {
    $previous = NULL;
    foreach($this->progression as &$step) {
      $step->prev = &$previous;
      $step->next = NULL;

      if($previous)
        $previous->next =& $step;

      $previous = & $step;
    }

  }


  public function getFirstIncompleteStep()
  {
    $this->exceptionIfNotLoaded();

    // called before? just return the result
    if( $x =& $this->firstIncompleteStep ) {
      return $x;
    }

    if( ! $this->CI->lib_session->isInitialized() ) {
      return $this->firstIncompleteStep = reset($this->progression);
    }

    $currentStep = end($this->progression);

    foreach($this->progression as &$step) {
      if($this->isCompleted($step)) continue;

      $currentStep = &$step; break;
    }

    return
      $this->firstIncompleteStep = &$currentStep;
  }


  protected function &get($name)
  {
    $this->exceptionIfNotLoaded();

    foreach($this->progression as &$step) {
      if( $step->name == $name )  return $step;
    }

    throw new Exception("There is no step named '$name'");
  }



  public function successorURL()
  {
    $this->exceptionIfNotLoaded();

    $step = $this->get($this->currentStep);

    return $step->next ? $step->next->url : NULL;
  }


  public function predecessorURL()
  {
    $this->exceptionIfNotLoaded();

    $step = $this->get($this->currentStep);

    return $step->prev ? $step->prev->url : NULL;
  }


  public function tagSteps()
  {
    foreach($this->progression as &$step) {
      $step->isCompleted = $this->isCompleted($step);
      $step->isNext = ($step == $this->firstIncompleteStep);
    }
  }


  public function getProgression()
  {
    $this->exceptionIfNotLoaded();

    return $this->progression;
  }


  public function setCurrentStep($name)
  {
    $this->exceptionIfNotLoaded();

    $this->currentStep = $name;
    $this->get($name)->isActive = TRUE;
  }


  public function previousStepsCompleted($name)
  {
    $this->exceptionIfNotLoaded();

    $currentStepNumber = $this->getStepNumberByName($this->currentStep);
    $stepNumber = $this->getStepNumberByName($name);

    return $stepNumber <= $currentStepNumber;
  }


  protected function isCompleted($step)
  {
    $this->exceptionIfNotLoaded();

    if(!$step->model) return TRUE;

    // load the model
    $this->CI->load->model($step->model);

    // check if there is data
    if( $this->CI->{$step->model}->isCompleted() ) {
      return TRUE;
    }
  }


  public function getStepNumberByName($name)
  {
    return $this->get($name)->number;
  }


  protected function exceptionIfNotLoaded()
  {
    if(!$this->loaded) {
      throw new Exception('No progress data loaded; called ::load?');
    }

  }

}
