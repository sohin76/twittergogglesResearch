
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Question 3</title>
    </head>
    <body>
        
        THIS CODE VALIDATES ALPHA-NUMERICAL CHARACTERS
        <form>
            
            



      
Please Enter A Number: <input type="text" name="textbox">

<input type="submit">
            
            
        </form>
              
    </body>
</html>
    <?php
    

   error_reporting(E_ERROR | E_WARNING | E_PARSE); 

   
   if (ctype_alnum($_GET['textbox']))       //obtain the input of the textbox from HTML code
       {                                     //use ctype_alnum to validate 0-9, +, -, decimals and alpha characters
         echo "Congratulations!!!! your input of ". print_r($_GET['textbox'], true). " contains all alpha-numerical characters";//output when the textbox is alpha-numeric
       }
 
         else echo "I'm sorry, \n your input \"". print_r($_GET['textbox'], true). "\" does not contain all alpha-numerial characters"  //output when text doesn't have a alpha-numeric character
   


       ?>

