/*
  File: Handlebars.js
  Author: Jackson Champion
  Date: 2025-07-08
  Course: CPSC 3750 – Web Application Development
  Purpose: Fetches pet data and renders it using HandleBar
  Notes: Uses AJAX to fetch pet data and Handlebars for html generation
*/

// Create a new AJAX Request
var ourRequest = new XMLHttpRequest();

//Fetches pet data with a GET request
ourRequest.open('GET', 'https://learnwebcode.github.io/json-example/pets-data.json');

//Defines what happens when the data loads
ourRequest.onload = function() {
    if (ourRequest.status >= 200 && ourRequest.status < 400) {
        var ourData = JSON.parse(ourRequest.responseText);
        console.log(ourData);
        createHtml(ourData);
    } else {
        console.log("Connection attempt returned an error.")
    }
};

//Displays a network error to console
ourRequest.onerror = function () {
    console.log("Connection error")
};

//Sends AJAX request
ourRequest.send();


//Calculates age of pet from birth year
Handlebars.registerHelper("calculateAge", function(birthYear)  {
    var age = new Date().getFullYear() - birthYear;
    return age;
});

//Generates the html and injects it onto page
function createHtml(petData) {
    var rawTemplate = document.getElementById("pet-template").innerHTML;
    var compileTemplate = Handlebars.compile(rawTemplate);
    var ourGeneratedHTML = compileTemplate(petData);

    var petContainer = document.getElementById("pet-container");
    petContainer.innerHTML = ourGeneratedHTML;
}
