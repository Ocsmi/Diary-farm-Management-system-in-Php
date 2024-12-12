<?php
// Start the session and include the database connection
session_start();
include('db_connect.php');

// Query for product sales report (total sales per product)
$query_sales = "SELECT tblproducts.product_name, SUM(tblsales.amount) AS total_sales 
                FROM tblsales 
                INNER JOIN tblproducts ON tblsales.product_id = tblproducts.product_id 
                GROUP BY tblproducts.product_name";
$result_sales = mysqli_query($con, $query_sales);

// Query for milk sales report (monthly milk sales)
$query_milk_sales = "SELECT MONTH(sale_date) AS month, SUM(amount) AS total_sales 
                     FROM tblmilk_sales 
                     GROUP BY MONTH(sale_date)";
$result_milk_sales = mysqli_query($con, $query_milk_sales);

// Prepare data for product sales chart
$product_names = [];
$product_sales = [];
while ($row = mysqli_fetch_assoc($result_sales)) {
    $product_names[] = $row['product_name'];
    $product_sales[] = $row['total_sales'];
}

// Prepare data for milk sales chart (monthly)
$months = [];
$milk_sales = [];
while ($row = mysqli_fetch_assoc($result_milk_sales)) {
    $months[] = date('F', mktime(0, 0, 0, $row['month'], 10));  // Convert month number to month name
    $milk_sales[] = $row['total_sales'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Reports</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #f7f8fc;
            color: #333;
        }
        .report-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }
        canvas {
            margin: 20px auto;
            display: block;
            max-width: 100%;
        }
        .sidebar {
            position: fixed;
            width: 200px;
            top: 0;
            left: 0;
            height: 100%;
            background: #007bff;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }
        .sidebar h2 {
            color: white;
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }
        .sidebar ul li {
            width: 100%;
        }
        .sidebar ul li a {
            display: block;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
        }
        .sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .header {
            margin-left: 220px;
            padding: 15px;
            background: #fff;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h2 {
            margin: 0;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }
        .logout-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Farm Admin</h2>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_cows.php">Manage Cows</a></li>
            <li><a href="view_reports.php">View Reports</a></li>
            <li><a href="view_users.php">View Users</a></li>
            <li><a href="add_user.php">Add User</a></li>
            <li><a href="product_sales.php">Product Sales</a></li>
            <li><a href="milk_sales.php">Milk Sales</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="report.php">Reports</a></li>
            <li><a href="profile2.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="report-container">
        <h2>Product Sales Report</h2>
        <canvas id="productSalesChart"></canvas>

        <h2>Monthly Milk Sales Report</h2>
        <canvas id="milkSalesChart"></canvas>
    </div>

    <script>
        // Product Sales Chart (Gradient Bar Chart)
        var ctx1 = document.getElementById('productSalesChart').getContext('2d');
        var gradient1 = ctx1.createLinearGradient(0, 0, 0, 400);
        gradient1.addColorStop(0, '#007bff');
        gradient1.addColorStop(1, '#33c0ff');
        var productSalesChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($product_names); ?>,
                datasets: [{
                    label: 'Total Sales ($)',
                    data: <?php echo json_encode($product_sales); ?>,
                    backgroundColor: gradient1,
                    borderColor: '#0056b3',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5] }
                    }
                }
            }
        });

        // Milk Sales Chart (Smooth Line Chart)
        var ctx2 = document.getElementById('milkSalesChart').getContext('2d');
        var milkSalesChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Milk Sales ($)',
                    data: <?php echo json_encode($milk_sales); ?>,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5] }
                    }
                }
            }
        });
    </script>
</body>
</html>
