
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Question 2</title>
    </head>
    <body>
        THIS CODE VALIDATES NUMBERS, DECIMALS, + and - 
        <form>
            
            



      
Please Enter A Number: <input type="text" name="textbox">
<!-- Set the input in the input to the variable called "textbox"-->
<input type="submit">
            
            
        </form>
              
    </body>
</html>
    <?php
    

   error_reporting(E_ERROR | E_WARNING | E_PARSE); 
   
   
   
   if (is_numeric($_GET['textbox']))                //obtain the input of the textbox from HTML code
       {                                            //use is_numeric to validate 0-9, +, - and 
         echo "\n Congratulations!! \n Your input consists of ALL Numbers";     //output when the textbox has numeric characters
       }
 
         else echo "\n I'm Sorry, \n Your input does not consist of ALL Numbers"  //output when the textbox doesn't have a numeric character   


       ?>

