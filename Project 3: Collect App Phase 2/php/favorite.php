<?php
/*
  File: favorite.php
  Author: Jackson Champion
  Date: 2025-07-27
  Course: CPSC 3750 – Web Application Development
  Purpose: Add or remove Magic: The Gathering cards from user's favorites page
  Notes: A user must be logged in to remove favorites. Uses Scryfall API to fetch card details
  and PHP to handle database interactions.
*/

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view this page.";
    exit();
}

// DB connection
$mysqli = new mysqli("localhost", "ewnuvdmy_demo_user", "JJ1241378j", "ewnuvdmy_magicDB");

//Check for connection errors
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
//Get the user ID from the session
$user_id = $_SESSION['user_id'];

//get the user's item ID from the POST request
$item_id = mysqli_real_escape_string($mysqli, $_POST['item_id']);


//Checks if acrtion is set in POST request
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
    $action = 'add';
}

if($action == "add") {
    // Check if the item is already in favorites
    $check = $mysqli->query("SELECT id FROM favorites WHERE user_id='$user_id' AND item_id='$item_id'");
    if ($check->num_rows > 0) {
        echo "This card is already in your favorites.";
        exit();
    }

    // Insert the item into favorites
    $sql = "INSERT INTO favorites (user_id, item_id, favorited_at) 
            VALUES ('$user_id', '$item_id', NOW())";

    if(mysqli_query($mysqli, $sql)) {
        echo "Item added to favorites successfully!";
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
    exit();
}

//delete the item from favorites
else if($action == "remove") {

    $sql = "DELETE FROM favorites WHERE user_id='$user_id' AND item_id='$item_id'";

    if(mysqli_query($mysqli, $sql)) {
        echo "Item removed from favorites successfully!";
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
    exit();
}
?>
