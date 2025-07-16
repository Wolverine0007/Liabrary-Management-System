<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "lms");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['query'])) {
    $search = mysqli_real_escape_string($connection, $_POST['query']);
    $query = "SELECT book_no, book_name FROM books WHERE book_name LIKE '%$search%' AND available_copies > 0 LIMIT 5";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<a href='#' class='list-group-item list-group-item-action' onclick=\"selectBook('" . $row['book_no'] . "', '" . addslashes($row['book_name']) . "')\">" . htmlspecialchars($row['book_name']) . " (Book No: " . htmlspecialchars($row['book_no']) . ")</a>";
        }
    } else {
        echo "<p class='list-group-item'>No books found</p>";
    }
}

mysqli_close($connection);
?>
