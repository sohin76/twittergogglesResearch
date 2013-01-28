<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        //An array of test cases
        $string = array ("Balloon", "qwe_rty", "hOcKEY$", "Stop!", "s@email.com", "123456", "abc1@3", "10%", "First_Name$", "_users");
        
        //Function to test for only alphabets with a-z, A-Z, _, only starting with an alphabet too.
        foreach ($string as $test1)
        if(preg_match("/^[A-Za-z][A-Za-z_$]+$/", $test1)){
            echo $test1;  echo " is an acceptable string <br />";
            }
            else
                {
                echo $test1; echo " is not an acceptable string <br />";
                }
        ?>
    </body>
</html>
