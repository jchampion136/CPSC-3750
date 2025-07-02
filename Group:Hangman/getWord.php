<?php
/*
  File: getWord.php
  Author: Jackson Champion
  Date: 2025-07-02
  Course: CPSC 3750 – Web Application Development
  Purpose: Selects a random word from a secure file for the Hangman game.
  Notes: Uses PHP and is called by hangman.js to retrieve words from the server.
*/

//Modifies so the words are stored in a secure directory, unable to be accessed by the user
$filePath = __DIR__ . '/../secure/words.txt';

// Check if the file exists
if (file_exists($filePath)) {
   $words = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
   if (!empty($words)) {
       // Randomly select a word from the file
       $selectedWord = trim($words[array_rand($words)]);
       // Send the selected word back to the client
       echo json_encode(['word' => $selectedWord]);
   } else {
       echo json_encode(['error' => 'No words found.']);
   }
} else {
   echo json_encode(['error' => 'File not found.']);
}
?>
