<?php
	$connection = mysqli_connect("localhost", "root", "");
	$db = mysqli_select_db($connection, "lms");

	// Retrieve and sanitize the accession number from the query string
	$accession_number = mysqli_real_escape_string($connection, $_GET['an']);

	$accession_number = mysqli_real_escape_string($connection, $_GET['an']);

	// First delete from issued_books
	$delete_issued = "DELETE FROM issued_books WHERE accession_number = '$accession_number'";
	mysqli_query($connection, $delete_issued);

	// Then delete from books
	$delete_book = "DELETE FROM books WHERE accession_number = '$accession_number'";
	mysqli_query($connection, $delete_book);

?>
<script type="text/javascript">
	alert("Book deleted successfully...");
	window.location.href = "manage_book.php";
</script>
