<?php
session_start(); // Start the session
// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['login_user_id'])) {
    header("Location: ../index.php");
    exit();
}
?>

<?php include('../header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maternal Health Tracking System</title>
    <link rel="stylesheet" href="css/index.css">
    

</head>
<body>
    <!-- Top Bar with Beautified Heading -->
    <header>
        <?php include '../topbar.php' ?>
        <?php include '../navbar.php' ?>
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

<script>
$(document).ready(function() {
    $(document).on("click", ".logout-btn", function() { 
        if (confirm("Are you sure you want to logout?")) { // Confirmation popup
            $.ajax({
                url: '../ajax/ajax.php?action=logout',
                method: 'POST',
                success: function(resp) {
                    console.log("Logout Response:", resp); // ✅ Debugging Output
                    if (resp.trim() == "1") { // Ensure it's properly checked
                        window.location.href = "../index.php"; // Redirect after logout
                    } else {
                        alert("Logout failed. Please try again.");
                    }
                },
                error: function(err) {
                    console.error("AJAX Error:", err);
                }
            });
        }
    });
});

</script>
</html>
