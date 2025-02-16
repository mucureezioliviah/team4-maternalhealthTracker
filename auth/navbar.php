<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collapsible Sidebar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
        }

        #sidebar {
            width: 300px;
            height: 100%;
			padding-top: 50px;
            background: #343a40;
            transition: width 0.3s ease;
            overflow: hidden;
        }

        #sidebar.collapsed {
            width: 80px;
        }

        #sidebar .nav-item {
            display: flex;
            align-items: center;
            padding: 12px;
            color: white;
			background: #495057;
            text-decoration: none;
            transition: background 0.3s;
        }

        #sidebar .nav-item:hover {
            background:rgb(54, 59, 65);
        }

        #sidebar .icon-field {
            width: 40px;
            text-align: center;
        }

        #sidebar.collapsed .nav-item span.text {
            display: none;
        }

        #menu-toggle {
			width: 30px;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            margin: 10px;
        }

        #menu {
            width: 100%;
            background: #343a40;
            padding: 10px;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar" class="mx-lt-5 bg-dark">
        <div id="menu">
            <a id="menu-toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav>
            <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> <span class="text">Home</span></a>
            <a href="index.php?page=patient_registration" class="nav-item nav-patient"><span class='icon-field'><i class="fa fa-users"></i></span> <span class="text">Patient Registration</span></a>
            <a href="index.php?page=health_dashboard" class="nav-item nav-hdashboard"><span class='icon-field'><i class="fa fa-tachometer"></i></span> <span class="text">Health Dashboard</span></a>
            <a href="index.php?page=health" class="nav-item nav-health"><span class='icon-field'><i class="fa fa-th-list"></i></span> <span class="text">Health</span></a>
            <a href="index.php?page=appointments" class="nav-item nav-appointments"><span class='icon-field'><i class="fa fa-calendar"></i></span> <span class="text">Appointments</span></a>
			<a href="index.php?page=requests" class="nav-item nav-requests"><span class='icon-field'><i class="fa fa-envelope"></i></span> <span class="text">Requests</span></a>
            
            <?php if ($_SESSION['login_type'] == 1) : ?>
                <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> <span class="text">Users</span></a>
                <a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> <span class="text">System Settings</span></a>
            <?php else : ?>
                <a href="index.php?page=user_settings" class="nav-item nav-user-settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> <span class="text">User Settings</span></a>
            <?php endif; ?>
        </nav>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        });

        $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active');
    </script>
</body>
</html>
