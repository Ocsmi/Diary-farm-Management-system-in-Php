<?php
session_start();
include('db_connect.php');

// Fetch milk sales data and join with cows' data
$query = "SELECT tblmilk_sales.sale_id, tblmilk_sales.cow_id, tblmilk_sales.quantity, tblmilk_sales.sale_date, tblmilk_sales.amount, tblcows.breed 
          FROM tblmilk_sales
          LEFT JOIN tblcows ON tblmilk_sales.cow_id = tblcows.cow_id
          ORDER BY tblmilk_sales.sale_date DESC";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Error fetching milk sales: " . mysqli_error($con);
}

// Handle form submission for adding a milk sale
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cow_id = mysqli_real_escape_string($con, $_POST['cow_id']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $sale_date = mysqli_real_escape_string($con, $_POST['sale_date']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);

    $query_insert = "INSERT INTO tblmilk_sales (cow_id, quantity, sale_date, amount) 
                     VALUES ('$cow_id', '$quantity', '$sale_date', '$amount')";

    if (mysqli_query($con, $query_insert)) {
        echo "<script>alert('Milk sale record added successfully!'); window.location.href='milk_sales.php';</script>";
    } else {
        echo "<script>alert('Error adding sale record: " . mysqli_error($con) . "');</script>";
    }
}

// Handle deletion of a milk sale record
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $query_delete = "DELETE FROM tblmilk_sales WHERE sale_id = '$delete_id'";

    if (mysqli_query($con, $query_delete)) {
        echo "<script>alert('Milk sale record deleted successfully!'); window.location.href='milk_sales.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch cow options for the form
$query_cows = "SELECT cow_id, breed FROM tblcows";
$result_cows = mysqli_query($con, $query_cows);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Milk Sales</title>
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
                <li><a href="view_users.php">View Users</a></li> <!-- Optional: link to view all users -->
                <li><a href="add_user.php">Add User</a></li> <!-- New link to add user -->
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
                <h1>Milk Sales</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>

            <!-- Form to add a new milk sale -->
            <h2>Add Milk Sale</h2>
            <form method="POST" style="margin-bottom: 20px;">
                <label for="cow_id">Cow Breed:</label>
                <select name="cow_id" id="cow_id" required>
                    <option value="">Select Cow Breed</option>
                    <?php while ($cow = mysqli_fetch_assoc($result_cows)) { ?>
                        <option value="<?php echo $cow['cow_id']; ?>">
                            <?php echo $cow['breed'] . " (ID: " . $cow['cow_id'] . ")"; ?>
                        </option>
                    <?php } ?>
                </select>
                <label for="quantity">Quantity (liters):</label>
                <input type="number" id="quantity" name="quantity" step="0.1" required>
                <label for="sale_date">Sale Date:</label>
                <input type="date" id="sale_date" name="sale_date" required>
                <label for="amount">Amount (USD):</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
                <button type="submit">Add Sale</button>
            </form>

            <!-- Milk Sales Table -->
            <h2>Milk Sales Records</h2>
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background-color: #007bff; color: white; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Cow Breed</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Quantity (liters)</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Sale Date</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Amount (USD)</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr style="background-color: <?php echo $row['sale_id'] % 2 === 0 ? '#f8f9fa' : '#ffffff'; ?>;">
                            <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['breed']); ?></td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['sale_date']); ?></td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo htmlspecialchars($row['amount']); ?></td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;">
                                <a href="milk_sales.php?delete_id=<?php echo $row['sale_id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this sale record?');" 
                                   style="color: red; text-decoration: none;">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
