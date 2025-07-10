<?php 
/*
  File: carDisplay.php
  Author: Jackson Champion
  Date: 2025-07-09
  Course: CPSC 3750 – Web Application Development
  Purpose: Displays the user's selected cars stored in the PHP session.
  Notes: Displays session data using PHP
*/
session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Display</title>
</head>
<body>
    <h1>Car Display Page</h1>
    <div id="navbar"></div>

    <!--Displays list of cars-->
    <h1>Your Selected Cars:</h1>
    <?php
    if (!empty($_SESSION['cars'])) {
        echo "<ul>";
        foreach ($_SESSION['cars'] as $car) {
            echo "<li>$car</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No cars selected</p>";
    }
    ?>

     <!-- Clear Car Selection-->
    <form action="carSelect.php" method="post">
        <button type="submit" name="clear">Clear Car Selections</button>
    </form>

    <!-- Go Back to Car Selection Page -->
    <form action="carSelect.php" method="get">
        <button type="submit">Back to Car Selection Page</button>
    </form>

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
