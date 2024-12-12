<?php
session_start();
include('db_connect.php');

// Ensure only logged-in users can add cows
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ensure only authorized roles can add cows
if ($_SESSION['role'] != 'employee' && $_SESSION['role'] != 'admin') {
    header("Location: unauthorized.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $breed = isset($_POST['breed']) ? mysqli_real_escape_string($con, $_POST['breed']) : '';

    if (!empty($breed)) {
        // Insert cow into tblcows
        $query = "INSERT INTO tblcows (breed) VALUES ('$breed')";
        
        if (mysqli_query($con, $query)) {
            echo "Cow added successfully!";
        } else {
            echo "Failed to add cow. Please try again.";
        }
    } else {
        echo "Please provide a breed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Cow</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <h1>Add Cow</h1>
    <form method="POST">
        <label for="breed">Breed:</label>
        <input type="text" id="breed" name="breed" required>
        <button type="submit">Add Cow</button>
    </form>
</body>
</html>
