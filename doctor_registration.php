<?php
session_start();

// Include database connection
require_once 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Prepare and execute the insert query for doctor registration (no need to include doctor_id)
        $stmt = $pdo->prepare("INSERT INTO doctor (doctorName, contact, email_adress) VALUES (?, ?, ?)");

        // Execute the query with form data
        $stmt->execute([
            $_POST['doctorName'],
            $_POST['contact'],
            $_POST['email_adress']
        ]);

        // Success message
        $_SESSION['success'] = "Doctor registered successfully!";
        header('Location: doctor_registration.php');
        exit;

    } catch (Exception $e) {
        // Error message
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header('Location: doctor_registration.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration</title>
    <link rel="stylesheet" href="patient_registration.css"> <!-- Reuse the same stylesheet -->
</head>
<body>
    <!-- Top Bar with Beautified Heading -->
    <header>
        <div class="top-bar">
            <h1>Maternal Health Tracking System</h1>
        </div>
        <!-- Navigation Bar -->
        <nav class="navigation-bar">
            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
            <a href="homepage.php" class="<?php echo ($current_page === 'homepage.php') ? 'active' : ''; ?>">Home</a>
            <a href="patient_registration.php" class="<?php echo ($current_page === 'patient_registration.php') ? 'active' : ''; ?>">Patient Registration</a>
            <a href="doctor_registration.php" class="<?php echo ($current_page === 'doctor_registration.php') ? 'active' : ''; ?>">Doctor Registration</a>
            <a href="health_dashboard.php" class="<?php echo ($current_page === 'health_dashboard.php') ? 'active' : ''; ?>">Health Dashboard</a>
            <a href="health.php" class="<?php echo ($current_page === 'health.php') ? 'active' : ''; ?>">Health Tracking</a>
            <a href="notifications.php" class="<?php echo ($current_page === 'notifications.php') ? 'active' : ''; ?>">Notifications</a>
            <a href="about.php" class="<?php echo ($current_page === 'about.php') ? 'active' : ''; ?>">About Us</a>
        </nav>
    </header>

    <!-- Doctor Registration Form -->
    <main>
        <section class="form-container">
            <h1>Register Doctor</h1>

            <!-- Success or error message -->
            <?php
            if (isset($_SESSION['success'])) {
                echo "<p class='success-message'>".$_SESSION['success']."</p>";
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                echo "<p class='error-message'>".$_SESSION['error']."</p>";
                unset($_SESSION['error']);
            }
            ?>

            <!-- Doctor Registration Form -->
            <form action="doctor_registration.php" method="POST">
                <div class="form-group">
                    <label for="doctorName">Doctor's Name:</label>
                    <input type="text" id="doctorName" name="doctorName" placeholder="Enter doctor's name" required>
                </div>
                <div class="form-group">
                    <label for="contact">Contact Number:</label>
                    <input type="tel" id="contact" name="contact" placeholder="Enter contact number" required>
                </div>
                <div class="form-group">
                    <label for="email_adress">Email Address:</label>
                    <input type="email" id="email_adress" name="email_adress" placeholder="Enter doctor's email address" required>
                </div>

                <button type="submit" class="submit-btn">Register Doctor</button>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date('Y'); ?> Maternal Health Tracking System. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
