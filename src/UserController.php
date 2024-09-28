<?php
require_once 'Database.php';

class UserController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username AND password = :password";
        $params = [
            'username' => $username,
            'password' => $password // Basic hashing, improve for production
        ];
        $result = $this->db->query($query, $params);
        return !empty($result);
    }

    public function getAllUsers() {
        $query = "SELECT username FROM users";
        return $this->db->query($query);
    }
}
