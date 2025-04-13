<?php
session_start(); // Start the session

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maternal Health Tracking System</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMXKtxzDgOsrGRtp1nANVOF0sA9oM/q77l3f1ps" crossorigin="anonymous">
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
            <a href="health_dashboard.php" class="<?php echo ($current_page === 'health_dashboard.php') ? 'active' : ''; ?>">Health Dashboard</a>
            <a href="health.php" class="<?php echo ($current_page === 'health.php') ? 'active' : ''; ?>">Health Tracking</a>
            <a href="notifications.php" class="<?php echo ($current_page === 'notifications.php') ? 'active' : ''; ?>">Notifications</a>
            <a href="doctor_registration.php" class="<?php echo ($current_page === 'doctor_registration.php') ? 'active' : ''; ?>"> Doctor</a>
            <a href="appointments.php" class="<?php echo ($current_page === 'appointments.php') ? 'active' : ''; ?>">Make Appointment</a>
            <a href="about.php" class="<?php echo ($current_page === 'about.php') ? 'active' : ''; ?>">About Us</a>

            <!-- Logout Button -->
            <form action="logout.php" method="POST" style="display:inline;">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </nav>
    </header>

    <!-- Hero Section -->
    <main>
        <section class="hero-section">
            <div class="hero-content">
                <h1>Welcome to Maternal Health</h1>
                <p>Ensuring the well-being of mothers and their babies</p>
                <a href="about.php" class="btn">Learn More</a>
            </div>
        </section>

        <!-- Information Section -->
        <section class="info-section">
            <div class="info-card">
                <h3>Patient Records</h3>
                <img src="images/records.jpeg" alt="Patient Records">
                <p>Register patients and view their profiles, health data, and medical history.</p>
            </div>
            <div class="info-card">
                <h3>Health Dashboard</h3>
                <img src="images/maternal_health.jpeg" alt="Health Dashboard">
                <p>View analytics and trends in maternal health data.</p>
            </div>
            <div class="info-card">
                <h3>Health Tracking</h3>
                <img src="images/nurse.jpg" alt="Health Tracking">
                <p>Track vital health indicators and flag high-risk cases.</p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <p>&copy; 2024 Maternal Health Tracking System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
