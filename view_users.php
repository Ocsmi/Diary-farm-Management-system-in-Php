<?php
session_start();
include('db_connect.php');

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Handle deletion of a user
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Query to delete the user based on user_id
    $delete_query = "DELETE FROM tblusers_temp WHERE user_id = '$delete_id'"; 
    if (mysqli_query($con, $delete_query)) {
        echo "User deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// Fetch users from the tblusers_temp table
$query = "SELECT * FROM tblusers_temp ORDER BY created_at DESC";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Error fetching users: " . mysqli_error($con);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
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
                <li><a href="report.php">Reports</a></li>
                <li><a href="profile2.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>View Users</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>All Users</h2>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td>
                                    <a href="view_users.php?delete_id=<?php echo $row['user_id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
