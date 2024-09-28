<?php
session_start();
require 'src/BillController.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$billController = new BillController();
$bills = $billController->getBills($_SESSION['user']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bill_id'])) {
    $billId = $_POST['bill_id'];
    if ($billController->payBill($billId)) {
        echo "Bill paid successfully!";
        // Redirect to refresh the page and show updated bill status
        header('Location: view_bills.php');
        exit();
    } else {
        echo "Failed to pay the bill. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Bills</title>
</head>
<body>
    <h1>Your Bills</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Amount</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bills as $bill): ?>
            <tr>
                <td><?php echo $bill['id']; ?></td>
                <td><?php echo $bill['amount']; ?></td>
                <td><?php echo $bill['due_date']; ?></td>
                <td><?php echo $bill['status']; ?></td>
                <td>
                    <?php if ($bill['status'] === 'unpaid'): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="bill_id" value="<?php echo $bill['id']; ?>">
                        <button type="submit">Pay Now</button>
                    </form>
                    <?php else: ?>
                    Paid
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <a href="index.php">Back to Dashboard</a>
</body>
</html>
