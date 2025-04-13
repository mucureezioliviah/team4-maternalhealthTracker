<?php
// Include database connection setup
require_once 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Prepare and execute the insert query
        $stmt = $pdo->prepare("INSERT INTO patient (patient_name, patient_contact, patient_email, age, address, medical_history) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['patient_name'],
            $_POST['patient_contact'],
            $_POST['patient_email'],
            $_POST['age'],
            $_POST['address'],
            $_POST['medical_history']
        ]);
        $successMessage = "Patient added successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <link rel="stylesheet" href="patient_registration.css"> <!-- Use homepage.css for consistent styling -->
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
        </nav>
    </header>

    <!-- Registration Form Section -->
    <main>
        <section class="form-section">
            <div class="form-container">
                <!-- Left Side (Image) -->
                <div class="form-image">
                    <img src="images/sick person.jpg" alt="Health Image" />
                </div>

                <!-- Right Side (Form) -->
                <div class="form-right">
                    <h2>Register a New Patient</h2>

                    <!-- Display success or error message -->
                    <?php if (isset($successMessage)) { echo "<p class='success'>$successMessage</p>"; } ?>
                    <?php if (isset($errorMessage)) { echo "<p class='error'>$errorMessage</p>"; } ?>

                    <!-- Registration Form -->
                    <form method="POST" action="patient_registration.php" class="registration-form">
    <!-- Patient Name -->
    <label for="patient_name">Patient Name:</label>
    <input type="text" id="patient_name" name="patient_name" placeholder="Enter patient's full name" required>

    <!-- Age -->
    <label for="age">Age:</label>
    <input type="number" id="age" name="age" placeholder="Enter patient's age" min="1">

    <!-- Email -->
    <label for="email">Email:</label>
    <input type="email" id="email" name="patient_email" placeholder="Enter patient's email address" required>

    <!-- Phone -->
    <label for="phone">Phone:</label>
    <input type="tel" id="phone" name="patient_contact" placeholder="Enter patient's phone number" required pattern="^[0-9]{10}$">

    <!-- Address -->
    <label for="address">Address:</label>
    <textarea id="address" name="address" rows="3" placeholder="Enter patient's home address"></textarea>

    <!-- Medical History -->
    <label for="medical_history">Medical History:</label>
    <textarea id="medical_history" name="medical_history" rows="5" placeholder="Any relevant medical history?"></textarea>

    <!-- Submit Button -->
    <button type="submit">Register Patient</button>


                    </form>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <p>&copy; 2024 Maternal Health Tracking System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
