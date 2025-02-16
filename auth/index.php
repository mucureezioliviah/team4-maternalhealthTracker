<?php
    if(isset($_SESSION['login_user_id'])) {
        if($_SESSION['login_type'] == 1) {
            header("location:admin/index.php"); // Admin
        } elseif ($_SESSION['login_type'] == 2) {
            header("location:doctor/index.php"); // Doctor
        }
    }
?>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	main#main{
		position: relative;
		width:calc(100%);
		height: calc(100%);
		display: flex;
		align-items: center;
		justify-content: center;
		background:white;
	}
	.login-card{
		position: absolute; /* Places it on top */
		top: 50%; /* Center vertically */
		left: 50%; /* Center horizontally */
		transform: translate(-50%, -50%); /* Perfect centering */
		width: 70%; /* Adjust size */
		height: 55%;
		padding: 10px;
		background: rgba(255, 255, 255, 0.2); /* Translucent white */
		backdrop-filter: blur(15px); /* ✅ Glassmorphism effect */
		border-radius: 15px; /* Rounded corners */
		box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Soft shadow */
		z-index: 5;
	}
	#portal-left, #portal-right {
    flex: 1;
    height: 100vh;
    background: rgba(255, 255, 255, 0.1); /* Light translucency */
}
	#portal-left{
		background:url(assets/img/pregnant_01.jpg);
		background-position: center;
		background-repeat: no-repeat;
		background-size: 120%;
	}
	#portal-right{
		background:rgba(10, 166, 228, 0.79);
	}

	@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MHTS - Portal</title>
</head>
<body>
	<main id="main" class=" bg-black">
		<div class="login-card">
			<?php include("login.php")?>
		</div>
  		<div id="portal-left">
  		</div>
  		<div id="portal-right">	
  		</div>
  	</main>
</body>
</html>
