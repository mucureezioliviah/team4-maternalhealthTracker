<?php
    session_start();
    require_once 'db.php'; // Include the database connection file


    $log_file = "session_log.txt";
	$log_data = print_r($_SESSION, true);
	$timestamp = date("Y-m-d H:i:s"); // Current date and time
	$log_entry = "[$timestamp] " . $log_data;
	file_put_contents($log_file, $log_entry . PHP_EOL, FILE_APPEND);

    ob_start();
    if (!isset($_SESSION['system'])) {
        $query = $conn->query("SELECT * FROM system_settings LIMIT 1");
    
        if ($query) {
            $system = $query->fetch_assoc(); // Use fetch_assoc() for an associative array
            if ($system) {
                foreach ($system as $k => $v) {
                    $_SESSION['system'][$k] = $v;
                }
            } else {
                echo "Warning: No system settings found.";
            }
        } else {
            echo "Error: Database query failed.";
        }
    }
    ob_end_flush();
?>

<?php
    if(isset($_SESSION['login_id'])) {
        if($_SESSION['login_type'] == 1) {
            header("location:admin/index.php?page=home"); // Admin
        } elseif ($_SESSION['login_type'] == 2) {
            header("location:doctor/index.php?page=home"); // Doctor
        }
    }
?>
<?php include('header.php'); ?>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		display: flex;
		align-items: center;
		/*background: url(assets/uploads/<?php //echo $_SESSION['system']['cover_img'] ?>);*/
		background:rgba(10, 166, 228, 0.79);
	    background-repeat: no-repeat;
	    background-size: cover;
	}
	#login-right .card{
		margin: auto;
		z-index: 1
	}
	#login-form, .card-body, .w-100{
		animation: fadeInUp 1s ease;
	}
	/*#login-form input {
		border-left: 0px;
		border-right: 0px;
		border-top: 0px;
	}*/
	.logo {
		margin: auto;
		font-size: 8rem;
		padding: .5em 0.8em;
		color: #000000b3;
        filter: drop-shadow(4px 4px 2px rgba(0, 0, 0, 0.2));
		animation: fadeInUp 1s ease;
}

	.logo img {
		width: 600px;
		height: 600px;
		transition: width 0.5s ease-out, height 0.5s ease-out;
		animation: fadeInUp 1s ease;
	}
	.logo img:hover {
		width: 610px;
		height: 610px;
	}
	.click_here {
			color: #007bff;
			text-decoration: none;
		}
	.forgot_password_text {
		font-size: 1rem;
		font-style: italic;
		font-family: Verdana, Geneva, Tahoma, sans-serif;
	}
	.forgot_text {
		margin-top: 1rem;
	}
	.eye_icon {
		position: absolute;
		background-color: rgba(0, 0, 0, 0);
		border: 0px;
		top: 72%; /* Center the icon vertically within the input field */
		right: 4px; /* Adjust distance from the right side of the input field */
		transform: translateY(-50%); /* Perfect vertical centering */
		color:rgba(10, 166, 228, 0.79);
		font-size: 18px; /* Adjust icon size */
		z-index: 2;
	}
    .eye_icon:hover{
        color: #007bff;
    }
    

	input.form-control {
		padding-right: 40px; /* Add padding to the input field so the text doesn't overlap the icon */
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
    <title>Login - Maternal Health Tracking System</title>
</head>
<body>
<main id="main" class=" bg-black">
  		<div id="login-left">
  			<div class="logo">
				<a>
  					<img src="assets/img/dashboard logo_02.png" alt="MHTS Logo">
				</a>
			</div>
  		</div>

  		<div id="login-right">
  			<div class="w-100">
  				<h3 class="text-info text-center"><b>Welcome Back</b></h3>
                <h5 class="text-info text-center">Login to continue</h5>
  				<br>

  			<div class="card col-md-8">
  				<div class="card-body">
  						
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label text-info fw-bold">Username</label>
  							<input type="text" id="username" name="username" class="form-control" placeholder="Enter Username">
  						</div>
  						<div class="form-group" style="position:relative">
  							<label for="password" class="control-label text-info fw-bold">Password</label>
  							<input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
							  <span class="eye_icon input-group-text" id="togglePassword" style="cursor: pointer;">
								<i class="fa fa-eye"></i>
							</span>
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-info" id="login-btn">Login</button></center>
						<div class="forgot_text">
							<a class="forgot_password_text">Forgot your password?
								
							</a><a class="click_here" href="mailto:<?php //echo $_SESSION['system']['email']?>"> Click Here </a> <a class="forgot_password_text">to contact Admin.</a>
						</div>
  					</form>
  				</div>
  			</div>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
</body>

<script>
	document.getElementById('togglePassword').addEventListener('click', function () {
		const passwordInput = document.getElementById('password');
		const icon = this.querySelector('i');
		
		// Toggle the type attribute
		if (passwordInput.type === 'password') {
			passwordInput.type = 'text';
			icon.classList.remove('fa-eye');
			icon.classList.add('fa-eye-slash');
		} else {
			passwordInput.type = 'password';
			icon.classList.remove('fa-eye-slash');
			icon.classList.add('fa-eye');
		}
		});

	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax/ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
			},
			info:function(resp){
				console.log(resp);
				if(resp == 1){
					location.href ='admin';
				}else if(resp == 2){
					location.href ='doctor';

				}else if(resp == 3){
					$('#login-form').prepend('<div class="alert alert-danger">Missing Username.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>
</html>
