<?php

$begruessung = NULL;

switch($bewerbung['anrede']) {
  case 'herr':
    $begruessung = $begruessungen['herr'];
    break;

  case 'frau':
    $begruessung = $begruessungen['frau'];
    break;

  default:

    $begruessung = $begruessungen['sonstige'];
}

$begruessung = sprintf($begruessung, $bewerbung['nachname']);


echo $begruessung;
// two blank lines!
?>


<?
echo $content;
echo $signatur;

?>
