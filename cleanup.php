<?php
$dir = 'process/';
$expireDate = time() - 60*15;

if($handle = opendir($dir)) {
  $delCounter = 0;
  
  while(false!==($file=readdir($handle))) {
    $res = preg_match('/^([0123456789]*)[_].*$/', $file, $matches);
    
    if($res) {
      $timestamp = $matches[1];
      
      if($timestamp < $expireDate) {
	unlink($dir.$file);
	$delCounter++;
      }
    }
  }
  
  echo 'Deleted '.$delCounter.' files';
}
else {
  die(sprintf('Could not open directory "%s"', $dir));
}