<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Student Password</title>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
	<script type="text/javascript" src="bootstrap-4.4.1/js/juqery_latest.js"></script>
	<script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<div class="navbar-header">
				<img src="../images/logo.png" alt="Library Logo" height="40">
			</div>
			<font style="color: white"><span><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span></font>
			<font style="color: white"><span><strong>Email: <?php echo $_SESSION['email'];?></strong></span></font>
		    <ul class="nav navbar-nav navbar-right">
		      <li class="nav-item dropdown">
	        	<a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile </a>
	        	<div class="dropdown-menu">
	        		<a class="dropdown-item" href="view_profile.php">View Profile</a>
	        		<div class="dropdown-divider"></div>
	        		<a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
	        		<div class="dropdown-divider"></div>
	        		<a class="dropdown-item" href="change_password.php">Change Password</a>
	        	</div>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="../logout.php">Logout</a>
		      </li>
		    </ul>
		</div>
	</nav><br>

	<span><marquee>This is library mangement system. Library opens at 8:00 AM and close at 8:00 PM</marquee></span><br><br>
	<center><h4>Change Student Password</h4><br></center>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<form action="update_password.php" method="post">
				<div class="form-group">
					<label>Old Password</label>
					<div class="input-group">
						<input type="password" class="form-control" name="old_password" id="old_password" required>
						<div class="input-group-append">
							<span class="input-group-text" onclick="togglePassword('old_password', this)">
								<i class="fa fa-eye-slash"></i>
							</span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>New Password</label>
					<div class="input-group">
						<input type="password" class="form-control" name="new_password" id="new_password" required>
						<div class="input-group-append">
							<span class="input-group-text" onclick="togglePassword('new_password', this)">
								<i class="fa fa-eye-slash"></i>
							</span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Confirm New Password</label>
					<div class="input-group">
						<input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
						<div class="input-group-append">
							<span class="input-group-text" onclick="togglePassword('confirm_password', this)">
								<i class="fa fa-eye-slash"></i>
							</span>
						</div>
					</div>
				</div>

				<button type="submit" name="update" class="btn btn-primary">Update Password</button>
			</form>
		</div>
		<div class="col-md-4"></div>
	</div>

	<script>
	function togglePassword(inputId, el) {
		const input = document.getElementById(inputId);
		const icon = el.querySelector("i");
		if (input.type === "password") {
			input.type = "text";
			icon.classList.remove("fa-eye-slash");
			icon.classList.add("fa-eye");
		} else {
			input.type = "password";
			icon.classList.remove("fa-eye");
			icon.classList.add("fa-eye-slash");
		}
	}
	</script>
</body>
</html>
