<?php
session_start();
include('db_connect.php');

// Handle form submission for adding a newborn record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mother_cow_id = mysqli_real_escape_string($con, $_POST['mother_cow_id']);
    $birth_date = mysqli_real_escape_string($con, $_POST['birth_date']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $weight = mysqli_real_escape_string($con, $_POST['weight']);
    $health_status = mysqli_real_escape_string($con, $_POST['health_status']);

    $query_insert = "INSERT INTO tblnewborns (mother_cow_id, birth_date, gender, weight, health_status) 
                     VALUES ('$mother_cow_id', '$birth_date', '$gender', '$weight', '$health_status')";

    if (mysqli_query($con, $query_insert)) {
        echo "<script>alert('Newborn record added successfully!'); window.location.href='newborn_records.php';</script>";
    } else {
        echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
    }
}

// Handle deletion of a newborn record
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $query_delete = "DELETE FROM tblnewborns WHERE newborn_id = '$delete_id'";

    if (mysqli_query($con, $query_delete)) {
        echo "<script>alert('Record deleted successfully!'); window.location.href='newborn_records.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch newborn records with the mother cow ID
$query = "SELECT tblnewborns.*, tblcows.cow_name 
          FROM tblnewborns 
          LEFT JOIN tblcows ON tblnewborns.mother_cow_id = tblcows.cow_id 
          ORDER BY tblnewborns.created_at DESC";

$result = mysqli_query($con, $query);

// Fetch cow options for the form
$query_cows = "SELECT cow_id, cow_name FROM tblcows";
$result_cows = mysqli_query($con, $query_cows);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Newborn Records</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Farm Employee</h2>
            <ul>
                <li><a href="employee_dashboard.php">Dashboard</a></li>
                <li><a href="milk_collection.php">Milk Collection</a></li>
                <li><a href="health_records.php">Herd Health</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="feeds_nutrition.php">Animal Feeds & Nutrition</a></li>
                <li><a href="reproductive_cycles.php">Reproductive Cycles</a></li>
                <li><a href="newborn_records.php">Newborn Records</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>  
        </div>
        <div class="main-content">
            <div class="header">
                <h1>Newborn Records</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            
            <!-- Form to add a newborn record -->
            <h2>Add Newborn Record</h2>
            <form method="POST" style="margin-bottom: 20px;">
                <label for="mother_cow_id">Mother Cow:</label>
                <select name="mother_cow_id" id="mother_cow_id" required>
                    <option value="">Select Mother Cow</option>
                    <?php while ($cow = mysqli_fetch_assoc($result_cows)) { ?>
                        <option value="<?php echo $cow['cow_id']; ?>">
                            <?php echo $cow['cow_name'] . " (ID: " . $cow['cow_id'] . ")"; ?>
                        </option>
                    <?php } ?>
                </select>
                <label for="birth_date">Birth Date:</label>
                <input type="date" id="birth_date" name="birth_date" required>
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <label for="weight">Weight (kg):</label>
                <input type="number" id="weight" name="weight" step="0.1" required>
                <label for="health_status">Health Status:</label>
                <input type="text" id="health_status" name="health_status" required>
                <button type="submit">Add Record</button>
            </form>

            <!-- Newborn records table -->
            <h2>Newborn Records</h2>
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background-color: #007bff; color: white; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Mother Cow ID</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Birth Date</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Gender</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Weight (kg)</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Health Status</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr style="background-color: <?php echo $row['mother_cow_id'] % 2 === 0 ? '#f8f9fa' : '#ffffff'; ?>;">
                            <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['mother_cow_id']); ?></td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['birth_date']); ?></td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['weight']); ?></td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['health_status']); ?></td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;">
                                <a href="?delete_id=<?php echo $row['newborn_id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this record?');">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
