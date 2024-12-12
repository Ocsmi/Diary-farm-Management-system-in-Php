<?php 
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'veterinarian') {
    header("Location: login.php");
    exit;
}
include('db_connect.php');

// Insert Health Record
if (isset($_POST['add_record'])) {
    $cow_id = $_POST['cow_id'];
    $health_issue = $_POST['health_issue'];
    $treatment = $_POST['treatment'];
    $date = $_POST['date'];

    // Insert record into the database
    $query = "INSERT INTO tblhealth_records (cow_id, health_issue, treatment, date) 
              VALUES ('$cow_id', '$health_issue', '$treatment', '$date')";
    if (mysqli_query($con, $query)) {
        echo "Health record added successfully!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Health Record</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Veterinarian</h2>
            <ul>
                <li><a href="veterinarian_dashboard.php">Dashboard</a></li>
                <li><a href="health_records.php">Health Records</a></li>
                <li><a href="add_health_record.php">Add Health Record</a></li> <!-- Added link -->
                <li><a href="breeding_cycles.php">Breeding Cycles</a></li>
                <li><a href="add_breeding_cycle.php">Add Breeding Record</a></li> <!-- New Link -->
                <li><a href="add_treatment_record.php">Add Treatment Records</a></li> <!-- New Link -->
                <li><a href="treatment_history.php">Treatment History</a></li>
                <li><a href="profile1.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Add Health Record</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <form method="post">
                    <label for="cow_id">Cow ID:</label>
                    <input type="number" name="cow_id" required><br><br>

                    <label for="health_issue">Health Issue:</label>
                    <input type="text" name="health_issue" required><br><br>

                    <label for="treatment">Treatment:</label>
                    <input type="text" name="treatment" required><br><br>

                    <label for="date">Date:</label>
                    <input type="date" name="date" required><br><br>

                    <button type="submit" name="add_record">Add Record</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
