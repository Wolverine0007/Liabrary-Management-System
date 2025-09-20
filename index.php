<?php
	session_start();
	include("admin/fetch_announcements.php");

	// Handle login submission
	if (isset($_POST['login'])) {
		$connection = mysqli_connect("localhost", "root", "", "lms");

		if (!$connection) {
			die("Database connection failed: " . mysqli_connect_error());
		}

		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$library_card_no = mysqli_real_escape_string($connection, $_POST['library_card_no']);

		$query = "SELECT * FROM users WHERE email = '$email'";
		$query_run = mysqli_query($connection, $query);
		$row = mysqli_fetch_assoc($query_run);

		if ($row) {
			if ($row['library_card_no'] === $library_card_no) {
				$_SESSION['name'] = $row['name'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['id'] = $row['id'];
				$_SESSION['library_card_no'] = $row['library_card_no'];
				header("Location: user_dashboard.php");
				exit();
			} else {
				$error_message = "Invalid Library Card Number.";
			}
		} else {
			$error_message = "Email not found.";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>LMS</title>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap-4.4.1/css/bootstrap.min.css">
	<script src="bootstrap-4.4.1/js/juqery_latest.js"></script>
	<script src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<style>
	#main_content {
		padding: 50px;
		background-color: whitesmoke;
	}
	#side_bar {
		background-color: whitesmoke;
		padding: 50px;
		width: 300px;
		height: 450px;
	}
</style>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<div class="navbar-header">
				<img src="images/logo.jpg" alt="Library Logo" height="40">
				<a class="navbar-brand" href="index.php">Central Library</a>
			</div>
			<ul class="nav navbar-nav ml-auto">
				<li class="nav-item"><a class="nav-link" href="admin/index.php">Admin Login</a></li>
				<li class="nav-item"><a class="nav-link" href="signup.php">Register</a></li>
				<li class="nav-item"><a class="nav-link" href="index.php">Login</a></li>
			</ul>
		</div>
	</nav>
	<br>
	<marquee><?php echo $marquee_text ?? 'Welcome to LMS'; ?></marquee><br><br>

	<div class="row">
		<div class="col-md-4" id="side_bar">
			<h5>Library Timing</h5>
			<ul>
				<li>Opening: 8:00 AM</li>
				<li>Closing: 8:00 PM</li>
				<li>(Sunday Off)</li>
			</ul>
			<h5>What We Provide?</h5>
			<ul>
				<li>Full furniture</li>
				<li>Free Wi-Fi</li>
				<li>Peaceful Environment</li>
			</ul>
		</div>

		<div class="col-md-8" id="main_content">
			<center><h3><u>User Login Form</u></h3></center>

			<?php if (!empty($error_message)): ?>
				<div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
			<?php endif; ?>

			<form action="" method="post" onsubmit="return validateLoginForm()">
				<div class="form-group">
					<label for="email">Email ID:</label>
					<input type="text" id="email" name="email" class="form-control" required>
					<small id="emailError" class="text-danger"></small>
				</div>

				<div class="form-group">
					<label for="library_card_no">Library Card No.:</label>
					<input type="text" id="library_card_no" name="library_card_no" class="form-control" required>
				</div>

				<button type="submit" name="login" class="btn btn-primary">Login</button> |
				<a href="signup.php">Not registered yet?</a>
			</form>

			<script>
				function validateLoginForm() {
					let email = document.getElementById("email").value.trim();
					let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
					let isValid = true;

					if (!emailPattern.test(email)) {
						document.getElementById("emailError").innerText = "Invalid email format";
						isValid = false;
					} else {
						document.getElementById("emailError").innerText = "";
					}

					return isValid;
				}
			</script>
		</div>
	</div>
</body>
</html>
