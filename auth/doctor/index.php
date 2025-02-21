<?php
session_start(); // Start the session
// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['login_user_id'])) {
    header("Location: ../index.php");
    exit();
}
// Include database connection setup
require_once '../db.php';
?>

<?php include('../header.php'); ?>
<style>
    body{
        background: rgb(230, 247, 255);
    }
   #main-content {
        background: rgb(230, 247, 255);
        width: 100%;
        margin-top: 55px;
        margin-left: 250px; /* Default margin to match sidebar width */
        padding: 10px;
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

</head>
<body>
    <?php include '../topbar.php' ?>
    <?php include '../navbar.php' ?>
    <?php include '../loading_overlay.php' ?>

    <div class="modal fade" id="uni_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <div id="msg"></div>

    <main id="main-content" >
        <?php $page = isset($_GET['page']) ? $_GET['page'] :'home'; ?>
  	    <?php include $page.'.php' ?>
    </main>

    <script src="../js/loader.js"></script>
    <script src="js/uni_modal.js"></script>
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
