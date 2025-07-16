<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}
require("functions.php");
include("fetch_announcements.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard | LMS</title>
    <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <style>
        /* Navbar styling */
        .navbar {
            background-color: #8B5A2B !important; /* Deep brown background */
            border-bottom: 3px solid #654321; /* Darker brown border */
        }

        .navbar a, .navbar .nav-link {
            color: white !important; /* White text */
        }

        .navbar .nav-link:hover, .navbar .nav-link:focus {
            color: #FFD700 !important; /* Golden hover */
        }

        /* Body background */
        body {
            background-image: url('../images/library.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Sidebar */
        .sidebar {
            background-color: #D2B48C; /* Tan color */
            background-image: linear-gradient(135deg, #DEB887, #D2B48C);
            padding: 20px;
            min-height: 100vh;
            border-radius: 0px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
        }

        .sidebar a {
            display: block;
            color: #5A3E2B; /* Dark brown text */
            text-decoration: none;
            padding: 12px 15px;
            font-size: 16px;
            font-weight: 500;
            transition: 0.3s ease-in-out;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background-color: #8B5A2B; /* Deep brown */
            color: white;
        }

        .sidebar a.active {
            background-color: #654321; /* Darker brown */
            color: white;
            font-weight: bold;
        }

        /* Cards styling */
        .card {
            background: linear-gradient(135deg, #DEB887, #F8D8AE);
            border: 1px solid #8B5A2B;
            color: #5A3E2B;
        }

        .card-header {
            background-color: #8B5A2B;
            color: white;
            font-weight: bold;
        }

        /* Buttons in cards */
        .card-body .btn {
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-danger { background-color: #8B0000; }
        .btn-success { background-color: #556B2F; }
        .btn-warning { background-color: #DAA520; }
        .btn-primary { background-color: #483D8B; }

        /* Dropdown menu styling */
        .dropdown-menu {
            background-color: rgb(220, 157, 75) !important;
            color: #5A3E2B !important;
            border: 1px solid #8B5A2B;
        }

        .dropdown-item:hover {
            background-color: #8B5A2B !important;
            color: white !important;
        }

        /* Navbar right text */
        .navbar-text {
            margin-right: 15px;
            color: white;
            font-weight: 600;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<div class="navbar-header">
			<img src="../images/logo.jpg" alt="Library Logo" height="40">
			<a class="navbar-brand" href="login.php">Central Library</a>
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
        <div class="col-md-2 sidebar">
            <a href="staff_dashboard.php" class="active">Dashboard</a>
            <a href="issue_book.php">Issue Book</a>
            <a href="return_book.php">Return Book</a>
            <a href="view_issued_book.php">View Issued Books</a>
            <a href="Regbooks.php">Search Books</a>
        </div>

        <div class="col-md-10">
            <br>
            <span><marquee><?php echo $marquee_text ?? 'Welcome to LMS'; ?></marquee></span><br><br>

            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-header">Issued Books</div>
                        <div class="card-body">
                            <p class="card-text">Total issued books: <?php echo get_issue_book_count(); ?></p>
                            <a class="btn btn-success" href="view_issued_book.php">View Issued Books</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-header">Search Books</div>
                        <div class="card-body">
                            <p class="card-text">Find books in the library</p>
                            <a class="btn btn-primary" href="Regbooks.php">Search Now</a>
                        </div>
                    </div>
                </div>
                <!-- You can add more cards here as needed -->
            </div>
        </div>
    </div>
</div>
</body>
</html>
