<?php

interface StepStatus
{
  function isCompleted();
  function markAsCompleted();

  function isValid();
  function updateValidity();
}
