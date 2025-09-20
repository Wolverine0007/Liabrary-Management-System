<?php
session_start();

$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$accession_number = $title = $author = $publisher = $price = "";
$error_message = "";

if (isset($_POST['add_book'])) {
    $accession_number = mysqli_real_escape_string($connection, $_POST['accession_number']);
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $author = mysqli_real_escape_string($connection, $_POST['author']);
    $publisher = mysqli_real_escape_string($connection, $_POST['publisher']);
    $price = $_POST['price'];

    $check_query = "SELECT * FROM books WHERE accession_number = '$accession_number'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Error: Accession Number already exists. Please use a different one.";
    } else {
        $insert_query = "INSERT INTO books (accession_number, title, author, publisher, price)
                         VALUES ('$accession_number', '$title', '$author', '$publisher', $price)";

        if (mysqli_query($connection, $insert_query)) {
            echo "<script>alert('Book added successfully'); window.location.href='add_book.php';</script>";
            exit();
        } else {
            $error_message = "Error: " . mysqli_error($connection);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
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
							<a class="dropdown-item" href="issue_book.php">Issue Book</a>
							<a class="dropdown-item" href="manage_book.php">Manage Books</a>
							<a class="dropdown-item" href="Regbooks.php">Total Books</a>
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
							<a class="dropdown-item" href="issue_book.php">Issue Book</a>
						</div>
					</li>

				</ul>
			</div>
		</div>
	</nav><br>
    <center><h4>Add a New Book</h4></center>
    <br>

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label>Accession Number (4 chars):</label>
                    <input type="text" name="accession_number" maxlength="4" class="form-control" required
                           value="<?php echo htmlspecialchars($accession_number); ?>">
                </div>
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" class="form-control" required
                           value="<?php echo htmlspecialchars($title); ?>">
                </div>
                <div class="form-group">
                    <label>Author:</label>
                    <input type="text" name="author" class="form-control" required
                           value="<?php echo htmlspecialchars($author); ?>">
                </div>
                <div class="form-group">
                    <label>Publisher:</label>
                    <input type="text" name="publisher" class="form-control" required
                           value="<?php echo htmlspecialchars($publisher); ?>">
                </div>
                <div class="form-group">
                    <label>Price:</label>
                    <input type="number" step="0.01" name="price" class="form-control" required
                           value="<?php echo htmlspecialchars($price); ?>">
                </div>
                <button type="submit" name="add_book" class="btn btn-primary">Add Book</button>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</body>
</html>
