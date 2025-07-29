<?php
/*
  File: reset_password.php
  Author: Jackson Champion
  Date: 2025-07-27
  Course: CPSC 3750 – Web Application Development
  Purpose: Allow users to reset their password using a security question
  Notes: resets password and failed attempts When answer is correct
*/
session_start();

// DB connection
$mysqli = new mysqli("localhost",  "ewnuvdmy_demo_user", "JJ1241378j", "ewnuvdmy_magicDB");

//Check if the connection fails
if (mysqli_connect_errno()) {
    printf("Connection failed: " . mysqli_connect_error());
    exit();
}

//Initializes messages
$message = "";

//User enters email to fetch security question
if (isset($_POST['find_question'])) {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $result = mysqli_query($mysqli, "SELECT security_question FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    // If user exists, fetch the security question
    if ($user) {
        $security_question = $user['security_question'];
    } else { // If no user found, set message
        $message = "No account found with that email.";
    }
}

//User submits the security answer and enters new password
if (isset($_POST['reset_password'])) {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $answer = mysqli_real_escape_string($mysqli, $_POST['security_answer']);
    $new_password = mysqli_real_escape_string($mysqli, $_POST['new_password']);
    $result = mysqli_query($mysqli, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    // If user exists, verify the security answer
    if ($user) {
        // Verify security answer
        if (password_verify($answer, $user['security_answer_hash'])) {

            //Hash the new password and update it in the database
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            mysqli_query($mysqli, "UPDATE users SET password_hash='$new_password_hash', failed_attempts=0 WHERE email='$email'");
            $message = "Password reset successful! You can now <a href='login.php'>log in</a>.";
            
            // Clear the question after reset
            $security_question = ""; 
        } else {
            $message = "Incorrect security answer.";
        }
    } else {
        $message = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>  
    <nav>
        <div id="navbar"></div>
    </nav>

    <h1>Reset Your Password</h1>

    <!-- Display success or error messages -->
    <?php if ($message) echo "<p style='color: green; font-weight: bold;'>$message</p>"; ?>

    <!-- Form For reset password -->
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <!--Display security question if available-->
        <?php if (!empty($security_question)): ?>
            <label><?php echo $security_question; ?></label>
            <input type="text" name="security_answer" required><br>

            <label>New Password:</label>
            <input type="password" name="new_password" required><br>
    
            <button type="submit" name="reset_password">Reset Password</button>
        <?php else: ?>
            <button type="submit" name="find_question">Find Security Question</button>
        <?php endif; ?>
    </form>

    <!--button to return to login page-->
    <a href="login.php" class="button-link">Back to Login</a>

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
