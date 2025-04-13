<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Dashboard - Maternal Health Tracking</title>
    <link rel="stylesheet" href="health_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMXKtxzDgOsrGRtp1nANVOF0sA9oM/q77l3f1ps" crossorigin="anonymous">
</head>
<body>
    <!-- Header and Navigation -->
    <header>
        <div class="top-bar">
            <h1>Maternal Health Tracking System</h1>
        </div>
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Health Dashboard</h1>
            <p>Monitor and track the health of patients and ensure better care outcomes.</p>
        </div>
    </section>

    <!-- Dashboard Section -->
    <main class="dashboard-section">
    <div class="stats">
    <div class="stat-box">
        <div class="icon">
            <i class="fas fa-users"></i>
        </div>
        <h2>Registered Patients</h2>
        <p>120</p>
    </div>
    <div class="stat-box">
        <div class="icon">
            <i class="fas fa-heartbeat"></i>
        </div>
        <h2>High-Risk Cases</h2>
        <p>15</p>
    </div>
    <div class="stat-box">
        <div class="icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <h2>Upcoming Appointments</h2>
        <p>20</p>
    </div>
    <div class="stat-box">
        <div class="icon">
            <i class="fas fa-bell"></i>
        </div>
        <h2>Notifications Sent</h2>
        <p>350</p>
    </div>
</div>


        <!-- Health Trends Section -->
        <div class="charts">
            <h2>Health Trends</h2>
            <div class="chart-container">
                <div class="chart-placeholder">
                    <p>Pie Chart: Risk Assessment</p>
                    <!-- Placeholder for pie chart -->
                </div>
                <div class="chart-placeholder">
                    <p>Bar Chart: Monthly Appointments</p>
                    <!-- Placeholder for bar chart -->
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date('Y'); ?> Maternal Health Tracking System. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
