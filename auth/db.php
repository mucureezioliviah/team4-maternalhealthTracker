<?php 
$conn = new mysqli('localhost', 'root', '', 'team6_maternaltracker');

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>