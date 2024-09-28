<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Sri-Care</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['user']; ?></h1>
    <a href="view_bills.php">View Bills</a><br>
    <a href="activate_service.php">Activate/Deactivate Service</a><br>
    <a href="chat.php">Chat with Customer Care</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
