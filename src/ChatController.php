<?php
require 'Database.php';

class ChatController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Fetch all messages between the user and customer care
    public function getMessages($username) {
    $query = "
        SELECT 
            CASE 
                WHEN c.agent_id IS NOT NULL THEN 'Customer Care' -- If agent_id is set, it’s from the agent
                ELSE u.username -- Otherwise, it’s from the customer
            END AS sender,
            c.message,
            c.timestamp
        FROM 
            chats c
        LEFT JOIN 
            users u ON u.id = c.user_id
        WHERE 
            u.username = :username OR c.agent_id IS NOT NULL
        ORDER BY 
            c.timestamp ASC
    ";
    $params = ['username' => $username];
    return $this->db->query($query, $params);
}

    // Store the message in the database (customer sends a message)
    public function sendMessage($username, $message) {
        $userIdQuery = "SELECT id FROM users WHERE username = :username";
        $userId = $this->db->query($userIdQuery, ['username' => $username])[0]['id'];

        $query = "INSERT INTO chats (user_id, agent_id, message, timestamp) VALUES (:user_id, NULL, :message, NOW())";
        $params = [
            'user_id' => $userId,
            'message' => $message
        ];
        return $this->db->execute($query, $params);
    }

    // Store the message in the database (agent sends a message)
    public function sendMessageFromAgent($username, $message) {
        $userIdQuery = "SELECT id FROM users WHERE username = :username";
        $userId = $this->db->query($userIdQuery, ['username' => $username])[0]['id'];
    
        $query = "INSERT INTO chats (user_id, agent_id, message, timestamp) VALUES (:user_id, 1, :message, NOW())"; // Assuming agent_id = 1 for the demo
        $params = [
            'user_id' => $userId,
            'message' => $message
        ];
        return $this->db->execute($query, $params);
    }    
}
