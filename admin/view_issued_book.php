<?php
session_start();

// Database connection
$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Correct SQL query joining on library_card_no
$query = "
    SELECT 
        issued_books.title, 
        issued_books.author, 
        issued_books.accession_number, 
        users.name AS student_name,
		users.library_card_no AS library_card_no
    FROM issued_books 
    LEFT JOIN users ON issued_books.library_card_no = users.library_card_no 
    WHERE issued_books.status = 1
";

$query_run = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issued Books</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script src="../bootstrap-4.4.1/js/jquery_latest.js"></script>
    <script src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
        </div>
        <font style="color: white"><strong>Welcome: <?php echo htmlspecialchars($_SESSION['name']); ?></strong></font>
        <font style="color: white"><strong>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></strong></font>
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">My Profile</a>
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
<br>

<marquee>This is library management system. Library opens at 8:00 AM and closes at 8:00 PM</marquee><br><br>

<div class="container">
    <center><h4>Issued Books Detail</h4><br></center>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <table class="table table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Book Number</th>
                        <th>Student Name</th>
						<th>Library Card No.</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($query_run && mysqli_num_rows($query_run) > 0) {
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['accession_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['student_name'] ?? 'N/A') . "</td>";
						echo "<td>" . htmlspecialchars($row['library_card_no'] ?? 'N/A') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No issued books found.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
