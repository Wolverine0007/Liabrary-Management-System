<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_GET['card'])) {
    $card = mysqli_real_escape_string($connection, $_GET['card']);

    $delete_query = "DELETE FROM staff_accounts WHERE id = '$card'";
    $result = mysqli_query($connection, $delete_query);

    if ($result) {
        echo "<script>alert('Staff deleted successfully.'); window.location.href='manage_staff.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error deleting staff.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='manage_staff.php';</script>";
    exit;
}
?>
