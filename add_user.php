<?php
session_start();
include('db_connect.php');

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input from the form
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $role = mysqli_real_escape_string($con, $_POST['role']);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into tblusers_temp (temporary table)
    $query = "INSERT INTO tblusers_temp (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "User added successfully!";
    } else {
        echo "Error adding user: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
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

        <div class="main-content">
            <div class="header">
                <h1>Add User</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>Create a New User</h2>
                <form method="POST" action="">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>

                    <label for="role">Role:</label>
                    <select name="role" id="role" required>
                        <option value="admin">Admin</option>
                        <option value="employee">Employee</option>
                        <option value="veterinarian">Veterinarian</option>
                    </select>

                    <button type="submit">Add User</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
