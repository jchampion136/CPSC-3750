/*
  File: collectApp.js
  Author: Jackson Champion
  Date: 2025-07-16
  Course: CPSC 3750 – Web Application Development
  Purpose: JS file for handling card search and displaying results for Magic: The Gathering cards
  From the Scryfall API
  Notes: Fetches Card data from the ScryFall API
*/

//Array that stores cards picked for the collection
myCollection = new Array();


//Fetches cards from the Scryfall API and displays cards based on user's search
function searchCards() {
  //Gets search Input
  const query = document.getElementById("searchInput").value;
  const resultsDiv = document.getElementById("results");
  const detailsDiv = document.getElementById("details");

  // Clear previous search results
  resultsDiv.innerHTML = "";
  detailsDiv.innerHTML = "";

  //Builds the URL based on the search and fetches a default list if no search is made
  const url = query 
    ? `https://api.scryfall.com/cards/search?q=${encodeURIComponent(query)}`
    : `https://api.scryfall.com/cards/search?q=*`; //If user doesn't type anything, show a default list

  // Fetch cards from Scryfall's API
  fetch(url)
    .then(response => response.json()) //Converts response into JSON
    .then(result => {
      //If no cards are found, Show "No results found"
      if (!result.data) {
        resultsDiv.innerHTML = "<p>No results found.</p>";
        return;
      }

      //Loop through first 20 cards in API
      result.data.slice(0, 20).forEach(card => {
        const cardDiv = document.createElement("div");

        //assigns a CSS class to keep consistent styling from style.css
        cardDiv.className = "card";

        //creates structure for each card in the search results to display on HTML
        cardDiv.innerHTML = `
          <h3>${card.name}</h3>
          ${card.image_uris ? `<img src="${card.image_uris.small}" alt="${card.name}">` : ""}
          <p><strong>Type:</strong> ${card.type_line}</p>
          <p><strong>Set:</strong> ${card.set_name}</p>
          <button onclick="addToCollection('${card.id}')">Add to My Collection</button>
        `;

        //When the user clicks anywhere on the card show more details about the card
        cardDiv.onclick = () => showCardDetails(card.id);
        resultsDiv.appendChild(cardDiv);
      });
    })
}

//Fetches detailed information about cards
function showCardDetails(cardID) {
  //References the details section called in the HTML
  const detailsDiv = document.getElementById("details");

  //Fetches the full details of a card by its ID
  fetch(`https://api.scryfall.com/cards/${cardID}`)
    .then(response => response.json())
    .then(card => {
      //Displays detailed information about the chosen card
      detailsDiv.innerHTML = `
        <h2>${card.name}</h2>
        ${card.image_uris ? `<img src="${card.image_uris.normal}" alt="${card.name}">` : ""}
        <p><strong>Mana Cost:</strong> ${card.mana_cost}</p>
        <p><strong>Type:</strong> ${card.type_line}</p>
        <p><strong>Text:</strong><br>${card.oracle_text || "No text available"}</p>
        <p><strong>Set:</strong> ${card.set_name}</p>
        <p><strong>Rarity:</strong> ${card.rarity}</p>
        <p><strong>Power/Toughness:</strong> ${card.power || "N/A"}/${card.toughness || "N/A"} </p>
        <p><strong>Flavor Text:</strong><i> ${card.flavor_text || "N/A"}</i></p>
        <hr>
      `;
    })

    //If an error is caught, display error message
    .catch(error => {
      detailsDiv.innerHTML = "<p>Error loading details.</p>";
      console.error(error);
    });
}

//Adds cards to personal collection
function addToCollection(cardID) {
  //Shows an alert if user adds the same card twice
  if (!myCollection.includes(cardID)) {
    myCollection.push(cardID);
    alert("Card added!");
  } else {
    alert("Card already in collection.")
  }
} 

//Shows list of cards added to collection
function showCollection() {
  const resultsDiv = document.getElementById("results");
  const detailsDiv = document.getElementById("details");

  //clears any previous results or card details
  resultsDiv.innerHTML = "";
  detailsDiv.innerHTML = "";

  //If the collection is empty show a message to user telling them its empty
  if (myCollection.length === 0) {
    resultsDiv.innerHTML = "<p>Your collection is empty.</p>";
    return;
  }

  //Loops through each card ID in collection
  myCollection.forEach(cardID => {
    //Fetches the cards again from Scryfall API
    fetch(`https://api.scryfall.com/cards/${cardID}`)
      .then(response => response.json())
      .then(card => {
        //Creates an element to display cards in the collections page
        const cardDiv = document.createElement("div");
        //Assign card class to "card" to keep consistent styling
        cardDiv.className = "card";
        cardDiv.innerHTML = `
          <h3>${card.name}</h3>
          ${card.image_uris ? `<img src="${card.image_uris.small}" alt="${card.name}">` : ""}
          <p><strong>Type:</strong> ${card.type_line}</p>
          <p><strong>Set:</strong> ${card.set_name}</p>
        `;

        //When user clicks anywhere on card in Collections page, show full detail
        cardDiv.onclick = () => showCardDetails(card.id);
        resultsDiv.appendChild(cardDiv);
      });
  });
}


