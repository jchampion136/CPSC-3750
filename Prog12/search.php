<?php
/*
  File: search.php
  Author: Jackson Champion
  Date: 2025-06-03
  Course: CPSC 3750 – Web Application Development
  Purpose: Returns a list of states and their capitals
  Notes: Uses PHP to generate the data for AJAX live searches.
*/

header("Content-type: text/xml");

$states = array (
  "Alabama" => "Montgomery", "Alaska" => "Juneau",
  "Arizona" => "Phoenix", "Arkansas" => "Little Rock",
  "California" => "Sacramento", "Colorado" => "Denver",
  "Connecticut" => "Hartford", "Delaware" => "Dover",
  "Florida" => "Tallahassee", "Georgia" => "Atlanta",
  "Hawaii" => "Honolulu", "Idaho" => "Boise",
  "Illinois" => "Springfield", "Indiana" => "Indianapolis",
  "Iowa" => "Des Moines", "Kansas" => "Topeka",
  "Kentucky" => "Frankfort", "Louisiana" => "Baton Rouge",
  "Maine" => "Augusta", "Maryland" => "Annapolis",
  "Massachusetts" => "Boston", "Michigan" => "Lansing",
  "Minnesota" => "Saint Paul", "Mississippi" => "Jackson",
  "Missouri" => "Jefferson City", "Montana" => "Helena",
  "Nebraska" => "Lincoln", "Nevada" => "Carson City",
  "New Hampshire" => "Concord", "New Jersey" => "Trenton",
  "New Mexico" => "Santa Fe", "New York" => "Albany",
  "North Carolina" => "Raleigh", "North Dakota" => "Bismarck",
  "Ohio" => "Columbus", "Oklahoma" => "Oklahoma City",
  "Oregon" => "Salem", "Pennsylvania" => "Harrisburg",
  "Rhode Island" => "Providence", "South Carolina" => "Columbia",
  "South Dakota" => "Pierre", "Tennessee" => "Nashville",
  "Texas" => "Austin", "Utah" => "Salt Lake City",
  "Vermont" => "Montpelier", "Virginia" => "Richmond",
  "Washington" => "Olympia", "West Virginia" => "Charleston",
  "Wisconsin" => "Madison", "Wyoming" => "Cheyenne"
);

echo "<?xml version=\"1.0\" ?>\n";
echo "<states>\n";


while (list($state, $capital) = each($states)) {
  if (isset($_GET['query']) && stristr($state, $_GET['query'])) {
    echo "<state>\n";
    echo "<name>$state</name>\n";
    echo "<capital>$capital</capital>\n";
    echo "</state>\n";
  }
}

echo "</states>\n";
?>
