<?php
    session_start();
    $connection = mysqli_connect("localhost", "root", "", "lms");

    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Initialize default message
    $announcement_text = "No current announcements.";

    // Adding a new announcement
    if (isset($_POST['add_announcement'])) {
        $message = mysqli_real_escape_string($connection, $_POST['announcement']);
        $query = "INSERT INTO announcements (message, created_at) VALUES ('$message', NOW())";

        if (mysqli_query($connection, $query)) {
            echo "<script>alert('Announcement saved successfully!'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        } else {
            echo "<script>alert('Error saving announcement: " . mysqli_error($connection) . "');</script>";
        }
    }

    /// Fetch all floated announcements
    $query = "SELECT message FROM announcements WHERE is_floated = 1";
    $result = mysqli_query($connection, $query);

    $marquee_text = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $marquee_text .= htmlspecialchars($row['message']) . " ✨ | ";
    }

    if (isset($_POST['float_announcements'])) {
        // Step 1: Unfloat all announcements first
        mysqli_query($connection, "UPDATE announcements SET is_floated = 0");

        // Step 2: Float only the selected announcements
        if (!empty($_POST['ids'])) {
            $ids = implode(",", array_map('intval', $_POST['ids'])); // Securely format IDs
            $float_query = "UPDATE announcements SET is_floated = 1 WHERE id IN ($ids)";
            
            if (mysqli_query($connection, $float_query)) {
                echo "<script>alert('Floated announcements updated successfully!'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
            } else {
                echo "<script>alert('Error updating floated announcements: " . mysqli_error($connection) . "');</script>";
            }
        } else {
            echo "<script>alert('No announcements are floated now.'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        }
    }

    // Removing an announcement
    if (isset($_POST['remove_announcement'])) {
        $id = $_POST['id'];

        $delete_query = "DELETE FROM announcements WHERE id = $id";
        if (mysqli_query($connection, $delete_query)) {
            echo "<script>alert('Announcement deleted successfully!'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        } else {
            echo "<script>alert('Error deleting announcement: " . mysqli_error($connection) . "');</script>";
        }
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
                            <a class="dropdown-item" href="manage_book.php">Manage Books</a>
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
							<a class="dropdown-item" href="add_user.php">Add New User</a>
							<a class="dropdown-item" href="issue_book.php">Issue Book</a>
						</div>
					</li>

				</ul>
			</div>
		</div>
	</nav>
	<span><marquee><?php echo $marquee_text; ?></marquee></span><br>

    <div class="container">
        <h2>Manage Announcements</h2>
        <form method="post">
            <div class="form-group">
                <label>New Announcement:</label>
                <textarea class="form-control" name="announcement" required></textarea>
            </div>
            <button type="submit" name="add_announcement" class="btn btn-primary">Post Announcement</button>
        </form>

        <h3 class="mt-4">All Announcements</h3>
        <form method="post" class="mb-4">
            <table class="table table-bordered">
                <tr>
                    <th>Select</th>
                    <th>ID</th>
                    <th>Message</th>
                    <th>Posted On</th>
                    <th>Actions</th>
                </tr>
                <?php
                    $result = mysqli_query($connection, "SELECT * FROM announcements ORDER BY created_at DESC");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $checked = ($row['is_floated'] == 1) ? "checked" : ""; // Auto-select if floated
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='ids[]' value='" . $row['id'] . "' $checked></td>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['message'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td>";
                        echo "<form method='post' class='d-inline'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<button type='submit' name='remove_announcement' class='btn btn-danger'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
            <button type="submit" name="float_announcements" class="btn btn-success">Update Floated Announcements</button>
        </form>
    </div>
</body>
</html>
