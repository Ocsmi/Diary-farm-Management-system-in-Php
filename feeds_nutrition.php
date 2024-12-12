<?php 
session_start();
include('db_connect.php');

// Ensure only logged-in users can view feeds
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM tblfeeds ORDER BY date_added DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feeds & Nutrition</title>
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
            <h2 class="section-title">Animal Feeds & Nutrition</h2>
            <!-- Success Message -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
            <?php endif; ?>

            <!-- Add Feeds Form -->
            <h3 class="section-subtitle">Add New Feed</h3>
            <form action="add_feed.php" method="post">
                <label for="feed_name">Feed Name:</label>
                <input type="text" id="feed_name" name="feed_name" required>
                
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>
                
                <label for="unit">Unit:</label>
                <input type="text" id="unit" name="unit" required>
                
                <label for="price_per_unit">Price Per Unit:</label>
                <input type="number" step="0.01" id="price_per_unit" name="price_per_unit" required>
                
                <label for="feed_type">Feed Type:</label>
                <input type="text" id="feed_type" name="feed_type" required>
                
                <button type="submit">Add Feed</button>
            </form>

            <!-- Feed Table -->
                                <h3 class="section-subtitle">Available Feeds</h3>
                    <table class="animal-feeds-nutrition-table">
                        <thead>
                            <tr>
                                <th>Feed Name</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Price/Unit</th>
                                <th>Total Value</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['feed_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars($row['unit']); ?></td>
                                    <td><?php echo htmlspecialchars(number_format($row['price_per_unit'], 2)); ?></td>
                                    <td><?php echo htmlspecialchars(number_format($row['quantity'] * $row['price_per_unit'], 2)); ?></td>
                                    <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                                    <td>
                                        <form action="delete_feed.php" method="post" style="display: inline-block;">
                                        <input type="hidden" name="feed_id" value="<?php echo $row['feed_id']; ?>">
                                            <button type="submit" class="delete-button">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

            </table>
        </div>
    </div>
</body>
</html>
