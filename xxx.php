<?php
session_start();
include('db_connect.php');

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Handle form submission to add a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = mysqli_real_escape_string($con, $_POST['role']);

    $query = "INSERT INTO tblusers (username, password, role, created_at) VALUES ('$username', '$password', '$role', NOW())";
    if (mysqli_query($con, $query)) {
        $success_message = "User added successfully!";
    } else {
        $error_message = "Error adding user: " . mysqli_error($con);
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
                <li><a href="view_users.php">View Users</a></li>
                <li><a href="add_user.php">Add User</a></li>
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
                <?php
                if (isset($success_message)) {
                    echo "<p class='success'>$success_message</p>";
                } elseif (isset($error_message)) {
                    echo "<p class='error'>$error_message</p>";
                }
                ?>
                <form action="add_user.php" method="POST">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>

                    <label for="role">Role:</label>
                    <select name="role" id="role" required>
                        <option value="">Select Role</option>
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
