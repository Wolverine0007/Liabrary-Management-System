<?php
session_start();

// Connect to database
$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Use library_card_no from session
$library_card_no = mysqli_real_escape_string($connection, $_SESSION['library_card_no']);

// Fetch issued books for the logged-in user with extra fields
$query = "SELECT accession_number, title, author, issue_date, due_date 
          FROM issued_books 
          WHERE library_card_no = '$library_card_no' AND status = 1";
$query_run = mysqli_query($connection, $query);

// Function to calculate fine for a book based on due_date
function calculate_fine($due_date) {
    $today = new DateTime();
    $due = new DateTime($due_date);
    $diff = $due->diff($today);
    $days_late = $diff->format("%r%a"); // relative days difference

    if ($days_late > 0) {
        return $days_late * 2; // ₹2 per day fine
    }
    return 0;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Issued Books</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="bootstrap-4.4.1/js/jquery_latest.js"></script>
    <script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="user_dashboard.php">Library Management System (LMS)</a>
        </div>
        <font style="color: white"><strong>Welcome: <?php echo htmlspecialchars($_SESSION['name']); ?></strong></font>
        <font style="color: white"><strong>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></strong></font>
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">My Profile</a>
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
<span><marquee>This is library management system. Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
<center><h4>Issued Book's Details</h4><br></center>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <table class="table table-bordered text-center" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Accession Number</th>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Fine (₹)</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($query_run && mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_assoc($query_run)) {
                    $fine = calculate_fine($row['due_date']);
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['accession_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['issue_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['due_date']) . "</td>";
                    echo "<td>" . $fine . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No books issued currently.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-2"></div>
</div>
<?php mysqli_close($connection); ?>
</body>
</html>
