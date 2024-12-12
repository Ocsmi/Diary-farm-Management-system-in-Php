<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'veterinarian') {
    header("Location: login.php");
    exit;
}
include('db_connect.php');

// Query to get daily milk collection summary
//$query_milk = "SELECT SUM(milk_collected) AS total_milk FROM tblmilk_collection WHERE collection_date = CURDATE()";
//$result_milk = mysqli_query($con, $query_milk);
//$data_milk = mysqli_fetch_assoc($result_milk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinarian Dashboard</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
    <h2>Veterinarian</h2>
    <ul>
        <li><a href="veterinarian_dashboard.php">Dashboard</a></li>
        <li><a href="healthy_records.php">Health Records</a></li>
        <li><a href="add_health_record.php">Add Health Record</a></li> <!-- Existing Link -->
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
                <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>Dashboard Overview</h2>
                <p>Welcome to your veterinarian dashboard! Here you can manage the health records, breeding cycles, and treatment history of the cows on the farm.</p>

                
                   
                

                <div class="actions">
                    <h3>Actions</h3>
                    <ul>
                        <li><a href="healthy_records.php">Manage Health Records</a></li>
                        <li><a href="breeding_cycles.php">Manage Breeding Cycles</a></li>
                        <li><a href="treatment_history.php">View Treatment History</a></li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>
