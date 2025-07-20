<?php
/*
  File: exam2.php
  Author: Jackson Champion
  Date: 2025-07-19
  Course: CPSC 3750 – Web Application Development
  Purpose: Provides the front end interface with buttons that display matching words with vowel counts
  Notes: Uses Javascript functionality from exam2.js to fetch and display words and AJAX requests 
    
*/

//Counts the number of vowels in a word
function countVowels($word) {
    $count = 0;
    $length = strlen($word);
    
    //loops through each character in each word
    for ($i = 0; $i < $length; $i++) {
        $char = strtolower($word[$i]); 

        //If the character is a vowel, add to the count
        if ($char === 'a' || $char === 'e' || $char === 'i' || $char === 'o' || $char === 'u') {
            $count++;
        }
    }
    //return number of vowels found
    return $count;
}

//Read words from the text file
$words = file('words.txt');

//Grpups each word with the number of vowels it has
$vowelArr = [];
foreach ($words as $word) {
    $count = countVowels($word);
    $vowelArr[$count][] = $word;
}

//Sort each word alphabetically
foreach ($vowelArr as &$list) {
    sort($list);
}

//Sorts the vowels in ascending order
ksort($vowelArr);

//Check for numVowels in the URL
if (isset($_GET['numVowels'])) {
     // get requested vowel count
    $count = intval($_GET['numVowels']);

    //Checks for an array of words for the specific vowel count
    if (isset($vowelArr[$count])) {

        //Loops through each word that matches the vowel count
        foreach ($vowelArr[$count] as $word) {
            echo $word . "\n";
        }
    }
    //Stops executing php code
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Exam #2 - Vowels To Words Finder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div id="navbar"></div>
</nav>

<h1>Exam #2 - Vowels To Words Finder</h1>
<h3>Select a number of vowels to see valid words:</h3>

<!--Creates a button for the number of vowels in words in the text file-->
<div class="button-container">
    <?php foreach ($vowelArr as $count => $list): ?>
        <button onclick="fetchWords(<?= $count ?>)"><?= $count ?></button>
    <?php endforeach; ?>
</div>

<h3 id="vowel-title"></h3>

<ul id="word-list"></ul>

<script src="exam2.js"></script>

    <footer>
        <h3>Contact Me</h3>
        <p> Email me at <a href="mailto:jackson.champion136@gmail.com">jackson.champion136@gmail.com</a></p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('navbar.html')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('navbar').innerHTML = data;
        });
    });
    </script>
</body>
</html>

