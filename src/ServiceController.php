<?php
require 'Database.php';

class ServiceController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function activateService($username, $service) {
        $query = "UPDATE services SET status = 'active' WHERE user_id = (SELECT id FROM users WHERE username = :username) AND service = :service";
        $params = ['username' => $username, 'service' => $service];
        return $this->db->execute($query, $params);
    }

    public function deactivateService($username, $service) {
        $query = "UPDATE services SET status = 'inactive' WHERE user_id = (SELECT id FROM users WHERE username = :username) AND service = :service";
        $params = ['username' => $username, 'service' => $service];
        return $this->db->execute($query, $params);
    }
}
