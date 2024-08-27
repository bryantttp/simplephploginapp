<?php

    include('config/database.php');
    include('functions/functions.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = sanitize_input($_POST['username']);
        $password = sanitize_input($_POST['password']);
        $confirm_password = sanitize_input($_POST['confirm_password']);
    
        // Check if passwords match
        if ($password != $confirm_password) {
            $error = "Passwords do not match!";
        } else {
            // Check if username or email already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
    
            if ($stmt->num_rows > 0) {
                $error = "Username already exists!";
            } else {
                // Insert new user into the database
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $username, $hashed_password);
                if ($stmt->execute()) {
                    header("Location: login.php?signup=success");
                    exit();
                } else {
                    $error = "Error in registration. Please try again.";
                }
            }
        }
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup</title>
        <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
        <h2>Signup Page</h2>
        <form method="POST" action="signup.php">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Signup</button>
        </form>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    </body>
    </html>