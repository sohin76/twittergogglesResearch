<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        
        <?php
        
        //NO USER INTERFACE
        
        echo "<h1>Numeric</h1>";
        
        //creates function, with parameter $a
        function isNumeric($a){
            //built in function to check for numbers, decimals, etc.
            if(is_numeric($a)){
                echo "$a is number<br/>";
            }
            else {
                echo "$a is not number<br/>";
            }
        }
        //sets parameters with test cases
        isNumeric('3');
        isNumeric('145');
        isNumeric('1f');
        isNumeric('1..0');
        isNumeric('1,34');
        isNumeric('534.9023');
        
        echo"<br><br>";
        
        echo "<h1>Alpha</h1>";
        
        //function with parameter $b
        function isAlpha($b){
            //built in function to check for A-Z and a-z
            if(ctype_alpha($b)){
                echo "$b is alpha<br/>";
            }
            else {
                echo "$b is not alpha<br/>";
            }
        }
        //sets parameters with test cases
        isAlpha('a');
        isAlpha('abc');
        isAlpha('abc4');
        isAlpha('-abc');
        isAlpha('ab.c');
        isAlpha('Alpha');
        
        
        
        
                ?>

    </body>


</html>