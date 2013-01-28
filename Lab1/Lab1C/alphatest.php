<?php
/*
 * untitled.php
 * 
 * Copyright 2013 Adam <adam@Daemonspawn>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>untitled</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="generator" content="Geany 1.22" />
</head>

<body>
<?php

//input is the string typed by the user
//$tempInput is variable that stores users string
if(isset($_POST["input"])){
$tempInput = $_POST["input"];
    }

//$alphaArray is an array of accepted characters for alphabetic strings.
//This allows the arrays to be modular, adding or changing characters and symbols that are parallel to the requirements.
$alphaArray = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", " ");

//$numArray is an array of accepted characters for numeric strings.
//This allows the arrays to be modular, adding or changing characters and symbols that are parallel to the requirements.
$numArray = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", ".", ",");

//Outputs the original string for reference
echo("The string given was: ".$tempInput." <br><br>");
echo("String status: <br>");

//The following Echos return the status of the string, as "true" or "false". This clearly identifies for the user
//the status of the string.
echo("Alphabetic:  ".isItAlphabetic($tempInput)."<br>");
echo("Numeric:     ".isItNumeric($tempInput)."<br><br><br>");
echo("Try another string?<br>");

    ?>

<form action="alphatest.php" method="POST">
    Please enter something: <input type="text" name="input">
    <input type="submit" value="Submit">
</form>

<?php

//isItNumeric function checks if string is numeric
//This function has the inputted string passed to ir, and returns the value "true"
function isItNumeric($string){
    global $numArray; //allow access to $numArray
    $tempArray = str_split($string); //split user string into an array for the functions below

    //Checks if the $tempArray has a + or - in it's first array slot
    //This allows us to use array_shift to pull out this character, so we can check for further + or - that would
    //cause the string to be false.
    if ($tempArray[0] === "+" Or $tempArray[0] === "-" ){
        //array_shift removes the first place of an array, and moves all further values to the left.
        array_shift($tempArray);
        //pulls $tempArray apart as $chars, allowing to easily check for the + or - and returns "false"
        foreach($tempArray as $chars){
            if($chars == '+' or $chars == '-')return "false";
        }
        return "true";

            }

    //Double checks that the first array value is NOT a + or -
    elseif($tempArray[0] != '+' or '-'){
        //$tempArray apart as $chars, allowing to easily check for the + or - and returns "true"
        foreach($tempArray as $char){
            if(!in_array($char, $numArray))return "false";
        }
        return "true";
    }

}
//Similar to the numeric function, this has the string passed down, and returns "true" or "false"
function isItAlphabetic($string){
    global $alphaArray;
    $tempArray = str_split($string);
    foreach($tempArray as $char){
        if(!in_array($char, $alphaArray)) return "false";
    }
    return "true";
}

?>
</body>

</html>
