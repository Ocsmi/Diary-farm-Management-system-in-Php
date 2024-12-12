<?php 
session_start();
include('db_connect.php');

// Ensure only logged-in users can add feeds
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ensure only authorized roles can add feeds
if ($_SESSION['role'] != 'employee' && $_SESSION['role'] != 'admin') {
    header("Location: unauthorized.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feed_name = isset($_POST['feed_name']) ? mysqli_real_escape_string($con, $_POST['feed_name']) : '';
    $quantity = isset($_POST['quantity']) ? mysqli_real_escape_string($con, $_POST['quantity']) : '';
    $unit = isset($_POST['unit']) ? mysqli_real_escape_string($con, $_POST['unit']) : '';
    $price_per_unit = isset($_POST['price_per_unit']) ? mysqli_real_escape_string($con, $_POST['price_per_unit']) : '';
    $feed_type = isset($_POST['feed_type']) ? mysqli_real_escape_string($con, $_POST['feed_type']) : '';

    if (!empty($feed_name) && !empty($quantity) && !empty($unit) && !empty($price_per_unit) && !empty($feed_type)) {
        $query = "INSERT INTO tblfeeds (feed_name, quantity, unit, price_per_unit, feed_type) 
                  VALUES ('$feed_name', '$quantity', '$unit', '$price_per_unit', '$feed_type')";

        if (mysqli_query($con, $query)) {
            header("Location: feeds_nutrition.php?success=Feed added successfully!");
            exit;
        } else {
            echo "Failed to add feed. Please try again.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Feed</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="container">
        <div class="add-feed-form">
            <h3>Add New Feed</h3>
            <form action="add_feed.php" method="post">
                <label for="feed_name">Feed Name:</label>
                <input type="text" id="feed_name" name="feed_name" required>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="unit">Unit:</label>
                <input type="text" id="unit" name="unit" required>

                <label for="price_per_unit">Price Per Unit:</label>
                <input type="number" step="0.01" id="price_per_unit" name="price_per_unit" required>

                <label for="feed_type">Feed Type:</label>
                <input type="text" id="feed_type" name="feed_type" required>

                <button type="submit">Add Feed</button>
            </form>
        </div>
    </div>
</body>
</html>
