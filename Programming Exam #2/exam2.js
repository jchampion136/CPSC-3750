/*
  File: exam2.js
  Author: Jackson Champion
  Date: 2025-07-19
  Course: CPSC 3750 – Web Application Development
  Purpose: Gets words from a text file based on the number of vowels
  Notes: executed by exam2.php
*/

function fetchWords(numVowels) {

    //Displays the current vowel count chosen
    vowelTitle = document.getElementById('vowel-title');
    vowelTitle.innerHTML = `Words with ${numVowels} vowel${numVowels !== 1 ? 's' : ''}:`;


    fetch("exam2.php?numVowels=" + numVowels)
    //Converts response into plain text
    .then(response => response.text())
    .then(text => {
        //Creates a scrollable word list
        wordList = document.getElementById('word-list');
        wordList.innerHTML = '';

        //Split the text responses into an array of words
        words = text.trim().split("\n");

        //loops through each word in the file
        words.forEach(word => {

            //Creates a new list element for each word
            li = document.createElement('li');
            li.className = 'word-item';
            li.textContent = word;
            wordList.appendChild(li);
        });
    });
}
