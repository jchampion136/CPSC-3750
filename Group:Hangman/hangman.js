/*
  File: hangman.js
  Author: Jackson Champion
  Date: 2025-07-02
  Course: CPSC 3750 – Web Application Development
  Purpose: Uses Javascript to implement a Hangman game that updates words and images based on user input.
  Notes: Includes a cheat mode that reveals the word to the user and a cache buster to ensure new words are fetched each time the game starts.
*/
currentWord = '';
guessedLetters = new Array();
wrongGuessCount = 0;


function startGame() {
    //Resets guess count and hangman image at the start of each game
    wrongGuessCount = 0; 
    updateImage();

    //Checks for cheat mode
    cheat = document.getElementById('cheatMode').checked;

    // Clears Guessed letters 
    guessedLetters = new Array();

   
    /*Fetches a new word from the list on server. A cache buster is implemented that
    makes sure a new word is fetched each time the game starts.*/
    fetch('getWord.php?nocache=' + new Date().getTime())
        .then(response => response.json())
        .then(data => {
            if (data.word) {
                //If Cheat mode is checked, Shows the word as an alert on page.
                if (cheat) {
                    alert("Cheat Mode: " + data.word);
                }
                setupGame(data.word);
            } else {
                console.error('Error fetching word:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
}

//Updates the hangman image based on the number of wrong guesses
function updateImage() {
    image = document.getElementById('hangmanImage');
    image.src = `hangman_pics/Hangman${wrongGuessCount}.jpeg`;
}

//Sets the game up with a new word
function setupGame(word) {
    currentWord = word.toUpperCase(); 
    guessedLetters = new Array();

    guessWord = document.getElementById('wordToGuess');
    guessWord.innerHTML = '_ '.repeat(word.length).trim();
    generateLetterButtons();
}

function generateLetterButtons() {
    const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lettersDiv = document.getElementById('letters');
    lettersDiv.innerHTML = ''; // Clear previous buttons
    letters.split('').forEach(letter => {
        const button = document.createElement('button');
        button.textContent = letter;
        button.onclick = () => guessLetter(letter);
        lettersDiv.appendChild(button);
    });
}

function guessLetter(letter) {
    // Maximum number of guesses allowed(each attached to a hangman image)
    maxWrongGuesses = 6; 

    //Alerts the user if they try to guess the same letter multiple times
    if (guessedLetters.includes(letter)) {
        alert('Letter already guessed!');
        return;
    }

    //Adds the guessed letter to a list
    guessedLetters.push(letter);

    var display = "";
    var isComplete = true;

    //Builds the display string with correct guesses and underscores for unguessed letters
    for (let i = 0; i < currentWord.length; i++) {
        if (guessedLetters.includes(currentWord[i])) {
            display += currentWord[i];
        } else {
            display += '_ ';
            isComplete = false;
        }
    }

    // Updates the displayed word
    wordToGuess = document.getElementById('wordToGuess');
    wordToGuess.innerHTML = display.trim();

    if (!currentWord.includes(letter)) {
        wrongGuessCount++;
        updateImage();

        // Check if the maximum number of wrong guesses has been reached
        if (wrongGuessCount >= maxWrongGuesses) {
            //Allows time for the image to update before alerting the user
            setTimeout(() => {
                alert('Game over! The word was: ' + currentWord);
                //Restarts the game 
                startGame(); 
            }, 100); 
        }
    }

    //If all letters are correctly guessed, game is complete
    if (isComplete) {
        // Delays the alert to allows time for the image to update.
        setTimeout(() => {
            alert('Congratulations! You win!');
            startGame();
        }, 100); 
    }
}

// Initially start the game
startGame();
