<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Question 1</title>
    </head>
    <body>
        
        THIS VALIDATES UPPER AND LOWERCASE ALPHA LETTERS 
        <form>
            
            
            
      
Enter value: <input type="text" name="textbox">      
<!-- Set the input in the input to the variable called "textbox"-->

<input type="submit">
            
            
        </form>
              
    </body>
</html>
    <?php
    
   error_reporting(E_ERROR | E_WARNING | E_PARSE); 
   
   
   
   
   if (ctype_alpha($_GET['textbox']))                  //obtain the input of the textbox from HTML code
       {                                               //use ctype_alpha to validate alpha letters
         echo "Your input consist of ALL letters";     //output when the textbox has all alpha letters
         
       }
 
         else echo "Your input consist of NO letters"  //output when the textbox doesn't have alpha letters
   
       ?>
