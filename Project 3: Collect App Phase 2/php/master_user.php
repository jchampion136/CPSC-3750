<?php
/*
  File: master_user.php
  Author: Jackson Champion
  Date: 2025-07-27
  Course: CPSC 3750 – Web Application Development
  Purpose: Display a master list of all registered users in the system 
  Notes: Displays user details such as ID, name, email, last login time, login count, and failed attempts
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

//Check if the connection fails
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//Sql query to fetch recent users
$sql = "SELECT id, name, email, last_login, login_count, failed_attempts FROM users ORDER BY last_login DESC";
$result = mysqli_query($mysqli, $sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Master User List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div id="navbar"></div>
</nav>

<h2>Master User List</h2>

<!--button to return to search page-->
<div>
    <a href="collectApp.html" class="button-link">Return to Search Page</a>
</div>

<?php

if($result && mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Last Login</th>
                <th>Login Count</th>
                <th>Failed Attempts</th>
            </tr>";

    //Loops through each user and displays their details in the table
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['last_login'] . "</td>
                <td>" . $row['login_count'] . "</td>
                <td>" . $row['failed_attempts'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No users found.";
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
