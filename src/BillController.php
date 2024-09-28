<?php
require 'Database.php';

class BillController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Fetch all bills for the user
    public function getBills($username) {
        $query = "SELECT * FROM bills WHERE user_id = (SELECT id FROM users WHERE username = :username)";
        $params = ['username' => $username];
        return $this->db->query($query, $params);
    }

    // Fetch an unpaid bill by its ID
    public function getBillById($billId) {
        $query = "SELECT * FROM bills WHERE id = :bill_id AND status = 'unpaid'";
        $params = ['bill_id' => $billId];
        return $this->db->query($query, $params);
    }

    // Pay a bill and update the status to 'paid'
    public function payBill($billId) {
        $query = "UPDATE bills SET status = 'paid' WHERE id = :bill_id";
        $params = ['bill_id' => $billId];
        return $this->db->execute($query, $params);
    }
}
