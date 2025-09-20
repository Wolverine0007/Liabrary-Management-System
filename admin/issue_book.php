<?php
session_start();

// Connect to DB
$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Process form submission for issuing a book
if (isset($_POST['issue_book'])) {
    $accession_number = mysqli_real_escape_string($connection, $_POST['accession_number']);
    $library_card_no = mysqli_real_escape_string($connection, $_POST['library_card_no']);
    $issue_date = mysqli_real_escape_string($connection, $_POST['issue_date']);
    $due_date = mysqli_real_escape_string($connection, $_POST['due_date']);

    // Check if the book exists
    $book_check_query = "SELECT accession_number, title, author FROM books WHERE accession_number = '$accession_number'";
    $book_check_result = mysqli_query($connection, $book_check_query);

    // Check if user exists
    $student_check_query = "SELECT * FROM users WHERE library_card_no = '$library_card_no'";
    $student_check_result = mysqli_query($connection, $student_check_query);

    if (mysqli_num_rows($book_check_result) > 0 && mysqli_num_rows($student_check_result) > 0) {
        $book_data = mysqli_fetch_assoc($book_check_result);
        $title = mysqli_real_escape_string($connection, $book_data['title']);
        $author = mysqli_real_escape_string($connection, $book_data['author']);

        // Insert into issued_books table (you need to have this table with relevant columns)
        $issue_query = "INSERT INTO issued_books (accession_number, title, author, library_card_no, issue_date, due_date, status) 
                        VALUES ('$accession_number', '$title', '$author', '$library_card_no', '$issue_date', '$due_date', 1)";

        if (mysqli_query($connection, $issue_query)) {
            // Success message
            header("Location: issue_book.php?msg=" . urlencode("Book issued successfully!"));
            exit();
        } else {
            header("Location: issue_book.php?msg=" . urlencode("Error issuing book: " . mysqli_error($connection)));
            exit();
        }
    } else {
        header("Location: issue_book.php?msg=" . urlencode("Invalid book accession number or library card number."));
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issue Book</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <!-- jQuery and Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css" />
    <script src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#searchBox").on("keyup", function(){
                var searchValue = $(this).val().toLowerCase();
                $("#booksTable tbody tr").filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1)
                });
            });
        });
    </script>
    <style>
        #searchBox {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php
if (isset($_GET['msg'])) {
    echo '<script>alert("' . addslashes($_GET['msg']) . '");</script>';
}
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <div class="navbar-header">
            <img src="../images/logo.jpg" alt="Library Logo" height="40" />
            <a class="navbar-brand" href="admin_dashboard.php">Central Library</a>
        </div>
        <font style="color: white"><strong>Welcome: <?php echo $_SESSION['name']; ?></strong></font>
        <font style="color: white"><strong>Email: <?php echo $_SESSION['email']; ?></strong></font>
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
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
                    <a class="nav-link dropdown-toggle" href="#" id="booksDropdown" role="button" data-toggle="dropdown">Books</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="add_book.php">Add New Book</a>
                        <a class="dropdown-item" href="manage_book.php">Manage Books</a>
                        <a class="dropdown-item" href="Regbooks.php">Total Books</a>
                        <a class="dropdown-item" href="view_issued_book.php">Issued Books</a>
                    </div>
                </li>

                <!-- Users Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-toggle="dropdown">Users</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="manage_users.php">Manage Users</a>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Books Table -->
<div class="container mt-5">
    <h2 class="text-center">Books List</h2>
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <input type="text" id="searchBox" class="form-control" placeholder="Search by Title or Author" />
        </div>
    </div>
    <table class="table table-bordered table-striped mt-3" id="booksTable">
        <thead>
            <tr>
                <th>Accession No.</th>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT accession_number, title, author, publisher, price 
            FROM books 
            WHERE accession_number NOT IN (
                SELECT accession_number FROM issued_books WHERE status = 1
            )";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['accession_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['publisher']) . "</td>";
                    echo "<td>" . htmlspecialchars(number_format($row['price'], 2)) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No books found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Issue Book Form -->
<div class="container mt-5">
    <h4 class="text-center">Issue Book</h4>
    <form action="" method="post">
        <div class="form-group">
            <label for="accession_number">Enter Accession Number:</label>
            <input type="text" name="accession_number" class="form-control" placeholder="Enter Book Accession Number" maxlength="4" required />
        </div>
        <div class="form-group">
            <label for="library_card_no">Enter Library Card Number:</label>
            <input type="text" name="library_card_no" class="form-control" placeholder="Enter your Library Card Number" required />
        </div>
        <div class="form-group">
            <label for="issue_date">Issue Date:</label>
            <input type="date" name="issue_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required />
        </div>
        <div class="form-group">
            <label for="due_date">Due Date:</label>
            <input type="date" name="due_date" class="form-control" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" required />
        </div>
        <button type="submit" name="issue_book" class="btn btn-primary">Issue Book</button>
    </form>
</div>

<?php
mysqli_close($connection);
?>
</body>
</html>
