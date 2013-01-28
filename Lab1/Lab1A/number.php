<?php


//USER INTERFACE ENABLED



//references usernum.php
require_once 'usernum.php';

//uses input box to run through function isNumerics
if (isset($_POST['number'])){
    echo isNumerics($x);
    return;
}


if (isset($_POST['letter'])){
    echo isAlpha($x);
    return;
}

echo '<h1>Numeric</h1>';

//creates form and input box and button to activate function
echo '<form name="form1" method="post" action="">
        <input type="text" name="number" id="number">
        <input type="submit" name="button" id="button" value="Submit">
      </form>';

echo'<br><br>';
echo'<h1>Alpha</h1>';

//creates input form for Alpha
echo '<form name="form1" method="post" action="">
        <input type="text" name="letter" id="letter">
        <input type="submit" name="button" id="button" value="Submit">
      </form>';



?>
