<?php
session_start(); // Start the session
// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['login_user_id'])) {
    header("Location: ../index.php");
    exit();
}
?>

<?php include('../header.php'); ?>
<style>
   
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maternal Health Tracking System</title>
    <link rel="stylesheet" href="css/index.css"> 

</head>
<body>
    <?php include '../topbar.php' ?>
    <?php include '../navbar.php' ?>

    <main id="view-panel" >
        <?php $page = isset($_GET['page']) ? $_GET['page'] :'home'; ?>
  	    <?php include $page.'.php' ?>
    </main>
</body>
</html>
