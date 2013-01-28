<?php
include 'testNum.php';
include 'testAlphaCode.php';
/*lab1 INFO 154 Jan 16, 2013
 * 
 * John Carrol-testNum
 * Jarrod Neser-testCases
 * Danica Dometita-testAlpha
 */        
        
        

               
        /*test case for testAlpha
        */
          
        $abc = "abc";
        $alphabet = "abcdefghijklmnopqrstuvwxyz";
        $null = "";
        $nums = "123";
        $abc123 = "abc123";
        $ab12cd = "ab12cd";
        $numabc = "123abc";
        
        
        /*echos testAlpha script to verify our function 
         *is looking working as we designed it to based
         *on the requirements*/
         
        echo "Here is the test cases for testing the testAlpha function";
        echo "<br>";
        echo "abc is ".testAlpha($abc)."<br>";
        echo "abcdefghijklmnopqrstuvwxyz is ".testAlpha($alphabet)."<br>";
        echo "NULL is ".testAlpha($null)."<br>";
        echo "123 is ".testAlpha($nums)."<br>";
        echo "abc123 is ".testAlpha($abc123)."<br>";
        echo "ab12cd is ".testAlpha($ab12cd)."<br>";
        echo "123abc is ".testAlpha($numabc)."<br>";
 /*-----------------------------------------------------------------------------
  */      

          
          
        /*test case for testnumber
        */ 
        $num = "0";
        $digit = "0.1";
        $positive = "+4";
        $neg = "-9";
        $number = "123";
        $minusnum= "3-5";
        $numberabc = "123abc";
        $abcnumber = "abc123";
        $abnumcd = "ab12cd";
        $numnull = "";
        $alpha = "abc";
        $comma = "1,500";
        $comma1 = "1,500,000";
        $comma2 = "1,50";
        $comma3 = "1,500,00";
        $comma4 = "1,500,000,000";
        
        
        
        
        /*echos testNUM script to verify our function 
         *is looking working as we designed it to based
         *on the requirements
         */
        
        echo "Here is the test cases for testing the testNUM function";
        echo "<br>";
        echo "0 is ".testNUM($num)."<br>";
        echo "0.1 is ".testNUM($digit)."<br>";
        echo "+4 is ".testNUM($positive)."<br>";
        echo "-9 is ".testNUM($neg)."<br>";
        echo "123 is ".testNUM($number)."<br>";
        echo "3-5 is ".testNUM($minusnum)."<br>";
        echo "123abc is ".testNUM($numberabc)."<br>";
        echo "abc123 is ".testNUM($abcnumber)."<br>";
        echo "ab12cd is ".testNUM($abnumcd)."<br>";
        echo "NULL is ".testNUM($numnull)."<br>";
        echo "abc is ".testNUM($alpha)."<br>";
        echo "1,500 is ".testNUm($comma)."<br>";
        echo "1,500,000 is ".testNUm($comma1)."<br>";
        echo "1,50 is ".testNUm($comma2)."<br>";
        echo "1,500,00 is ".testNUm($comma3)."<br>";
        echo "1,500,000,000 is ".testNUm($comma4)."<br>";
        
        ?>
