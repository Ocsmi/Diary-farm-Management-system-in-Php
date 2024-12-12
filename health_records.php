<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: login.php");
    exit;
}
include('db_connect.php');

// Handle adding a new health record
if (isset($_POST['add_health_record'])) {
    $cow_id = $_POST['cow_id'];
    $health_issue = $_POST['health_issue'];
    $treatment = $_POST['treatment'];
    $date = $_POST['date'];

    $query = "INSERT INTO tblhealth_records (cow_id, health_issue, treatment, date) VALUES ('$cow_id', '$health_issue', '$treatment', '$date')";
    if (mysqli_query($con, $query)) {
        echo "<p class='success'>Health record added successfully!</p>";
    } else {
        echo "<p class='error'>Error: " . mysqli_error($con) . "</p>";
    }
}

// Fetch existing health records
$records_query = "SELECT * FROM tblhealth_records";
$records_result = mysqli_query($con, $records_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Records</title>
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
                <h1>Health Records</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>Add Health Record</h2>
                <form method="post">
                    <label for="cow_id">Cow ID:</label>
                    <input type="text" name="cow_id" required>
                    
                    <label for="health_issue">Health Issue:</label>
                    <input type="text" name="health_issue" required>
                    
                    <label for="treatment">Treatment:</label>
                    <input type="text" name="treatment" required>
                    
                    <label for="date">Date:</label>
                    <input type="date" name="date" required>
                    
                    <button type="submit" name="add_health_record">Add Record</button>
                </form>
                
                <h2>Existing Health Records</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Cow ID</th>
                            <th>Health Issue</th>
                            <th>Treatment</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($records_result)): ?>
                            <tr>
                                <td><?php echo $row['cow_id']; ?></td>
                                <td><?php echo $row['health_issue']; ?></td>
                                <td><?php echo $row['treatment']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
