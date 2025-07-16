<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

if (isset($_GET['card'])) {
    $card = mysqli_real_escape_string($connection, $_GET['card']);

    // Delete the user
    $delete_query = "DELETE FROM users WHERE library_card_no = '$card'";
    $result = mysqli_query($connection, $delete_query);

    if ($result) {
        echo "<script>alert('User deleted successfully.'); window.location.href='manage_users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid user.'); window.history.back();</script>";
}
?>
