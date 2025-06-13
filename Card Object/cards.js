/*
  File: cards.js
  Author: Jackson Champion
  Date: 2025-06-12
  Course: CPSC 3750 – Web Application Development
  Purpose: Takes Card Information using an input interface
  Notes: Implemented using JavaScript
*/
function printCard() {
   cardString = "";
   cardString += "<strong>Name: </strong>" + this.name + "<br>";
   cardString += "<strong>Email: </strong>" + this.email + "<br>";
   cardString += "<strong>Address: </strong>" + this.address + "<br>";
   cardString += "<strong>Phone: </strong>" + this.phone + "<br>";
   cardString += "<strong>Birthdate: </strong>" + this.birthdate + "<hr>";
  return cardString;
}

function Card(name, email, address, phone, birthdate) {
  this.name = name;
  this.email = email;
  this.address = address;
  this.phone = phone;
  this.birthdate = birthdate;
  this.printCard = printCard;
}

cardArray = [
  new Card("Sue Suthers", "sue@suthers.com", "123 Elm Street, Yourtown ST 99999", "555-555-9876", "01/01/1970"),
  new Card("Fred Fanboy", "fred@fanboy.com", "233 Oak Lane, Sometown ST 99399", "555-555-4444", "02/02/1980"),
  new Card("Jimbo Jones", "jimbo@jones.com", "233 Walnut Circle, Anotherville ST 88999", "555-555-1344", "03/03/1990")
];

function createCard() {
  name = document.getElementById("name").value;
  email = document.getElementById("email").value;
  address = document.getElementById("address").value;
  phone = document.getElementById("phone").value;
  birthdate = document.getElementById("birthdate").value;

  newCard = new Card(name, email, address, phone, birthdate);
  cardArray.push(newCard);
  document.getElementById("cardForm").reset();
}

function displayCards() {
  cardOutput = document.getElementById("cardOutput");
  cardOutput.innerHTML = "";
  for(i = 0; i < cardArray.length; i++) {
    div = document.createElement("div");
    div.innerHTML = cardArray[i].printCard();
    cardOutput.appendChild(div);
  }
}
