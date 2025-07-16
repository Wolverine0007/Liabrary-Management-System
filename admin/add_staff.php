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
    $role = mysqli_real_escape_string($connection, $_POST['role']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $department = mysqli_real_escape_string($connection, $_POST['department']);

    $check_query = "SELECT * FROM staff_accounts WHERE email = '$email'";
    $result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $error = "A user with this email already exists.";
    } else {
        $query = "INSERT INTO staff_accounts (name, email, password, role, phone, department) 
                  VALUES ('$name', '$email', '$password', '$role', '$phone', '$department')";

        if (mysqli_query($connection, $query)) {
            $success = "Staff member added successfully.";
        } else {
            $error = "Failed to add staff member.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
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
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
        <h2>Add Staff Member</h2>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email ID:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="text" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Role:</label>
                <select name="role" class="form-control" required>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone" class="form-control" maxlength="15">
            </div>
            <div class="form-group">
                <label>Department:</label>
                <input type="text" name="department" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Add Staff</button>
        </form>
        <br>
        <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    <div class="col-md-4"></div>
    </div>
</body>
</html>
