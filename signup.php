<?php
session_start();
require_once 'db.php'; // Include the database connection file

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form values
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare SQL to check if the username or email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $_SESSION['error'] = "Username or email already exists!";
        } else {
            // Insert the new user into the database
            $stmt = $pdo->prepare("INSERT INTO users (username, password, email, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$username, $hashed_password, $email, $first_name, $last_name]);

            // Redirect to login page after successful registration
            $_SESSION['success'] = "Registration successful! You can now log in.";
            header('Location: login.php');
            exit();
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
    <title>Signup - Maternal Health Tracking System</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="signup-container">
        <h1>Create an Account</h1>
        <p>Fill in the form to register</p>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='error'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        ?>

        <form action="signup.php" method="POST" class="signup-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required placeholder="Choose a username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required placeholder="Choose a password">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required placeholder="Enter your first name">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required placeholder="Enter your last name">
            </div>
            <button type="submit" class="signup-btn">Register</button>
            <p class="redirect">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>
