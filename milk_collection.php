<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: login.php");
    exit;
}
include('db_connect.php');

// Handle adding a new cow
if (isset($_POST['add_cow'])) {
    $cow_id = $_POST['cow_id'];
    $breed = $_POST['breed'];
    $health_status = $_POST['health_status'];
    $milk_produced_today = $_POST['milk_produced_today'];
    $collection_date = $_POST['collection_date']; // Fetch the entered date

    // Validate collection_date to ensure a proper value is entered
    if (!empty($collection_date)) {
        // Check if the cow_id exists in tblproducts
        $check_query = "SELECT product_id FROM tblproducts WHERE product_id = '$cow_id'";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Insert the data into tblherd
            $query = "INSERT INTO tblherd (cow_id, breed, health_status, milk_produced_today, collection_date) 
                      VALUES ('$cow_id', '$breed', '$health_status', '$milk_produced_today', '$collection_date')";
            if (mysqli_query($con, $query)) {
                echo "Cow added successfully!";
            } else {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            echo "Error: The cow ID does not exist in the products table.";
        }
    } else {
        echo "Error: Please enter a valid collection date.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Collection</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Farm Employee</h2>
            <ul>
                <li><a href="employee_dashboard.php">Dashboard</a></li>
                <li><a href="milk_collection.php">Milk Collection</a></li>
                <li><a href="health_records.php">Herd Health</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="feeds_nutrition.php">Animal Feeds & Nutrition</a></li>
                <li><a href="reproductive_cycles.php">Reproductive Cycles</a></li>
                <li><a href="newborn_records.php">Newborn Records</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Milk Collection</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>Add New Cow</h2>
                <form method="post">
                    <label for="cow_id">Cow ID:</label>
                    <input type="text" name="cow_id" required><br><br>
                    <label for="breed">Breed:</label>
                    <input type="text" name="breed" required><br><br>
                    <label for="health_status">Health Status:</label>
                    <input type="text" name="health_status" required><br><br>
                    <label for="milk_produced_today">Milk Produced Today:</label>
                    <input type="number" step="0.01" name="milk_produced_today" required><br><br>
                    <label for="collection_date">Collection Date and Time:</label>
                    <input type="datetime-local" name="collection_date" required><br><br>
                    <button type="submit" name="add_cow">Add Cow</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
