<?php 
	require("functions.php"); 
	session_start(); 
	include("fetch_announcements.php");
	require_once dirname(__DIR__) . "/config.php";

	$name = ""; 
	$email = ""; 
	$phone = ""; 
	$query = "select * from staff_accounts where email = '$_SESSION[email]'"; 
	$query_run = mysqli_query($connection,$query); 
	while ($row = mysqli_fetch_assoc($query_run)){ 
		$name = $row['name']; 
		$email = $row['email']; 
		$phone = $row['phone']; 
	} 
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
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
		<div class="container-fluid"> 
			<div class="navbar-header">
				<img src="../images/logo.jpg" alt="Library Logo" height="40">
				<a class="navbar-brand" href="admin_dashboard.php">Central Library</a>
			</div>
			<font style="color: white"><span><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span></font> 
			<font style="color: white"><span><strong>Email: <?php echo $_SESSION['email'];?></strong></span></font>
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
							<a class="dropdown-item" href="add_book.php">Add New Book</a>
							<a class="dropdown-item" href="issue_book.php">Issue Book</a>
							<a class="dropdown-item" href="Regbooks.php">All Books</a>
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
							<a class="dropdown-item" href="add_user.php">Add New User</a>
							<a class="dropdown-item" href="issue_book.php">Issue Book</a>
						</div>
					</li>

				</ul>
			</div>
		</div>
	</nav><br>

	<span><marquee><?php echo $marquee_text; ?></marquee></span><br><br>
	<center><h4>Manage Books</h4><br></center> 
	<div class="row"> 
		<div class="col-md-2"></div> 
		<div class="col-md-8"> 
			<!-- Issue Book Section (First) -->
			<div class="card mb-4">
				<div class="card-header">Issue Book</div>
				<div class="card-body">
					<form action="issue_book.php" method="post">
						<div class="form-row">
							<div class="form-group col-md-3">
								<label>Accession No.</label>
								<input type="text" id="issue_accession_number" name="accession_number" class="form-control" required>
							</div>
							<div class="form-group col-md-3">
								<label>Library Card No.</label>
								<input type="text" name="library_card_no" class="form-control" required>
							</div>
							<div class="form-group col-md-3">
								<label>Issue Date</label>
								<input type="date" name="issue_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
							</div>
							<div class="form-group col-md-3">
								<label>Due Date</label>
								<input type="date" name="due_date" class="form-control" required>
							</div>
						</div>
						<button type="submit" name="issue_book" class="btn btn-primary">Issue</button>
						<a href="issue_book.php" class="btn btn-link">Advanced issue form</a>
					</form>
				</div>
			</div>

			<!-- Search by Title (Second) -->
			<input type="text" id="searchInput" class="form-control" placeholder="Search by title... (click a row to add to Issue form)" onkeyup="searchBooks()"><br>
			<table class="table table-bordered table-hover"> 
				<thead> 
					<tr> 
						<th>Accession No.</th> 
						<th>Title</th> 
						<th>Author</th> 
						<th>Publisher</th> 
						<th>Price</th> 
						<th>Action</th> 
					</tr> 
				</thead> 
				<?php 
					$query = "SELECT * FROM books"; 
					$query_run = mysqli_query($connection,$query); 
					while ($row = mysqli_fetch_assoc($query_run)){ 
				?> 
				<tr class="book-row" data-accession="<?php echo $row['accession_number']; ?>" style="cursor: pointer;"> 
					<td><?php echo $row['accession_number']; ?></td> 
					<td class="book-name"><?php echo $row['title']; ?></td> 
					<td><?php echo $row['author']; ?></td> 
					<td><?php echo $row['publisher']; ?></td> 
					<td><?php echo $row['price']; ?></td> 
					<td>
						<a href="edit_book.php?an=<?php echo $row['accession_number']; ?>" class="text-primary mx-1" title="Edit">
							<i class="fas fa-edit"></i>
						</a>
						<a href="delete_book.php?an=<?php echo $row['accession_number']; ?>" class="text-danger mx-1" title="Delete" onclick="return confirm('Are you sure to delete this book?')">
							<i class="fas fa-trash"></i>
						</a>
					</td>
				</tr> 
				<?php 
					} 
				?> 
			</table> 
		</div> 
		<div class="col-md-2"></div> 
	</div> 

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var rows = document.querySelectorAll('.book-row');
			rows.forEach(function(row) {
				row.addEventListener('click', function() {
					var accession = this.getAttribute('data-accession');
					var input = document.getElementById('issue_accession_number');
					if (input && accession) {
						input.value = accession;
						input.focus();
						input.scrollIntoView({ behavior: 'smooth', block: 'center' });
					}
				});
			});
		});
	</script>
</body> 
</html>
