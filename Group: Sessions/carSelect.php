<?php 
/*
  File: carSelect.php
  Author: Jackson Champion
  Date: 2025-07-09
  Course: CPSC 3750 – Web Application Development
  Purpose: Allows the user to select from a list of their favorite cars
  Notes: Uses form submission using PHP
*/
session_start();

// resets the user's list of cars they choose
if (isset($_POST['clear'])) {
    unset($_SESSION['cars']);
    $message = "Car selections cleared.";
}

// Handles car submissions the user selected
if (isset($_POST['cars'])) {
    if (!empty($_SESSION['cars'])) {
        $cars = array_unique(array_merge($_SESSION['cars'], $_POST['cars']));
        $_SESSION['cars'] = $cars;
    } else {
        $_SESSION['cars'] = $_POST['cars'];
    }
    $message = "Your car selections have been saved!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Selection Page</title>
</head>
<body>
    <h1>Car Selection Page</h1>
    <div id="navbar"></div>

    <!-- Form to select and submit favorite cars-->
    <form action="carSelect.php" method="post">
        <label for="cars">Choose cars:</label><br>
        <select name="cars[]" id="cars" multiple>
            <option value="Jeep Wrangler">Jeep Wrangler</option>
            <option value="Toyota Camry">Toyota Camry</option>
            <option value="Subaru Crosstrek">Subaru Crosstrek</option>
            <option value="Nissan Altima">Nissan Altima</option>
            <option value="Mercedes Benz">Mercedes Benz</option>
            <option value="Ford F150">Ford F150</option>
            <option value="Dodge Challenger">Dodge Challenger</option>
        </select><br><br>
        <!--Submits user's choices -->
        <button type="submit">Submit</button> 
    </form>
    <!--Button takes user to display page -->
    <form action="carDisplay.php" method="post">
        <button type="submit">Go to Car Display Page</button>
    </form>

    <!--Shows car saved or cleared message-->
    <?php 
    if (isset($message)) {
        echo "<p><strong>$message</strong></p>";
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
