<?php
session_start();
$error = "";
include("fetch_announcements.php");

if (isset($_POST['login'])) {
    $connection = mysqli_connect("localhost", "root", "", "lms");
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = $_POST['password'];

    // Check staff_accounts
    $staff_query = "SELECT * FROM staff_accounts WHERE email = '$email' LIMIT 1";
    $staff_result = mysqli_query($connection, $staff_query);
    if ($row = mysqli_fetch_assoc($staff_result)) {
        if ($row['password'] === $password) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            if ($row['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: staff_dashboard.php");
            }
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        // Check users table
        $user_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $user_result = mysqli_query($connection, $user_query);
        if ($user = mysqli_fetch_assoc($user_result)) {
            if ($user['password'] === $password) {
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['library_card_no'] = $user['library_card_no'];
                $_SESSION['id'] = $user['id'];
                header("Location: ../user_dashboard.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>LMS | Login</title>
    <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
    <script src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    #main_content {
        padding: 50px;
        background-color: whitesmoke;
    }
    #side_bar {
        background-color: whitesmoke;
        padding: 50px;
        width: 300px;
        height: 450px;
    }
</style>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-header" href="index.php">
                <img src="../images/logo.png" alt="Library Logo" height="40">
                <a class="navbar-brand" href="index.php">Central Library</a>
            </a>
        </div>
    </div>
</nav><br>

<marquee><?php echo $marquee_text ?? 'Welcome to LMS'; ?></marquee><br><br>

<div class="row">
    <div class="col-md-4" id="side_bar">
        <h5>Library Timing</h5>
        <ul>
            <li>Opening: 8:00 AM</li>
            <li>Closing: 8:00 PM</li>
            <li>(Sunday Off)</li>
        </ul>
        <h5>What We Provide?</h5>
        <ul>
            <li>Full furniture</li>
            <li>Free Wi-Fi</li>
            <li>Peaceful Environment</li>
        </ul>
    </div>

    <div class="col-md-8" id="main_content">
        <center><h3><u>Login Portal</u></h3></center>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="post" autocomplete="off">
            <div class="form-group">
                <label for="email">Email ID:</label>
                <input type="text" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group position-relative">
                <label for="password">Password:</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <div class="input-group-append">
                        <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer;">
                            <span id="eye-icon">👁️‍🗨️</span>
                        </span>
                    </div>
                </div>
            </div>

            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>

<script>
    function togglePassword() {
        const pass = document.getElementById("password");
        const eye = document.getElementById("eye-icon");
        if (pass.type === "password") {
            pass.type = "text";
            eye.textContent = "👁️";
        } else {
            pass.type = "password";
            eye.textContent = "👁️‍🗨️";
        }
    }
</script>

</body>
</html>
