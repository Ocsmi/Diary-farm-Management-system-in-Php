<?php
session_start();
include('db_connect.php');

// Handle form submission for adding a product sale
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $sale_date = mysqli_real_escape_string($con, $_POST['sale_date']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);  // Sale amount

    // Insert sale into tblsales (for product sales)
    $query_insert = "INSERT INTO tblsales (product_id, quantity, sale_date, amount) 
                     VALUES ('$product_id', '$quantity', '$sale_date', '$amount')";

    if (mysqli_query($con, $query_insert)) {
        echo "<script>alert('Product sale added successfully!'); window.location.href='product_sales.php';</script>";
    } else {
        echo "<script>alert('Error adding sale: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all product sales
$query_sales = "SELECT tblsales.*, tblproducts.product_name 
                FROM tblsales 
                JOIN tblproducts ON tblsales.product_id = tblproducts.product_id 
                ORDER BY tblsales.sale_date DESC";
$result_sales = mysqli_query($con, $query_sales);

// Fetch product options for the form
$query_products = "SELECT product_id, product_name FROM tblproducts";
$result_products = mysqli_query($con, $query_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Sales</title>
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
                <h1>Product Sales</h1>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>

            <!-- Form to add a product sale -->
            <h2>Add Product Sale</h2>
            <form method="POST">
                <label for="product_id">Product:</label>
                <select name="product_id" id="product_id" required>
                    <option value="">Select Product</option>
                    <?php while ($product = mysqli_fetch_assoc($result_products)) { ?>
                        <option value="<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></option>
                    <?php } ?>
                </select>
                <label for="quantity">Quantity Sold:</label>
                <input type="number" id="quantity" name="quantity" required>
                <label for="sale_date">Sale Date:</label>
                <input type="date" id="sale_date" name="sale_date" required>
                <label for="amount">Amount ($):</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
                <button type="submit">Add Sale</button>
            </form>

            <!-- Product sales table -->
            <h2>Product Sales Records</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #007bff; color: white;">
                        <th>Product Name</th>
                        <th>Quantity Sold</th>
                        <th>Sale Date</th>
                        <th>Amount ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_sales)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['sale_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
