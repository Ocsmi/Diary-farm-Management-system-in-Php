<?php
session_start();
include('db_connect.php');

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'veterinarian') {
    header("Location: login.php"); // Redirect to login if not veterinarian
    exit;
}

// Check if a delete request has been made
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // SQL query to delete the health record
    $delete_query = "DELETE FROM tblhealth_records WHERE record_id = '$delete_id'";

    if (mysqli_query($con, $delete_query)) {
        echo "Health record deleted successfully!";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

// Query to fetch health records
$query = "SELECT * FROM tblhealth_records ORDER BY date DESC";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Error fetching health records: " . mysqli_error($con);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Records</title>
    <link rel="stylesheet" href="style2.css">
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
                <h1>Health Records</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>All Health Records</h2>

                <?php
                if (mysqli_num_rows($result) > 0) {
                    // Display health records in a table
                    echo "<table>";
                    echo "<tr><th>Cow ID</th><th>Health Issue</th><th>Treatment</th><th>Date</th><th>Action</th></tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['cow_id']}</td>
                                <td>{$row['health_issue']}</td>
                                <td>{$row['treatment']}</td>
                                <td>{$row['date']}</td>
                                <td>
                                    <!-- Delete button -->
                                    <a href='healthy_records.php?delete_id={$row['record_id']}' 
                                       onclick='return confirm(\"Are you sure you want to delete this health record?\");'>
                                       <button>Delete</button>
                                    </a>
                                </td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No health records found.";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
