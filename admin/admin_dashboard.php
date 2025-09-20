<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // go to login if not authorized
    exit();
}
require("functions.php");
include("fetch_announcements.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
  	<script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
  	<script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
  	<style>

		.navbar {
			background-color: #8B5A2B !important; /* Deep brown background */
			border-bottom: 3px solid #654321; /* Slightly darker brown border for depth */
		}

		.navbar a, .navbar .nav-link {
			color: white !important; /* White text for better contrast */
		}

		.navbar .nav-link:hover, .navbar .nav-link:focus {
			color: #FFD700 !important; /* Golden hover effect */
		}

		.card {
			background: linear-gradient(135deg, #DEB887, #F8D8AE); /* Same gradient as sidebar */
			border: 1px solid #8B5A2B; /* Dark brown border for depth */
			color: #5A3E2B; /* Dark brown text for a wooden feel */
		}

		.card-header {
			background-color: #8B5A2B; /* Dark brown for card headers */
			color: white; /* White text for contrast */
			font-weight: bold;
		}

		.card-body .btn {
			border-radius: 5px;
			font-weight: bold;
		}

		.btn-danger { background-color: #8B0000; } /* Dark Red */
		.btn-success { background-color: #556B2F; } /* Dark Green */
		.btn-warning { background-color: #DAA520; } /* Golden */
		.btn-primary { background-color: #483D8B; } /* Dark Blue */



		body {
			background-image: url('../images/library.jpg'); /* Path to the background image */
			background-size: cover; /* Ensures the image covers the entire screen */
			background-position: center; /* Centers the background image */
			background-repeat: no-repeat; /* Prevents the image from repeating */
			background-attachment: fixed; /* Keeps the image fixed while scrolling */
		}

		.sidebar {
			background-color: #D2B48C; /* Tan color for a plywood look */
			background-image: linear-gradient(135deg, #DEB887, #D2B48C); /* Gradient for depth */
			padding: 20px;
			min-height: 100vh;
			border-radius: 0px;
			box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
		}

		.sidebar a {
			display: block;
			padding: 10px;
			color: black;
			text-decoration: none;
		}
		.sidebar a:hover {
			background-color: #d0e2ff;
			color: #000;
		}

		:root {
    --navbar-bg-color: #343a40; /* Default Dark Theme */
    --navbar-text-color: white;
    --dropdown-bg-color: #212529; /* Dark mode dropdown */
    --dropdown-text-color: white;
}

.navbar {
    background-color: #8B5A2B !important; /* Deep brown for wooden look */
    border-bottom: 3px solid #654321; /* Optional: Slightly darker border for depth */
}


.navbar .nav-link {
    color: var(--navbar-text-color) !important;
}

/* Dropdown Styling */
.dropdown-menu {
    background-color:rgb(220, 157, 75) !important; /* Tan wooden background */
    color: #5A3E2B !important; /* Dark brown text */
    border: 1px solid #8B5A2B; /* Optional: Deep brown border for a wooden frame */
}

.dropdown-item:hover {
    background-color: #8B5A2B !important; /* Deep brown hover effect */
    color: white !important; /* White text for contrast */
}


	</style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<div class="navbar-header">
			<img src="../images/logo.jpg" alt="Library Logo" height="40">
			<a class="navbar-brand" href="admin_dashboard.php">Central Library</a>
			</div>
			<font style="color: white">
                <strong>Welcome: <?php echo $_SESSION['name']; ?></strong>
            </font>
            <font style="color: white">
                <strong>Email: <?php echo $_SESSION['email']; ?></strong>
            </font>
		    <ul class="nav navbar-nav navbar-right">
		      <li class="nav-item dropdown">
	        	<a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a>
	        	<div class="dropdown-menu">
	        		<a class="dropdown-item" href="view_profile.php">View Profile</a>
	        		<div class="dropdown-divider"></div>
	        		<a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
	        		<div class="dropdown-divider"></div>
	        		<a class="dropdown-item" href="change_password.php">Change Password</a>
	        	</div>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="logout.php">Logout</a>
		      </li>
		    </ul>
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row">
			<style>
				.sidebar {
					background-color: #D2B48C; /* Tan color for a plywood look */
					background-image: linear-gradient(135deg, #DEB887, #D2B48C); /* Gradient for depth */
					padding: 20px;
					min-height: 100vh;
					border-radius: 0px;
					box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2); /* Slightly deeper shadow */
				}

				.sidebar a {
					display: block;
					color: #5A3E2B; /* Dark brown for a wood-like feel */
					text-decoration: none;
					padding: 12px 15px;
					font-size: 16px;
					font-weight: 500;
					transition: 0.3s ease-in-out;
					border-radius: 5px;
					margin-bottom: 5px;
				}

				.sidebar a:hover {
					background-color: #8B5A2B; /* Deep brown hover effect */
					color: white;
				}

				.sidebar a.active {
					background-color: #654321; /* Darker brown for active page */
					color: white;
					font-weight: bold;
				}

			</style>

			<div class="col-md-2 sidebar">
				<a href="admin_dashboard.php" class="active">Dashboard</a>
				<a href="add_book.php">Add New Book</a>
				<a href="add_staff.php">Add Staff Member</a>
				<a href="add_user.php">Add New User</a>
				<a href="manage_book.php">Manage Books</a>
				<a href="issue_book.php">Issue Book</a>
				<a href="announcements.php">Announcements</a>
			</div>


			<!-- Main content -->
			<div class="col-md-10">
				<br>
				<span><marquee><?php echo $marquee_text; ?></marquee></span><br><br>
				<div class="row">
					<div class="col-md-3">
						<div class="card bg-light">
							<div class="card-header">Registered User</div>
							<div class="card-body">
								<p class="card-text">No of total Users: <?php echo get_user_count();?></p>
								<a class="btn btn-danger" href="Regusers.php">View Registered Users</a>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card bg-light">
							<div class="card-header">Total Books</div>
							<div class="card-body">
								<p class="card-text">No of books available: <?php echo get_book_count();?></p>
								<a class="btn btn-success" href="Regbooks.php">View All Books</a>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card bg-light">
							<div class="card-header">Manage Users</div>
							<div class="card-body">
								<p class="card-text">No of registered users: <?php echo get_user_count();?></p>
								<a class="btn btn-success" href="manage_users.php">View All Users</a>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="card bg-light">
							<div class="card-header">Manage Staff</div>
							<div class="card-body">
								<p class="card-text">No of staff members: <?php echo get_staff_count();?></p>
								<a class="btn btn-success" href="manage_staff.php">View All Staff</a>
							</div>
						</div>
					</div>
					
				</div><br><br>
				<div class="row">
					<div class="col-md-3">
						<div class="card bg-light">
							<div class="card-header">Book Issued</div>
							<div class="card-body">
								<p class="card-text">No of books issued: <?php echo get_issue_book_count();?></p>
								<a class="btn btn-success" href="view_issued_book.php">View Issued Books</a>
							</div>
						</div>
					</div>
					<div class="col-md-3"></div>
					<div class="col-md-3"></div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
