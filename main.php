<?php
//loads file by given path as json 
function loadData(string $path): Array{
    $file = fopen($path, "r");
    if(!$file) throw new Exception("Unable to open file $path\n");
    $json = json_decode(fread($file,filesize($path)));
    fclose($file);
    return $json;
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

$flags = getopt("t:l:",array("dry::"));

if(!isset($flags['t'])||!isset($flags['l'])) die("File was not specified\n");

try{
    $tree = loadData($flags['t']);
    $list = loadData($flags['l']);
}catch(Exception $e){
    echo $e->getMessage();
    die();
}




