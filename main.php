<?php
function loadData(string $path): Array{
    $file = fopen($path, "r");
    if(!$file) throw new Exception("Unable to open file $path\n");
    $json = json_decode(fread($file,filesize($path)));
    fclose($file);
    return $json;
}
$flags = getopt("t:l:");
if(!isset($flags['t'])||!isset($flags['l'])) die("File was not specified\n");
try{
    $tree = loadData($flags['t']);
    $list = loadData($flags['l']);
}catch(Exception $e){
    echo $e->getMessage();
    die();
}
