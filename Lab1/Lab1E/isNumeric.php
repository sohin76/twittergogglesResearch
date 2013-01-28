<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php

        function isNumeric($test) {
            if (is_numeric($test)) {
                echo "<p>" . $test . " is numeric </p>";
            } else {
                echo "<p>" . $test . " is not numeric </p>";
            }
        }
        ?>
    </body>
</html>
