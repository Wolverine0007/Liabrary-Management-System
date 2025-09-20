<?php
require_once __DIR__ . '/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';

    // Check if email already exists
    $stmt = mysqli_prepare($connection, "SELECT id FROM users WHERE email = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already exists. Please use a different email.'); window.location.href = 'signup.php';</script>";
        exit();
    }

    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $insert = mysqli_prepare($connection, "INSERT INTO users (name, email, password, mobile, address) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($insert, "sssss", $name, $email, $hashed, $mobile, $address);
    if (mysqli_stmt_execute($insert)) {
        echo "<script>alert('Registration successful. You may login now.'); window.location.href = 'index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: Unable to register. Please try again.'); window.location.href = 'register.php';</script>";
        exit();
    }
}
?>
