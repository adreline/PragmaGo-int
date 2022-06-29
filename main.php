<?php
//loads file by given path as json 
function loadData(string $path): Array{
    $file = fopen($path, "r");
    if(!$file) throw new Exception("Unable to open file $path\n");
    $json = json_decode(fread($file,filesize($path)));
    fclose($file);
    return $json;
}
//saves output to json file, returns number of bytes written and a filename
function saveData($json,$path=false): string{
    $path = ($path) ? $path : uniqid('pragmaout_').".json";
    $file = fopen($path, "w");
    if(!$file) throw new Exception("Unable to open file $path\n");
    $txt = json_encode($json);
    if(!$txt) throw new Exception("Failed to serialize the results\n");
    $b = fwrite($file,$txt);
    if(!$b) throw new Exception("Failed to write data to $path\n");
    return "written $b bytes to $path\n";
}
//fetches category name by a given id
function fetchNameById($hay,$id){
    foreach($hay as $cat){
        if($cat->category_id == $id) return $cat->translations->pl_PL->name;
    }
    return false;
}
//recursively traverse a tree, appending category name to each leaf
function traverse($tree,$list){
    foreach($tree as &$leaf){
        $name = fetchNameById($list,$leaf->id);
        $leaf->name = ($name) ? $name : "n/a";
        //because we are passing a pointer instead of a copy, we can pass children to a recursive call and still be able to make changes to $tree
        if(sizeof($leaf->children)>0) traverse($leaf->children,$list);
    }
    return $tree; //we can safely return the tree because it will be discarded by recursive calls and read only by the top level call
}

$flags = getopt("t:l:o::",array("dry::"));

if(!isset($flags['t'])||!isset($flags['l'])) die("File was not specified\n");

try{
    $tree = loadData($flags['t']);
    $list = loadData($flags['l']);
}catch(Exception $e){
    die($e->getMessage());
}

$result = traverse($tree,$list);
if(isset($flags['dry'])){ //do not output the result to a file if --dry is specified
    var_dump($result);
}else{
    $output_path = (isset($flags['o'])) ? $flags['o'] : false;
    try{
       $endmsg = saveData($result,$output_path);
       exit($endmsg);
    }catch(Exception $e){
        die($e->getMessage());
    }
}
