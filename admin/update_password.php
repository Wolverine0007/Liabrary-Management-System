<?php
session_start();
require_once dirname(__DIR__) . '/config.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    echo "<script>alert('Unauthorized access'); window.location.href='login.php';</script>";
    exit();
}

$email = $_SESSION['email'];
$role = $_SESSION['role']; // 'admin', 'staff', or 'student'

// Map role to the correct table
switch ($role) {
    case 'admin':
    case 'staff':
        $table = 'staff_accounts';
        break;
    case 'student':
        $table = 'users';
        break;
    default:
        echo "<script>alert('Invalid user role'); window.location.href='login.php';</script>";
        exit();
}

// Fetch stored password
$stmt = mysqli_prepare($connection, "SELECT password FROM $table WHERE email = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
if (!$row) {
    echo "<script>alert('User not found'); window.history.back();</script>";
    exit();
}

$stored = $row['password'];
$old = $_POST['old_password'] ?? '';
$new = $_POST['new_password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if ($new !== $confirm) {
    echo "<script>alert('New passwords do not match'); window.history.back();</script>";
    exit();
}

$valid = (strpos($stored, '$2y$') === 0 || strpos($stored, '$argon2') === 0)
    ? password_verify($old, $stored)
    : hash_equals($stored, $old);
if (!$valid) {
    echo "<script>alert('Old password is incorrect'); window.history.back();</script>";
    exit();
}

$new_hash = password_hash($new, PASSWORD_BCRYPT);
$upd = mysqli_prepare($connection, "UPDATE $table SET password = ? WHERE email = ?");
mysqli_stmt_bind_param($upd, 'ss', $new_hash, $email);
if (mysqli_stmt_execute($upd)) {
    echo "<script>alert('Password updated successfully'); window.location.href='{$role}_dashboard.php';</script>";
} else {
    echo "<script>alert('Password update failed'); window.history.back();</script>";
}
?>
