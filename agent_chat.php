<?php
session_start();
require 'src/ChatController.php';
require 'src/UserController.php';

// Redirect if the agent is not logged in
if (!isset($_SESSION['agent'])) {
    header('Location: agent_login.php');
    exit();
}

$chatController = new ChatController();
$userController = new UserController();

// Get the list of users for the agent to chat with
$users = $userController->getAllUsers();
$messages = [];

if (isset($_GET['user'])) {
    $selectedUser = $_GET['user'];
    $messages = $chatController->getMessages($selectedUser);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'])) {
    $message = $_POST['message'];
    $user = $_POST['user'];

    if (!empty($message)) {
        $chatController->sendMessageFromAgent($user, $message);
        header("Location: agent_chat.php?user=$user"); // Refresh the page to show the new message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Care Chat</title>
</head>
<body>
    <h1>Customer Care - Chat</h1>

    <h3>Select a User to Chat With</h3>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <a href="agent_chat.php?user=<?php echo $user['username']; ?>">
                    Chat with <?php echo $user['username']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if (isset($selectedUser)): ?>
        <h3>Chat with <?php echo htmlspecialchars($selectedUser); ?></h3>
        <div style="border: 1px solid #000; padding: 10px; height: 300px; overflow-y: scroll;">
            <?php foreach ($messages as $msg): ?>
                <p><strong><?php echo htmlspecialchars($msg['sender']); ?>:</strong> <?php echo htmlspecialchars($msg['message']); ?> <em>(<?php echo $msg['timestamp']; ?>)</em></p>
            <?php endforeach; ?>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="user" value="<?php echo htmlspecialchars($selectedUser); ?>">
            <textarea name="message" rows="4" cols="50" placeholder="Type your message..." required></textarea><br><br>
            <button type="submit">Send</button>
        </form>
    <?php endif; ?>

    <br>
    <a href="agent_dashboard.php">Back to Dashboard</a>
</body>
</html>
