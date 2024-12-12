<?php
session_start();
include('db_connect.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Query to check the login credentials
    $query = "SELECT * FROM tblusers WHERE username = '$username' AND password = '$password' AND role = '$role'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($_SESSION['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($_SESSION['role'] == 'employee') {
            header("Location: employee_dashboard.php");
        } elseif ($_SESSION['role'] == 'veterinarian') {
            header("Location: veterinarian_dashboard.php");
        } else {
            header("Location: login.php?error=Invalid Role");
        }
    } else {
        echo "Error: Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <form method="post" class="login-form">
            <h2>Login</h2>
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <select name="role" required>
                    <option value="admin">Admin</option>
                    <option value="employee">Employee</option>
                    <option value="veterinarian">Veterinarian</option>
                </select>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
