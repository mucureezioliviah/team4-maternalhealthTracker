<style>
	.logo {
    margin: auto;
    width: 40px;
}
.user_session {
  margin: 5px;
}
</style>

<script>$(document).ready(function() {
    $(document).on("click", ".logout-link", function(e) { 
        e.preventDefault(); // Prevent default link behavior
        if (confirm("Are you sure you want to logout?")) { 
            $.ajax({
                url: $(this).attr("href"), // Get URL from href attribute
                method: 'POST',
                success: function(resp) {
                    console.log("Logout Response:", resp.trim()); // Debugging Output
                    if (resp.trim() === "1") { // Ensure response is checked properly
                        window.location.href = "/maternalhealth/auth/index.php"; // Redirect after logout
                    } else {
                        alert("Logout failed. Please try again.");
                    }
                },
                error: function(err) {
                    console.error("AJAX Error:", err);
                }
            });
        }
    });
});</script>

<nav class="navbar navbar-light fixed-top bg-success" style="padding:0;min-height: 3.5rem">
  <div class="container-fluid mt-2 mb-2">
  	<div class="col-lg-12">
  		<div class="col-md-1 float-left" style="display: flex;">
  		
  		</div>
      <div class="col-md-4 float-left text-white">
        <img src="/maternalhealth/auth/assets/img/dashboard logo.png" class="logo">
        <large><b><?php echo isset($_SESSION['login_username']) ? $_SESSION['login_username'] : '' ?> | Doctor</b></large>
      </div>
	  	<div class="user_session float-right">
        <div class=" dropdown mr-4">
            <a href="#" class="text-white dropdown-toggle"  id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login_username'] ?> </a>
              <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
                <a class="dropdown-item" href="javascript:void(0)" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a>
                <a class="dropdown-item" href="../"><i class="fa fa-home"></i> Site Home</a>
                <a class="dropdown-item logout-link" href="/maternalhealth/auth/ajax/ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>

              </div>
        </div>
      </div>
  </div>
  
</nav>

<script>
  $('#manage_my_account').click(function(){
    uni_modal("Manage Account","manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own")
  })
</script>