<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php

        function isAlpha($var) {
            if (ctype_alpha($var)) {
                echo "<p>" . $var . " is alphabetic </p>";
            } else {
                echo "<p>" . $var . " is not alphabetic </p>";
            }
        }
        ?>
    </body>
</html>