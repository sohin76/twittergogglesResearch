<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>

        <form action="testfunctions.php" method="post">
            Insert String: <input type="text" name="number">
            <br>
            <input type="submit" name="isAlpha" value="Check Alpha">
            <input type="submit" name="isNumeric" value="Check Numeric">

            <?php
            include 'isNumeric.php';
            include 'isAlpha.php';

            if (isset($_POST["isAlpha"])) {
                $input = $_POST["number"];
                isAlpha($input);
            }

            if (isset($_POST["isNumeric"])) {
                $input = $_POST["number"];
                isNumeric($input);
            }
            ?>

            </body>
            </html>
