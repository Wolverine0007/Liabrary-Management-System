<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

$card = mysqli_real_escape_string($connection, $_GET['card']);
$user_query = "SELECT * FROM users WHERE library_card_no = '$card'";
$user_result = mysqli_query($connection, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Currently issued books
$book_query = "SELECT accession_number, title, author, issue_date, due_date FROM issued_books WHERE library_card_no = '$card' AND status = 1";
$book_result = mysqli_query($connection, $book_query);

// Book return history
$history_query = "SELECT accession_number, title, author, issue_date, due_date, return_date, fine FROM issued_books WHERE library_card_no = '$card' AND status = 0";
$history_result = mysqli_query($connection, $history_query);
?>

<!DOCTYPE html>
<html>
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

<!-- Integrated Navbars -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
		<div class="container-fluid"> 
			<div class="navbar-header">
				<img src="../images/logo.jpg" alt="Library Logo" height="40">
				<a class="navbar-brand" href="admin_dashboard.php">Central Library</a>
			</div>
			<font style="color: white"><span><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span></font> 
			<font style="color: white"><span><strong>Email: <?php echo $_SESSION['email'];?></strong></span></font>
			<ul class="nav navbar-nav navbar-right"> 
				<!-- <li class="nav-item dropdown"> 
					<a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a> 
					<div class="dropdown-menu"> 
						<a class="dropdown-item" href="#">View Profile</a> 
						<div class="dropdown-divider"></div> 
						<a class="dropdown-item" href="#">Edit Profile</a> 
						<div class="dropdown-divider"></div> 
						<a class="dropdown-item" href="change_password.php">Change Password</a> 
					</div> 
				</li>  -->
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
						<a class="nav-link dropdown-toggle" href="#" id="booksDropdown" role="button" data-toggle="dropdown">Books</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="add_book.php">Add New Book</a>
							<a class="dropdown-item" href="issue_book.php">Issue Book</a>
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
        <h4>User Details</h4>
        <div>
            <a href="issue_book.php?card=<?php echo urlencode($user['library_card_no']); ?>" class="btn btn-success mr-2">Issue Book</a>
                        <a href="delete_user.php?card=<?php echo urlencode($user['library_card_no']); ?>" class="btn btn-danger mr-2" onclick="return confirm('Are you sure you want to delete this user?');">
                Delete User
            </a>
            <a href="return_book.php?card=<?php echo urlencode($user['library_card_no']); ?>" class="btn btn-info mr-2">Return Book</a>
            <a href="edit_user_profile.php?card=<?php echo urlencode($user['library_card_no']); ?>" class="btn btn-warning">Update Profile</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Profile</div>
        <div class="card-body">
            <div class="d-flex mb-2">
                <div class="font-weight-bold" style="width: 180px;">Name:</div>
                <div><?php echo htmlspecialchars($user['name']); ?></div>
            </div>
            <div class="d-flex mb-2">
                <div class="font-weight-bold" style="width: 180px;">Email:</div>
                <div><?php echo htmlspecialchars($user['email']); ?></div>
            </div>
            <div class="d-flex mb-2">
                <div class="font-weight-bold" style="width: 180px;">Library Card No:</div>
                <div><?php echo htmlspecialchars($user['library_card_no']); ?></div>
            </div>
            <div class="d-flex mb-2">
                <div class="font-weight-bold" style="width: 180px;">Address:</div>
                <div><?php echo htmlspecialchars($user['address']); ?></div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Currently Issued Books</div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Accession No</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Fine (₹)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($book_result)):
                    $due = new DateTime($row['due_date']);
                    $today = new DateTime();

                    $fine = 0;
                    if ($today > $due) {
                        $overdue_days = $due->diff($today)->days;
                        $overdue_days = $overdue_days - 1;

                        if ($overdue_days > 0) {
                            if ($overdue_days <= 7) {
                                $fine = 2 * $overdue_days;
                            } else {
                                $fine = 2 * 7 + 5 * ($overdue_days - 7);
                            }
                        }
                    }
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['accession_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['author']); ?></td>
                    <td><?php echo htmlspecialchars($row['issue_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                    <td><?php echo $fine; ?></td>
                    <td>
                        <a href="return_single_book.php?accession=<?php echo urlencode($row['accession_number']); ?>&card=<?php echo urlencode($card); ?>" class="btn btn-sm btn-danger ml-2">Return</a>
                    </td>

                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Returned Books History</div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Accession No</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                        <th>Fine Paid (₹)</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (mysqli_num_rows($history_result) > 0):
                    while ($row = mysqli_fetch_assoc($history_result)):
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['accession_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                        <td><?php echo htmlspecialchars($row['issue_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['return_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['fine']); ?></td>
                    </tr>
                <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No books returned yet.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
