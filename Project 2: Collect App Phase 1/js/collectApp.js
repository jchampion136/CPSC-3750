/*
  File: collectApp.js
  Author: Jackson Champion
  Date: 2025-07-18
  Course: CPSC 3750 – Web Application Development
  Purpose: handles card search and displays results for Magic: The Gathering cards
  From the Scryfall API
  Notes: Fetches Card data from the ScryFall API
*/

//Fetches cards from the Scryfall API and displays cards based on user's search
function searchCards() {
  //Gets search Input
  query = document.getElementById("searchInput").value;
  resultsDiv = document.getElementById("results");
  detailsDiv = document.getElementById("details");

  // Clear previous search results
  resultsDiv.innerHTML = "";
  detailsDiv.innerHTML = "";

  //Builds the URL based on the search and fetches a default list if no search is made
  if (query) {
    url = `https://api.scryfall.com/cards/search?q=${encodeURIComponent(query)}`;
  } else {
  // If search bar is empty show a default list alphabetically
    url = `https://api.scryfall.com/cards/search?q=*`;
  }
  // Fetch cards from Scryfall's API
  fetch(url)
    .then(response => response.json()) 
    .then(result => {
      //If no cards are found, Show "No results found"
      if (!result.data) {
        resultsDiv.innerHTML = "<p>No results found.</p>";
        return;
      }

      //Shows a max result of up to 100 cards
      maxResults = Math.min(result.data.length, 100);

      for (let i = 0; i < maxResults; i++) {
        let card = result.data[i];

        cardDiv = document.createElement("div");

        //assigns a CSS class to keep consistent styling from style.css
        cardDiv.className = "card";

        //creates structure for each card in the search results to display on HTML
        cardDiv.innerHTML = `
          <h3>${card.name}</h3>
          ${card.image_uris ? `<img src="${card.image_uris.small}">` : ""}
          <p><strong>Type:</strong> ${card.type_line}</p>
          <p><strong>Set:</strong> ${card.set_name}</p>
        `;

        //When the user clicks anywhere on the card show more details about the card
        cardDiv.onclick = () => showCardDetails(card.id);
        resultsDiv.appendChild(cardDiv);
      }
  });
}

//Fetches detailed information about cards
function showCardDetails(cardID) {
  //References the details section called in the HTML
  detailsDiv = document.getElementById("details");

  //Fetches the full details of a card by its ID
  fetch(`https://api.scryfall.com/cards/${cardID}`)
    .then(response => response.json())
    .then(card => {
      //Displays detailed information about the chosen card
      detailsDiv.innerHTML = `
        <h2>${card.name}</h2>
        ${card.image_uris ? `<img src="${card.image_uris.normal}">` : ""}
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
      detailsDiv.innerHTML = "<p>Error: Cannot Load Cards.</p>";
      console.error(error);
    });
}


