<?php
session_start();
require_once 'db.php';  // Include database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Check if all required fields are set
        if (isset($_POST['appointment_name'], $_POST['patient_name'], $_POST['appointment_time'], $_POST['status'])) {
            // Retrieve the patient_name from the form
            $patient_name = $_POST['patient_name'];
            
            // Query the database to find the patient_id for the given patient_name
            $stmt = $pdo->prepare("SELECT patient_id FROM patient WHERE patient_name = ?");
            $stmt->execute([$patient_name]);

            // Fetch the patient_id from the database
            $patient = $stmt->fetch();

            // Check if patient is found
            if ($patient) {
                $patient_id = $patient['patient_id'];

                // Prepare SQL query to insert the appointment into the database
                $stmt = $pdo->prepare("INSERT INTO appointments (appointment_name, appointment_time, patient_id, status)
                                       VALUES (?, ?, ?, ?)");

                // Set values from form input
                $appointment_name = $_POST['appointment_name'];
                $appointment_time = $_POST['appointment_time'];
                $status = $_POST['status'];

                // Execute the query with the data from the form
                $stmt->execute([$appointment_name, $appointment_time, $patient_id, $status]);

                // Set success message in session
                $_SESSION['success'] = 'Appointment created successfully!';
            } else {
                // If patient not found, set error message
                $_SESSION['error'] = 'Patient not found!';
            }
        } else {
            // If any field is missing, set error message
            $_SESSION['error'] = 'All fields are required!';
        }
    } catch (Exception $e) {
        // Handle any error and set error message
        $_SESSION['error'] = 'Error: ' . $e->getMessage();
    }

    // Redirect back to the appointment page
    header('Location: appointments.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Appointment</title>
    <link rel="stylesheet" href="patient_registration.css"> <!-- Use the existing stylesheet -->
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
            <a href="appointments.php" class="<?php echo ($current_page === 'appointments.php') ? 'active' : ''; ?>">Appointments</a>
            <a href="about.php" class="<?php echo ($current_page === 'about.php') ? 'active' : ''; ?>">About Us</a>
        </nav>
    </header>

    <!-- Appointment Section -->
    <main>
        <section class="appointment-container">
            <h1>Create Appointment</h1>

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

            <form action="appointments.php" method="POST">
                <label for="patient_name">Patient Name:</label>
                <input type="text" name="patient_name" placeholder="Enter patient name" required>

                <label for="appointment_name">Appointment Type:</label>
                <select name="appointment_name" id="appointment_name" required>
                    <option value="Initial Consultation">Initial Consultation</option>
                    <option value="Routine Check-up">Routine Check-up</option>
                    <option value="Prenatal Appointment">Prenatal Appointment</option>
                    <option value="Postpartum Check-up">Postpartum Check-up</option>
                    <option value="Ultrasound Appointment">Ultrasound Appointment</option>
                    <option value="Blood Pressure Monitoring">Blood Pressure Monitoring</option>
                    <option value="Diabetes Screening">Diabetes Screening</option>
                    <option value="Growth & Development Check">Growth & Development Check</option>
                    <option value="Immunization Appointment">Immunization Appointment</option>
                    <option value="Lab Results Follow-up">Lab Results Follow-up</option>
                    <option value="Diet & Lifestyle Counseling">Diet & Lifestyle Counseling</option>
                    <option value="Emergency Consultation">Emergency Consultation</option>
                    <option value="Blood Test Follow-up">Blood Test Follow-up</option>
                    <option value="Fetal Health Monitoring">Fetal Health Monitoring</option>
                    <option value="Gynecological Exam">Gynecological Exam</option>
                </select>

                <label for="appointment_time">Appointment Time:</label>
                <input type="datetime-local" name="appointment_time" required>

                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="Scheduled">Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>

                <button type="submit">Create Appointment</button>
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
