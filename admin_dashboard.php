<?php
session_start();
include('db_connect.php'); // Include the database con

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect to login if not logged in or not admin
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS for styling -->
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
     <h2>Farm Admin</h2>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="manage_cows.php">Manage Cows</a></li>
                <li><a href="view_reports.php">View Reports</a></li>
                <li><a href="view_users.php">View Users</a></li> <!-- Optional: link to view all users -->
                <li><a href="add_user.php">Add User</a></li> <!-- New link to add user -->
                <li><a href="product_sales.php">Product Sales</a></li>
                <li><a href="milk_sales.php">Milk Sales</a></li>
                <li><a href="inventory.php">Inventory</a></li>
                <li><a href="report.php">Reports</a></li>
                <li><a href="profile2.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
</div>


        <!-- Main Content Area -->
        <div class="main-content">
            <div class="header">
                <h1>Welcome, Admin!</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <!-- Content will change based on page (Manage Cows, View Reports, etc.) -->
                <h2>Manage Your Cows</h2>
                <p>Select a cow to manage, view reports, etc.</p>
            </div>
        </div>
    </div>
</body>
</html>
