<?php
session_start();

// DB Connection
$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$default_fine = 0;

// Pre-calculate fine if data is coming via GET
if (isset($_GET['accession_number']) && isset($_GET['library_card_no'])) {
    $acc = mysqli_real_escape_string($connection, $_GET['accession_number']);
    $card = mysqli_real_escape_string($connection, $_GET['library_card_no']);

    $query = "SELECT due_date FROM issued_books WHERE accession_number='$acc' AND library_card_no='$card' AND status=1";
    $result = mysqli_query($connection, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $due = new DateTime($row['due_date']);
        $today = new DateTime();

        if ($today > $due) {
            $days_late = $due->diff($today)->days;
            if ($days_late <= 7) {
                $default_fine = $days_late * 2;
            } else {
                $default_fine = (7 * 2) + (($days_late - 7) * 5);
            }
        }
    }
}

// Handle Return
if (isset($_POST['return_book'])) {
    $accession_number = mysqli_real_escape_string($connection, $_POST['accession_number']);
    $library_card_no = mysqli_real_escape_string($connection, $_POST['library_card_no']);
    $return_date = mysqli_real_escape_string($connection, $_POST['return_date']);
    $fine = mysqli_real_escape_string($connection, $_POST['fine']);

    $check_query = "SELECT * FROM issued_books WHERE accession_number='$accession_number' AND library_card_no='$library_card_no' AND status=1";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $return_query = "UPDATE issued_books SET status=0, return_date='$return_date', fine='$fine' WHERE accession_number='$accession_number' AND library_card_no='$library_card_no'";
        if (mysqli_query($connection, $return_query)) {
            header("Location: return_book.php?msg=" . urlencode("Book returned successfully."));
            exit();
        } else {
            header("Location: return_book.php?msg=" . urlencode("Error returning book: " . mysqli_error($connection)));
            exit();
        }
    } else {
        header("Location: return_book.php?msg=" . urlencode("No such issued book found for this user."));
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Book</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="../bootstrap-4.4.1/css/bootstrap.min.css" />
</head>
<body>
<?php
if (isset($_GET['msg'])) {
    echo '<script>alert("' . addslashes($_GET['msg']) . '");</script>';
}
?>

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

<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <h4 class="text-center">Return Book</h4>
        <form action="" method="post">
            <div class="form-group">
                <label for="accession_number">Accession Number:</label>
                <input type="text" name="accession_number" class="form-control" placeholder="Enter Book Accession Number" maxlength="4" required value="<?php echo isset($_GET['accession_number']) ? htmlspecialchars($_GET['accession_number']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="library_card_no">Library Card Number:</label>
                <input type="text" name="library_card_no" class="form-control" placeholder="Enter Library Card Number" required value="<?php echo isset($_GET['library_card_no']) ? htmlspecialchars($_GET['library_card_no']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="return_date">Return Date:</label>
                <input type="date" name="return_date" class="form-control" required value="<?php echo date('Y-m-d'); ?>" />
            </div>
            <div class="form-group">
                <label for="fine">Fine (₹):</label>
                <input type="number" name="fine" class="form-control" readonly value="<?php echo $default_fine; ?>" />
            </div>
            <button type="submit" name="return_book" class="btn btn-success">Return Book</button>
        </form>
    </div>
    <div class="col-md-4"></div>
</div>

<?php mysqli_close($connection); ?>
</body>
</html>
