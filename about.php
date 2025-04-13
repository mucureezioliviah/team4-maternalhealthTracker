<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Maternal Health Tracking System</title>
    <link rel="stylesheet" href="about.css"> <!-- Use the same stylesheet as the homepage -->
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
            <a href="about.php" class="<?php echo ($current_page === 'about.php') ? 'active' : ''; ?>">About Us</a>
        </nav>
    </header>

    <!-- About Us Section -->
    <main>
        <section class="about-container">
            <h1>About Maternal Health Tracking System</h1>
            <p>
                The Maternal Health Tracking System (MHTS) is designed to improve the health and well-being of pregnant women by providing an efficient and user-friendly platform for tracking maternal health indicators. 
                Our system enables healthcare providers to monitor patient progress, manage appointments, and send reminders for medication and checkups, ensuring a safer and healthier journey for expectant mothers.
            </p>
            <p>
                This platform is developed with the mission of reducing maternal mortality rates and ensuring that every mother receives the care she needs. By leveraging technology, we aim to bridge the gap between healthcare providers and patients, fostering a more connected and supportive healthcare ecosystem.
            </p>

            <div class="team-section">
                <h2>Our Team</h2>
                <p>
                    The MHTS project is developed by a passionate team of healthcare professionals, software developers, and data analysts. Our goal is to revolutionize maternal healthcare with innovative and accessible solutions.
                </p>
                <ul>
                    <li>Tonny Twesigye- Project Lead & Healthcare Specialist</li>
                    <li>Kihembo Daniel - Software Developer</li>
                    <li>Natukunda Jovita- Data Analyst</li>
                    <li>Mugumya Edwin- UX/UI Designer</li>
                </ul>
            </div>
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
