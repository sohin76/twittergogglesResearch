<?php

//creates function
         function isNumerics(){
             //sets $x to get number from input box
             $x= $_POST['number'];
            if(is_numeric($x)){
                //built in function
                echo "Is number<br/>";
            }
            else {
                echo "Is not number<br/>";
            }
        }
 
        //creates function to check for Alpha, similar to numeric
         function isAlpha(){
             $z= $_POST['letter'];
            if(ctype_alpha($z)){
                echo "Is alpha<br/>";
            }
            else {
                echo "Is not alpha<br/>";
            }
        }
?>
