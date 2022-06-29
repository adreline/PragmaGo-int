<?php
if(!isset($argv[1])) die("File was not specified\n");
$myfile = fopen($argv[1], "r") or die("Unable to open file\n");
$j = json_decode(fread($myfile,filesize($argv[1])));
var_dump($j);
fclose($myfile);