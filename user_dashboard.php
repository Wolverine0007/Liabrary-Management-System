<?php
session_start();

if (!isset($_SESSION['library_card_no'])) {
    header("Location: admin/login.php");
    exit();
}
require("admin/functions.php");
include("admin/fetch_announcements.php");
require_once __DIR__ . '/config.php';

function get_user_issue_book_count() {
    global $connection;
    $card_no = mysqli_real_escape_string($connection, $_SESSION['library_card_no']);
    $query = "SELECT COUNT(*) as user_issue_book_count FROM issued_books WHERE library_card_no = '$card_no' AND status = 1";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['user_issue_book_count'] ?? 0;
}

function calculate_fine() {
    global $connection;
    $card_no = mysqli_real_escape_string($connection, $_SESSION['library_card_no']);
    $fine = 0;

    $query = "SELECT due_date FROM issued_books 
              WHERE library_card_no = '$card_no' 
              AND due_date IS NOT NULL 
              AND CURDATE() > due_date 
              AND status = 1";
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $due = new DateTime($row['due_date']);
        $today = new DateTime();
        if ($today > $due) {
            $overdue_days = $due->diff($today)->days;
            $overdue_days = $overdue_days - 1;

            if ($overdue_days > 0) {
                if ($overdue_days <= 7) {
                    $fine += 2 * $overdue_days;
                } else {
                    $fine += (2 * 7) + (5 * ($overdue_days - 7));
                }
            }
        }
    }

    return $fine;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: url('images/library.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
        }

        .navbar {
            background-color: #8B5A2B !important;
            border-bottom: 3px solid #654321;
        }

        .navbar .nav-link, .navbar-brand {
            color: white !important;
        }

        .navbar .nav-link:hover {
            color: #FFD700 !important;
        }

        .dropdown-menu {
            background-color: rgb(220, 157, 75) !important;
            color: #5A3E2B !important;
            border: 1px solid #8B5A2B;
        }

        .dropdown-item:hover {
            background-color: #8B5A2B !important;
            color: white !important;
        }

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

        .card-body .btn {
            font-weight: bold;
            border-radius: 5px;
        }

        .btn-danger { background-color: #8B0000; }
        .btn-success { background-color: #556B2F; }
        .btn-warning { background-color: #DAA520; }
        .btn-primary { background-color: #483D8B; }

        marquee {
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container-fluid">
		<div class="navbar-header">
		<img src="images/logo.jpg" alt="Library Logo" height="40">
		<a class="navbar-brand" href="user_dashboard.php">Central Library</a>
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
<br>
<span><marquee><?php echo $marquee_text; ?></marquee></span><br><br>
<br><br>

<div class="container">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">Books Issued</div>
                <div class="card-body">
                    <p class="card-text">No. of books issued: <?php echo get_user_issue_book_count(); ?></p>
                    <a class="btn btn-success" href="view_issued_book.php">View Issued Books</a>
                </div>
            </div>
        </div>
		<div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">Books Available</div>
                <div class="card-body">
                    <p class="card-text">No. of books awailable: <?php echo get_book_count();?></p>
                    <a class="btn btn-success" href="admin/Regbooks.php">View Books Awailable</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">Fine</div>
                <div class="card-body">
                    <p class="card-text">Total Fine: ₹<?php echo calculate_fine(); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
