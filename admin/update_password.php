<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    echo "<script>alert('Unauthorized access'); window.location.href='login.php';</script>";
    exit();
}

$email = $_SESSION['email'];
$role = $_SESSION['role']; // 'admin', 'staff', or 'student'

// Map role to the correct table
$table = "";
switch ($role) {
    case "admin":
        $table = "staff_accounts";
        break;
    case "staff":
        $table = "staff_accounts";
        break;
    case "student":
        $table = "users";
        break;
    default:
        echo "<script>alert('Invalid user role'); window.location.href='login.php';</script>";
        exit();
}

// Get current password from DB
$query = "SELECT password FROM $table WHERE email = '$email'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('User not found'); window.history.back();</script>";
    exit();
}

$current_password = $row['password'];
$old_password_input = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validation
if ($old_password_input !== $current_password) {
    echo "<script>alert('Old password is incorrect'); window.history.back();</script>";
    exit();
}

if ($new_password !== $confirm_password) {
    echo "<script>alert('New passwords do not match'); window.history.back();</script>";
    exit();
}

// Update password
$update_query = "UPDATE $table SET password = '$new_password' WHERE email = '$email'";
if (mysqli_query($connection, $update_query)) {
    echo "<script>alert('Password updated successfully'); window.location.href='{$role}_dashboard.php';</script>";
} else {
    echo "<script>alert('Password update failed'); window.history.back();</script>";
}
?>
