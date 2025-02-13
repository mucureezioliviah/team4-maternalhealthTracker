
<style>
	.collapse a{
		text-indent:10px;
	}/*
	nav#sidebar{
		background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important
	}*/
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=patient_registration" class="nav-item nav-patient"><span class='icon-field'><i class="fa fa-th-list"></i></span> Patient Registration</a>
				<a href="index.php?page=health_dashboard" class="nav-item nav-hdashboard"><span class='icon-field'><i class="fa fa-th-list"></i></span> Health Dashboard</a>
				<a href="index.php?page=health" class="nav-item nav-health"><span class='icon-field'><i class="fa fa-map-marked-alt"></i></span> Health</a>
				<a href="index.php?page=appointments" class="nav-item nav-appointments"><span class='icon-field'><i class="fa fa-calendar"></i></span> Appointments</a>
				<a  class="nav-item nav-reports" data-toggle="collapse" href="#reportCollpase" role="button" aria-expanded="false" aria-controls="reportCollpase"><span class='icon-field'><i class="fa fa-file"></i></span> Reports <i class="fa fa-angle-down float-right"></i></a>
				<div class="collapse" id="reportCollpase">
					<a href="index.php?page=audience_report" class="nav-item nav-audience_report"><span class='icon-field'></span> Audience Report</a>
					<a href="index.php?page=venue_report" class="nav-item nav-venue_report"><span class='icon-field'></span> Venue Report</a>
				</div>
                <a href="index.php?page=settings" class="nav-item nav-user-settings"><span class='icon-field'><i class="fa fa-calendar"></i></span> User Settings</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> System Settings</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
