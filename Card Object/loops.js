/*
  File: loops.js
  Author: Jackson Champion
  Date: 2025-06-12
  Course: CPSC 3750 – Web Application Development
  Purpose: Takes Card Information using loops and prompts
  Notes: Uses Javacript Implementation
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

// create the array
cardArray = new Array();

// loop and prompt for card info
do {
  next = prompt("Enter the Next Name", "");
  if (next > "") {
    email = prompt("Enter Email for " + next, "");
    address = prompt("Enter Address for " + next, "");
    phone = prompt("Enter Phone Number for " + next, "");
    birthdate = prompt("Enter Birthdate for " + next, "");
    card = new Card(next, email, address, phone, birthdate);
    cardArray.push(card);
  }
} while (next > "");

// display all cards
document.write("<h2>" + cardArray.length + " Card(s) entered:</h2>");
document.write("<ol>");
for (i = 0; i < cardArray.length; i++) {
  document.write("<li>" + cardArray[i].printCard() + "</li>");
}
document.write("</ol>");
