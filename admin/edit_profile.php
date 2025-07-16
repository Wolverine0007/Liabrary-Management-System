<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

$email = $_SESSION['email'];
$query = "SELECT * FROM staff_accounts WHERE email='$email'";
$query_run = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($query_run);
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
						<a class="dropdown-item" href="change_password.php">Change Password</a> 
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
	</nav><br>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<h2>Edit Profile</h2>
		<form action="update.php" method="POST">
			<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

			<div class="form-group">
				<label>Name</label>
				<input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" required>
			</div>

			<div class="form-group">
				<label>Email</label>
				<input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
			</div>

			<div class="form-group">
				<label>Phone</label>
				<input type="text" class="form-control" name="phone" value="<?php echo $row['phone']; ?>" required>
			</div>

			<div class="form-group">
				<label>Department</label>
				<input type="text" class="form-control" name="department" value="<?php echo $row['department']; ?>" required>
			</div>

			<button type="submit" class="btn btn-primary">Update</button>
		</form>
	</div>
	<div class="col-md-4"></div>
</div>
</body>
</html>
