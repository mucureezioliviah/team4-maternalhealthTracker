<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file = $_FILES['profile_pic'];

    if (in_array($file['type'], $allowed_types) && $file['size'] <= 2 * 1024 * 1024) { // 2MB limit
        $target_dir = "uploads/";
        $filename = basename($file['name']);
        $target_file = $target_dir . uniqid() . "_" . $filename;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Update profile picture in the database
            require 'db.php';
            $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE username = ?");
            $stmt->bind_param("ss", $target_file, $_SESSION['username']);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            $_SESSION['profile_pic'] = $target_file;
        }
    } else {
        $_SESSION['upload_error'] = "Invalid file type or size exceeds 2MB.";
    }
}
header("Location: homePage.php");
exit();
?>
