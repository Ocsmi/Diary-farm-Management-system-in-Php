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

    // SQL query to delete the treatment record
    $delete_query = "DELETE FROM tbltreatment_history WHERE treatment_id = '$delete_id'";

    if (mysqli_query($con, $delete_query)) {
        echo "Treatment record deleted successfully!";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

// Fetch the treatment records
$query = "SELECT * FROM tbltreatment_history ORDER BY treatment_date DESC";
$result = mysqli_query($con, $query);
if (!$result) {
    die("Error fetching treatment records: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treatment History</title>
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
                <li><a href="add_breeding_cycle.php">Add Breeding Record</a></li>
                <li><a href="treatment_history.php">Treatment History</a></li>
                <li><a href="add_treatment_record.php">Add Treatment Records</a></li>
                <li><a href="profile1.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Treatment History</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content">
                <h2>Treatment Records</h2>

                <!-- Display records in a table -->
                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Cow ID</th>
                                <th>Treatment Type</th>
                                <th>Treatment Date</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['cow_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['treatment_type']); ?></td>
                                    <td><?php echo htmlspecialchars($row['treatment_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['treatment_description']); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    <td>
                                        <!-- Delete button -->
                                        <a href="treatment_history.php?delete_id=<?php echo $row['treatment_id']; ?>" 
                                           onclick="return confirm('Are you sure you want to delete this treatment record?');">
                                           <button>Delete</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                <?php } else { ?>
                    <p>No treatment records found.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
