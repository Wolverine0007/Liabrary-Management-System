<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

$card = isset($_GET['card']) ? mysqli_real_escape_string($connection, $_GET['card']) : '';

// Fetch user data based on library_card_no from URL
$name = $email = $mobile = $address = "";

$query = "SELECT * FROM users WHERE library_card_no = '$card'";
$query_run = mysqli_query($connection, $query);

if ($row = mysqli_fetch_assoc($query_run)) {
    $name = $row['name'];
    $email = $row['email'];
    $mobile = $row['mobile'];
    $address = $row['address'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.4.1/css/bootstrap.min.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<div class="navbar-header">
			<a href="user_dashboard.php">
				<img src="images/logo.jpg" alt="Library Logo" height="40">
			</a>
			<a class="navbar-brand" href="user_dashboard.php">Central Library</a>
			</div>
			<font style="color: white"><span><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span></font>
			<font style="color: white"><span><strong>Email: <?php echo $_SESSION['email'];?></strong></font>
		    <ul class="nav navbar-nav navbar-right">
		      <li class="nav-item dropdown">
	        	<a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile </a>
	        	<div class="dropdown-menu">
	        		<a class="dropdown-item" href="view_profile.php">View Profile</a>
	        		<div class="dropdown-divider"></div>
	        		<a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
	        		<div class="dropdown-divider"></div>
	        		<a class="dropdown-item" href="change_password.php">Change Password</a>
	        	</div>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="logout.php">Logout</a>
		      </li>
		    </ul>
		</div>
	</nav><br>
    <div class="container mt-4">
        <h4 class="text-center">Edit Profile</h4><br>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="update.php" method="post">
                    <input type="hidden" name="library_card_no" value="<?php echo htmlspecialchars($card); ?>">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile:</label>
                        <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($mobile); ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea rows="3" name="address" class="form-control"><?php echo htmlspecialchars($address); ?></textarea>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</body>
</html>
