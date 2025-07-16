<?php
session_start(); // Start session

$connection = mysqli_connect("localhost", "root", "", "lms");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('User not logged in!'); window.location.href = 'admin/login.php';</script>";
    exit();
}

// Get user ID from session
$user_id = $_SESSION['id'];

// Secure user inputs
$name = mysqli_real_escape_string($connection, $_POST['name']);
$email = mysqli_real_escape_string($connection, $_POST['email']);
$mobile = mysqli_real_escape_string($connection, $_POST['mobile']);
$address = mysqli_real_escape_string($connection, $_POST['address']);

// Prepare and execute query
$query = "UPDATE users SET name = ?, email = ?, mobile = ?, address = ? WHERE id = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $mobile, $address, $user_id);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Profile updated successfully!'); window.location.href = 'user_dashboard.php';</script>";
} else {
    echo "<script>alert('Update failed!'); window.location.href = 'user_dashboard.php';</script>";
}

// Close connections
mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
