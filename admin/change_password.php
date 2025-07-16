<?php
	require("functions.php");
	include("fetch_announcements.php");
	session_start();
?>
<!DOCTYPE html>
<html>
<head> 
	<title>Manage Book</title> 
	<meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1"> 
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">   
	<script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>   
	<script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>   

	<script type="text/javascript">
		function searchBooks() {
			let input = document.getElementById("searchInput").value.toLowerCase();
			let rows = document.querySelectorAll(".book-row");
			rows.forEach(row => {
				let bookName = row.querySelector(".book-name").textContent.toLowerCase();
				if (bookName.includes(input)) {
					row.style.display = "";
				} else {
					row.style.display = "none";
				}
			});
		}
	</script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
		<div class="container-fluid"> 
			<div class="navbar-header">
				<img src="../images/logo.png" alt="Library Logo" height="40">
				<a class="navbar-brand" href="index.php">Central Library</a>
			</div>
			<font style="color: white"><span><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span></font> 
			<font style="color: white"><span><strong>Email: <?php echo $_SESSION['email'];?></strong></span></font>
			<ul class="nav navbar-nav navbar-right"> 
				<li class="nav-item dropdown"> 
					<a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a> 
					<div class="dropdown-menu"> 
						<a class="dropdown-item" href="view_profile.php">View Profile</a> 
						<div class="dropdown-divider"></div> 
						<a class="dropdown-item" href="edit_profile.php">Edit Profile</a> 
						
					</div> 
				</li> 
				<li class="nav-item"> 
					<a class="nav-link" href="../logout.php">Logout</a> 
				</li> 
			</ul> 
		</div> 
	</nav>
	<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd"> 
		<div class="container-fluid">
			<a class="navbar-brand" href="admin_dashboard.php">Dashboard</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav mr-auto">

					<!-- Books Dropdown -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="booksDropdown" role="button" data-toggle="dropdown">
							Books
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="add_book.php">Add New Book</a>
							<a class="dropdown-item" href="issue_book.php">Issue Book</a>
							<a class="dropdown-item" href="Regbooks.php">All Books</a>
							<a class="dropdown-item" href="view_issued_book.php">Issued Books</a>
						</div>
					</li>

					<!-- Users Dropdown -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-toggle="dropdown">
							Users
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="manage_users.php">Manage Users</a>
							<a class="dropdown-item" href="add_user.php">Add New User</a>
							<a class="dropdown-item" href="issue_book.php">Issue Book</a>
						</div>
					</li>

				</ul>
			</div>
		</div>
	</nav>
	<span><marquee><?php echo $marquee_text; ?></marquee></span><br><br>
		<center><h4>Change Admin Password</h4><br></center>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
				<form action="update_password.php" method="POST">
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

					<button type="submit" class="btn btn-primary">Update Password</button>
				</form>
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
			</div>
			<div class="col-md-4"></div>
		</div>
</body>
</html>
