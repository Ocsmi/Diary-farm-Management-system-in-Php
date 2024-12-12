<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: login.php");
    exit;
}
include('db_connect.php');

// Fetch employee details
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tblusers WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

// Handle password update
if (isset($_POST['update_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $query = "UPDATE tblusers SET password = '$new_password' WHERE user_id = '$user_id'";
        if (mysqli_query($con, $query)) {
            echo "<p class='success'>Password updated successfully!</p>";
        } else {
            echo "<p class='error'>Error: " . mysqli_error($con) . "</p>";
        }
    } else {
        echo "<p class='error'>Passwords do not match!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Farm Employee</h2>
            <ul>
                <li><a href="employee_dashboard.php">Dashboard</a></li>
                <li><a href="milk_collection.php">Milk Collection</a></li>
                <li><a href="health_records.php">Health Records</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="feeds_nutrition.php">Animal Feeds & Nutrition</a></li>
                <li><a href="reproductive_cycles.php">Reproductive Cycles</a></li>
                <li><a href="newborn_records.php">Newborn Records</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <h1>Profile</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>My Profile</h2>
                <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                <p><strong>Role:</strong> <?php echo $user['role']; ?></p>
                <p><strong>Joined:</strong> <?php echo $user['created_at']; ?></p>
                
                <h2>Update Password</h2>
                <form method="post">
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" required>
                    
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" required>
                    
                    <button type="submit" name="update_password">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
