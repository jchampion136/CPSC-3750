<?php
/*
  File: database.php
  Author: Jackson Champion
  Date: 2025-07-22
  Course: CPSC 3750 – Web Application Development
  Purpose: Allows users to add, view, and search for people from a database as well as
  filter by last name.
  Notes: Uses a SQL query to create Person table and PHP to handle form submissions.
*/

//Connect to the database
$mysqli = new mysqli("localhost", "ewnuvdmy_demo_user", "JJ1241378j", "ewnuvdmy_personDB");

//Check if the connection fails
if (mysqli_connect_errno()) {
    printf("Connection failed: " . mysqli_connect_error());
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Person</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div id="navbar"></div>
    </nav>

    <h1>Add a Person</h1>

    <!-- Form to add a new person -->
    <form method="POST">
        <label>First Name:</label>
        <input type="text" name="first_name">
        <br>

        <label>Last Name:</label>
        <input type="text" name="last_name">
        <br>

        <label>Email:</label>
        <input type="email" name="email">
        <br>
        <br>

        <button type="submit" name="add_person">Add Person</button>
        <button type="submit" name="view_all">Show All People</button>
    </form>

    <!--Searches for a person by last name-->
    <h2>Search by Last Name</h2>
    <form method="POST">
        <label>Enter Last Name:</label>
        <input type="text" name="search_last_name" required>
        <button type="submit" name="search_last">Search</button>
    </form>

    <?php

    //Add a new person to the database
    if (isset($_POST['add_person'])) {
        $first_name = mysqli_real_escape_string($mysqli, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($mysqli, $_POST['last_name']);
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);

        //Inserts new person into the database
        $sql = "INSERT INTO Person (first_name, last_name, email) VALUES ('$first_name', '$last_name', '$email')";
        $response = mysqli_query($mysqli, $sql);

        //Either shows a success message or an error message after Person is added
        if ($response) {
            echo "<p style='color: green; font-weight: bold;'>New person added successfully.</p>";
        } else {
            echo "Error: " . mysqli_error($mysqli);
        }
    }

    //Shows all people in the database if button is clicked
    if (isset($_POST['view_all'])) {
        $result = mysqli_query($mysqli, "SELECT * FROM Person ORDER BY last_name, first_name");

        //If there are results, display them on a table
        if ($result) {
            echo "<table border='1'><tr><th>First</th><th>Last</th><th>Email</th></tr>";

        //Loops through each result and displays on table
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['first_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['email']}</td>
                 </tr>";
        }
        echo "</table>";
        }
    }

    //Searches for people by last name
    if (isset($_POST['search_last'])) {
        $search_name = mysqli_real_escape_string($mysqli, $_POST['search_last_name']);

        //Case-insensitive search for last name
        $result = mysqli_query($mysqli, 
            "SELECT * FROM Person WHERE LOWER(last_name) = LOWER('$search_name')");

        //If there are results, display them on a table
        if ($result) {
            echo "<table border='1'><tr><th>First</th><th>Last</th><th>Email</th></tr>";

            //Loops through each result and displays on table
            while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['first_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['email']}</td>
                 </tr>";
            }
            echo "</table>";
        }
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
