<!-- db_connect.php -->
<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dairyfarm_management"; // Your new database name

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
