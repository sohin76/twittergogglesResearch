<?php

function countNum($input, $progress){
    $count = 0;
    $inputArr= str_split($input);
    $inputArr = array_slice($inputArr, $progress);
    foreach($inputArr as $x){
        if(is_numeric($x)){
            $count++;
        } 
    }
    return $count;
}
?>
