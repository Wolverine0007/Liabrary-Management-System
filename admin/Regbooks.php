<?php
session_start();
include("fetch_announcements.php");

$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// No server-side search filtering; fetch all books grouped by title, author, etc.
$query = "SELECT title, author, price, publisher, COUNT(*) AS available_copies
          FROM books
          GROUP BY title, author, price, publisher";
$query_run = mysqli_query($connection, $query);
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
			let title = row.querySelector(".book-title").textContent.toLowerCase();
			let author = row.querySelector(".book-author").textContent.toLowerCase();

			if (title.includes(input) || author.includes(input)) {
				row.style.display = "";
			} else {
				row.style.display = "none";
			}
		});
	}

	// Attach searchBooks to input event
	document.addEventListener("DOMContentLoaded", function () {
		document.getElementById("searchInput").addEventListener("keyup", searchBooks);
	});
</script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
		<div class="container-fluid"> 
			<div class="navbar-header">
				<img src="../images/logo.jpg" alt="Library Logo" height="40">
				<a class="navbar-brand" href="../user_dashboard.php">Central Library</a>
			</div>
			<font style="color: white"><span><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span></font> 
			<font style="color: white"><span><strong>Email: <?php echo $_SESSION['email'];?></strong></span></font>
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
					<a class="nav-link" href="../logout.php">Logout</a> 
				</li> 
			</ul> 
		</div> 
	</nav>
	<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd"> 
		<div class="container-fluid">
			<a class="navbar-brand" href="../user_dashboard.php">Dashboard</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav mr-auto"></ul>
			</div>
		</div>
	</nav><br>

<span><marquee><?php echo $marquee_text; ?></marquee></span><br><br>

<div class="container">
    <center><h4>Library Books Availability</h4></center>

    <form class="form-inline justify-content-center mb-3" autocomplete="off" onsubmit="return false;">
        <input type="text" id="searchInput" class="form-control mr-2" placeholder="Search by title or author">
    </form>

    <table class="table table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>Book Name</th>
                <th>Author</th>
                <th>Price</th>
                <th>Publisher</th>
                <th>Available Copies</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                echo "<tr class='book-row'>";
                echo "<td class='book-title'>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td class='book-author'>" . htmlspecialchars($row['author']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['publisher']) . "</td>";
                echo "<td>" . htmlspecialchars($row['available_copies']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No books found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
