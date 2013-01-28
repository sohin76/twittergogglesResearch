<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        foreach ($strings as $tests){
            if (ctype_digit($tests)){
                echo "True \n";
            } else {
                echo"False \n";
            }
        }

        ?>
    </body>
</html>
