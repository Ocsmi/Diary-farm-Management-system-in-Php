<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: login.php");
    exit;
}
include('db_connect.php');



// Fetch daily total milk production along with breed
$query = "
    SELECT collection_date, breed, SUM(milk_produced_today) AS daily_total
    FROM tblherd
    GROUP BY collection_date, breed
    ORDER BY collection_date DESC";
$result = mysqli_query($con, $query);

// Fetch grand total milk production
$grand_total_query = "SELECT SUM(milk_produced_today) AS grand_total FROM tblherd";
$grand_total_result = mysqli_query($con, $grand_total_query);
$grand_total_data = mysqli_fetch_assoc($grand_total_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
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
                <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>Daily Milk Collection Report</h2>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Breed</th>
                            <th>Total Milk Collected (Liters)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['collection_date']; ?></td>
                                    <td><?php echo $row['breed']; ?></td>
                                    <td><?php echo $row['daily_total']; ?> Liters</td>
                                    
                                </tr>
                        <?php } 
                        } else { ?>
                            <tr>
                                <td colspan="4">No records found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h2>Grand Total Milk Collected</h2>
                <p>Total Milk Collected: <?php echo isset($grand_total_data['grand_total']) ? $grand_total_data['grand_total'] : '0'; ?> Liters</p>
            </div>
        </div>
    </div>
</body>
</html>
