<?php
session_start();

// Include database connection
require_once 'db.php';

// Fetch all doctors from the database
$stmt = $pdo->query("SELECT * FROM doctor");
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission to store selected doctor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_SESSION['patient_id']; // Assuming patient ID is stored in session
    $doctor_id = $_POST['doctor_id'];

    try {
        // Insert the selected doctor into the patient's record (or notifications table, depending on your schema)
        $stmt = $pdo->prepare("INSERT INTO notifications (patient_id, doctor_id, status) VALUES (?, ?, 'Pending')");
        $stmt->execute([$patient_id, $doctor_id]);

        $_SESSION['success'] = "Doctor selected successfully! Now you can send notifications to the selected doctor.";
        header('Location: notifications.php'); // Redirect to notifications page
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header('Location: select_doctor.php'); // Redirect back to the select doctor page
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Doctor</title>
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
            <a href="homepage.php">Home</a>
            <a href="patient_registration.php">Patient Registration</a>
            <a href="health_dashboard.php">Health Dashboard</a>
            <a href="health.php">Health Tracking</a>
            <a href="notifications.php">Notifications</a>
            <a href="about.php">About Us</a>
        </nav>
    </header>

    <!-- Doctor Selection Form -->
    <main>
        <section class="form-container">
            <h1>Select Your Doctor</h1>

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

            <!-- Doctor Selection Form -->
            <form action="select_doctor.php" method="POST">
                <div class="form-group">
                    <label for="doctor_id">Select a Doctor:</label>
                    <select name="doctor_id" id="doctor_id" required>
                        <option value="">Choose a doctor</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['doctorName']; ?> - <?php echo $doctor['email_adress']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="submit-btn">Select Doctor</button>
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
