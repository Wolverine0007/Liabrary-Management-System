<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");

$accession = mysqli_real_escape_string($connection, $_GET['accession']);
$card = mysqli_real_escape_string($connection, $_GET['card']);

$query = "SELECT * FROM issued_books WHERE accession_number = '$accession' AND library_card_no = '$card' AND status = 1";
$result = mysqli_query($connection, $query);
$book = mysqli_fetch_assoc($result);

$due = new DateTime($book['due_date']);
$today = new DateTime();
$fine = 0;
if ($today > $due) {
    $overdue_days = $due->diff($today)->days - 1;
    if ($overdue_days > 0) {
        $fine = ($overdue_days <= 7) ? (2 * $overdue_days) : (2 * 7 + 5 * ($overdue_days - 7));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $return_date = mysqli_real_escape_string($connection, $_POST['return_date']);
    $edited_fine = mysqli_real_escape_string($connection, $_POST['fine']);
    $update = "UPDATE issued_books SET status = 0, return_date = '$return_date', fine = '$edited_fine' WHERE accession_number = '$accession' AND library_card_no = '$card'";
    if (mysqli_query($connection, $update)) {
        header("Location: view_user.php?card=$card&msg=" . urlencode("Book returned successfully."));
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Book</title>
    <link rel="stylesheet" href="../bootstrap-4.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h4>Confirm Return of Book</h4>
    <form method="post">
        <table class="table table-bordered w-50">
            <tr><th>Accession No</th><td><?php echo $book['accession_number']; ?></td></tr>
            <tr><th>Library Card No</th><td><?php echo $book['library_card_no']; ?></td></tr>
            <tr><th>Title</th><td><?php echo $book['title']; ?></td></tr>
            <tr><th>Author</th><td><?php echo $book['author']; ?></td></tr>
            <tr><th>Issue Date</th><td><?php echo $book['issue_date']; ?></td></tr>
            <tr><th>Due Date</th><td><?php echo $book['due_date']; ?></td></tr>
            <tr>
                <th>Fine (₹)</th>
                <td><input type="number" name="fine" class="form-control" value="<?php echo $fine; ?>" required></td>
            </tr>
        </table>

        <div class="form-group w-50">
            <label for="return_date"><strong>Select Return Date</strong></label>
            <input type="date" id="return_date" name="return_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Confirm Return</button>
        <a href="view_user.php?card=<?php echo $card; ?>" class="btn btn-secondary ml-2">Cancel</a>
    </form>
</div>
</body>
</html>
