<?php

function get_user_count(){
	$connection = mysqli_connect("localhost", "root", "", "lms");
	$query = "SELECT COUNT(*) AS user_count FROM users";
	$query_run = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($query_run);
	return $row['user_count'];
}

function get_staff_count(){
	$connection = mysqli_connect("localhost", "root", "", "lms");
	$query = "SELECT COUNT(*) AS staff_count FROM staff_accounts";
	$query_run = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($query_run);
	return $row['staff_count'];
}

function get_book_count(){
	$connection = mysqli_connect("localhost", "root", "", "lms");
	$query = "SELECT COUNT(*) AS book_count FROM books";
	$query_run = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($query_run);
	return $row['book_count'];
}

function get_issue_book_count(){
	$connection = mysqli_connect("localhost", "root", "", "lms");
	$query = "SELECT COUNT(*) AS issue_book_count FROM issued_books WHERE status = 1";
	$query_run = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($query_run);
	return $row['issue_book_count'];
}

?>
