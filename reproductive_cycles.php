<?php
session_start();
include('db_connect.php');

// Fetch cows to populate dropdown
$query_cows = "SELECT cow_id, breed FROM tblcows";
$result_cows = mysqli_query($con, $query_cows);

// Check if cows are available
if (mysqli_num_rows($result_cows) == 0) {
    echo "No cows available. Please add cows to the system first.";
}

// Handle form submission for adding reproductive cycle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch data from POST request
    $cow_id = isset($_POST['cow_id']) ? mysqli_real_escape_string($con, $_POST['cow_id']) : '';
    $cycle_start_date = isset($_POST['cycle_start_date']) ? mysqli_real_escape_string($con, $_POST['cycle_start_date']) : '';
    $pregnancy_status = isset($_POST['pregnancy_status']) ? mysqli_real_escape_string($con, $_POST['pregnancy_status']) : '';
    $expected_due_date = isset($_POST['expected_due_date']) ? mysqli_real_escape_string($con, $_POST['expected_due_date']) : NULL;  // can be NULL
    $notes = isset($_POST['notes']) ? mysqli_real_escape_string($con, $_POST['notes']) : NULL; // can be NULL

    // Check if cow_id exists in tblcows
    $check_cow_query = "SELECT cow_id FROM tblcows WHERE cow_id = '$cow_id'";
    $check_cow_result = mysqli_query($con, $check_cow_query);

    if (mysqli_num_rows($check_cow_result) > 0) {
        // Proceed with insertion if cow_id exists
        if (!empty($cow_id) && !empty($cycle_start_date) && !empty($pregnancy_status)) {
            // Prepare the INSERT query
            $insert_query = "INSERT INTO tblreproductive_cycles (cow_id, cycle_start_date, pregnancy_status, expected_due_date, notes) 
                             VALUES ('$cow_id', '$cycle_start_date', '$pregnancy_status', '$expected_due_date', '$notes')";
            
            if (mysqli_query($con, $insert_query)) {
                echo "Reproductive cycle added successfully!";
                header("Location: reproductive_cycles.php"); // Redirect to same page to prevent form resubmission
                exit;
            } else {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            echo "Please fill in all required fields.";
        }
    } else {
        echo "Selected cow ID does not exist. Please choose a valid cow.";
    }
}

// Handle deletion of reproductive cycle
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM tblreproductive_cycles WHERE cycle_id = '$delete_id'";

    if (mysqli_query($con, $delete_query)) {
        echo "Reproductive cycle deleted successfully!";
        header("Location: reproductive_cycles.php"); // Refresh the page after deletion
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// Fetch reproductive cycle records to display
$query_cycles = "SELECT rc.cycle_id, rc.cow_id, rc.cycle_start_date, rc.pregnancy_status, rc.expected_due_date, rc.notes, c.breed 
                 FROM tblreproductive_cycles rc
                 JOIN tblcows c ON rc.cow_id = c.cow_id
                 ORDER BY rc.created_at DESC";
$result_cycles = mysqli_query($con, $query_cycles);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Reproductive Cycle</title>
    <link rel="stylesheet" href="style1.css">
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
            <h1>Profile</h1>
            <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <h1>Add Reproductive Cycle</h1>
            <!-- Form to add reproductive cycle -->
            <form method="POST">
                <label for="cow_id">Select Cow:</label>
                <select name="cow_id" id="cow_id" required>
                    <option value="">Select Cow</option>
                    <?php
                    if (mysqli_num_rows($result_cows) > 0) {
                        while ($row = mysqli_fetch_assoc($result_cows)) {
                            echo "<option value='" . $row['cow_id'] . "'>" . $row['breed'] . " (ID: " . $row['cow_id'] . ")</option>";
                        }
                    } else {
                        echo "<option value=''>No cows available</option>";
                    }
                    ?>
                </select>

                <label for="cycle_start_date">Cycle Start Date:</label>
                <input type="date" id="cycle_start_date" name="cycle_start_date" required>

                <label for="pregnancy_status">Pregnancy Status:</label>
                <select name="pregnancy_status" id="pregnancy_status" required>
                    <option value="Pregnant">Pregnant</option>
                    <option value="Not Pregnant">Not Pregnant</option>
                    <option value="Calved">Calved</option>
                </select>

                <label for="expected_due_date">Expected Due Date:</label>
                <input type="date" id="expected_due_date" name="expected_due_date">

                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes"></textarea>

                <button type="submit">Add Reproductive Cycle</button>
            </form>

          <h2 style="font-size: 24px; color: #007bff; text-align: center; margin-bottom: 20px;">Reproductive Cycles List</h2>
<table style="width: 100%; border-collapse: collapse; margin-top: 20px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <thead>
        <tr style="background-color: #007bff; color: white; text-align: left;">
            <th style="padding: 10px; border: 1px solid #dee2e6;">Cycle ID</th>
            <th style="padding: 10px; border: 1px solid #dee2e6;">Cow Breed</th>
            <th style="padding: 10px; border: 1px solid #dee2e6;">Cycle Start Date</th>
            <th style="padding: 10px; border: 1px solid #dee2e6;">Pregnancy Status</th>
            <th style="padding: 10px; border: 1px solid #dee2e6;">Expected Due Date</th>
            <th style="padding: 10px; border: 1px solid #dee2e6;">Notes</th>
            <th style="padding: 10px; border: 1px solid #dee2e6;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result_cycles)) { ?>
            <tr style="background-color: <?php echo $row['cycle_id'] % 2 === 0 ? '#f8f9fa' : '#ffffff'; ?>;">
                <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['cycle_id']); ?></td>
                <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['breed']); ?></td>
                <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['cycle_start_date']); ?></td>
                <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['pregnancy_status']); ?></td>
                <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['expected_due_date']); ?></td>
                <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['notes']); ?></td>
                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">
                    <a href="?delete_id=<?php echo $row['cycle_id']; ?>" 
                       style="color: #dc3545; text-decoration: none; font-weight: bold;" 
                       onclick="return confirm('Are you sure you want to delete this reproductive cycle?')">
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
