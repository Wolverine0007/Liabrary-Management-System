<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

// Fetch form data
$id = $_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$address = $_POST['address'] ?? '';
$library_card_no = $_POST['library_card_no'] ?? '';

// Get current email using id
$get_current = mysqli_query($connection, "SELECT email FROM users WHERE id = '$id'");
if (!$get_current || mysqli_num_rows($get_current) == 0) {
    echo "<script>alert('User not found.'); window.history.back();</script>";
    exit();
}

$current_data = mysqli_fetch_assoc($get_current);
$current_email = $current_data['email'];

// Only check for email duplicates if email is changed
if ($email !== $current_email) {
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $check_email);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already exists.'); window.history.back();</script>";
        exit();
    }
}

// Perform update
$query = "UPDATE users 
          SET name='$name', 
              email='$email', 
              mobile='$mobile', 
              address='$address', 
              updated_at=NOW() 
          WHERE id='$id'";

$query_run = mysqli_query($connection, $query);

if ($query_run) {
    $_SESSION['email'] = $email;
    echo "<script>alert('Profile updated successfully'); window.location.href='view_user.php?card=$library_card_no';</script>";
} else {
    echo "<script>alert('Update failed: " . mysqli_error($connection) . "'); window.history.back();</script>";
}
?>
