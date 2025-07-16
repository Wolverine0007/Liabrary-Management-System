<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

$query = "SELECT * FROM staff_accounts";
$result = mysqli_query($connection, $query);
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
		function searchUsers() {
			let input = document.getElementById("searchInput").value.toLowerCase();
			let rows = document.querySelectorAll(".user-row");

			rows.forEach(row => {
				let userName = row.querySelector(".user-name").textContent.toLowerCase();
				let cardNo = row.querySelector(".user-card").textContent.toLowerCase();

				if (userName.includes(input) || cardNo.includes(input)) {
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
				<img src="../images/logo.png" alt="Library Logo" height="40">
				<a class="navbar-brand" href="index.php">Central Library</a>
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
			<ul class="nav navbar-nav navbar-center"> 
				<li class="nav-item"> 
					<a class="nav-link" href="admin_dashboard.php">Dashboard</a> 
				</li> 
				<li class="nav-item dropdown"> 
					<a class="nav-link dropdown-toggle" data-toggle="dropdown">Staff</a> 
					<div class="dropdown-menu"> 
						<a class="dropdown-item" href="add_staff.php">Add New Staff</a> 
						
					</div> 
				</li> 
			</ul> 
		</div> 
	</nav><br> 
<div class="container mt-4">
    <h4 class="text-center">Manage Staff</h4>
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search by name or staff ID" onkeyup="searchStaff()">
    <table class="table table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Staff ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr class="staff-row">
                <td class="staff-name"><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td class="staff-id"><?php echo htmlspecialchars($row['id']); ?></td>
                <td><a href="view_staff.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-sm btn-primary">View Details</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
