<?php
// Include database connection setup
require_once 'db.php';

$successMessage = $errorMessage = ''; // Initialize success and error messages

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Fetch the patient_id corresponding to the patient name
        $patient_name = $_POST['patient_name'];
        $stmt = $pdo->prepare("SELECT patient_id FROM patient WHERE patient_name = ?");
        $stmt->execute([$patient_name]);
        $patient = $stmt->fetch();

        if ($patient) {
            // Patient found, proceed with inserting health record
            $patient_id = $patient['patient_id'];

            // Prepare and execute the insert query for health records
            $stmt = $pdo->prepare("INSERT INTO healthrecords (visit_date, blood_pressure, weight, haemoglobin, complications, patient_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['visit_date'],
                $_POST['blood_pressure'],
                $_POST['weight'],
                $_POST['hemoglobin_level'],
                $_POST['complications'],
                $patient_id  // Using the fetched patient_id
            ]);

            $successMessage = "Health record added successfully!";
        } else {
            $errorMessage = "Patient not found!";
        }
    } catch (Exception $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
}

// Fetch records for the current patient (replace `1` with dynamic `patient_id`)
// Optionally, you can remove this block if patient records should be displayed dynamically
$patient_id = 1; // This should be dynamically fetched based on session or user
$sql = "SELECT * FROM healthrecords WHERE patient_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$patient_id]);
$records = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maternal Health Tracking</title>
    <link rel="stylesheet" href="health.css">
</head>
<body>

<!-- Top Bar with Beautified Heading -->
<header>
    <div class="top-bar">
        <h1>Maternal Health Tracking</h1>
    </div>

    <!-- Navigation Bar -->
    <nav class="navigation-bar">
        <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
        <a href="homepage.php" class="<?php echo ($current_page === 'homepage.php') ? 'active' : ''; ?>">Home</a>
        <a href="health.php" class="<?php echo ($current_page === 'health.php') ? 'active' : ''; ?>">Maternal Health</a>
        <a href="patient_registration.php" class="<?php echo ($current_page === 'patient_registration.php') ? 'active' : ''; ?>">Patient Registration</a>
        <a href="notifications.php" class="<?php echo ($current_page === 'notifications.php') ? 'active' : ''; ?>">Notifications</a>
        <a href="appointments.php" class="<?php echo ($current_page === 'appointments.php') ? 'active' : ''; ?>">Make Appointment</a>
        <a href="doctor_registration.php" class="<?php echo ($current_page === 'doctor_registration.php') ? 'active' : ''; ?>"> Doctor</a>
        <a href="about.php" class="<?php echo ($current_page === 'about.php') ? 'active' : ''; ?>">About Us</a>
    </nav>
</header>

<main>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Maternal Health Tracking</h1>
            <p>Track vital health indicators to ensure the safety of mothers and babies.</p>
        </div>
    </section>

    <!-- Input Form for New Maternal Health Record -->
    <section class="form-section">
        <h2>Add New Maternal Health Record</h2>
        
        <?php if (isset($successMessage)): ?>
            <p style="color: green;"><?php echo $successMessage; ?></p>
        <?php elseif (isset($errorMessage)): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        
        <form action="health.php" method="POST" class="form">
            <!-- Patient Name Field -->
            <div class="form-group">
                <label for="patient_name">Patient Name</label>
                <input type="text" id="patient_name" name="patient_name" required placeholder="Enter patient's name">
            </div>

            <div class="form-group">
                <label for="visit_date">Visit Date</label>
                <input type="date" id="visit_date" name="visit_date" required>
            </div>
            <div class="form-group">
                <label for="blood_pressure">Blood Pressure (e.g., 120/80)</label>
                <input type="text" id="blood_pressure" name="blood_pressure" required>
            </div>
            <div class="form-group">
                <label for="weight">Weight (kg)</label>
                <input type="number" step="0.1" id="weight" name="weight" required>
            </div>
            <div class="form-group">
                <label for="hemoglobin_level">Hemoglobin Level (g/dL)</label>
                <input type="number" step="0.1" id="hemoglobin_level" name="hemoglobin_level" required>
            </div>
            <div class="form-group">
                <label for="complications">Complications (if any)</label>
                <textarea id="complications" name="complications" rows="3" placeholder="Describe complications (if any)"></textarea>
            </div>
            <button type="submit" class="save-btn">Save</button>
        </form>
    </section>

    <!-- Display Existing Maternal Health Records -->
    <section class="records-section">
        <h2>Your Maternal Health Records</h2>
        
        <?php if (count($records) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Visit Date</th>
                        <th>Blood Pressure</th>
                        <th>Weight (kg)</th>
                        <th>Hemoglobin Level (g/dL)</th>
                        <th>Complications</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['visit_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['blood_pressure']); ?></td>
                            <td><?php echo htmlspecialchars($row['weight']); ?></td>
                            <td><?php echo htmlspecialchars($row['haemoglobin']); ?></td>
                            <td><?php echo htmlspecialchars($row['complications']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No health records found.</p>
        <?php endif; ?>
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
