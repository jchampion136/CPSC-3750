/*
  File: audio.js
  Author: Jackson Champion
  Date: 2025-06-24
  Course: CPSC 3750 – Web Application Development
  Purpose: Demonstrates audio features for project #1 such as segment playback and a playlist.
  Notes: Uses Javascript implemeted by auidio.html and audio.css
*/
audio = document.getElementById('audio');
fileName = document.getElementById('fileName');

//Array of audio segment titles
titles = [
  "Intro",
  "First Verse",
  "Second Verse",
  "Refrain",
  "Third Verse",
  "Fourth Verse",
  "Fifth Verse",
  "Sixth Verse",
  "Guitar Solo",
  "Bridge",
  "Outro"
];

//Array of audio segment start times in seconds
times = [0, 53, 92, 136, 158, 208, 259, 307, 354, 404, 464];

//convert seconds to minutes:seconds format
function formatTime(seconds) {
    const mins = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);

    let formattedTime;
    //Puts a leading zero if seconds are less than 10
    if (secs < 10) {
        formmattedTime = '0' + secs;
    } else {
        formmattedTime = secs
    }
    return mins + ':' + formmattedTime;
}

//Starts a timer that pauses the audio when it reaches the end of a segment
function startTimer(end) {

  //Checks if the audio has reached the end of the segment
    if (audio.currentTime >= end) {
      audio.pause();
      audio.currentTime = end;
      updateCurrentTime(); //Update The display
    }
}

//Plays the audio file from start to end
function playSegment(start, end) {
  audio.currentTime = start;
  audio.play();
  startTimer(end);
}

//Plays or pauses the audio based on the current state
function PlayOrPause() {
  if (audio.paused) {
    audio.play();
  } else {
    audio.pause();
  }
}

//Allows the user to add a title at the current play time
function addTitle() {
  //Prompts the user for a new title
  newTitle = prompt("Enter title name:");

  //Doesn't add a title if the user cancels or enters an empty string
  if (!newTitle) {
    return;
  }

  //Gets the current time of the audio
  currentTime = Math.floor(audio.currentTime);

  insertIndex = 0;
  while ((insertIndex < times.length) && (currentTime > times[insertIndex])) {
    insertIndex++;
  }

  //Insert the new title and time in each array at the correct position
  titles.splice(insertIndex, 0, newTitle);
  times.splice(insertIndex, 0, currentTime);

  loadPlaylist(); 
}

//Fast forwards and rewinds the audio by a number of seconds (5 seconds set on the webpage)
function moveForward(seconds) {
  audio.currentTime = Math.min(audio.currentTime + seconds, audio.duration);
}
function moveBackward(seconds) {
  audio.currentTime = Math.max(audio.currentTime - seconds, 0);
}

//Updates the current playback time
function updateCurrentTime() {
  timeDisplay = document.getElementById('currentTimeDisplay');
  timeDisplay.innerHTML= formatTime(audio.currentTime);
}

//Continually updates the current time display every 500 milliseconds
setInterval(updateCurrentTime, 500);

//Loads the playlist and creates buttons for each segment
function loadPlaylist() {
  playlist = document.getElementById('playlist');
  playlist.innerHTML = "";

  
  for (let i = 0; i < titles.length; i++) {
    const start = times[i];
    let end;
    if((i + 1) < times.length) {
      end = times[i + 1];
    } else {
      end = audio.duration;
    }

    //Create a button for each segment
    button = document.createElement("button");
    button.innerHTML = `${titles[i]} (${formatTime(start)})`;

    //Play the segment when the button is clicked
    button.onclick = () => playSegment(start, end);
    playlist.appendChild(button);
  }
}
