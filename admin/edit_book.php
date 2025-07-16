<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['name']) || !isset($_SESSION['email'])) {
    die("Unauthorized access. Please log in first.");
}

// Connect to database
$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if accession_number is provided in URL
if (isset($_GET['an'])) {
    $accession_number = mysqli_real_escape_string($connection, $_GET['an']);

    // Fetch book details
    $query = "SELECT * FROM books WHERE accession_number = '$accession_number'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $author = $row['author'];
        $publisher = $row['publisher'];
        $price = $row['price'];
    } else {
        die("Book not found.");
    }
} else {
    die("Accession Number is missing in the URL.");
}

// Handle form submission to update book
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $author = mysqli_real_escape_string($connection, $_POST['author']);
    $publisher = mysqli_real_escape_string($connection, $_POST['publisher']);
    $price = mysqli_real_escape_string($connection, $_POST['price']);

    $update_query = "UPDATE books SET 
                        title = '$title', 
                        author = '$author', 
                        publisher = '$publisher', 
                        price = '$price' 
                     WHERE accession_number = '$accession_number'";

    if (mysqli_query($connection, $update_query)) {
        $_SESSION['message'] = "Book details updated successfully!";
        header("Location: edit_book.php?an=$accession_number");
        exit();
    } else {
        $_SESSION['message'] = "Error updating book: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Book</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script src="../bootstrap-4.4.1/js/jquery_latest.js"></script>
    <script src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
        <span class="navbar-text text-white"><strong>Welcome: <?php echo htmlspecialchars($_SESSION['name']); ?></strong></span>
        <span class="navbar-text text-white ml-3"><strong>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></strong></span>
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
            <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav><br>

<div class="container">
    <center><h4>Edit Book</h4></center>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="post">
                <div class="form-group">
                    <label>Accession Number:</label>
                    <input type="text" value="<?php echo htmlspecialchars($accession_number); ?>" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Author:</label>
                    <input type="text" name="author" value="<?php echo htmlspecialchars($author); ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Publisher:</label>
                    <input type="text" name="publisher" value="<?php echo htmlspecialchars($publisher); ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Price:</label>
                    <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($price); ?>" class="form-control" required>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update Book</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
