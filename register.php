<?php
    $connection = mysqli_connect("localhost", "root", "", "lms");

    if (!$connection) {
        die("Database Connection Failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($connection, $_POST['email']);

        // Check if email already exists
        $check_email_query = "SELECT * FROM users WHERE email='$email'";
        $check_email_result = mysqli_query($connection, $check_email_query);

        if (mysqli_num_rows($check_email_result) > 0) {
            // Email exists, show alert and redirect
            echo "<script>alert('Email already exists. Please use a different email.'); window.location.href = 'signup.php';</script>";
            exit();  // ✅ Fix: Prevent further execution to avoid blank page
        } else {
            // Insert the new user if email is unique
            $query = "INSERT INTO users (name, email, password, mobile, address) VALUES ('$_POST[name]', '$_POST[email]', '$_POST[password]', '$_POST[mobile]', '$_POST[address]')";
            $query_run = mysqli_query($connection, $query);

            if ($query_run) {
                echo "<script>alert('Registration successful...You may Login now !!'); window.location.href = 'index.php';</script>";
                exit(); // ✅ Fix: Prevents further script execution
            } else {
                echo "<script>alert('Error: Unable to register. Please try again.'); window.location.href = 'register.php';</script>";
                exit(); // ✅ Fix: Prevents blank page on query failure
            }
        }
    }
?>
