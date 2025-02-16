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
   #main-content {
        margin-top: 50px;
        margin-left: 250px; /* Default margin to match sidebar width */
        padding: 20px;
        transition: margin-left 0.3s ease; /* Smooth transition */
    }

    #main-content.sidebar-collapsed {
        margin-left: 60px; /* Adjusted margin for collapsed sidebar */
    }
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

    <main id="main-content" >
        <?php $page = isset($_GET['page']) ? $_GET['page'] :'home'; ?>
  	    <?php include $page.'.php' ?>
    </main>

    <script>
       document.addEventListener('DOMContentLoaded', function () {
            const mainContent = document.getElementById('main-content');

            // Function to apply the sidebar state to the main content
            function applySidebarState(isCollapsed) {
                if (isCollapsed === 'true') {
                    mainContent.classList.add('sidebar-collapsed');
                } else {
                    mainContent.classList.remove('sidebar-collapsed');
                }
                console.log('Main content script - Sidebar state applied:', isCollapsed);
            }

            // Read initial state from sessionStorage
            let isCollapsed = sessionStorage.getItem('sidebarCollapsed');
            applySidebarState(isCollapsed);

            // Listen for changes from the sidebar script
            window.addEventListener('sidebarStateChanged', function (event) {
                applySidebarState(event.detail.collapsed);
            });
        });


</script>

</body>
</html>
