<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

$card = mysqli_real_escape_string($connection, $_GET['card'] ?? '');

// Initialize variables
$id = $name = $email = $phone = $address = "";

// Fetch user data based on library_card_no
$query = "SELECT * FROM users WHERE library_card_no = '$card'";
$query_run = mysqli_query($connection, $query);

if ($row = mysqli_fetch_assoc($query_run)) {
    $id = $row['id'];
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['mobile'];
    $address = $row['address'];
}
?>
<!DOCTYPE html>
<html>
<head> 
    <title>Edit User Profile</title> 
    <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1"> 
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">   
    <script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>   
    <script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>   
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

    <div class="container mt-4">
        <h4 class="text-center">Edit User Profile</h4><br>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="update_user.php" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <input type="hidden" name="library_card_no" value="<?php echo htmlspecialchars($card); ?>">

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="mobile">Mobile:</label>
                        <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea rows="3" name="address" class="form-control" required><?php echo htmlspecialchars($address); ?></textarea>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</body>
</html>
