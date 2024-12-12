<?php
session_start();
include('db_connect.php');

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch the admin's details from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tblusers WHERE user_id = $user_id";
$result = mysqli_query($con, $query);
if (!$result) {
    die("Error fetching user details: " . mysqli_error($con));
}
$user = mysqli_fetch_assoc($result);

// Handle profile update
if (isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Update the password if provided
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE tblusers SET username = '$username', password = '$hashed_password' WHERE user_id = $user_id";
    } else {
        // Update username only if no password is provided
        $update_query = "UPDATE tblusers SET username = '$username' WHERE user_id = $user_id";
    }

    if (mysqli_query($con, $update_query)) {
        echo "Profile updated successfully!";
        // Update session username
        $_SESSION['username'] = $username;
    } else {
        echo "Error updating profile: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="style2.css">
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
                <h1>Admin Profile</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>Profile Information</h2>

                <!-- Display current user information -->
                <form method="POST" action="">
                    <label for="username">Username:</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

                    <label for="password">New Password (leave blank to keep current):</label>
                    <input type="password" name="password"><br><br>

                    <button type="submit" name="update_profile">Update Profile</button>
                </form>

                <h3>Current Profile Information:</h3>
                <table>
                    <tr>
                        <td><strong>Username:</strong></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Role:</strong></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Created At:</strong></td>
                        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
