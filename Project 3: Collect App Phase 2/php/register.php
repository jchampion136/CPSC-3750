<?php
/*
  File: register.php
  Author: Jackson Champion
  Date: 2025-07-27
  Course: CPSC 3750 – Web Application Development
  Purpose: Create a new user account registration page
  Notes: Inserts user into database with password and security questions if email does not already exist
*/

// DB connection
$mysqli = new mysqli("localhost",  "ewnuvdmy_demo_user", "JJ1241378j", "ewnuvdmy_magicDB");

//Check if the connection fails
if (mysqli_connect_errno()) {
    printf("Connection failed: " . mysqli_connect_error());
    exit();
}

//Initializes message
$message = "";

// Handle registration
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $security_question = mysqli_real_escape_string($mysqli, $_POST['security_question']);
    $security_answer_hash = password_hash($_POST['security_answer'], PASSWORD_DEFAULT);

    //check if email already exists
    $check_email = mysqli_query($mysqli, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check_email) > 0) {
            $message = "Email already exists. Please use a different email.";
    } else {
        //Insert new user into the database
        $sql = "INSERT INTO users (name, email, password_hash, security_question, security_answer_hash) 
            VALUES ('$name', '$email', '$password', '$security_question', '$security_answer_hash')";
        
        //Check if query was successful and display message
        if (mysqli_query($mysqli, $sql)) {
            $message = "Registration successful! You can now <a href='login.php'>log in</a>.";
        } else {
            $message = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div id="navbar"></div>
    </nav>

    <h1>Create an Account</h1>


<!-- Display success or error messages -->
    <?php if ($message) echo "<p style='color: green; font-weight: bold;'>$message</p>"; ?>

    <!-- Registration Form -->
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>Security Question:</label>
        <input type="text" name="security_question" required><br>

        <label>Answer:</label>
        <input type="text" name="security_answer" required><br><br>

        <button type="submit" name="register">Register</button>
    </form>

     <a href="login.php" class="button-link">Return to Login</a>

    <footer>
        <h3>Contact Me</h3>
        <p> Email me at <a href="mailto:jackson.champion136@gmail.com">jackson.champion136@gmail.com</a></p>
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
