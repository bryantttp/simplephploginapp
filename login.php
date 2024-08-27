<?php

    include('config/database.php');
    include('functions/functions.php');

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = sanitize_input($_POST['username']);
        $password = sanitize_input($_POST['password']);
    
        if (authenticate_user($conn, $username, $password)) {
            $_SESSION['username'] = $username;
            header("Location: welcome.php");
        } else {
            $error = "Invalid username or password!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Login Page</h2>
    <form method="POST" action="login.php">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</body>
</html>