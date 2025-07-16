<?php include("admin/fetch_announcements.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>LMS</title>
    <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="bootstrap-4.4.1/js/jquery_latest.js"></script>
    <script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<style type="text/css">
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
            <img src="images/logo.png" alt="Library Logo" height="40">
            <a class="navbar-brand" href="index.php">Central Library</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item"><a class="nav-link" href="index.php">Admin Login</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Register</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php">Login</a></li>
        </ul>
    </div>
</nav><br>
<span><marquee><?php echo htmlspecialchars($announcement_text); ?></marquee></span><br><br>
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
            <li>Free Wi-fi</li>
            <li>News Papers</li>
            <li>Discussion Room</li>
            <li>RO Water</li>
            <li>Peaceful Environment</li>
        </ul>
    </div>
    <div class="col-md-8" id="main_content">
        <center><h3><u>User Registration Form</u></h3></center>
        <form action="register.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email ID:</label>
                <input type="text" id="email" name="email" class="form-control" required>
                <small id="emailError" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <div class="input-group-append">
                        <span class="input-group-text" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                    </div>
                </div>
                <small id="passwordError" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <div class="input-group">
                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
                    <div class="input-group-append">
                        <span class="input-group-text" onclick="togglePassword('confirmPassword', this)">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                    </div>
                </div>
                <small id="confirmPasswordError" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label for="mobile">Mobile:</label>
                <input type="text" id="mobile" name="mobile" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" class="form-control" required></textarea> 
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</div>

<script>
function validateForm() {
    let isValid = true;

    let email = document.getElementById("email").value.trim();
    let emailPattern = /^[a-zA-Z0-9._%+-]+@mitaoe\.ac\.in$/;
    if (!emailPattern.test(email)) {
        document.getElementById("emailError").innerText = "Must be @mitaoe.ac.in";
        isValid = false;
    } else {
        document.getElementById("emailError").innerText = "";
    }

    let password = document.getElementById("password").value;
    let passwordPattern = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;
    if (!passwordPattern.test(password)) {
        document.getElementById("passwordError").innerText = "Weak password (min 6 chars, 1 letter & 1 number)";
        isValid = false;
    } else {
        document.getElementById("passwordError").innerText = "";
    }

    let confirmPassword = document.getElementById("confirmPassword").value;
    if (confirmPassword !== password) {
        document.getElementById("confirmPasswordError").innerText = "Passwords do not match";
        isValid = false;
    } else {
        document.getElementById("confirmPasswordError").innerText = "";
    }

    return isValid;
}

function togglePassword(fieldId, iconSpan) {
    const field = document.getElementById(fieldId);
    const icon = iconSpan.querySelector('i');
    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    } else {
        field.type = "password";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    }
}
</script>
</body>
</html>
