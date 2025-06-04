/*
  File: sort.js
  Author: Jackson Champion
  Date: 2025-06-04
  Course: CPSC 3750 – Web Application Development
  Purpose: Creates sortNames() function to sort names alphabetically in an array
  Notes: Implemented in sort.html webpage
*/

// initialize the counter and the array
var numbernames=0;
var names = new Array();

function SortNames() {
   var thename = document.theform.newname.value;

   names[numbernames]= thename;
   
   // Increment the counter
   numbernames++;

   //sorts names alphabetically and uppercase
   names.sort((a, b) => a.toUpperCase().localeCompare(b.toUpperCase()));

   output = "";
   for (i = 0; i < names.length; i++) {
       output += (i + 1) + ". " + names[i].toUpperCase() + "\n";
   }

   document.theform.sorted.value = output;
}
