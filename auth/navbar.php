<?php
// Get the current page from the URL query parameter
$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';

?>

<style>
    body {
        display: flex;
    }
    #sidebar {
        position: fixed;
        width: 250px;
        height: 100vh;
		padding-top: 50px;
        background: #343a40;
        transition: width 0.3s ease;
        overflow: hidden;
        top: 0px;
        left: 0px;
    }
    #sidebar.collapsed {
        width: 60px;
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
    #sidebar .nav-item-active{
        display: flex;
        align-items: center;
        padding: 12px;
        color: rgb(208, 234, 255);
        background:rgb(65, 71, 79);
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
    #sidebar.collapsed nav .text{
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
<body>
    <!-- Sidebar -->
    <div id="sidebar" class="mx-lt-5 bg-dark">
        <div id="menu">
            <a id="menu-toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav>
            <a href="index.php?page=home" class="nav-item<?php echo $current_page == "home" ?"-active" : "";?> nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> <span class="text">Home</span></a>
            <a href="index.php?page=patient_registration" class="nav-item<?php echo $current_page == "patient_registration" ?"-active" : "";?> nav-patient"><span class='icon-field'><i class="fa fa-users"></i></span> <span class="text">Patient Management</span></a>
            <a href="index.php?page=health" class="nav-item<?php echo $current_page == "health" ?"-active" : "";?> nav-health"><span class='icon-field'><i class="fa fa-th-list"></i></span> <span class="text">Health Records</span></a>
            <a href="index.php?page=appointments" class="nav-item<?php echo $current_page == "appointments" ?"-active" : "";?> nav-appointments"><span class='icon-field'><i class="fa fa-calendar"></i></span> <span class="text">Appointments</span></a>
			<a href="index.php?page=requests" class="nav-item<?php echo $current_page == "requests" ?"-active" : "";?> nav-requests"><span class='icon-field'><i class="fa fa-envelope"></i></span> <span class="text">Requests</span></a>
            
            <?php if ($_SESSION['login_type'] == 1) : ?>
                <a href="index.php?page=users" class="nav-item<?php echo $current_page == "users" ?"-active" : "";?> nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> <span class="text">Doctors</span></a>
                <a href="index.php?page=site_settings" class="nav-item<?php echo $current_page == "site_settings" ?"-active" : "";?> nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> <span class="text">System Settings</span></a>
            <?php else : ?>
                <a href="index.php?page=user_settings" class="nav-item<?php echo $current_page == "user_settings" ?"-active" : "";?> nav-user-settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> <span class="text">User Settings</span></a>
            <?php endif; ?>
        </nav>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menu-toggle');

            let isCollapsed = sessionStorage.getItem('sidebarCollapsed');

            if (isCollapsed === null) {
                sessionStorage.setItem('sidebarCollapsed', 'false');
                isCollapsed = 'false';
            }

            console.log('Sidebar script - Initial sidebarCollapsed value from sessionStorage:', isCollapsed);

            // Apply sidebar state
            if (isCollapsed === 'true') {
                sidebar.classList.add('collapsed');
            } else {
                sidebar.classList.remove('collapsed');
            }

            menuToggle.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                
                // Update sessionStorage
                const newState = sidebar.classList.contains('collapsed') ? 'true' : 'false';
                sessionStorage.setItem('sidebarCollapsed', newState);

                console.log('Sidebar script - Sidebar toggled. New sidebarCollapsed value:', newState);

                // Dispatch an event to notify other scripts (like main content)
                window.dispatchEvent(new CustomEvent('sidebarStateChanged', { detail: { collapsed: newState } }));
            });
        });


    </script>
</body>
</html>
