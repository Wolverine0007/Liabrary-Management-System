<?php
$connection = mysqli_connect("localhost", "root", "", "lms");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT book_no, book_name, author, category, status FROM books";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error retrieving books: " . mysqli_error($connection));
}

$books = [];
while ($row = mysqli_fetch_assoc($result)) {
    $books[] = $row;
}
mysqli_close($connection);
?>
