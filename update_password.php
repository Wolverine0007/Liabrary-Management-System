<?php
session_start();
require_once __DIR__ . '/config.php';

if (!isset($_SESSION['email'])) {
    echo "<script>alert('Unauthorized'); window.location.href='index.php';</script>";
    exit();
}

$email = $_SESSION['email'];
$old = $_POST['old_password'] ?? '';
$new = $_POST['new_password'] ?? '';

$stmt = mysqli_prepare($connection, "SELECT password FROM users WHERE email = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);

if (!$row) {
    echo "<script>alert('User not found'); window.location.href='change_password.php';</script>";
    exit();
}

$stored = $row['password'];
$valid = (strpos($stored, '$2y$') === 0 || strpos($stored, '$argon2') === 0)
    ? password_verify($old, $stored)
    : hash_equals($stored, $old);

if (!$valid) {
    echo "<script>alert('Wrong user password'); window.location.href='change_password.php';</script>";
    exit();
}

$new_hash = password_hash($new, PASSWORD_BCRYPT);
$upd = mysqli_prepare($connection, "UPDATE users SET password = ? WHERE email = ?");
mysqli_stmt_bind_param($upd, "ss", $new_hash, $email);
if (mysqli_stmt_execute($upd)) {
    echo "<script>alert('Updated successfully'); window.location.href='user_dashboard.php';</script>";
} else {
    echo "<script>alert('Update failed'); window.location.href='change_password.php';</script>";
}
?>
