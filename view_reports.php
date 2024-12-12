<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}
include('db_connect.php'); // Include your DB connection

// Handle deletion of a report
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Query to delete the record based on collection_date
    $delete_query = "DELETE FROM tblherd WHERE collection_date = '$delete_id'"; 
    if (mysqli_query($con, $delete_query)) {
        echo "Record deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

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

// Fetch weekly total milk production
$weekly_query = "
    SELECT YEAR(collection_date) AS year, WEEK(collection_date) AS week, SUM(milk_produced_today) AS weekly_total
    FROM tblherd
    GROUP BY year, week
    ORDER BY year DESC, week DESC";
$weekly_result = mysqli_query($con, $weekly_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Farm Admin</h2>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="manage_cows.php">Manage Cows</a></li>
                <li><a href="view_reports.php">View Reports</a></li>
                <li><a href="view_users.php">View Users</a></li>
                <li><a href="add_user.php">Add User</a></li>
                <li><a href="product_sales.php">Product Sales</a></li>
                <li><a href="milk_sales.php">Milk Sales</a></li>
                <li><a href="inventory.php">Inventory</a></li>
                <li><a href="reports.php">Reports</a></li>
                <li><a href="profile2.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>View Reports</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <!-- Daily Milk Collection Report -->
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
                                    <td>
                                        <a href="view_reports.php?delete_id=<?php echo $row['collection_date']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                                    </td>
                                </tr>
                        <?php } 
                        } else { ?>
                            <tr>
                                <td colspan="4">No records found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Weekly Milk Collection Report -->
                <h2>Weekly Milk Collection Report</h2>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Week Number</th>
                            <th>Total Milk Collected (Liters)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (mysqli_num_rows($weekly_result) > 0) {
                            while ($row = mysqli_fetch_assoc($weekly_result)) { ?>
                                <tr>
                                    <td><?php echo $row['year']; ?></td>
                                    <td><?php echo $row['week']; ?></td>
                                    <td><?php echo $row['weekly_total']; ?> Liters</td>
                                </tr>
                        <?php } 
                        } else { ?>
                            <tr>
                                <td colspan="3">No records found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Grand Total Milk Collected -->
                <h2>Grand Total Milk Collected</h2>
                <p>Total Milk Collected: <?php echo isset($grand_total_data['grand_total']) ? $grand_total_data['grand_total'] : '0'; ?> Liters</p>
            </div>
        </div>
    </div>
</body>
</html>
