<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        echo "Numeric Test Cases: <br>";
		$string_num = array("123450", "123,450", "1234.50", "-123450",
			"+123450", "-123,450", "+123,450", "-1234.50",
			"+1234.50", "0.12345", "0.12345", "-0.12345",
			"-.12345", "+0.12345", "+.12345", "ABC", "abc123", "123abc", "..9808");
        foreach ($string_num as $test2){
            if (!preg_match("/^[0-9,+-][0-9,+-.]*(?:,[0-9]+)*$/",$test2)) {
                echo $test2; echo " False <br />";
            }
            else 
                {
                echo $test2; echo " True <br />";
            }
        }
        ?>
    </body>
</html>
