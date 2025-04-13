<?php
session_start();
require_once 'db.php'; // Include the database connection file

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Prepare the SQL query to check if the user exists
        $stmt = $pdo->prepare("SELECT user_id, password FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user is found and password matches
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables for the logged-in user
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $username;

            // Redirect to the homepage or dashboard after successful login
            header('Location: homepage.php');
            exit();
        } else {
            $_SESSION['error'] = 'Invalid username or password!';
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Maternal Health Tracking System</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h1>Welcome Back</h1>
        <p>Log in to your account</p>
        
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='error'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']); // Clear the error message after displaying
        }
        ?>

        <!-- Login form -->
        <form action="login.php" method="POST" class="login-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>
            <button type="submit" class="login-btn">Login</button>
            <p class="redirect">Don't have an account? <a href="signup.php">Register here</a></p>
        </form>
    </div>
</body>
</html>
