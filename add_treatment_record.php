<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'veterinarian') {
    header("Location: login.php");
    exit;
}
include('db_connect.php');

if (isset($_POST['add_record'])) {
    $cow_id = $_POST['cow_id'];
    $treatment_type = $_POST['treatment_type'];
    $treatment_description = $_POST['treatment_description'];
    $treatment_date = $_POST['treatment_date'];
    $created_at = date('Y-m-d H:i:s');

    // Check if the cow_id exists in tblhealth_records (sick cows)
    $health_query = "SELECT cow_id FROM tblhealth_records WHERE cow_id = '$cow_id' LIMIT 1";
    $health_result = mysqli_query($con, $health_query);

    // Check if the cow_id exists in tblherd (full herd)
    $herd_query = "SELECT cow_id FROM tblherd WHERE cow_id = '$cow_id' LIMIT 1";
    $herd_result = mysqli_query($con, $herd_query);

    // Ensure the cow_id exists in both tblhealth_records and tblherd
    if (mysqli_num_rows($health_result) > 0 && mysqli_num_rows($herd_result) > 0) {
        // Insert treatment record into tbltreatment_history
        $query = "INSERT INTO tbltreatment_history (cow_id, treatment_type, treatment_description, treatment_date, created_at) 
                  VALUES ('$cow_id', '$treatment_type', '$treatment_description', '$treatment_date', '$created_at')";
        if (mysqli_query($con, $query)) {
            echo "Treatment record added successfully!";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        // Error message if cow_id doesn't exist in both tables
        echo "Cow ID does not exist in both the health records and herd. Please ensure the cow is both sick and in the herd before adding treatment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Treatment Record</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Veterinarian</h2>
            <ul>
                <li><a href="veterinarian_dashboard.php">Dashboard</a></li>
                <li><a href="healthy_records.php">Health Records</a></li>
                <li><a href="add_health_record.php">Add Health Record</a></li> <!-- Added link -->
                <li><a href="breeding_cycles.php">Breeding Cycles</a></li>
                <li><a href="add_breeding_cycle.php">Add Breeding Record</a></li> <!-- New Link -->
                <li><a href="treatment_history.php">Treatment History</a></li>
                <li><a href="add_treatment_record.php">Add Treatment Records</a></li> <!-- New Link -->
                <li><a href="profile1.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Add Treatment Record</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <form method="post">
                    <label for="cow_id">Cow ID:</label>
                    <select name="cow_id" required>
                        <option value="">Select Cow ID</option>
                        <?php 
                        // Generate cow IDs from 1 to 20
                        for ($i = 1; $i <= 20; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <br><br>

                    <label for="treatment_type">Treatment Type:</label>
                    <input type="text" name="treatment_type" required><br><br>

                    <label for="treatment_description">Treatment Description:</label>
                    <textarea name="treatment_description" required></textarea><br><br>

                    <label for="treatment_date">Treatment Date:</label>
                    <input type="date" name="treatment_date" required><br><br>

                    <button type="submit" name="add_record">Add Treatment Record</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
