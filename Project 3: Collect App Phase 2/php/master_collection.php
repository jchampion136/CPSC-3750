<?php
/*
  File: master_collection.php
  Author: Jackson Champion
  Date: 2025-07-27
  Course: CPSC 3750 – Web Application Development
  Purpose: Displays a master collection of all favorite Magic Cards from all users
  Notes: Requires user to be logged in to view favorites and Uses Scryfall API to fetch card details
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

//Check for connection errors
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//Fetches all favorites from the database
$sql = "
    SELECT f.item_id, f.favorited_at, u.name AS user_name, u.email
    FROM favorites f
    JOIN users u ON f.user_id = u.id
    ORDER BY f.favorited_at DESC
";

//Executes the SQL query
$result = mysqli_query($mysqli, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Master Collection of Favorites</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<nav>
    <div id="navbar"></div>
</nav>

<h2>Master Collection of Favorites</h2>

<!--button to return to search page-->
<div>
  <a href="collectApp.html" class="button-link">Return to Search Page</a>
</div>

<?php   

if ($result && mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>Card</th>
            <th>Type</th>
            <th>Set</th>
            <th>Favorited At</th>
            <th>User Email</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $item_id = $row['item_id'];
        $favorited_at = $row['favorited_at'];
        $user_email = $row['email'];

        // Get card info from Scryfall
        $api_url = "https://api.scryfall.com/cards/" . $item_id;
        $api_response = file_get_contents($api_url);
        $card = json_decode($api_response, true);

        //Display error message if card not found
        echo "<tr>";
        if (!$card || (isset($card['object']) && $card['object'] === 'error')) {
            echo "<td colspan='3' style='color:red;'>Card not found for Item ID: $item_id</td>";
        } else {
            echo "<td>" . $card['name'] . "</td>";
            echo "<td>" . $card['type_line'] . "</td>";
            echo "<td>" . $card['set_name']. "</td>";
        }

        echo "<td>$favorited_at</td>";
        echo "<td>$user_email</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No favorites found.</p>";
}
?>

    <footer>
        <h3>Contact Me</h3>
        <p>Email me at <a href="mailto:jackson.champion136@gmail.com">jackson.champion136@gmail.com</a></p>
    </footer>


    <script>
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