<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$department = $_POST['department'] ?? '';

// if (!$id || !$name || !$email || !$phone || !$department) {
//     echo "<script>alert('All fields are required.'); window.history.back();</script>";
//     exit();
// }

// Check if email is being changed and is unique
$current_email = $_SESSION['email'];
$check_email = "SELECT * FROM staff_accounts WHERE email='$email' AND id != '$id'";
$result = mysqli_query($connection, $check_email);

if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('Email already exists.'); window.history.back();</script>";
    exit();
}

// ✅ FIXED: Added comma before updated_at
$query = "UPDATE staff_accounts 
          SET name='$name', 
              email='$email', 
              phone='$phone', 
              department='$department', 
              updated_at=NOW() 
          WHERE id=$id";

$query_run = mysqli_query($connection, $query);

if ($query_run) {
    $_SESSION['email'] = $email;
    echo "<script>alert('Profile updated successfully'); window.location.href='view_staff.php?id=$id';</script>";
} else {
    echo "<script>alert('Update failed: " . mysqli_error($connection) . "'); window.history.back();</script>";
}
?>
