<?php
session_start();
require 'src/ChatController.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$chatController = new ChatController();
$messages = $chatController->getMessages($_SESSION['user']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    if (!empty($message)) {
        $chatController->sendMessage($_SESSION['user'], $message);
        header('Location: chat.php'); // Refresh the page to show the new message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat with Customer Care</title>
</head>
<body>
    <h1>Chat with Customer Care</h1>

    <div style="border: 1px solid #000; padding: 10px; height: 300px; overflow-y: scroll;">
    <?php foreach ($messages as $msg): ?>
        <p><strong><?php echo htmlspecialchars($msg['sender']); ?>:</strong> <?php echo htmlspecialchars($msg['message']); ?> <em>(<?php echo $msg['timestamp']; ?>)</em></p>
    <?php endforeach; ?>
</div>

    <form method="POST" action="">
        <textarea name="message" rows="4" cols="50" placeholder="Type your message..." required></textarea><br><br>
        <button type="submit">Send</button>
    </form>

    <br>
    <a href="index.php">Back to Dashboard</a>
</body>
</html>
