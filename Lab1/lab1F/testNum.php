<?php
include 'countNums.php';

      function testNUM($input){
          $answer = TRUE; //sets initial switch
          $count = 0; // intiates count
          $characters = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "+", "-", "."); // acceptable character array
          $pieces = str_split($input); //seperates input into array of characters
          
          
          
          foreach ($pieces as $x){ //loop for every char of input
             if($count == 0){ // first run through 
                 $answer = in_array($x, $characters); // looks for match with acceptable chars allows for + and -
                 $characters[10] = ""; //removes + from acceptable characters (first digit only)
                 $characters[11] = ""; //removes - from acceptable characters (first digit only)
                 if(strcmp($x, ".") == 0){ //removes . from acceptable characters IF . was used
                     $characters[12] = "";
                 }
                 
             }else{ // second run through
                 if(countNum($input, $count)%3 == 0)//if there are any interval of 3 digits after comma 
                    $characters[13] = ","; //adds , to acceptable characters
                 $answer = in_array($x, $characters); // looks for match with acceptable chars
                 if(strcmp($x, ".") == 0){ //removes . from acceptable characters IF . was used
                     $characters[12] = "";
                 $characters[13]= "";
                 
                 }  
                 
             }
             if($answer == FALSE){ //if there is no match on ANY run through ($answers = FALSE) return FALSE
                 return "FALSE";
             }
             $count++; //increases count
          }
          
          return "TRUE";
          
      }
      
      
?>

