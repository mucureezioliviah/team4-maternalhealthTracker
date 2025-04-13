<?php
session_start();
require_once 'db.php';  // Include database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Check if all required fields are set
        if (isset($_POST['type'], $_POST['recipient'], $_POST['subject'], $_POST['message'], $_POST['patient_name'], $_POST['doctor_id'])) {
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
                $doctor_id = $_POST['doctor_id']; // Get the doctor selected by the patient
                
                // Prepare SQL query to insert the notification into the database
                $stmt = $pdo->prepare("INSERT INTO notifications (notification_type, recipient_email, subject, message, patient_id, doctor_id, status)
                                       VALUES (?, ?, ?, ?, ?, ?, ?)");

                // Set default values for other fields
                $notification_type = $_POST['type'];
                $recipient_email = $_POST['recipient'];
                $subject = $_POST['subject'];
                $message = $_POST['message'];
                $status = 'Pending'; // Set status to 'Pending'

                // Execute the query with the data from the form
                $stmt->execute([$notification_type, $recipient_email, $subject, $message, $patient_id, $doctor_id, $status]);

                // Set success message in session
                $_SESSION['success'] = 'Notification sent successfully!';
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

    // Redirect back to the notifications page
    header('Location: notifications.php');
    exit;
}

// Fetch all doctors from the database for selection
$stmt = $pdo->query("SELECT doctor_id, doctorName FROM doctor");
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="notifications.css">
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

    <!-- Notifications Section -->
    <main>
        <section class="notifications-container">
            <div class="image-container">
                <img src="images/notifications.jpeg" alt="Notification Icon" />
            </div>

            <h1>Send Notification</h1>

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

            <form action="notifications.php" method="POST">
                <label for="patient_name">Patient Name:</label>
                <input type="text" name="patient_name" placeholder="Enter patient name" required>

                <label for="type">Notification Type:</label>
                <select name="type" id="type" required>
                    <option value="reminder">Reminder</option>
                    <option value="alert">Alert</option>
                    <option value="general">General Notification</option>
                </select>

                <label for="doctor_id">Choose Doctor:</label>
                <select name="doctor_id" id="doctor_id" required>
                    <option value="">Select a doctor</option>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['doctorName']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="recipient">Recipient Email:</label>
                <input type="email" name="recipient" placeholder="Enter recipient's email" required>

                <label for="subject">Subject:</label>
                <input type="text" name="subject" placeholder="Enter notification subject" required>

                <label for="message">Message:</label>
                <textarea name="message" placeholder="Enter your message" required></textarea>

                <button type="submit">Send Notification</button>
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
