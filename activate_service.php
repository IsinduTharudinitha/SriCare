<?php
session_start();
require 'src/ServiceController.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$serviceController = new ServiceController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = $_POST['service'];
    $action = $_POST['action'];

    // Activate or deactivate the service based on user input
    if ($action === 'activate') {
        $result = $serviceController->activateService($_SESSION['user'], $service);
        $message = $result ? 'Service activated successfully!' : 'Failed to activate service.';
    } elseif ($action === 'deactivate') {
        $result = $serviceController->deactivateService($_SESSION['user'], $service); // Assume deactivateService function exists in ServiceController
        $message = $result ? 'Service deactivated successfully!' : 'Failed to deactivate service.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Activate/Deactivate Services</title>
</head>
<body>
    <h1>Activate/Deactivate Services</h1>

    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="service">Select Service:</label>
        <select name="service" id="service" required>
            <option value="International Roaming">International Roaming</option>
            <option value="Ring-in Tone">Ring-in Tone</option>
            <option value="Data Top-Up">Data Top-Up</option>
            <option value="Other VAS Services">Other VAS Services</option>
        </select><br><br>

        <label for="action">Action:</label>
        <input type="radio" id="activate" name="action" value="activate" required>
        <label for="activate">Activate</label>
        <input type="radio" id="deactivate" name="action" value="deactivate" required>
        <label for="deactivate">Deactivate</label><br><br>

        <button type="submit">Submit</button>
    </form>

    <br>
    <a href="index.php">Back to Dashboard</a>
</body>
</html>
