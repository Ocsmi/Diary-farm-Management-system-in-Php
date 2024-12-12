<?php
session_start();
include('db_connect.php');

// Ensure only logged-in users can delete feeds
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ensure only authorized roles can delete feeds
if ($_SESSION['role'] != 'employee' && $_SESSION['role'] != 'admin') {
    header("Location: unauthorized.php");
    exit;
}

// Check if the feed_id is passed
if (isset($_POST['feed_id'])) {
    $feed_id = mysqli_real_escape_string($con, $_POST['feed_id']);

    // Delete the feed with the given feed_id
    $query = "DELETE FROM tblfeeds WHERE feed_id = '$feed_id'";

    if (mysqli_query($con, $query)) {
        header("Location: feeds_nutrition.php?success=Feed deleted successfully!");
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "Feed ID is missing.";
}
?>
