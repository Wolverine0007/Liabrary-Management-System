<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

$card = mysqli_real_escape_string($connection, $_GET['id']);
$staff_query = "SELECT * FROM staff_accounts WHERE id = '$card'";
$staff_result = mysqli_query($connection, $staff_query);
$staff = mysqli_fetch_assoc($staff_result);

?>

<!DOCTYPE html>
<html>
<head> 
	<title>Manage Staff</title> 
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
				<img src="../images/logo.jpg" alt="Library Logo" height="40">
				<a class="navbar-brand" href="admin_dashboard.php">Central Library</a>
			</div>
			<font style="color: white"><span><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span></font> 
			<font style="color: white"><span><strong>Email: <?php echo $_SESSION['email'];?></strong></span></font>
			<ul class="nav navbar-nav navbar-right"> 
				<li class="nav-item dropdown"> 
					<a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a> 
					<div class="dropdown-menu"> 
						<a class="dropdown-item" href="#">View Profile</a> 
						<div class="dropdown-divider"></div> 
						<a class="dropdown-item" href="#">Edit Profile</a> 
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

<!-- Page Content -->
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Staff Details</h4>
        <div>
            <a href="delete_staff.php?card=<?php echo urlencode($staff['id']); ?>" class="btn btn-danger mr-2" onclick="return confirm('Are you sure you want to delete this staff?');">
                Delete Staff
            </a>
            <a href="edit_staff_profile.php?card=<?php echo urlencode($staff['id']); ?>" class="btn btn-warning">Update Profile</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Profile</div>
        <div class="card-body">
            <div class="d-flex mb-2">
                <div class="font-weight-bold" style="width: 180px;">Id:</div>
                <div><?php echo htmlspecialchars($staff['id']); ?></div>
            </div>
            <div class="d-flex mb-2">
                <div class="font-weight-bold" style="width: 180px;">Name:</div>
                <div><?php echo htmlspecialchars($staff['name']); ?></div>
            </div>
            <div class="d-flex mb-2">
                <div class="font-weight-bold" style="width: 180px;">Email:</div>
                <div><?php echo htmlspecialchars($staff['email']); ?></div>
            </div>
            <div class="d-flex mb-2">
                <div class="font-weight-bold" style="width: 180px;">Phone:</div>
                <div><?php echo htmlspecialchars($staff['phone']); ?></div>
            </div>
            <div class="d-flex mb-2">
                <div class="font-weight-bold" style="width: 180px;">Role:</div>
                <div><?php echo htmlspecialchars($staff['role']); ?></div>
            </div>
            <div class="d-flex mb-2">
                <div class="font-weight-bold" style="width: 180px;">Department:</div>
                <div><?php echo htmlspecialchars($staff['department']); ?></div>
            </div>
        </div>
    </div>

    

    
</div>
</body>
</html>
