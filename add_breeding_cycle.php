<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'veterinarian') {
    header("Location: login.php");
    exit;
}
include('db_connect.php');

if (isset($_POST['add_breeding_cycle'])) {
    $cow_id = $_POST['cow_id'];
    $breeding_date = $_POST['breeding_date'];
    $method_of_insemination = $_POST['method_of_insemination'];
    $expected_calving_date = $_POST['expected_calving_date'];
    $status = $_POST['status'];

    $query = "INSERT INTO tblbreeding_cycles (cow_id, breeding_date, method_of_insemination, expected_calving_date, status)
              VALUES ('$cow_id', '$breeding_date', '$method_of_insemination', '$expected_calving_date', '$status')";

    if (mysqli_query($con, $query)) {
        echo "Breeding cycle record added successfully!";
    } else {
        echo "Error: " . mysqli_error($con);  // This will display any errors
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Breeding Cycle</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Veterinarian</h2>
            <ul>
                <li><a href="veterinarian_dashboard.php">Dashboard</a></li>
                <li><a href="healthy_records.php">Health Records</a></li>
                <li><a href="add_health_record.php">Add Health Record</a></li>
                <li><a href="breeding_cycles.php">Breeding Cycles</a></li>
                <li><a href="add_breeding_cycle.php">Add Breeding Cycle</a></li> <!-- Add this link -->
                <li><a href="treatment_history.php">Treatment History</a></li>
                <li><a href="add_treatment_record.php">Add Treatment Records</a></li>
                <li><a href="profile1.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Add Breeding Cycle</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <form method="POST">
                    <label for="cow_id">Cow ID:</label>
                    <input type="number" name="cow_id" required><br><br>

                    <label for="breeding_date">Breeding Date:</label>
                    <input type="date" name="breeding_date" required><br><br>

                    <label for="method_of_insemination">Method of Insemination:</label>
                    <input type="text" name="method_of_insemination" required><br><br>

                    <label for="expected_calving_date">Expected Calving Date:</label>
                    <input type="date" name="expected_calving_date" required><br><br>

                    <label for="status">Status:</label>
                    <input type="text" name="status" required><br><br>

                    <button type="submit" name="add_breeding_cycle">Add Breeding Cycle</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
