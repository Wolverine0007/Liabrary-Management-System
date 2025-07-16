<?php
    $connection = mysqli_connect("localhost", "root", "", "lms");

    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Initialize default message
    $announcement_text = "No current announcements.";

    // Fetch all floated announcements
    $query = "SELECT message FROM announcements WHERE is_floated = 1";
    $result = mysqli_query($connection, $query);

    $marquee_text = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $marquee_text .= htmlspecialchars($row['message']) . " ✨ | ";
    }

?>
