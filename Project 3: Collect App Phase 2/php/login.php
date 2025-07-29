<?php
/*
  File: login.php
  Author: Jackson Champion
  Date: 2025-07-27
  Course: CPSC 3750 – Web Application Development
  Purpose: Prvide user login functionality and validation
  Notes: Locks account after 3 failed attempts, uses password hashing for security and uses PHP sessions to manage login states
  Includes Forgot password and registration links
*/
session_start();


// DB connection
$mysqli = new mysqli("localhost", "ewnuvdmy_demo_user", "JJ1241378j", "ewnuvdmy_magicDB");

//Check for connection errors
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
//Initializes message 
$message = "";

//handles login form submitted
if (isset($_POST['login'])) {

    //Escape user input email to prevent SQL injection
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);

    //Gets raw password from form
    $password = $_POST['password'];

    // Fetch user based on email
    $result = mysqli_query($mysqli, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Check if account is locked from number of failed attempts
        if ($user['failed_attempts'] >= 3) {
            $message = "Account locked! Reset password to unlock.";
        } else {
            // Verify password
            if (password_verify($password, $user['password_hash'])) {
                //Successful login that will reset failed attempts
                mysqli_query($mysqli, "UPDATE users SET 
                    last_login = NOW(), 
                    login_count = COALESCE(login_count, 0) + 1,
                    failed_attempts = 0
                    WHERE id = {$user['id']}");

                // Stores session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];

                // Alert user of successful login
                echo "<script>
                    alert('Login successful! Welcome, " . htmlspecialchars($user['name']) . ". Redirecting to Collect App...');
                    window.location.href = 'collectApp.html';
                </script>";

                // Redirect back to Collect App
                header("Location: collectApp.html");
                exit;

            } else {
                // Wrong password adds one to failed attempts
                mysqli_query($mysqli, "UPDATE users SET failed_attempts = failed_attempts + 1 WHERE id = {$user['id']}");
                $message = "Incorrect password.";
            }
        }
    } else {
        $message = "No account found with that email.";
    }
}

//Handles logout request
if (isset($_GET['logout'])) {
    session_destroy();

    echo "<script>
        alert('You have successfully logged out.');
        window.location.href = 'collectApp.html';
    </script>";
    exit; 
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>User Login</h1>
    
    <nav>
        <div id="navbar"></div>
    </nav>

    <!--Displays login error or success messages-->
    <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>

    <!-- Login Form -->
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>
     <a href="collectApp.html" class="button-link">Return to Search Page</a>

    <!-- Links for password reset-->
    <p><a href="reset_password.php">Forgot your password?</a></p>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
    
    
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
