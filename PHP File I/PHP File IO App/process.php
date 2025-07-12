<?php 
/*
  File: process.php
  Author: Jackson Champion
  Date: 2025-07-12
  Course: CPSC 3750 – Web Application Development
  Purpose: Creates files and uses functions to classify numbers as prime Fibonacci or Armstrong
  Notes: Uses PHP file I/O and cookie detection.
*/
//Check if user has cookies
if(!isset($_COOKIE['cookies'])) {

    //Saves cookies for 5 minutes
    setcookie("cookies", "yes", time() + 3000, "/");

    //Files created
    $files = ['prime.txt', 'armstrong.txt', 'fibonacci.txt', 'none.txt'];

    //Create file if they dont exist
    foreach ($files as $file) {
        if (!file_exists($file)) {
            $newFile = fopen($file, 'w');
            fclose($newFile);
        }
    }
}

//Checks if the number is prime
function isPrime($num) {
    if ($num <= 1) {
        return false;
    }

    if($num == 2 || $num % 2 == 0) {
        return true;
    }

    for ($i = 3; $i <= sqrt($num); $i += 2) {
        if ($num % $i == 0) {
            return false;
        }
    }

    return true;
}

//Checks for armstrong number
function isArmstrong($num) {
    $originalNum = $num;
    $sum = 0;
    $numDigits = strlen((string)$num); 

    // Loop through each digit
    while ($num > 0) {
        $digit = $num % 10; 
        $sum += pow($digit, $numDigits); 
        $num = (int)($num / 10); 
    }

    return $sum === $originalNum;
}

//checks for fibonacci number
function isFibonacci($num) {
    if ($num < 0) {
        return false;
    } 

    $a = 0;
    $b = 1;

    while ($b < $num) {
        $temp = $a + $b;
        $a = $b;
        $b = $temp;
    }

    return $b === $num || $num === 0;
}
?>
