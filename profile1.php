<?php
session_start();
include('db_connect.php');

// Check if the user is logged in as veterinarian
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'veterinarian') {
    header("Location: login.php"); // Redirect to login if not veterinarian
    exit;
}

// Fetch veterinarian's profile information
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tblusers WHERE user_id = '$user_id' AND role = 'veterinarian'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if (isset($_POST['update_profile'])) {
    // Update profile information
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $update_query = "UPDATE tblusers SET username = '$username', password = '$password', email = '$email' WHERE user_id = '$user_id' AND role = 'veterinarian'";
    
    if (mysqli_query($con, $update_query)) {
        echo "Profile updated successfully!";
        // Reload the page to reflect changes
        header("Location: profile1.php");
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
    <title>Veterinarian Profile</title>
    <link rel="stylesheet" href="profile1.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Veterinarian Dashboard</h2>
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
                <h1>Profile Information</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>Update Your Profile</h2>
                
                <form method="POST">
                    <label for="username">Username:</label>
                    <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br><br>

                    <label for="password">Password:</label>
                    <input type="password" name="password" value="<?php echo $user['password']; ?>" required><br><br>

                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

                    <button type="submit" name="update_profile">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
