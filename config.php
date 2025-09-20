<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "lms";

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$connection) {
	die("Database connection failed: " . mysqli_connect_error());
}

?>


