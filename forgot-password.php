<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email from POST data
    $email = $_POST['email'];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "cattle_management_system");

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT username FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a reset token
        $token = bin2hex(random_bytes(50));
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Send the password reset email
        $resetLink = "https://yourwebsite.com/reset-password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the link to reset your password: $resetLink";
        $headers = "From: no-reply@yourwebsite.com";

        mail($email, $subject, $message, $headers);

        echo "Password reset link has been sent to your email.";
    } else {
        echo "Email not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Forgot password form -->
<form method="POST">
    <label for="email">Enter your email:</label>
    <input type="email" name="email" id="email" placeholder="Your email address" required />
    <button type="submit" class="forgot-password-btn">Submit</button>
</form>
