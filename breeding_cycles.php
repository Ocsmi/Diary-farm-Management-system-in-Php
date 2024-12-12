<?php 
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'veterinarian') {
    header("Location: login.php");
    exit;
}
include('db_connect.php');

// Check if a delete request has been made
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // SQL query to delete the breeding cycle record
    $delete_query = "DELETE FROM tblbreeding_cycles WHERE cycle_id = '$delete_id'";

    if (mysqli_query($con, $delete_query)) {
        echo "Breeding cycle record deleted successfully!";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

// Query to fetch breeding cycles
$query = "SELECT * FROM tblbreeding_cycles ORDER BY breeding_date DESC";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Error fetching records: " . mysqli_error($con);  // Debugging any query error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Breeding Cycles</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Veterinarian</h2>
            <ul>
                <li><a href="veterinarian_dashboard.php">Dashboard</a></li>
                <li><a href="healthy_records.php">Health Records</a></li>
                <li><a href="add_health_record.php">Add Health Record</a></li>
                <li><a href="breeding_cycles.php">Breeding Cycles</a></li>
                <li><a href="add_breeding_cycle.php">Add Breeding Cycle</a></li>
                <li><a href="add_treatment_record.php">Add Treatment Records</a></li>
                <li><a href="treatment_history.php">Treatment History</a></li>
                <li><a href="profile1.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Breeding Cycles</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>Breeding Cycle Records</h2>
                <table>
                    <tr>
                        <th>Cow ID</th>
                        <th>Breeding Date</th>
                        <th>Method of Insemination</th>
                        <th>Expected Calving Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['cow_id']; ?></td>
                            <td><?php echo $row['breeding_date']; ?></td>
                            <td><?php echo $row['method_of_insemination']; ?></td>
                            <td><?php echo $row['expected_calving_date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <!-- Delete button -->
                                <a href="breeding_cycles.php?delete_id=<?php echo $row['cycle_id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this breeding cycle?');">
                                   <button>Delete</button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
