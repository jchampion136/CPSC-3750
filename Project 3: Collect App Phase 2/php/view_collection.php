<?php
/*
  File: view_collection.php
  Author: Jackson Champion
  Date: 2025-07-27
  Course: CPSC 3750 – Web Application Development
  Purpose: View registered user's favorited Magic cards
  Notes: Requires user to be logged in to view favorites and uses Scryfall API to fetch card details
*/
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to view this page.');</script>";
    echo "<script>window.location.href = 'collectApp.html';</script>";
    exit();
}


// DB connection
$mysqli = new mysqli("localhost", "ewnuvdmy_demo_user", "JJ1241378j", "ewnuvdmy_magicDB");

// Check for connection errors
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user's favorite items from the database with the latest favorites first
$sql = "SELECT item_id, favorited_at FROM favorites WHERE user_id='$user_id' ORDER BY favorited_at DESC";
$result = mysqli_query($mysqli, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Favorite Cards</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav>
        <div id="navbar"></div>
    </nav>

    <h1>Your Favorite Magic: The Gathering Cards</h1>

    <!-- Button to return to search page -->
    <div>
      <a href="collectApp.html" class="button-link">Return to Search Page</a>
    </div>

<?php

// Check if user has saved any favorites
if ($result && mysqli_num_rows($result) > 0) {
    echo "<ul>";

    // Loop through each favorite item
    while ($row = mysqli_fetch_assoc($result)) {
        $item_id = htmlspecialchars($row['item_id']);
        $favorited_at = htmlspecialchars($row['favorited_at']);

        // Fetch card details from Scryfall API
        $api_url = "https://api.scryfall.com/cards/" . $item_id;
        $api_response = file_get_contents($api_url);
        $card = json_decode($api_response, true);

        //Display card details if valid
        if ($card && isset($card['name'])) {
            $card_name = htmlspecialchars($card['name']);
            $card_image = isset($card['image_uris']['small']) ? $card['image_uris']['small'] : '';
            $card_type = htmlspecialchars($card['type_line']);
            $card_set = htmlspecialchars($card['set_name']);

            //Output card information
            echo "<li>";
            echo "<h3>$card_name</h3>";
            echo $card_image ? "<img src='$card_image' alt='$card_name'>" : "";
            echo "<p><strong>Type:</strong> $card_type</p>";
            echo "<p><strong>Set:</strong> $card_set</p>";
            echo "<p><small>Favorited At: $favorited_at</small></p>";
            echo "<button onclick=\"removeFromFavorites('$item_id')\">Remove from Favorites</button>";
            echo "</li>";
        } else { //Display if card not found
            echo "<li class='favorite-card'>";
            echo "<h3 style='color:red;'>Card not found</h3>";
            echo "<p>Item ID: <code>$item_id</code></p>";
            echo "<p><small>Favorited At: $favorited_at</small></p>";
            echo "<button onclick=\"removeFromFavorites('$item_id')\">Remove from Favorites</button>";
            echo "</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>No favorites found.</p>";
}
?>

  <footer>
    <h3>Contact Me</h3>
    <p>Email me at <a href="mailto:jackson.champion136@gmail.com">jackson.champion136@gmail.com</a></p>
  </footer>

  <!--Remove from favorites function-->
  <script>
    function removeFromFavorites(cardID) {
      fetch("favorite.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "item_id=" + encodeURIComponent(cardID) + "&action=remove"
      })
    
      .then(response => response.text())
      .then(data => {
        location.reload(); // Reload page after removing
      })

      // catches error if problems occur
      .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while removing the card from favorites.");
      });
    }

    document.addEventListener('DOMContentLoaded', () => {
      fetch('navbar.html')
        .then(response => response.text())
        .then(data => {
          document.getElementById('navbar').innerHTML = data;
        });
    });
  </script>
</body>
</html>
