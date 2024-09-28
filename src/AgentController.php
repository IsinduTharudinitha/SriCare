<?php
require 'Database.php';

class AgentController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Simple login for agents
    public function login($username, $password) {
        $query = "SELECT * FROM agents WHERE username = :username AND password = :password";
        $params = [
            'username' => $username,
            'password' => $password // Basic hashing, improve for production
        ];

        $result = $this->db->query($query, $params);
        return !empty($result);
    }
}
