<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $connection = mysqli_connect("localhost", "root", "", "lms");

    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $mobile = mysqli_real_escape_string($connection, $_POST['mobile']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $library_card_no = mysqli_real_escape_string($connection, $_POST['library_card_no']);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $check_query = "SELECT * FROM users WHERE email = '$email' OR library_card_no = '$library_card_no'";
        $result = mysqli_query($connection, $check_query);

        if (mysqli_num_rows($result) > 0) {
            $error = "User with this email or library card number already exists.";
        } else {
            $query = "INSERT INTO users (name, email, password, mobile, address, library_card_no) 
                      VALUES ('$name', '$email', '$password', '$mobile', '$address', '$library_card_no')";

            if (mysqli_query($connection, $query)) {
                $success = "User added successfully.";
            } else {
                $error = "Failed to add user.";
            }
        }
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
            <a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
        </div>
        <font style="color: white"><span><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span></font>
        <font style="color: white"><span><strong>Email: <?php echo $_SESSION['email'];?></strong></font>
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
							<a class="dropdown-item" href="manage_users.php">Manage Users</a>
							<a class="dropdown-item" href="issue_book.php">Issue Book</a>
						</div>
					</li>

				</ul>
			</div>
		</div>
	</nav><br>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
    <h2>Add New User</h2>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<form method="post" action="" name="userForm" onsubmit="return validateForm()">
    <div class="form-group">
        <label>Full Name:</label>
        <input type="text" name="name" class="form-control" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
    </div>
    <div class="form-group">
        <label>Email ID:</label>
        <input type="email" name="email" class="form-control" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
    </div>
    <div class="form-group">
        <label>Password:</label>
        <div class="input-group">
            <input type="password" name="password" id="password" class="form-control" required>
            <div class="input-group-append">
                <span class="input-group-text" onclick="togglePassword('password', this)">
                    <i class="fa fa-eye-slash"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Confirm Password:</label>
        <div class="input-group">
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            <div class="input-group-append">
                <span class="input-group-text" onclick="togglePassword('confirm_password', this)">
                    <i class="fa fa-eye-slash"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Mobile:</label>
        <input type="text" name="mobile" class="form-control" maxlength="15" value="<?php echo isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : ''; ?>">
    </div>
    <div class="form-group">
        <label>Address:</label>
        <textarea name="address" class="form-control" rows="3"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Library Card Number:</label>
        <input type="text" name="library_card_no" class="form-control" required value="<?php echo isset($_POST['library_card_no']) ? htmlspecialchars($_POST['library_card_no']) : ''; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Add User</button>
</form>

    <br>
    <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>
<div class="col-md-4"></div>
</div>
<script>
function togglePassword(inputId, el) {
    const input = document.getElementById(inputId);
    const icon = el.querySelector("i");
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}
</script>

</body>
</html>
