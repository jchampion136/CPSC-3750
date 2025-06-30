/*
  File: search.js
  Author: Jackson Champion
  Date: 2025-06-30
  Course: CPSC 3750 – Web Application Development
  Purpose: Implements live search functionality 
  Notes: Gets result from search.php
*/

// global variable to manage the timeout
var t;

// Start a timeout with each keypress
function startSearch() {
   if (t) window.clearTimeout(t);
   t = window.setTimeout("liveSearch()",200);
}

// Perform the search
function liveSearch() {
   // assemble the PHP filename
   query = document.getElementById("searchlive").value;
   filename = "search.php?query=" + query;
   // DisplayResults will handle the Ajax response
   ajaxCallback = displayResults;
   // Send the Ajax request
   ajaxRequest(filename);
}

// Display search results
function displayResults() {
   // remove old list
   ul = document.getElementById("list");
   div = document.getElementById("results");

   if (ul && div.contains(ul)) {
      div.removeChild(ul);
   }

   
   // make a new list
   ul = document.createElement("ul");
   ul.id="list";

   states = ajaxreq.responseXML.getElementsByTagName("state");

   for (i = 0; i < states.length; i++) {
      li = document.createElement("li");
      state = states[i].getElementsByTagName("name")[0].textContent;
      capital = states[i].getElementsByTagName("capital")[0].textContent;

      text = document.createTextNode(state + " - " + capital);
      li.appendChild(text);
      ul.appendChild(li);
   }
   
   if (states.length==0) {
      li = document.createElement("li");
      li.appendChild(document.createTextNode("No results"));
      ul.appendChild(li);
   }

   // display the new list
   div.appendChild(ul);
}

// set up event handler
window.onload = function() {
   obj = document.getElementById("searchlive");
   obj.onkeydown = startSearch;
}
